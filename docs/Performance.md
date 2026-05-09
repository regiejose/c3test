# Performance
This project uses Drupal’s Cache API to improve performance by reducing redundant computation and external API requests while ensuring data consistency.

Drupal provides a layered caching system composed of:

- Cache API (storage layer)
- Cache Tags (invalidation mechanism)
- Cache Contexts (variation mechanism)

## Cache API

Cache API is used to store and retrieve precomputed data.

It prevents unnecessary processing or external API calls by serving cached responses when available.

### Example usage:
```bash
$cid = 'senior_portal:footer_menu';

$cache = \Drupal::cache()->get($cid);

if ($cache) {
  return new JsonResponse($cache->data);
}

\Drupal::cache()->set(
  $cid,
  $data,
  time() + 3600,
  ['senior_portal:data']
);
```

## Cache Tags
Cache Tags are used to invalidate cached data when related content changes.

### Example:
```bash
# render array
return [
  '#theme' => 'senior_portal_page',
  '#items' => $this->apiService->fetchData(),
  '#cache' => [
    'tags' => ['senior_portal:data'],
    'max-age' => 3600,
  ],
];
```

```bash
# Cache set
\Drupal::cache()->set(
  $cid,
  $data,
  time() + 3600,
  ['senior_portal:data']    # cache tag
);
```
### Invalidation:
Purpose
- Ensures cached data stays fresh
- Enables fine-grained cache invalidation
- Avoids full cache rebuilds
```bash
\Drupal::service('cache_tags.invalidator')
  ->invalidateTags(['senior_portal:data']);
```

## Cache context
Cache Contexts define variations of cached content based on request-specific conditions.

Unlike cache tags (which invalidate), cache contexts create different cached versions of the same content.

### Example
```bash
return [
  '#theme' => 'senior_portal_page',
  '#items' => $this->apiService->fetchData(),
  '#cache' => [
    'tags' => ['senior_portal:data'],
    'max-age' => 3600,
    'contexts' => ['user.roles']
  ],
];
```