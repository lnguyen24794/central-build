#!/usr/bin/env bash
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/../.." && pwd)"
SQL_GZ="$ROOT/.docs/hostinger/evoplumb_fresh.sql.gz"
SITE_URL="${SITE_URL:-http://localhost:8080}"

cd "$ROOT"

echo "==> Starting containers"
docker compose up -d db wordpress phpmyadmin wpcli

echo "==> Waiting for MySQL"
for i in $(seq 1 60); do
  if docker compose exec -T db mysqladmin ping -h 127.0.0.1 -uroot -prootpass --silent; then
    break
  fi
  sleep 2
done

echo "==> Importing database"
gunzip -c "$SQL_GZ" | docker compose exec -T db mysql -uroot -prootpass evoplumb

echo "==> Fixing file ownership for Apache"
docker compose exec -T -u root wordpress chown -R www-data:www-data /var/www/html/wp-content || true

echo "==> URL search-replace + options"
docker compose exec -T -u root wpcli wp option update home "$SITE_URL" --allow-root
docker compose exec -T -u root wpcli wp option update siteurl "$SITE_URL" --allow-root
docker compose exec -T -u root wpcli wp search-replace 'https://evoplumbenergysaver.com' "$SITE_URL" --all-tables --precise --recurse-objects --skip-columns=guid --allow-root || true
docker compose exec -T -u root wpcli wp search-replace 'http://evoplumbenergysaver.com' "$SITE_URL" --all-tables --precise --recurse-objects --skip-columns=guid --allow-root || true
docker compose exec -T -u root wpcli wp cache flush --allow-root || true

echo "==> Running content setup"
docker compose exec -T -u root wpcli wp eval-file /scripts/setup-content.php --allow-root

echo "==> Done"
echo "Site:        $SITE_URL"
echo "phpMyAdmin:  http://localhost:8081"
echo "WP Admin:    $SITE_URL/wp-admin/"
