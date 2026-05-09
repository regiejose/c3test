## Local Development Setup
```bash
git clone git@github.com:regiejose/c3test.git
cd c3test
```

Start the Project
```bash
ddev start
```

Install PHP dependency
```bash
ddev composer install
```

Run Drupal installation and launch
```bash
ddev drush site:install --account-name=admin --account-pass=admin -y
ddev launch
# or
ddev launch $(ddev drush uli)
```

Export configuration
```bash
ddev drush cex -y
```

Cache Rebuild
```bash
ddev drush cr
```

## Theme (Drupal Theme + TailwindCSS + ReactJS)
Navigate to theme directory
```bash
cd web/themes/custom/senior_theme
```
Install Node packages:
```bash
npm install
```
### Build assets (Tailwind + React)

Development mode
```bash
npm run dev
```

Production build
```bash
npm run build
```
