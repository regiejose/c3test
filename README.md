# C3 - Senior Portal - Test
A custom Drupal 10 project with modern frontend tooling and local development

The project uses DDEV to provide a reproducible containerized development environment aligned with modern Drupal DevOps practices. This ensures consistent PHP, database, and frontend tooling across developer machines.

## Requirements

- PHP 8.1+ (8.4 installed)
- Composer
- [DDEV](https://docs.ddev.com/en/stable/users/install/docker-installation/)
- [Docker](https://docs.docker.com/desktop/setup/install/windows-install/)


---

## Tech Stack

- Drupal
- PHP
- Twig
- Tailwind CSS
- ReactJS
- Vite
- MariaDB


---
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

## Theme (Drupal Theme + TailwindCSS + ReactJS)
Navigate to theme directory
```bash
cd web/themes/custom/senior_theme
```
Install Node packages:
```bash
npm install
```
Build assets (Tailwind + React)

Development mode
```bash
npm run dev
```

Production build
```bash
npm run build
```
