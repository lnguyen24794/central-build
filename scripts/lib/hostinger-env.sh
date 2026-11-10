#!/usr/bin/env bash
# Shared Hostinger helpers — sourced by init/deploy scripts.
# shellcheck shell=bash

hostinger_load_env() {
  local env_file="${1:-}"
  if [[ -z "$env_file" || ! -f "$env_file" ]]; then
    echo "Missing env file: ${env_file:-"(empty)"}" >&2
    return 1
  fi

  SERVER_NAME=""
  SSH_USERNAME=""
  SSH_PASSWORD=""
  SSH_PORT="22"
  DOMAIN=""
  REMOTE_PUBLIC_HTML=""
  THEME_SLUG="porto-child"

  local line key val
  while IFS= read -r line || [[ -n "$line" ]]; do
    [[ -z "$line" || "$line" =~ ^[[:space:]]*# ]] && continue
    key="${line%%=*}"
    val="${line#*=}"
    if [[ "$val" =~ ^\'(.*)\'$ ]]; then val="${BASH_REMATCH[1]}"; fi
    if [[ "$val" =~ ^\"(.*)\"$ ]]; then val="${BASH_REMATCH[1]}"; fi
    case "$key" in
      SERVER_NAME|SSH_USERNAME|SSH_PASSWORD|SSH_PORT|DOMAIN|REMOTE_PUBLIC_HTML|THEME_SLUG)
        printf -v "$key" '%s' "$val"
        ;;
    esac
  done < "$env_file"

  if [[ -z "$SERVER_NAME" || -z "$SSH_USERNAME" || -z "$SSH_PASSWORD" ]]; then
    echo "SERVER_NAME, SSH_USERNAME, SSH_PASSWORD are required in $env_file" >&2
    return 1
  fi

  if [[ -z "$DOMAIN" && -z "$REMOTE_PUBLIC_HTML" ]]; then
    echo "DOMAIN (or REMOTE_PUBLIC_HTML) is required in $env_file" >&2
    return 1
  fi

  if [[ -z "$REMOTE_PUBLIC_HTML" ]]; then
    REMOTE_PUBLIC_HTML="domains/${DOMAIN}/public_html"
  fi

  if [[ -z "$THEME_SLUG" ]]; then
    THEME_SLUG="porto-child"
  fi

  REMOTE_HOST="${SSH_USERNAME}@${SERVER_NAME}"
  RSYNC_SSH="ssh -p ${SSH_PORT} -o StrictHostKeyChecking=accept-new"
}

hostinger_run() {
  # Run command that may prompt for SSH password.
  if command -v sshpass >/dev/null 2>&1; then
    SSHPASS="$SSH_PASSWORD" sshpass -e "$@"
    return $?
  fi

  if ! command -v expect >/dev/null 2>&1; then
    echo "Need expect or sshpass installed." >&2
    return 1
  fi

  local argv="" a
  for a in "$@"; do
    argv+="$a"$'\n'
  done
  export EXPECT_PASS="$SSH_PASSWORD"
  export EXPECT_ARGV="$argv"
  expect <<'EOF'
set timeout -1
set password $env(EXPECT_PASS)
set raw $env(EXPECT_ARGV)
set args [split [string trimright $raw "\n"] "\n"]
eval [concat [list spawn] $args]
expect {
  -re "(?i)password:" { send -- "$password\r"; exp_continue }
  eof
}
catch wait result
exit [lindex $result 3]
EOF
}

hostinger_ssh() {
  hostinger_run ssh -p "$SSH_PORT" -o StrictHostKeyChecking=accept-new "$REMOTE_HOST" "$@"
}

hostinger_rsync_from() {
  # hostinger_rsync_from <remote-path> <local-path> [extra rsync args...]
  local remote_path="$1"
  local local_path="$2"
  shift 2
  mkdir -p "$local_path"
  hostinger_run rsync -avz --checksum "$@" \
    -e "$RSYNC_SSH" \
    "${REMOTE_HOST}:${remote_path}/" \
    "${local_path}/"
}

hostinger_rsync_to() {
  # hostinger_rsync_to <local-path> <remote-path> [extra rsync args...]
  local local_path="$1"
  local remote_path="$2"
  shift 2
  hostinger_run rsync -avz --checksum "$@" \
    -e "$RSYNC_SSH" \
    "${local_path}/" \
    "${REMOTE_HOST}:${remote_path}/"
}
