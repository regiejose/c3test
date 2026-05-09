import React from 'react'
import ReactDOM from 'react-dom/client'

import '../css/style.css'

import FooterAbout from './react/footerAbout'
import FooterMenu from './react/FooterMenu'


const footerAboutEl = document.getElementById('react-footer-about')
if (footerAboutEl) {
  ReactDOM.createRoot(footerAboutEl).render(
    <FooterAbout endpoint={footerAboutEl.dataset.endpoint} />
  )
}

const FooterMenuEl = document.getElementById('react-footer-menu');
if (FooterMenuEl) {
  ReactDOM.createRoot(FooterMenuEl).render(
    <FooterMenu endpoint={FooterMenuEl.dataset.endpoint} />
  )
}