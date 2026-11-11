# Hostinger — centralbuild.au

## SSH

Credentials: `.docs/hostinger/.env` (not committed — copy from `.env.example`).

| Field | Value |
|-------|--------|
| Host | `SERVER_NAME` |
| Port | `SSH_PORT` |
| User | `SSH_USERNAME` |

Remote web root:

```text
~/domains/centralbuild.au/public_html
```

| Item | Value |
|------|-------|
| WordPress | 7.1.x |
| Theme | `wp-content/themes/central-build` (git clone of `lnguyen24794/central-build`) |
| Plugins | classic-editor, litespeed-cache, hostinger-* |
| Table prefix | `wp_` |

## Pull source (local edit)

```bash
./scripts/init-from-hostinger.sh                           # code only
./scripts/init-from-hostinger.sh --with-uploads --with-db  # + media + DB dump
```

DB dump lands in `.docs/hostinger/centralbuild.au_fresh.sql.gz` (gitignored).

## Push edits

```bash
./scripts/deploy.sh --dry-run   # preview
./scripts/deploy.sh             # whole theme
./scripts/deploy.sh --css --flush
./scripts/deploy.sh front-page.php css/components.css
```

Only `themes/central-build` is deployed (`.git/`, `Html_pages/` excluded).

## Custom code focus

- Theme: `public_html/wp-content/themes/central-build/`
- Plugins: `public_html/wp-content/plugins/`
