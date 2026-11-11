# centralbuild.au — WordPress

`public_html/` = source của `centralbuild.au` trên Hostinger (gitignored).
Theme custom: `public_html/wp-content/themes/central-build/`.

## Init / refresh từ Hostinger

```bash
cp .docs/hostinger/.env.example .docs/hostinger/.env   # điền SSH_PASSWORD
./scripts/init-from-hostinger.sh --with-uploads --with-db
```

Chi tiết: [.docs/hostinger/README.md](./.docs/hostinger/README.md), [Init.md](./Init.md).

## Local (Docker)

```bash
./docker/scripts/bootstrap.sh
```

- Site: http://localhost:8080
- WP Admin: http://localhost:8080/wp-admin/
- phpMyAdmin: http://localhost:8081
- DB: `centralbuild` / user `centralbuild` / pass `centralbuild` (port `3307`), prefix `wp_`

Bootstrap: khởi động containers → import `.docs/hostinger/centralbuild.au_fresh.sql.gz`
→ đổi URL `https://centralbuild.au` → `http://localhost:8080` → tắt LiteSpeed / Hostinger plugins ở local.

`wp-config.php` local tự dùng DB Docker khi có biến `WP_DOCKER` / `WORDPRESS_DB_HOST`;
trên server vẫn dùng DB production.

## Deploy theme

```bash
./scripts/deploy.sh --dry-run
./scripts/deploy.sh
./scripts/deploy.sh --css --flush
```
