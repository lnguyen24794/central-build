# Local Docker (WordPress)

## New domain starter kit

Starter kit nằm ở repo riêng: **[lnguyen24794/base_hostinger](https://github.com/lnguyen24794/base_hostinger)**

```bash
git clone https://github.com/lnguyen24794/base_hostinger.git ~/GitHub/base_hostinger
~/GitHub/base_hostinger/scripts/new-site.sh anthomevn.vn ~/GitHub
cd ~/GitHub/anthomevn.vn
# điền password trong .docs/hostinger/.env nếu cần
./scripts/init-from-hostinger.sh --with-db
```

`public_html/` = source domain đích. Chi tiết: [Init.md](./Init.md)

## Init from Hostinger (this repo)

```bash
./scripts/init-from-hostinger.sh --list-domains
./scripts/init-from-hostinger.sh --with-db
```

## Quick start (local)

```bash
chmod +x docker/scripts/bootstrap.sh
./docker/scripts/bootstrap.sh
```

- Site: http://localhost:8080  
- phpMyAdmin: http://localhost:8081  
- DB: `evoplumb` / user `evoplumb` / pass `evoplumb` (port `3307`)

## What bootstrap does

1. Starts `db`, `wordpress`, `phpmyadmin`, `wpcli`
2. Imports `.docs/hostinger/evoplumb_fresh.sql.gz`
3. Rewrites URLs to `http://localhost:8080`
4. Runs `docker/scripts/setup-content.php` (creates `/heat-pump-hot-water/...` pages)

## Redeploy content only

```bash
docker compose exec -T wpcli wp eval-file /scripts/setup-content.php --allow-root
```

## Production theme sync

```bash
./scripts/deploy.sh
./scripts/deploy.sh --css --flush
```
