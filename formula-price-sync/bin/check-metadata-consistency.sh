#!/usr/bin/env bash
# Check version consistency across files
set -euo pipefail
ROOT="$(cd "$(dirname "$0")/.." && pwd)"
VER_PHP="$(grep -E '^ \* Version:' "$ROOT/formula-price-sync.php" | head -1 | sed 's/.*Version:[[:space:]]*//')"
VER_README="$(grep -E '^Stable tag:' "$ROOT/readme.txt" 2>/dev/null | head -1 | sed 's/Stable tag:[[:space:]]*//' || true)"
VER_COMPOSER="$(python3 -c "import json; print(json.load(open('$ROOT/composer.json')).get('version',''))" 2>/dev/null || true)"

echo "PHP header version: $VER_PHP"
echo "readme.txt Stable tag: ${VER_README:-n/a}"
echo "composer.json version: ${VER_COMPOSER:-n/a}"

if [ -n "$VER_README" ] && [ "$VER_PHP" != "$VER_README" ]; then
  echo "ERROR: Version mismatch PHP vs readme.txt"
  exit 1
fi
echo "Metadata consistency OK"
