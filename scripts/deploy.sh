#!/usr/bin/env bash
# Deploy the theme (THEME_SLUG, default central-build) to Hostinger (DOMAIN from .env).
#
# Usage:
#   ./scripts/deploy.sh                       # sync whole theme
#   ./scripts/deploy.sh --css                 # sync css/ + js/ only
#   ./scripts/deploy.sh --flush               # also purge LiteSpeed / WP cache
#   ./scripts/deploy.sh --dry-run             # show what would change
#   ./scripts/deploy.sh --mu                  # also sync mu-plugins/ (access control) to wp-content/mu-plugins
#   ./scripts/deploy.sh front-page.php css/components.css
#
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
# shellcheck source=lib/hostinger-env.sh
source "$ROOT/scripts/lib/hostinger-env.sh"

ENV_FILE="$ROOT/.docs/hostinger/.env"

CSS_ONLY=0
MU=0
FLUSH=0
DRY_RUN=0
PATHS=()

usage() {
  cat <<'USAGE'
Deploy theme to Hostinger (DOMAIN + THEME_SLUG from .docs/hostinger/.env).

  ./scripts/deploy.sh
  ./scripts/deploy.sh --css
  ./scripts/deploy.sh --flush
  ./scripts/deploy.sh --dry-run
  ./scripts/deploy.sh --mu              # also sync mu-plugins/ (access control)
  ./scripts/deploy.sh front-page.php css/components.css
  ./scripts/deploy.sh --css --flush
USAGE
  exit "${1:-0}"
}

while [[ $# -gt 0 ]]; do
  case "$1" in
    -h|--help) usage 0 ;;
    --css) CSS_ONLY=1; shift ;;
    --flush) FLUSH=1; shift ;;
    -n|--dry-run) DRY_RUN=1; shift ;;
    --mu) MU=1; shift ;;
    -*)
      echo "Unknown option: $1" >&2
      usage 1
      ;;
    *)
      PATHS+=("$1")
      shift
      ;;
  esac
done

hostinger_load_env "$ENV_FILE"
THEME_SLUG="${THEME_SLUG:-central-build}"

LOCAL_THEME="$ROOT/public_html/wp-content/themes/${THEME_SLUG}"
REMOTE_THEME="${REMOTE_PUBLIC_HTML}/wp-content/themes/${THEME_SLUG}"
REMOTE="${REMOTE_HOST}"

RSYNC_OPTS=(--exclude '.git/' --exclude '.gitignore' --exclude '.DS_Store' --exclude 'Html_pages/' --exclude '*.markdown')
[[ "$DRY_RUN" -eq 1 ]] && RSYNC_OPTS+=(--dry-run)

if [[ ! -d "$LOCAL_THEME" ]]; then
  echo "Local theme not found: $LOCAL_THEME" >&2
  echo "Set THEME_SLUG in .docs/hostinger/.env (current: ${THEME_SLUG})" >&2
  exit 1
fi

sync_dir() {
  # sync_dir <relative dir inside theme, or empty for whole theme>
  local rel="$1"
  local src="$LOCAL_THEME${rel:+/$rel}"
  local dst="$REMOTE_THEME${rel:+/$rel}"
  echo "==> Sync ${THEME_SLUG}/${rel} -> ${DOMAIN}"
  hostinger_rsync_to "$src" "$dst" "${RSYNC_OPTS[@]}"
}

sync_paths() {
  local p rel
  for p in "${PATHS[@]}"; do
    if [[ "$p" != /* ]]; then
      if [[ -e "$LOCAL_THEME/$p" ]]; then
        p="$LOCAL_THEME/$p"
      elif [[ -e "$ROOT/$p" ]]; then
        p="$ROOT/$p"
      fi
    fi
    if [[ ! -e "$p" ]]; then
      echo "Not found: $p" >&2
      exit 1
    fi
    case "$p" in
      "$LOCAL_THEME"/*) ;;
      *)
        echo "Only paths under themes/${THEME_SLUG} are allowed: $p" >&2
        exit 1
        ;;
    esac
    rel="${p#"$LOCAL_THEME"/}"
    if [[ -d "$p" ]]; then
      sync_dir "$rel"
    else
      echo "==> Sync file $rel"
      hostinger_run rsync -avz --checksum "${RSYNC_OPTS[@]}" -e "$RSYNC_SSH" "$p" "$REMOTE:${REMOTE_THEME}/${rel}"
    fi
  done
}

if [[ "$CSS_ONLY" -eq 1 ]]; then
  sync_dir css
  sync_dir js
elif [[ ${#PATHS[@]} -gt 0 ]]; then
  sync_paths
else
  sync_dir ""
fi

if [[ "$MU" -eq 1 ]]; then
  echo "==> Sync mu-plugins/ -> ${DOMAIN} (wp-content/mu-plugins)"
  MU_OPTS=(--exclude '.DS_Store')
  [[ "$DRY_RUN" -eq 1 ]] && MU_OPTS+=(--dry-run)
  hostinger_rsync_to "$ROOT/mu-plugins" "${REMOTE_PUBLIC_HTML}/wp-content/mu-plugins" "${MU_OPTS[@]}"
fi

if [[ "$FLUSH" -eq 1 && "$DRY_RUN" -eq 0 ]]; then
  echo "==> Purging cache on ${DOMAIN}"
  hostinger_ssh "cd ~/${REMOTE_PUBLIC_HTML} && (wp litespeed-purge all 2>/dev/null || true) && wp cache flush 2>/dev/null; true"
fi

echo ""
echo "Deploy done → https://${DOMAIN}/"
echo "Tip: hard-refresh (Cmd+Shift+R) if CSS looks cached."
