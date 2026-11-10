# Hostinger — evoplumbenergysaver.com

## SSH

Credentials: `.docs/hostinger/.env` (not committed).

| Field | Value |
|-------|--------|
| Host | `SERVER_NAME` |
| Port | `SSH_PORT` |
| User | `SSH_USERNAME` |

Remote web root:

```text
~/domains/evoplumbenergysaver.com/public_html
```

## Pull source (local edit)

From repo root (password from `.env`):

```bash
rsync -avz \
  -e "ssh -p $SSH_PORT" \
  --exclude 'wp-content/ai1wm-backups/' \
  --exclude 'wp-content/uploads/' \
  --exclude 'wp-content/cache/' \
  --exclude '*.zip' \
  --exclude '*.sql' \
  "$SSH_USERNAME@$SERVER_NAME:domains/evoplumbenergysaver.com/public_html/" \
  ./public_html/
```

## Push edits

```bash
./scripts/deploy.sh
```

CSS only:

```bash
./scripts/deploy.sh --css --flush
```

Specific files under `porto-child`:

```bash
./scripts/deploy.sh front-page.php assets/css/evo-brand.css
```

## Custom code focus

- Theme: `public_html/wp-content/themes/porto-child/`
- Parent: `public_html/wp-content/themes/porto/`
- Plugins: `public_html/wp-content/plugins/`
