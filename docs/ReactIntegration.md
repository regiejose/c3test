# React Integration

## React Structure
```bash
senior_theme/js
├── main.jsx        # Main entrypoint
└── react/
  └── components/
    ├── FooterAbout.jsx
    └── FooterMenu.jsx
```

## React integration
Found in 'senior_theme/templates/includes/footer.html.twig'
```bash
<div 
  id="react-footer-about" 
  data-endpoint="/v1/api/footer-about">
</div>
```

```bash
<div 
  id="react-footer-menu" 
  data-endpoint="/v1/api/footer-menu">
</div>
```

## React fetch example
```bash
fetch(endpoint)
  .then(res => res.json())
  .then(setData)
```

## IMPORTANT!
Make sure to execute 'npm run build' once you're done updating the reactjs file.
```bash
npm run build
```