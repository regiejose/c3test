## Security

### Access Control

The `/senior-portal` route is restricted to authenticated users with "access senior portal" permission only.

```bash
requirements:
  _permission: 'access senior portal'
```

### JWT Protection (Drupal API)
It uses JWT (JSON Web Token) protection for securing API endpoints in Drupal. It ensures that only requests with valid tokens can access protected routes.
- Token-based authentication using JWT
- Secures custom API endpoints
- Returns proper 401 Unauthorized or 403 Forbidden responses
- Lightweight integration inside Drupal controllers or services
- Configurable secret key via environment variables
```bash
# Dependency
ddev composer require firebase/php-jwt
```
The system validates JWT from the Authorization header:
```bash
Authorization: Bearer <token>
```

## Dependency Injection

Services are injected via the Drupal service container.

Avoids excessive static service calls.

## Escaping

Twig auto-escaping is used throughout templates.

## Secure Configuration Handling

Environment variables are supported.

Sensitive credentials are not committed to Git.

NOTE: 
- For this demo project, local development configuration is committed via `.ddev/config.yaml` for easier setup.
- Sensitive credentials and environment-specific secrets should not be committed to the repository.
- In production environments, secrets should be stored using environment variables or secure secret management systems (e.g., GitHub Actions Secrets, server environment variables, Vault, AWS Secrets Manager, etc.).
