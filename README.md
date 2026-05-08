# C3 Test
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
git clone <repo>
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
# or automatically log in with:
ddev launch $(ddev drush uli)
```