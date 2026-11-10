#!/usr/bin/env bash
# Deploy porto-child theme to Hostinger production (DOMAIN from .env).
#
# Usage:
#   ./scripts/deploy.sh
#   ./scripts/deploy.sh --css
#   ./scripts/deploy.sh --flush
#   ./scripts/deploy.sh --setup
#   ./scripts/deploy.sh assets/css/evo-brand.css
#
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
# shellcheck source=lib/hostinger-env.sh
source "$ROOT/scripts/lib/hostinger-env.sh"

ENV_FILE="$ROOT/.docs/hostinger/.env"
LOCAL_THEME=""

CSS_ONLY=0
FLUSH=0
SETUP=0
PATHS=()

usage() {
  cat <<'USAGE'
Deploy porto-child to Hostinger (DOMAIN from .docs/hostinger/.env).

  ./scripts/deploy.sh
  ./scripts/deploy.sh --css
  ./scripts/deploy.sh --flush
  ./scripts/deploy.sh --setup
  ./scripts/deploy.sh assets/css/evo-brand.css front-page.php
  ./scripts/deploy.sh --css --flush
USAGE
  exit "${1:-0}"
}

while [[ $# -gt 0 ]]; do
  case "$1" in
    -h|--help) usage 0 ;;
    --css) CSS_ONLY=1; shift ;;
    --flush) FLUSH=1; shift ;;
    --setup) SETUP=1; shift ;;
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

LOCAL_THEME="$ROOT/public_html/wp-content/themes/${THEME_SLUG}"
REMOTE_THEME="${REMOTE_PUBLIC_HTML}/wp-content/themes/${THEME_SLUG}"
REMOTE="${REMOTE_HOST}"

if [[ ! -d "$LOCAL_THEME" ]]; then
  echo "Local theme not found: $LOCAL_THEME" >&2
  echo "Set THEME_SLUG in .docs/hostinger/.env (current: ${THEME_SLUG})" >&2
  exit 1
fi

bump_css_version() {
  local functions="$LOCAL_THEME/functions.php"
  [[ -f "$functions" ]] || return 0

  local current next major minor patch
  current="$(
    perl -ne "if (/evo-brand\\.css/ .. /;/) { if (/\\s*'([0-9]+\\.[0-9]+\\.[0-9]+)'/) { print \$1; exit } }" "$functions"
  )"
  if [[ -z "$current" ]]; then
    echo "Could not detect CSS version (skip bump)"
    return 0
  fi
  IFS=. read -r major minor patch <<<"$current"
  next="${major}.${minor}.$((patch + 1))"
  perl -i -0pe "s/(evo-brand\\.css.*?array\\( 'styles-child' \\),\\s*)'${current}'/\${1}'${next}'/s" "$functions"
  echo "CSS version: $current -> $next"
}

sync_theme_all() {
  echo "==> Sync ${THEME_SLUG} -> ${DOMAIN} (${REMOTE_THEME})"
  hostinger_rsync_to "$LOCAL_THEME" "$REMOTE_THEME" \
    --exclude 'screenshot.png' \
    --exclude '.DS_Store'
}

sync_css() {
  bump_css_version
  echo "==> Sync CSS + functions.php"
  hostinger_run rsync -avz --checksum -e "$RSYNC_SSH" \
    "$LOCAL_THEME/assets/css/evo-brand.css" \
    "$REMOTE:${REMOTE_THEME}/assets/css/evo-brand.css"
  hostinger_run rsync -avz --checksum -e "$RSYNC_SSH" \
    "$LOCAL_THEME/functions.php" \
    "$REMOTE:${REMOTE_THEME}/functions.php"
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
      "$LOCAL_THEME"/*|"$LOCAL_THEME") ;;
      *)
        echo "Only paths under porto-child are allowed: $p" >&2
        exit 1
        ;;
    esac
    rel="${p#"$LOCAL_THEME"/}"
    if [[ -d "$p" ]]; then
      echo "==> Sync dir $rel/"
      hostinger_run rsync -avz --checksum -e "$RSYNC_SSH" "$p/" "$REMOTE:${REMOTE_THEME}/${rel}/"
    else
      echo "==> Sync file $rel"
      hostinger_run rsync -avz --checksum -e "$RSYNC_SSH" "$p" "$REMOTE:${REMOTE_THEME}/${rel}"
    fi
  done
}

remote_wp() {
  local cmd="$1"
  echo "==> Remote WP: $cmd"
  hostinger_ssh "cd ~/${REMOTE_PUBLIC_HTML} && ${cmd}"
}

if [[ "$CSS_ONLY" -eq 1 ]]; then
  sync_css
elif [[ ${#PATHS[@]} -gt 0 ]]; then
  sync_paths
else
  sync_theme_all
fi

if [[ "$SETUP" -eq 1 ]]; then
  remote_wp "wp eval-file wp-content/themes/${THEME_SLUG}/bin/setup-content.php"
fi

if [[ "$FLUSH" -eq 1 ]]; then
  remote_wp "wp cache flush 2>/dev/null; rm -rf wp-content/cache/* 2>/dev/null; true"
fi

echo ""
echo "Deploy done → https://${DOMAIN}/"
echo "Tip: hard-refresh (Cmd+Shift+R) if CSS looks cached."
