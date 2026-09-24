#!/usr/bin/env bash
# Local WP + WooCommerce smoke runner (requires WP-CLI and a WP install path)
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
WP_PATH=""

while [[ $# -gt 0 ]]; do
  case "$1" in
    --path=*) WP_PATH="${1#*=}"; shift ;;
    --path) WP_PATH="$2"; shift 2 ;;
    *) echo "Unknown arg: $1"; exit 1 ;;
  esac
done

if [ -z "$WP_PATH" ]; then
  echo "Usage: $0 --path=/path/to/wordpress"
  exit 1
fi

if ! command -v wp >/dev/null 2>&1; then
  echo "WP-CLI not found"
  exit 1
fi

echo "Running local smoke against $WP_PATH"
wp --path="$WP_PATH" plugin list || true
echo "Smoke local finished (extend with real product/price assertions as needed)"
