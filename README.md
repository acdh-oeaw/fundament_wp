<p align="center">

  <h3 align="center">Fundament WP</h3>

  <p align="center">
    A starter HTML, CSS, and JavaScript framework/guideline for ACDH web applications, as a WordPress theme.
  </p>
</p>

<br>

## Table of contents

- [Status](#status)
- [Installation](#installation)
- [What's included](#whats-included)
- [Tips for creating your project website](#tips-for-creating-your-project-website)
- [Recommended Plugins](#recommended-plugins)
- [Fundament Footer with Editable center content](#fundament-extended-footer)
- [HERO Text Translate](#hero-text-translate)


## Status
The most recent stable version can be found under releases.

Moreover the project is currently under constant development.

## Installation
- Clone or copy into your WordPress directory wp-content/themes/
- You may also upload the theme as a .zip file from the WordPress dashboard.
- Activate the theme and make your changes mainly using the Customizer (Appearance > Customizer on WordPress dashboard)

## What's included

```
fundament_wp/
├── css/
│   └── assets.min.css (Fundament base CSS)
├── js/
│   └── assets.min.js (Fundament base JS)
└── style.css (Fundament theme CSS)
```

## Tips for creating your project website

- [ ] Find a name and create a logo preferably with a transparent background and export as .svg or .png
- [ ] Sketch or make a list of the main pages and the structure your website / application ([remember Shneiderman’s Mantra](http://www.codingthearchitecture.com/2015/01/08/shneidermans_mantra.html))
- [ ] Write must-have textual content such as "About the project, Team, Contact, Publications, Downloads" etc. in a text editor of your choice.
- [ ] Think about creating some introductory content (spell out the abbreviations!) to show on the primary section of your home page (i.e hero area)
- [ ] Develop main functionality of your application with your favourite server side language and use only basic HTML and CSS for the user interface
- [ ] Download Fundament or Fundament-WP and create a new website instance
- [ ] Add your project's title, logo, hero area content and information pages
- [ ] Create separate pages for your application's views and integrate your application into the HTML body of Fundament
- [ ] Check out Fundament's example pages and Bootstrap-4 for which CSS classes to use and adapt your components
- [ ] Create and enqueue additional .css and .js files to overwrite / extend existing styles or functionality


## Recommended Plugins
- SVG Support (https://wordpress.org/plugins/svg-support/)
- Shortcoder (https://wordpress.org/plugins/shortcoder/)
- Insert Headers and Footers (https://wordpress.org/plugins/insert-headers-and-footers/)
- WP Mail SMTP (https://de.wordpress.org/plugins/wp-mail-smtp/)
- Polylang Multilanguage plugin (https://wordpress.org/plugins/polylang/)
- ACDHCH GNU Mailman Newsletter subscribe widget (https://github.com/acdh-oeaw/fundament_wp_mailman)

## Fundament Extended Footer
If you have to add extra info into the footer center area (for example: project partner logos), then you can use this footer.
Steps:
- Go to Appearance/Customize/Imprint and Footer and Turn off the "Use Fundament Footer"
- Go to Appearance/Widgets
- Drag and Drop a "text" or a "Custom HTML" widget inside the "Fundament Extended Footer" section

## HERO Text Translate
You can also translate the hero static text, for this you need to do the following steps:
- Install and enable Polylang plugin.((https://wordpress.org/plugins/polylang/))
- Open Theme Customization/Homepage Hero Block and here check the "Hero Title translation" checkbox. Publish the changes.
- Now under the Admin/Languages/String translations you can find the 'fundament_wp_hero_dynamic_title' translation section.
 In this section you can find all the available languages from your site and you can translate them.