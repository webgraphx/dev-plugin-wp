#!/usr/bin/env bash
# Build clean marketplace release ZIP (no tests / no bin / no .github)
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
VERSION="$(grep -E '^ \* Version:' "$ROOT/formula-price-sync.php" | head -1 | sed 's/.*Version:[[:space:]]*//')"
OUT_DIR="$ROOT/build"
ZIP_NAME="formula-price-sync-${VERSION}.zip"
TMP="$(mktemp -d)"

cleanup() { rm -rf "$TMP"; }
trap cleanup EXIT

mkdir -p "$OUT_DIR"
rm -f "$OUT_DIR/$ZIP_NAME"

# Copy production files only
rsync -a --exclude='.git' --exclude='.github' --exclude='tests' --exclude='bin' \
  --exclude='build' --exclude='node_modules' --exclude='vendor' \
  --exclude='*.md' --exclude='phpunit.xml.dist' --exclude='phpcs.xml.dist' \
  --exclude='playwright.config.ts' --exclude='package.json' --exclude='composer.json' \
  --exclude='composer.lock' --exclude='.gitignore' \
  "$ROOT/" "$TMP/formula-price-sync/"

# Keep a minimal readme if needed
if [ -f "$ROOT/readme.txt" ]; then
  cp "$ROOT/readme.txt" "$TMP/formula-price-sync/"
fi

cd "$TMP"
zip -r "$OUT_DIR/$ZIP_NAME" formula-price-sync -x "*.DS_Store" "*/.git*"
echo "Built: $OUT_DIR/$ZIP_NAME"
