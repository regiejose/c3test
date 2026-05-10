## Security

### Access Control

The `/senior-portal` route is restricted to authenticated users with "access senior portal" permission only.

```bash
requirements:
  _permission: 'access senior portal'
```