#!/usr/bin/env bash
# Start local Docker stack and import the production DB dump of centralbuild.au.
#
# Prerequisite: ./scripts/init-from-hostinger.sh --with-db
#   -> .docs/hostinger/centralbuild.au_fresh.sql.gz
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/../.." && pwd)"
PROD_DOMAIN="${PROD_DOMAIN:-centralbuild.au}"
SQL_GZ="${SQL_GZ:-$ROOT/.docs/hostinger/${PROD_DOMAIN}_fresh.sql.gz}"
SITE_URL="${SITE_URL:-http://localhost:8080}"
DB_NAME="centralbuild"

cd "$ROOT"

if [[ ! -f "$SQL_GZ" ]]; then
  echo "Missing DB dump: $SQL_GZ" >&2
  echo "Run: ./scripts/init-from-hostinger.sh --with-db" >&2
  exit 1
fi

echo "==> Starting containers"
docker compose up -d db wordpress phpmyadmin wpcli

echo "==> Waiting for MySQL"
for _ in $(seq 1 60); do
  if docker compose exec -T db mysqladmin ping -h 127.0.0.1 -uroot -prootpass --silent 2>/dev/null; then
    break
  fi
  sleep 2
done

echo "==> Importing database"
gunzip -c "$SQL_GZ" | docker compose exec -T db mysql -uroot -prootpass "$DB_NAME"

echo "==> Fixing file ownership for Apache"
docker compose exec -T -u root wordpress chown -R www-data:www-data /var/www/html/wp-content || true

wp() { docker compose exec -T -u root wpcli wp "$@" --allow-root; }

echo "==> URL search-replace ${PROD_DOMAIN} -> ${SITE_URL}"
wp search-replace "https://www.${PROD_DOMAIN}" "$SITE_URL" --all-tables --precise --recurse-objects --skip-columns=guid || true
wp search-replace "https://${PROD_DOMAIN}" "$SITE_URL" --all-tables --precise --recurse-objects --skip-columns=guid || true
wp search-replace "http://${PROD_DOMAIN}" "$SITE_URL" --all-tables --precise --recurse-objects --skip-columns=guid || true
wp option update home "$SITE_URL"
wp option update siteurl "$SITE_URL"

echo "==> Disabling production-only plugins locally"
wp plugin deactivate litespeed-cache hostinger-preview-domain-3D0Nn1pOX6EgFUqh hostinger-auto-updates-plugin-1KLGgkUv8UonqaN3 2>/dev/null || true
wp rewrite flush --hard 2>/dev/null || true
wp cache flush || true

echo "==> Done"
echo "Site:        $SITE_URL"
echo "phpMyAdmin:  http://localhost:8081"
echo "WP Admin:    $SITE_URL/wp-admin/"
