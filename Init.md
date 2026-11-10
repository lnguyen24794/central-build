# Init WordPress repo từ Hostinger

Starter kit đã chuyển sang repo riêng:

**https://github.com/lnguyen24794/base_hostinger**

`public_html/` trong mỗi repo = source của domain đích.

## Tạo repo/domain mới

```bash
# Clone starter kit
git clone https://github.com/lnguyen24794/base_hostinger.git ~/GitHub/base_hostinger

# Cách 1 — helper
~/GitHub/base_hostinger/scripts/new-site.sh anthomevn.vn ~/GitHub

# Cách 2 — copy tay
cp -R ~/GitHub/base_hostinger ~/GitHub/anthomevn.vn
cd ~/GitHub/anthomevn.vn
rm -rf .git
git init
cp .docs/hostinger/.env.example .docs/hostinger/.env
# điền DOMAIN + password
```

## Lấy source

```bash
cd ~/GitHub/anthomevn.vn
chmod +x scripts/*.sh
./scripts/init-from-hostinger.sh --list-domains
./scripts/init-from-hostinger.sh --with-db
```

Source về `./public_html/`.

## Local + deploy

```bash
docker compose up -d
./scripts/deploy.sh
```

Chi tiết đầy đủ trong repo `base_hostinger` → `Init.md`.
