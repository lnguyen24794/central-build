#!/usr/bin/env bash
# Back-compat wrapper — use ./scripts/deploy.sh
exec "$(cd "$(dirname "$0")" && pwd)/deploy.sh" "$@"
