#!/usr/bin/env bash
# Pull a WordPress site from Hostinger into this repo and scaffold local tooling.
#
# Prerequisites:
#   .docs/hostinger/.env  (see .docs/hostinger/.env.example)
#
# Usage:
#   ./scripts/init-from-hostinger.sh
#   ./scripts/init-from-hostinger.sh --with-uploads
#   ./scripts/init-from-hostinger.sh --with-db
#   ./scripts/init-from-hostinger.sh --list-domains
#   ./scripts/init-from-hostinger.sh --help
#
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
# shellcheck source=lib/hostinger-env.sh
source "$ROOT/scripts/lib/hostinger-env.sh"

ENV_FILE="$ROOT/.docs/hostinger/.env"
ENV_EXAMPLE="$ROOT/.docs/hostinger/.env.example"
LOCAL_PUBLIC="$ROOT/public_html"

WITH_UPLOADS=0
WITH_DB=0
LIST_ONLY=0
SKIP_DOCKER=0

usage() {
  cat <<'USAGE'
Init a WordPress repo from Hostinger (shared account, many domains).

  ./scripts/init-from-hostinger.sh
  ./scripts/init-from-hostinger.sh --with-uploads
  ./scripts/init-from-hostinger.sh --with-db
  ./scripts/init-from-hostinger.sh --list-domains
  ./scripts/init-from-hostinger.sh --skip-docker

Required in .docs/hostinger/.env:
  SERVER_NAME, SSH_USERNAME, SSH_PASSWORD, SSH_PORT, DOMAIN
USAGE
  exit "${1:-0}"
}

while [[ $# -gt 0 ]]; do
  case "$1" in
    -h|--help) usage 0 ;;
    --with-uploads) WITH_UPLOADS=1; shift ;;
    --with-db) WITH_DB=1; shift ;;
    --list-domains) LIST_ONLY=1; shift ;;
    --skip-docker) SKIP_DOCKER=1; shift ;;
    *)
      echo "Unknown option: $1" >&2
      usage 1
      ;;
  esac
done

mkdir -p "$ROOT/.docs/hostinger" "$ROOT/scripts" "$ROOT/docker/scripts" "$ROOT/docker/php"

if [[ ! -f "$ENV_FILE" ]]; then
  if [[ -f "$ENV_EXAMPLE" ]]; then
    cp "$ENV_EXAMPLE" "$ENV_FILE"
    echo "Created $ENV_FILE from example. Fill DOMAIN + SSH credentials, then re-run."
    exit 1
  fi
  echo "Missing $ENV_FILE" >&2
  exit 1
fi

hostinger_load_env "$ENV_FILE"

if [[ "$LIST_ONLY" -eq 1 ]]; then
  echo "==> Domains on Hostinger account"
  hostinger_ssh "ls -1 ~/domains"
  exit 0
fi

echo "==> Target domain: ${DOMAIN:-"(custom path)"}"
echo "==> Remote path:   ~/${REMOTE_PUBLIC_HTML}"

echo "==> Checking remote public_html exists"
if ! hostinger_ssh "test -d ~/${REMOTE_PUBLIC_HTML}"; then
  echo "Remote path not found: ~/${REMOTE_PUBLIC_HTML}" >&2
  echo "Available domains:" >&2
  hostinger_ssh "ls -1 ~/domains" >&2 || true
  exit 1
fi

RSYNC_EXCLUDES=(
  --exclude 'wp-content/ai1wm-backups/'
  --exclude 'wp-content/cache/'
  --exclude 'wp-content/upgrade/'
  --exclude 'wp-content/upgrade-temp-backup/'
  --exclude '.well-known/'
  --exclude '*.zip'
  --exclude '*.sql'
  --exclude '*.sql.gz'
  --exclude '.DS_Store'
)

if [[ "$WITH_UPLOADS" -eq 0 ]]; then
  RSYNC_EXCLUDES+=(--exclude 'wp-content/uploads/')
  echo "==> Pulling source (uploads excluded — pass --with-uploads to include)"
else
  echo "==> Pulling source (including uploads)"
fi

hostinger_rsync_from "$REMOTE_PUBLIC_HTML" "$LOCAL_PUBLIC" "${RSYNC_EXCLUDES[@]}"

echo "==> Scanning pulled source for malware"
"$ROOT/scripts/scan-malware.sh" || true

if [[ "$WITH_DB" -eq 1 ]]; then
  echo "==> Exporting database via remote mysqldump (from wp-config.php)"
  DUMP_REMOTE="/tmp/${DOMAIN:-site}_fresh.sql.gz"
  hostinger_ssh "cd ~/${REMOTE_PUBLIC_HTML} && \
    DB_NAME=\$(php -r \"include 'wp-config.php'; echo DB_NAME;\") && \
    DB_USER=\$(php -r \"include 'wp-config.php'; echo DB_USER;\") && \
    DB_PASS=\$(php -r \"include 'wp-config.php'; echo DB_PASSWORD;\") && \
    DB_HOST=\$(php -r \"include 'wp-config.php'; echo DB_HOST;\") && \
    mysqldump -h \"\$DB_HOST\" -u \"\$DB_USER\" -p\"\$DB_PASS\" \"\$DB_NAME\" \
      --single-transaction --quick --routines --triggers 2>/dev/null \
      | gzip -c > '${DUMP_REMOTE}' && ls -lh '${DUMP_REMOTE}'"
  hostinger_run rsync -avz --progress -e "$RSYNC_SSH" \
    "${REMOTE_HOST}:${DUMP_REMOTE}" \
    "$ROOT/.docs/hostinger/${DOMAIN:-site}_fresh.sql.gz"
  echo "==> DB dump saved to .docs/hostinger/${DOMAIN:-site}_fresh.sql.gz"
fi

# --- scaffold repo files (non-destructive if already customized) ---
write_if_missing() {
  local path="$1"
  local content="$2"
  if [[ -f "$path" ]]; then
    echo "keep existing: $path"
    return 0
  fi
  mkdir -p "$(dirname "$path")"
  printf '%s\n' "$content" > "$path"
  echo "created: $path"
}

write_if_missing "$ROOT/.gitignore" "$(cat <<'GITIGNORE'
# Secrets / credentials
.env
**/.env
.docs/hostinger/.env
.docs/hostinger/*.sql
.docs/hostinger/*.sql.gz
public_html/wp-config.php

# WordPress bulky / generated
public_html/wp-content/uploads/
public_html/wp-content/ai1wm-backups/
public_html/wp-content/cache/
public_html/wp-content/upgrade/
public_html/wp-content/upgrade-temp-backup/
public_html/**/*.zip
public_html/**/*.sql
public_html/.well-known/

# OS / editor
.DS_Store
*.swp
.idea/
.vscode/
GITIGNORE
)"

write_if_missing "$ROOT/.docs/hostinger/README.md" "$(cat <<EOF
# Hostinger — ${DOMAIN:-site}

Remote web root:

\`\`\`text
~/${REMOTE_PUBLIC_HTML}
\`\`\`

## Pull / refresh source

\`\`\`bash
./scripts/init-from-hostinger.sh
./scripts/init-from-hostinger.sh --with-uploads --with-db
\`\`\`

## Deploy theme edits

\`\`\`bash
./scripts/deploy.sh
\`\`\`
EOF
)"

if [[ "$SKIP_DOCKER" -eq 0 ]]; then
  write_if_missing "$ROOT/docker-compose.yml" "$(cat <<'YML'
services:
  db:
    image: mysql:8.0
    container_name: wp-db
    restart: unless-stopped
    environment:
      MYSQL_DATABASE: wordpress
      MYSQL_USER: wordpress
      MYSQL_PASSWORD: wordpress
      MYSQL_ROOT_PASSWORD: rootpass
    ports:
      - "3307:3306"
    volumes:
      - wp_db_data:/var/lib/mysql
    command: --default-authentication-plugin=mysql_native_password --character-set-server=utf8mb4 --collation-server=utf8mb4_unicode_ci
    healthcheck:
      test: ["CMD", "mysqladmin", "ping", "-h", "127.0.0.1", "-uroot", "-prootpass"]
      interval: 5s
      timeout: 5s
      retries: 30

  wordpress:
    image: wordpress:php8.2-apache
    container_name: wp-app
    restart: unless-stopped
    depends_on:
      db:
        condition: service_healthy
    ports:
      - "8080:80"
    environment:
      WORDPRESS_DB_HOST: db:3306
      WORDPRESS_DB_USER: wordpress
      WORDPRESS_DB_PASSWORD: wordpress
      WORDPRESS_DB_NAME: wordpress
      WP_DOCKER: "1"
    volumes:
      - ./public_html:/var/www/html
      - ./docker/php/uploads.ini:/usr/local/etc/php/conf.d/uploads.ini:ro

  phpmyadmin:
    image: phpmyadmin:5
    container_name: wp-pma
    restart: unless-stopped
    depends_on:
      - db
    ports:
      - "8081:80"
    environment:
      PMA_HOST: db
      PMA_USER: wordpress
      PMA_PASSWORD: wordpress

volumes:
  wp_db_data:
YML
)"

  write_if_missing "$ROOT/docker/php/uploads.ini" "$(cat <<'INI'
file_uploads = On
memory_limit = 512M
upload_max_filesize = 128M
post_max_size = 128M
max_execution_time = 300
max_input_vars = 5000
INI
)"

  write_if_missing "$ROOT/README.md" "$(cat <<EOF
# ${DOMAIN:-WordPress site}

## Init / refresh from Hostinger

See [Init.md](./Init.md).

\`\`\`bash
./scripts/init-from-hostinger.sh --with-db
\`\`\`

## Local Docker

\`\`\`bash
docker compose up -d
\`\`\`

- Site: http://localhost:8080
- phpMyAdmin: http://localhost:8081

Import DB (if dumped):

\`\`\`bash
gunzip -c .docs/hostinger/${DOMAIN:-site}_fresh.sql.gz | docker compose exec -T db mysql -uroot -prootpass wordpress
\`\`\`

## Deploy

\`\`\`bash
./scripts/deploy.sh
\`\`\`
EOF
)"
fi

# Ensure deploy script exists (copy from this toolkit if missing in a fresh clone pattern)
if [[ ! -f "$ROOT/scripts/deploy.sh" ]]; then
  echo "Note: scripts/deploy.sh missing — copy toolkit scripts into the new repo."
fi

SIZE="$(du -sh "$LOCAL_PUBLIC" 2>/dev/null | awk '{print $1}')"
echo ""
echo "Init complete."
echo "  Domain:  ${DOMAIN:-custom}"
echo "  Local:   $LOCAL_PUBLIC ($SIZE)"
echo "  Next:    edit theme under public_html/wp-content/themes/"
echo "           ./scripts/deploy.sh   # push theme changes"
if [[ "$WITH_DB" -eq 1 ]]; then
  echo "  DB dump: .docs/hostinger/${DOMAIN:-site}_fresh.sql.gz"
fi
