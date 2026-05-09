# API response
API responses are cached using Drupal Cache API with a 1-hour TTL and cache tags (senior_portal:data) to ensure fast response times while allowing targeted invalidation when underlying data changes.


### Example
endpoint: /v1/api/portal
```bash
response:
[
  {
    "title": "React",
    "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
  },
  {
    "title": "Drupal",
    "description": "Fusce purus est, consequat eu dignissim ac, elementum a nisl."
  },
  {
    "title": "TailwindCSS",
    "description": "Orci varius natoque penatibus et magnis dis parturient montes,"
  }
]
```
endpoint: /v1/api/footer-about
```bash
response:
{
  "about": "Aliquam erat volutpat. Donec orci sem, volutpat sollicitudin velit id, condimentum ultricies tellus. Nunc velit turpis, iaculis id mauris ut, sollicitudin posuere est."
}
```

endpoint: /v1/api/footer-menu
```bash
response:
{
  "title": "C3 Interactive",
  "menuItems": [
    {
      "mid": 1,
      "mLabel": "About us",
      "mLink": "/about"
    },
    {
      "mid": 2,
      "mLabel": "Careers",
      "mLink": "/careers"
    },
    {
      "mid": 3,
      "mLabel": "Contact us",
      "mLink": "/contact-us"
    },
    {
      "mid": 4,
      "mLabel": "Privacy Policy",
      "mLink": "/privacy-policy"
    }
  ]
}
```