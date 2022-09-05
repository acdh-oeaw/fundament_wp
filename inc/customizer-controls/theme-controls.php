<?php

// Define the KIRKI_VERSION constant.
if (!defined('KIRKI_VERSION')) {
    define('KIRKI_VERSION', '3.0.24');
}

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Do not proceed if Kirki does not exist.
if (!class_exists('Kirki')) {
    return;
}

/**
 * First of all, add the config.
 *
 * @link https://aristath.github.io/kirki/docs/getting-started/config.html
 */
Kirki::add_config(
        'fundament_wp_options', array(
    'capability' => 'edit_theme_options',
    'option_type' => 'theme_mod',
        )
);

/**
 * Add Sections.
 *
 * We'll be doing things a bit differently here, just to demonstrate an example.
 * We're going to define 1 section per control-type just to keep things clean and separate.
 *
 * @link https://aristath.github.io/kirki/docs/getting-started/sections.html
 */
$sections = array(
    'typography' => array(esc_attr__('Typography', 'fundament_wp'), ''),
    'theme_layout' => array(esc_attr__('Theme Layout', 'fundament_wp'), ''),
    'navbar' => array(esc_attr__('Top Navigation', 'fundament_wp'), ''),
    'home_hero' => array(esc_attr__('Homepage Hero Block', 'fundament_wp'), ''),
    'home_blocks' => array(esc_attr__('Homepage Content Blocks', 'fundament_wp'), ''),
    'single_posts' => array(esc_attr__('Single Posts', 'fundament_wp'), ''),
    'archive_pages' => array(esc_attr__('Archive Pages', 'fundament_wp'), ''),
    'footer' => array(esc_attr__('Imprint and Footer', 'fundament_wp'), ''),
);
foreach ($sections as $section_id => $section) {
    $section_args = array(
        'title' => $section[0],
        'description' => $section[1],
    );
    if (isset($section[2])) {
        $section_args['type'] = $section[2];
    }
    Kirki::add_section(str_replace('-', '_', $section_id) . '_section', $section_args);
}

/* Get Categories for Query Selectors */
$categories = get_categories(array('orderby' => 'name', 'order' => 'ASC'));
$category_choices = array();
foreach ($categories as $category) {
    $category_choices[$category->term_id] = $category->name;
}
/* Get Tags for Query Selectors */
$tags = get_tags(array('orderby' => 'name', 'order' => 'ASC'));
$tag_choices = array();
foreach ($tags as $tag) {
    $tag_choices[$tag->term_id] = $tag->name;
}
/* Get Pages for Query Selectors */
$pages_list = get_pages(array('sort_column' => 'post_title', 'sort_order' => 'asc', 'post_type' => 'page', 'post_status' => 'publish'));
$page_choices = array();
foreach ($pages_list as $page_item) {
    if ($page_item) {
        $page_choices[$page_item->ID] = $page_item->post_title;
    }
}

/**
 * A proxy function. Automatically passes-on the config-id.
 *
 * @param array $args The field arguments.
 */
function my_config_kirki_add_field($args) {
    Kirki::add_field('fundament_wp_options', $args);
}

/**
 * Body Typography Control.
 */
my_config_kirki_add_field(
        array(
            'type' => 'typography',
            'settings' => 'typography_body',
            'label' => esc_attr__('Primary Font', 'fundament_wp'),
            'description' => esc_attr__('This is the main font which is used in all elements except headings and article content. It is often a sans-serif font with regular weight.', 'fundament_wp'),
            'section' => 'typography_section',
            'priority' => 10,
            'transport' => 'refresh',
            'default' => array(
                'font-family' => 'Asap',
                'variant' => '400',
                'color' => '#212529',
            ),
            'output' => array(
                array(
                    'element' => array('body'),
                ),
            ),
            'choices' => array(
                'fonts' => array(
                    'google' => array('alpha'),
                ),
            ),
        )
);

/**
 * Heading Typography Control.
 */
my_config_kirki_add_field(
        array(
            'type' => 'typography',
            'settings' => 'typography_heading',
            'label' => esc_attr__('Heading Font', 'fundament_wp'),
            'description' => esc_attr__('This is the font which is used in all headings. It is often a sans-serif font with semi-bold or bold weight.', 'fundament_wp'),
            'section' => 'typography_section',
            'priority' => 10,
            'transport' => 'refresh',
            'default' => array(
                'font-family' => 'Asap',
                'variant' => '600',
                'color' => '#212529',
            ),
            'output' => array(
                array(
                    'element' => array('h1', 'h2', 'h3', 'h4', 'h5', 'h6', '.navbar-brand', '.btn-round'),
                ),
            ),
            'choices' => array(
                'fonts' => array(
                    'google' => array('alpha'),
                ),
            ),
        )
);

/**
 * Article Typography Control.
 */
my_config_kirki_add_field(
        array(
            'type' => 'typography',
            'settings' => 'typography_article',
            'label' => esc_attr__('Article Font', 'fundament_wp'),
            'description' => esc_attr__('This font is used in the actual content of single articles and comments. It is often a serif font with regular weight.', 'fundament_wp'),
            'section' => 'typography_section',
            'priority' => 10,
            'transport' => 'refresh',
            'default' => array(
                'font-family' => 'Lora',
                'variant' => '400',
                'color' => '#212529',
                'font-size' => '1.3rem',
                'line-height' => '1.55',
            ),
            'output' => array(
                array(
                    'element' => array('.single main > article .entry-content', '.page main > article .entry-content', '.post-teaser'),
                ),
            ),
            'choices' => array(
                'fonts' => array(
                    'google' => array('alpha'),
                ),
            ),
        )
);

/**
 * Navbar Logo Height
 */
my_config_kirki_add_field(
        array(
            'type' => 'slider',
            'settings' => 'navbar_logo_height',
            'label' => esc_attr__('Navbar Logo Height', 'fundament_wp'),
            'description' => esc_attr__('Make your logo on the navigation bar bigger or smaller.', 'fundament_wp'),
            'section' => 'navbar_section',
            'default' => '2.5',
            'choices' => array(
                'min' => 2.5,
                'max' => 6.0,
                'step' => 0.1,
                'suffix' => 'rem',
            ),
            'output' => array(
                array(
                    'element' => array('.navbar .navbar-brand'),
                    'property' => 'height',
                    'units' => 'rem',
                ),
            ),
            'transport' => 'postMessage',
            'js_vars' => array(
                array(
                    'element' => array('.navbar .navbar-brand'),
                    'property' => 'height',
                    'units' => 'rem',
                ),
            ),
        )
);

/**
 * Navbar Padding
 */
my_config_kirki_add_field(
        array(
            'type' => 'dimensions',
            'settings' => 'navbar_padding',
            'label' => esc_attr__('Navbar Padding', 'fundament_wp'),
            'description' => esc_attr__('Define the padding of your top navigation bar.', 'fundament_wp'),
            'section' => 'navbar_section',
            'default' => array(
                'padding-top' => '1.25rem',
                'padding-bottom' => '1.25rem',
            ),
            'output' => array(
                array(
                    'element' => array('.navbar'),
                    'property' => '',
                ),
            ),
            'transport' => 'postMessage',
            'js_vars' => array(
                array(
                    'element' => array('.navbar'),
                    'property' => '',
                ),
            ),
        )
);

/**
 * Navbar Background Color
 */
my_config_kirki_add_field(
        array(
            'type' => 'color',
            'settings' => 'navbar_bg_color',
            'label' => __('Navbar Background Color', 'fundament_wp'),
            'description' => esc_attr__('Define the background color of your top navigation bar.', 'fundament_wp'),
            'section' => 'navbar_section',
            'default' => '#fff',
            'choices' => array(
                'alpha' => true,
            ),
            'output' => array(
                array(
                    'element' => array('.navbar'),
                    'property' => 'background-color',
                ),
            ),
            'transport' => 'postMessage',
            'js_vars' => array(
                array(
                    'element' => array('.navbar'),
                    'property' => 'background-color',
                ),
            ),
        )
);

/**
 * Navbar Font Color Scheme
 */
my_config_kirki_add_field(
        array(
            'type' => 'radio',
            'settings' => 'navbar_color_scheme',
            'label' => esc_attr__('Navbar Font Color Scheme', 'fundament_wp'),
            'description' => esc_attr__('Use the light navbar setting with a bright background color and the dark navbar with a dark background.', 'fundament_wp'),
            'section' => 'navbar_section',
            'default' => 'navbar-light',
            'choices' => array(
                'navbar-light' => esc_attr__('Light Navbar', 'fundament_wp'),
                'navbar-dark' => esc_attr__('Dark Navbar', 'fundament_wp'),
            ),
            'transport' => 'refresh',
        )
);

/**
 * Navbar Placement
 */
my_config_kirki_add_field(
        array(
            'type' => 'radio',
            'settings' => 'navbar_placement',
            'label' => esc_attr__('Navbar Placement', 'fundament_wp'),
            'description' => esc_attr__('Choose between a static or fixed-to-top navbar.', 'fundament_wp'),
            'section' => 'navbar_section',
            'default' => 'static-navbar',
            'choices' => array(
                'static-navbar' => esc_attr__('Static Navbar', 'fundament_wp'),
                'sticky-navbar' => esc_attr__('Fixed-Top Navbar', 'fundament_wp'),
            ),
            'transport' => 'refresh',
        )
);

/**
 * Navigation Items Font Size
 */
my_config_kirki_add_field(
        array(
            'type' => 'slider',
            'settings' => 'nav_link_font_size',
            'label' => esc_attr__('Navigation Items Font Size', 'fundament_wp'),
            'description' => esc_attr__('Define the font size of the navigation items of your menu.', 'fundament_wp'),
            'section' => 'navbar_section',
            'default' => '1',
            'choices' => array(
                'min' => 0.5,
                'max' => 10,
                'step' => 0.1,
                'suffix' => 'rem',
            ),
            'transport' => 'postMessage',
            'output' => array(
                array(
                    'element' => '.navbar .nav-link',
                    'property' => 'font-size',
                    'units' => 'rem',
                ),
            ),
            'js_vars' => array(
                array(
                    'element' => '.navbar .nav-link',
                    'property' => 'font-size',
                    'units' => 'rem',
                ),
            ),
        )
);

/**
 * Navigation Items Padding
 */
my_config_kirki_add_field(
        array(
            'type' => 'dimensions',
            'settings' => 'nav_link_padding',
            'label' => esc_attr__('Navigation Items Padding', 'fundament_wp'),
            'description' => esc_attr__('Define the padding of the navigation items of your menu.', 'fundament_wp'),
            'section' => 'navbar_section',
            'transport' => 'postMessage',
            'default' => array(
                'padding-right' => '0.75rem',
                'padding-left' => '0.75rem',
            ),
            'output' => array(
                array(
                    'element' => '.navbar .nav-item a.nav-link',
                    'property' => '',
                ),
                array(
                    'element' => '.navbar .nav-item.active > a.nav-link::after',
                    'choice' => 'padding-left',
                    'property' => 'left',
                ),
                array(
                    'element' => '.navbar .nav-item.active > a.nav-link::after',
                    'choice' => 'padding-right',
                    'property' => 'right',
                ),
            ),
            'js_vars' => array(
                array(
                    'element' => '.navbar .nav-item a.nav-link',
                    'property' => '',
                ),
                array(
                    'element' => '.navbar .nav-item.active > a.nav-link::after',
                    'choice' => 'padding-left',
                    'property' => 'left',
                ),
                array(
                    'element' => '.navbar .nav-item.active > a.nav-link::after',
                    'choice' => 'padding-right',
                    'property' => 'right',
                ),
            ),
        )
);

/**
 * Active / Hovered Navigation Item Color
 */
my_config_kirki_add_field(
        array(
            'type' => 'color',
            'settings' => 'nav_link_active_color',
            'label' => __('Active / Hovered Navigation Item Color', 'fundament_wp'),
            'description' => esc_attr__('Define the color of the navigation items while active or on mouse over.', 'fundament_wp'),
            'section' => 'navbar_section',
            'transport' => 'postMessage',
            'choices' => array(
                'alpha' => true,
            ),
            'output' => array(
                array(
                    'element' => array('.navbar .nav-item.active > a.nav-link', '.navbar .nav-item > a.nav-link:hover'),
                    'property' => 'color',
                ),
                array(
                    'element' => '.navbar .nav-item.active > a.nav-link::after',
                    'property' => 'background-color',
                ),
            ),
            'js_vars' => array(
                array(
                    'element' => array('.navbar .nav-item.active > a.nav-link', '.navbar .nav-item > a.nav-link:hover'),
                    'property' => 'color',
                ),
                array(
                    'element' => '.navbar .nav-item.active > a.nav-link::after',
                    'property' => 'background-color',
                ),
            ),
        )
);

/**
 * Active Navigation Item Bottom Border
 */
my_config_kirki_add_field(
        array(
            'type' => 'toggle',
            'settings' => 'nav_link_active_border',
            'label' => esc_attr__('Active Navigation Item Bottom Border', 'fundament_wp'),
            'description' => esc_attr__('Select if you want to display a bottom border for the navigation items while active.', 'fundament_wp'),
            'section' => 'navbar_section',
            'default' => false,
            'transport' => 'refresh',
            'output' => array(
                array(
                    'element' => '.navbar .nav-item.active > a.nav-link::after',
                    'property' => 'height',
                    'exclude' => array(false), // if toggle is off -> don't add this style
                    'value_pattern' => '2px',
                ),
            ),
        )
);

/**
 * Display Navbar Search Field
 */
my_config_kirki_add_field(
        array(
            'type' => 'toggle',
            'settings' => 'navbar_search_toggle',
            'label' => esc_attr__('Display Navbar Search Field', 'fundament_wp'),
            'description' => esc_attr__('Select if you want to display the search field on the top navigation.', 'fundament_wp'),
            'section' => 'navbar_section',
            'default' => true,
            'transport' => 'refresh',
        )
);

/**
 * Navbar Social Media: GitHub Icon
 */
my_config_kirki_add_field(
        array(
            'type' => 'text',
            'settings' => 'navbar_social_github',
            'label' => esc_attr__('Navbar Social Media: GitHub Icon', 'fundament_wp'),
            'description' => esc_attr__('To display a GitHub icon please add your GitHub URL below.', 'fundament_wp'),
            'section' => 'navbar_section',
            'transport' => 'refresh',
        )
);

/**
 * Navbar Social Media: Twitter Icon
 */
my_config_kirki_add_field(
        array(
            'type' => 'text',
            'settings' => 'navbar_social_twitter',
            'label' => esc_attr__('Navbar Social Media: Twitter Icon', 'fundament_wp'),
            'description' => esc_attr__('To display a Twitter icon please add your Twitter URL below.', 'fundament_wp'),
            'section' => 'navbar_section',
            'transport' => 'refresh',
        )
);

/**
 * Navbar Social Media: Facebook Icon
 */
my_config_kirki_add_field(
        array(
            'type' => 'text',
            'settings' => 'navbar_social_facebook',
            'label' => esc_attr__('Navbar Social Media: Facebook Icon', 'fundament_wp'),
            'description' => esc_attr__('To display a Facebook icon please add your Facebook URL below.', 'fundament_wp'),
            'section' => 'navbar_section',
            'transport' => 'refresh',
        )
);

/**
 * Container Width
 */
my_config_kirki_add_field(
        array(
            'type' => 'select',
            'settings' => 'theme_layout_container',
            'label' => esc_attr__('Container Width', 'fundament_wp'),
            'description' => esc_attr__('Choose between a fixed container layout and a full width fluid layout.', 'fundament_wp'),
            'section' => 'theme_layout_section',
            'default' => 'container',
            'choices' => array(
                'container' => esc_attr__('Fixed Width Container', 'fundament_wp'),
                'container-fluid' => esc_attr__('Full Width Container', 'fundament_wp'),
            ),
            'transport' => 'refresh',
        )
);

/**
 * Sidebar Positioning
 */
my_config_kirki_add_field(
        array(
            'type' => 'select',
            'settings' => 'theme_layout_sidebar',
            'label' => esc_attr__('Sidebar Positioning', 'fundament_wp'),
            'description' => esc_attr__('Set the position of your sidebar. Can either be: right, left, both or none. After defining this setting, please go to Widgets section to add widgets to different sidebars. Note: this can be overridden on individual pages.', 'fundament_wp'),
            'section' => 'theme_layout_section',
            'default' => 'none',
            'choices' => array(
                'right' => esc_attr__('Right sidebar', 'fundament_wp'),
                'left' => esc_attr__('Left sidebar', 'fundament_wp'),
                'both' => esc_attr__('Right & Left sidebar', 'fundament_wp'),
                'none' => esc_attr__('No sidebar', 'fundament_wp'),
            ),
            'transport' => 'refresh',
        )
);

/**
 * Site Uniform Color
 */
my_config_kirki_add_field(
        array(
            'type' => 'color',
            'settings' => 'theme_layout_uniform_color',
            'label' => __('Site Uniform Color', 'fundament_wp'),
            'description' => esc_attr__('Define the uniform color of your website, which will be used on many elements such as buttons, borders and icons. These settings can be overwritten by the specific color definitions in the further sections.', 'fundament_wp'),
            'section' => 'theme_layout_section',
            'default' => '#212529',
            'choices' => array(
                'alpha' => true,
            ),
            'output' => array(
                array(
                    'element' => array('.btn-round', '.separator-title', '#wrapper-hero-content .hero-dark .btn-round:hover', '.single main > article .entry-content a', '.page main > article .entry-content a'),
                    'property' => 'color',
                ),
                array(
                    'element' => array('.separator-title', '.single main > article .entry-content a', '.page main > article .entry-content a'),
                    'property' => 'border-color',
                ),
                array(
                    'element' => array('.card-wrapper .card .card-inner'),
                    'property' => 'border-top-color',
                ),
                array(
                    'element' => array('.btn-round:hover'),
                    'property' => 'background-color',
                ),
            ),
            'transport' => 'postMessage',
            'js_vars' => array(
                array(
                    'element' => array('.btn-round', '.separator-title', '#wrapper-hero-content .hero-dark .btn-round:hover', '.single main > article .entry-content a', '.page main > article .entry-content a'),
                    'property' => 'color',
                ),
                array(
                    'element' => array('.separator-title', '.single main > article .entry-content a', '.page main > article .entry-content a'),
                    'property' => 'border-color',
                ),
                array(
                    'element' => array('.card-wrapper .card .card-inner'),
                    'property' => 'border-top-color',
                ),
                array(
                    'element' => array('.btn-round:hover'),
                    'property' => 'background-color',
                ),
            ),
        )
);

/**
 * Body Background Color
 */
my_config_kirki_add_field(
        array(
            'type' => 'color',
            'settings' => 'theme_layout_body_bg_color',
            'label' => __('Body Document Background Color', 'fundament_wp'),
            'description' => esc_attr__('Define the background color of your website body.', 'fundament_wp'),
            'section' => 'theme_layout_section',
            'default' => '#F1F1F1',
            'choices' => array(
                'alpha' => true,
            ),
            'output' => array(
                array(
                    'element' => 'body',
                    'property' => 'background-color',
                ),
            ),
            'transport' => 'postMessage',
            'js_vars' => array(
                array(
                    'element' => 'body',
                    'property' => 'background-color',
                ),
            ),
        )
);

/**
 * HTML Background Color
 */
my_config_kirki_add_field(
        array(
            'type' => 'color',
            'settings' => 'theme_layout_html_bg_color',
            'label' => __('HTML Document Background Color', 'fundament_wp'),
            'description' => esc_attr__('Define the background color of your HTML document. This color is visible on some browsers where the scrolling can stretch the page further and also on some mobile browsers. It is wise to make this color same as your body/navbar/outline-border background color.', 'fundament_wp'),
            'section' => 'theme_layout_section',
            'default' => '#fff',
            'choices' => array(
                'alpha' => true,
            ),
            'output' => array(
                array(
                    'element' => 'html',
                    'property' => 'background-color',
                ),
            ),
            'transport' => 'postMessage',
            'js_vars' => array(
                array(
                    'element' => 'html',
                    'property' => 'background-color',
                ),
            ),
        )
);

/**
 * Outline Border Around Website
 */
my_config_kirki_add_field(
        array(
            'type' => 'slider',
            'settings' => 'theme_layout_body_border',
            'label' => esc_attr__('Outline Border Around Website', 'fundament_wp'),
            'description' => esc_attr__('Add an outline border around your website with the following thickness.', 'fundament_wp'),
            'section' => 'theme_layout_section',
            'transport' => 'postMessage',
            'default' => '0',
            'choices' => array(
                'min' => 0,
                'max' => 2.0,
                'step' => 0.1,
                'suffix' => 'rem',
            ),
            'output' => array(
                array(
                    'element' => 'body',
                    'property' => 'border-right-width',
                    'units' => 'rem',
                ),
                array(
                    'element' => 'body',
                    'property' => 'border-left-width',
                    'units' => 'rem',
                ),
                array(
                    'element' => 'body',
                    'property' => 'border-bottom-width',
                    'units' => 'rem',
                ),
                array(
                    'element' => '#wrapper-navbar',
                    'property' => 'border-top-width',
                    'units' => 'rem',
                ),
            ),
            'js_vars' => array(
                array(
                    'element' => 'body',
                    'property' => 'border-right-width',
                    'units' => 'rem',
                ),
                array(
                    'element' => 'body',
                    'property' => 'border-left-width',
                    'units' => 'rem',
                ),
                array(
                    'element' => 'body',
                    'property' => 'border-bottom-width',
                    'units' => 'rem',
                ),
                array(
                    'element' => '#wrapper-navbar',
                    'property' => 'border-top-width',
                    'units' => 'rem',
                ),
            ),
        )
);

/**
 * Outline Border Around Website Color
 */
my_config_kirki_add_field(
        array(
            'type' => 'color',
            'settings' => 'theme_layout_body_border_color',
            'label' => __('Outline Border Around Website Color', 'fundament_wp'),
            'description' => esc_attr__('Define the background color of the outline border around your website.', 'fundament_wp'),
            'section' => 'theme_layout_section',
            'default' => '#6c757d',
            'choices' => array(
                'alpha' => true,
            ),
            'output' => array(
                array(
                    'element' => 'body',
                    'property' => 'border-color',
                ),
                array(
                    'element' => '#wrapper-navbar',
                    'property' => 'border-top-color',
                ),
            ),
            'transport' => 'postMessage',
            'js_vars' => array(
                array(
                    'element' => 'body',
                    'property' => 'border-color',
                ),
                array(
                    'element' => '#wrapper-navbar',
                    'property' => 'border-top-color',
                ),
            ),
        )
);

/**
 * Hero Type Setting
 */
my_config_kirki_add_field(
        array(
            'type' => 'select',
            'settings' => 'hero_type_setting',
            'label' => esc_attr__('Select Hero Type', 'fundament_wp'),
            'description' => esc_attr__('A hero element will be visible on top of your homepage. You may use static hero content or generate your hero from post(s).', 'fundament_wp'),
            'section' => 'home_hero_section',
            'default' => 'none',
            'choices' => array(
                'none' => esc_attr__('No Hero', 'fundament_wp'),
                'static-hero' => esc_attr__('Static Hero', 'fundament_wp'),
                'post-hero' => esc_attr__('Hero with Post Items', 'fundament_wp'),
            ),
            'transport' => 'refresh',
        )
);

/**
 * Post Hero Query Type
 */
my_config_kirki_add_field(
        array(
            'type' => 'radio',
            'settings' => 'hero_post_query_type',
            'label' => esc_attr__('Hero Posts Query Source', 'fundament_wp'),
            'description' => esc_attr__('Query posts from categories, tags or some selected posts.', 'fundament_wp'),
            'section' => 'home_hero_section',
            'default' => 'categories',
            'choices' => array(
                'categories' => esc_attr__('Categories', 'fundament_wp'),
                'tags' => esc_attr__('Tags', 'fundament_wp'),
                'posts' => esc_attr__('Specific posts', 'fundament_wp'),
            ),
            'transport' => 'refresh',
            'required' => array(
                array(
                    'setting' => 'hero_type_setting',
                    'operator' => '==',
                    'value' => 'post-hero'
                )
            ),
        )
);

/**
 * Post Hero Category Query
 */
my_config_kirki_add_field(
        array(
            'type' => 'select',
            'settings' => 'hero_post_category_query',
            'label' => esc_attr__('Select Categories to Query', 'fundament_wp'),
            'description' => esc_attr__('You may select multiple categories to query your content from.', 'fundament_wp'),
            'section' => 'home_hero_section',
            'transport' => 'refresh',
            'default' => 'option-1',
            'multiple' => 10,
            'choices' => array(
                'option-1' => esc_attr__('Option 1', 'fundament_wp'),
                'option-2' => esc_attr__('Option 2', 'fundament_wp'),
                'option-3' => esc_attr__('Option 3', 'fundament_wp'),
                'option-4' => esc_attr__('Option 4', 'fundament_wp'),
                'option-5' => esc_attr__('Option 5', 'fundament_wp'),
            ),
            'required' => array(
                array(
                    'setting' => 'hero_type_setting',
                    'operator' => '==',
                    'value' => 'post-hero'
                ),
                array(
                    'setting' => 'hero_post_query_type',
                    'operator' => '==',
                    'value' => 'categories'
                )
            ),
        )
);

/**
 * Post Hero Tag Query
 */
my_config_kirki_add_field(
        array(
            'type' => 'select',
            'settings' => 'hero_post_tag_query',
            'label' => esc_attr__('Select Tags to Query', 'fundament_wp'),
            'description' => esc_attr__('You may select multiple tags to query your content from.', 'fundament_wp'),
            'section' => 'home_hero_section',
            'transport' => 'refresh',
            'default' => 'option-1',
            'multiple' => 10,
            'choices' => array(
                'option-1' => esc_attr__('Option 1', 'fundament_wp'),
                'option-2' => esc_attr__('Option 2', 'fundament_wp'),
                'option-3' => esc_attr__('Option 3', 'fundament_wp'),
                'option-4' => esc_attr__('Option 4', 'fundament_wp'),
                'option-5' => esc_attr__('Option 5', 'fundament_wp'),
            ),
            'required' => array(
                array(
                    'setting' => 'hero_type_setting',
                    'operator' => '==',
                    'value' => 'post-hero'
                ),
                array(
                    'setting' => 'hero_post_query_type',
                    'operator' => '==',
                    'value' => 'tags'
                )
            ),
        )
);

/**
 * Post Hero Posts Query
 */
my_config_kirki_add_field(
        array(
            'type' => 'select',
            'settings' => 'hero_post_posts_query',
            'label' => esc_attr__('Select Posts to Query', 'fundament_wp'),
            'description' => esc_attr__('You may select multiple posts to query your content from.', 'fundament_wp'),
            'section' => 'home_hero_section',
            'transport' => 'refresh',
            'default' => 'option-1',
            'multiple' => 10,
            'choices' => array(
                'option-1' => esc_attr__('Option 1', 'fundament_wp'),
                'option-2' => esc_attr__('Option 2', 'fundament_wp'),
                'option-3' => esc_attr__('Option 3', 'fundament_wp'),
                'option-4' => esc_attr__('Option 4', 'fundament_wp'),
                'option-5' => esc_attr__('Option 5', 'fundament_wp'),
            ),
            'required' => array(
                array(
                    'setting' => 'hero_type_setting',
                    'operator' => '==',
                    'value' => 'post-hero'
                ),
                array(
                    'setting' => 'hero_post_query_type',
                    'operator' => '==',
                    'value' => 'posts'
                )
            ),
        )
);

/**
 * Post Hero Number of Items
 */
my_config_kirki_add_field(
        array(
            'type' => 'number',
            'settings' => 'hero_post_number_of_items',
            'label' => esc_attr__('Number of Items', 'fundament_wp'),
            'section' => 'home_hero_section',
            'transport' => 'refresh',
            'choices' => array(
                'min' => 1,
                'max' => 10,
                'step' => 1,
            ),
            'required' => array(
                array(
                    'setting' => 'hero_type_setting',
                    'operator' => '==',
                    'value' => 'post-hero'
                )
            ),
        )
);

/**
 * Static Hero: Title.
 */
my_config_kirki_add_field(
        array(
            'type' => 'text',
            'settings' => 'hero_static_title',
            'label' => esc_attr__('Hero Title', 'fundament_wp'),
            'description' => esc_attr__('The heading of your static hero content.', 'fundament_wp'),
            'section' => 'home_hero_section',
            'transport' => 'refresh',
            'required' => array(
                array(
                    'setting' => 'hero_type_setting',
                    'operator' => '==',
                    'value' => 'static-hero'
                )
            ),
        )
);


if (is_plugin_active('polylang/polylang.php')) {
    my_config_kirki_add_field(
            array(
                'type' => 'checkbox',
                'settings' => 'hero_static_title_translate',
                'label' => esc_attr__('Hero Section Translation', 'fundament_wp'),
                'description' => esc_attr__('Turn on if you are using multilanguage site and then you can translate the title, text and button.', 'fundament_wp'),
                'section' => 'home_hero_section',
                'transport' => 'refresh',
                'required' => array(
                    array(
                        'setting' => 'hero_type_setting',
                        'operator' => '==',
                        'value' => 'static-hero'
                    )
                ),
            )
    );
}

/**
 * Hero Title Color
 */
my_config_kirki_add_field(
        array(
            'type' => 'color',
            'settings' => 'hero_title_color',
            'label' => __('Hero Title Color', 'fundament_wp'),
            'description' => esc_attr__('Define the color of the heading of your hero area.', 'fundament_wp'),
            'section' => 'home_hero_section',
            'choices' => array(
                'alpha' => true,
            ),
            'transport' => 'postMessage',
            'output' => array(
                array(
                    'element' => '#wrapper-hero-content > #wrapper-hero-inner > h1',
                    'property' => 'color',
                ),
            ),
            'js_vars' => array(
                array(
                    'element' => '#wrapper-hero-content > #wrapper-hero-inner > h1',
                    'property' => 'color',
                ),
            ),
            'required' => array(
                array(
                    'setting' => 'hero_type_setting',
                    'operator' => 'contains',
                    'value' => array('static-hero', 'post-hero')
                )
            ),
        )
);

/**
 * Hero Title Font Size
 */
my_config_kirki_add_field(
        array(
            'type' => 'slider',
            'settings' => 'hero_title_font_size',
            'label' => esc_attr__('Hero Title Font Size', 'fundament_wp'),
            'description' => esc_attr__('Define the font size of the heading of your hero area.', 'fundament_wp'),
            'section' => 'home_hero_section',
            'default' => '2.5',
            'choices' => array(
                'min' => 1,
                'max' => 10,
                'step' => 0.1,
                'suffix' => 'rem',
            ),
            'transport' => 'postMessage',
            'output' => array(
                array(
                    'element' => '#wrapper-hero-content > #wrapper-hero-inner > h1',
                    'property' => 'font-size',
                    'units' => 'rem',
                ),
            ),
            'js_vars' => array(
                array(
                    'element' => '#wrapper-hero-content > #wrapper-hero-inner > h1',
                    'property' => 'font-size',
                    'units' => 'rem',
                ),
            ),
            'required' => array(
                array(
                    'setting' => 'hero_type_setting',
                    'operator' => 'contains',
                    'value' => array('static-hero', 'post-hero')
                )
            ),
        )
);

/**
 * Static Hero: Text.
 */
my_config_kirki_add_field(
        array(
            'type' => 'textarea',
            'settings' => 'hero_static_text',
            'label' => esc_attr__('Hero Text', 'fundament_wp'),
            'description' => esc_attr__('Add your static hero text.', 'fundament_wp'),
            'section' => 'home_hero_section',
            'transport' => 'refresh',
            'required' => array(
                array(
                    'setting' => 'hero_type_setting',
                    'operator' => '==',
                    'value' => 'static-hero'
                )
            ),
        )
);

/**
 * Hero Text Font Size
 */
my_config_kirki_add_field(
        array(
            'type' => 'slider',
            'settings' => 'hero_text_font_size',
            'label' => esc_attr__('Hero Text Font Size', 'fundament_wp'),
            'description' => esc_attr__('Define the font size of the text of your hero area.', 'fundament_wp'),
            'section' => 'home_hero_section',
            'default' => '1',
            'choices' => array(
                'min' => 0.5,
                'max' => 10,
                'step' => 0.1,
                'suffix' => 'rem',
            ),
            'transport' => 'postMessage',
            'output' => array(
                array(
                    'element' => '#wrapper-hero-content > #wrapper-hero-inner > p',
                    'property' => 'font-size',
                    'units' => 'rem',
                ),
            ),
            'js_vars' => array(
                array(
                    'element' => '#wrapper-hero-content > #wrapper-hero-inner > p',
                    'property' => 'font-size',
                    'units' => 'rem',
                ),
            ),
            'required' => array(
                array(
                    'setting' => 'hero_type_setting',
                    'operator' => 'contains',
                    'value' => array('static-hero', 'post-hero')
                )
            ),
        )
);

/**
 * Hero: Button.
 */
my_config_kirki_add_field(
        array(
            'type' => 'text',
            'settings' => 'hero_button',
            'label' => esc_attr__('Hero Button', 'fundament_wp'),
            'description' => esc_attr__('Add your hero button label. Leave empty for no button.', 'fundament_wp'),
            'section' => 'home_hero_section',
            'transport' => 'refresh',
            'required' => array(
                array(
                    'setting' => 'hero_type_setting',
                    'operator' => 'contains',
                    'value' => array('static-hero', 'post-hero')
                )
            ),
        )
);

/**
 * Hero Button Color
 */
my_config_kirki_add_field(
        array(
            'type' => 'color',
            'settings' => 'hero_button_color',
            'label' => __('Hero Button Color', 'fundament_wp'),
            'description' => esc_attr__('Define the color of the button of your hero area.', 'fundament_wp'),
            'section' => 'home_hero_section',
            'choices' => array(
                'alpha' => true,
            ),
            'transport' => 'postMessage',
            'output' => array(
                array(
                    'element' => '#wrapper-hero-content > #wrapper-hero-inner button',
                    'property' => 'color',
                ),
                array(
                    'element' => '#wrapper-hero-content > #wrapper-hero-inner button',
                    'property' => 'border-color',
                ),
                array(
                    'element' => '#wrapper-hero-content > #wrapper-hero-inner button:hover',
                    'property' => 'background-color',
                ),
            ),
            'js_vars' => array(
                array(
                    'element' => '#wrapper-hero-content > #wrapper-hero-inner button',
                    'property' => 'color',
                ),
                array(
                    'element' => '#wrapper-hero-content > #wrapper-hero-inner button',
                    'property' => 'border-color',
                ),
                array(
                    'element' => '#wrapper-hero-content > #wrapper-hero-inner button:hover',
                    'property' => 'background-color',
                ),
            ),
            'required' => array(
                array(
                    'setting' => 'hero_type_setting',
                    'operator' => 'contains',
                    'value' => array('static-hero', 'post-hero')
                )
            ),
        )
);

/**
 * Hero Button Font Size
 */
my_config_kirki_add_field(
        array(
            'type' => 'slider',
            'settings' => 'hero_button_font_size',
            'label' => esc_attr__('Hero Button Font Size', 'fundament_wp'),
            'description' => esc_attr__('Define the font size of the button of your hero area.', 'fundament_wp'),
            'section' => 'home_hero_section',
            'default' => '0.9',
            'choices' => array(
                'min' => 0.5,
                'max' => 10,
                'step' => 0.1,
                'suffix' => 'rem',
            ),
            'transport' => 'postMessage',
            'output' => array(
                array(
                    'element' => '#wrapper-hero-content > #wrapper-hero-inner button',
                    'property' => 'font-size',
                    'units' => 'rem',
                ),
            ),
            'js_vars' => array(
                array(
                    'element' => '#wrapper-hero-content > #wrapper-hero-inner button',
                    'property' => 'font-size',
                    'units' => 'rem',
                ),
            ),
            'required' => array(
                array(
                    'setting' => 'hero_type_setting',
                    'operator' => 'contains',
                    'value' => array('static-hero', 'post-hero')
                )
            ),
        )
);

/**
 * Hero Button Padding
 */
my_config_kirki_add_field(
        array(
            'type' => 'dimensions',
            'settings' => 'hero_button_padding',
            'label' => esc_attr__('Hero Button Padding', 'fundament_wp'),
            'description' => esc_attr__('Define the padding of the button of your hero area.', 'fundament_wp'),
            'section' => 'home_hero_section',
            'transport' => 'postMessage',
            'default' => array(
                'padding-top' => '0.6rem',
                'padding-bottom' => '0.6rem',
                'padding-right' => '1.2rem',
                'padding-left' => '1.2rem',
            ),
            'output' => array(
                array(
                    'element' => '#wrapper-hero-content > #wrapper-hero-inner button',
                    'property' => '',
                ),
            ),
            'js_vars' => array(
                array(
                    'element' => '#wrapper-hero-content > #wrapper-hero-inner button',
                    'property' => '',
                ),
            ),
        )
);

/**
 * Static Hero: URL.
 */
my_config_kirki_add_field(
        array(
            'type' => 'text',
            'settings' => 'hero_static_url',
            'label' => esc_attr__('Hero URL', 'fundament_wp'),
            'description' => esc_attr__('Enter the URL where you want to link your hero to. Leave empty for no linking.', 'fundament_wp'),
            'transport' => 'refresh',
            'section' => 'home_hero_section',
            'required' => array(
                array(
                    'setting' => 'hero_type_setting',
                    'operator' => '==',
                    'value' => 'static-hero'
                )
            ),
        )
);

/**
 * Static Hero: Background Image
 */
my_config_kirki_add_field(
        array(
            'type' => 'image',
            'settings' => 'hero_static_image',
            'label' => esc_attr__('Hero Background Image', 'fundament_wp'),
            'description' => esc_attr__('Select the image you want to use in the background of your hero.', 'fundament_wp'),
            'section' => 'home_hero_section',
            'transport' => 'refresh',
            'default' => '',
            'required' => array(
                array(
                    'setting' => 'hero_type_setting',
                    'operator' => '==',
                    'value' => 'static-hero'
                )
            ),
        )
);

/**
 * Hero: Background Color
 */
my_config_kirki_add_field(
        array(
            'type' => 'color',
            'settings' => 'hero_bg_color',
            'label' => __('Hero Background Color', 'fundament_wp'),
            'description' => esc_attr__('Define the background color of your hero content. If the hero has a background image, you can decrease the opacity of this color to make a color overlay on the image.', 'fundament_wp'),
            'section' => 'home_hero_section',
            'default' => 'rgba(108,117,125,0.75)',
            'choices' => array(
                'alpha' => true,
            ),
            'required' => array(
                array(
                    'setting' => 'hero_type_setting',
                    'operator' => 'contains',
                    'value' => array('static-hero', 'post-hero')
                )
            ),
            'output' => array(
                array(
                    'element' => '#wrapper-hero-content::after',
                    'property' => 'background-color',
                ),
            ),
            'transport' => 'postMessage',
            'js_vars' => array(
                array(
                    'element' => '#wrapper-hero-content::after',
                    'property' => 'background-color',
                ),
            ),
        )
);

/**
 * Hero Color Scheme
 */
my_config_kirki_add_field(
        array(
            'type' => 'radio',
            'settings' => 'hero_color_scheme',
            'label' => esc_attr__('Hero Text Color Scheme', 'fundament_wp'),
            'description' => esc_attr__('Use the light scheme with a bright background color and the dark scheme with a dark background.', 'fundament_wp'),
            'section' => 'home_hero_section',
            'default' => 'hero-dark',
            'choices' => array(
                'hero-light' => esc_attr__('Light Hero', 'fundament_wp'),
                'hero-dark' => esc_attr__('Dark Hero', 'fundament_wp'),
            ),
            'transport' => 'refresh',
            'required' => array(
                array(
                    'setting' => 'hero_type_setting',
                    'operator' => 'contains',
                    'value' => array('static-hero', 'post-hero')
                )
            ),
        )
);

/**
 * Hero Content Width
 */
my_config_kirki_add_field(
        array(
            'type' => 'slider',
            'settings' => 'hero_content_width',
            'label' => esc_attr__('Hero Content Width', 'fundament_wp'),
            'description' => esc_attr__('Define the width of the text content on the hero.', 'fundament_wp'),
            'section' => 'home_hero_section',
            'default' => '50',
            'choices' => array(
                'min' => 25,
                'max' => 100,
                'step' => 1,
                'suffix' => '%',
            ),
            'output' => array(
                array(
                    'element' => array('#wrapper-hero-inner h1', '#wrapper-hero-inner p'),
                    'property' => 'width',
                    'units' => '%',
                ),
            ),
            'transport' => 'postMessage',
            'js_vars' => array(
                array(
                    'element' => array('#wrapper-hero-inner h1', '#wrapper-hero-inner p'),
                    'property' => 'width',
                    'units' => '%',
                ),
            ),
            'required' => array(
                array(
                    'setting' => 'hero_type_setting',
                    'operator' => 'contains',
                    'value' => array('static-hero', 'post-hero')
                )
            ),
        )
);

/**
 * Homepage Content Blocks Repeater Control.
 */
my_config_kirki_add_field(
        array(
            'type' => 'repeater',
            'settings' => 'home_content_blocks',
            'label' => esc_attr__('Homepage Content Blocks', 'fundament_wp'),
            'description' => esc_attr__('Arrange and define your content blocks for your homepage.', 'fundament_wp'),
            'section' => 'home_blocks_section',
            'transport' => 'refresh',
            'row_label' => array(
                'type' => 'text',
                'value' => esc_attr__('Content Block', 'fundament_wp')
            ),
            'fields' => array(
                'blocks_type' => array(
                    'type' => 'select',
                    'label' => esc_attr__('Content Block Type', 'fundament_wp'),
                    'description' => esc_attr__('Select the type of your content block.', 'fundament_wp'),
                    'default' => 'cards-query-posts',
                    'choices' => array(
                        'cards-query-posts' => esc_attr__('Card Items: Query Posts', 'fundament_wp'),
                        'cards-query-pages' => esc_attr__('Card Items: Query Pages', 'fundament_wp'),
                        'carousel-query-posts' => esc_attr__('Carousel: Query Posts', 'fundament_wp'),
                        'carousel-query-pages' => esc_attr__('Carousel: Query Pages', 'fundament_wp'),
                        'shortcode-block' => esc_attr__('Shortcode Block', 'fundament_wp'),
                    )
                ),
                'block_title' => array(
                    'type' => 'text',
                    'label' => esc_attr__('Content Block Title', 'fundament_wp'),
                    'description' => esc_attr__('This will be the heading above your content block. Leave empty for no heading.', 'fundament_wp'),
                    'required' => array(
                        array(
                            'setting' => 'blocks_type',
                            'operator' => 'contains',
                            'value' => array('cards-query-posts', 'cards-query-pages', 'carousel-query-posts', 'carousel-query-pages'),
                        )
                    ),
                ),
                'blocks_per_row' => array(
                    'type' => 'select',
                    'label' => esc_attr__('Elements per Row', 'fundament_wp'),
                    'description' => esc_attr__('Select number of content blocks per row.', 'fundament_wp'),
                    'default' => 'col-md-12',
                    'choices' => array(
                        'col-md-12' => esc_attr__('1', 'fundament_wp'),
                        'col-md-6' => esc_attr__('2', 'fundament_wp'),
                        'col-md-4' => esc_attr__('3', 'fundament_wp'),
                        'col-md-3' => esc_attr__('4', 'fundament_wp'),
                        'col-md-2' => esc_attr__('6', 'fundament_wp')
                    ),
                    'required' => array(
                        array(
                            'setting' => 'blocks_type',
                            'operator' => 'contains',
                            'value' => array('cards-query-posts', 'cards-query-pages'),
                        )
                    ),
                ),
                'number_of_blocks' => array(
                    'type' => 'text',
                    'label' => esc_attr__('Total Number of Blocks', 'fundament_wp'),
                    'description' => esc_attr__('Set max limit for items or leave empty to display all (limited to 1000).', 'fundament_wp'),
                    'default' => '12',
                    'required' => array(
                        array(
                            'setting' => 'blocks_type',
                            'operator' => 'contains',
                            'value' => array('cards-query-posts', 'cards-query-pages', 'carousel-query-posts', 'carousel-query-pages'),
                        )
                    ),
                ),
                'blocks_layout_type' => array(
                    'type' => 'select',
                    'label' => esc_attr__('Blocks Layout Type', 'fundament_wp'),
                    'description' => esc_attr__('Select type of layout for these blocks.', 'fundament_wp'),
                    'default' => 'card-vertical',
                    'choices' => array(
                        'card-vertical' => esc_attr__('Cards with Image on Top', 'fundament_wp'),
                        'card-horizontal card-horizontal-left' => esc_attr__('Cards with Image on Left', 'fundament_wp'),
                        'card-horizontal card-horizontal-right' => esc_attr__('Cards with Image on Right', 'fundament_wp'),
                        'card-image-overlay' => esc_attr__('Cards with Image Overlay', 'fundament_wp'),
                        'card-no-image' => esc_attr__('Cards with no Image', 'fundament_wp')
                    ),
                    'required' => array(
                        array(
                            'setting' => 'blocks_type',
                            'operator' => 'contains',
                            'value' => array('cards-query-posts', 'cards-query-pages'),
                        )
                    ),
                ),
                'blocks_overlay_color' => array(
                    'type' => 'color',
                    'label' => esc_attr__('Blocks Overlay Color', 'fundament_wp'),
                    'description' => esc_attr__('Define a color with transparency to use as an overlay over the images.', 'fundament_wp'),
                    'default' => 'rgba(224, 224, 224, 0.75);',
                    'choices' => array(
                        'alpha' => true,
                    ),
                    'required' => array(
                        array(
                            'setting' => 'blocks_layout_type',
                            'operator' => '==',
                            'value' => 'card-image-overlay',
                        )
                    ),
                ),
                'blocks_overlay_text_color' => array(
                    'type' => 'checkbox',
                    'label' => esc_attr__('Light Color Post Title', 'fundament_wp'),
                    'required' => array(
                        array(
                            'setting' => 'blocks_layout_type',
                            'operator' => '==',
                            'value' => 'card-image-overlay',
                        )
                    ),
                ),
                'blocks_overlay_text_color' => array(
                    'type' => 'select',
                    'label' => esc_attr__('Blocks Overlay Type', 'fundament_wp'),
                    'description' => esc_attr__('Switch between dark or light type to change post title text color.', 'fundament_wp'),
                    'default' => 'light',
                    'choices' => array(
                        'light' => esc_attr__('Light Overlay', 'fundament_wp'),
                        'dark' => esc_attr__('Dark Overlay', 'fundament_wp')
                    ),
                    'required' => array(
                        array(
                            'setting' => 'blocks_layout_type',
                            'operator' => '==',
                            'value' => 'card-image-overlay',
                        )
                    ),
                ),
                'blocks_image_height' => array(
                    'type' => 'number',
                    'label' => esc_attr__('Blocks Thumbnails Height', 'fundament_wp'),
                    'description' => esc_attr__('Define a fixed height for the blocks thumbnails in px.', 'fundament_wp'),
                    'required' => array(
                        array(
                            'setting' => 'blocks_layout_type',
                            'operator' => '==',
                            'value' => 'card-vertical',
                        )
                    ),
                ),
                'blocks_min_height' => array(
                    'type' => 'number',
                    'label' => esc_attr__('Blocks Minimum Height', 'fundament_wp'),
                    'description' => esc_attr__('Define a minimum height for the individual blocks in px.', 'fundament_wp'),
                    'default' => 80,
                    'required' => array(
                        array(
                            'setting' => 'blocks_layout_type',
                            'operator' => 'contains',
                            'value' => array('card-vertical', 'card-horizontal card-horizontal-left', 'card-horizontal card-horizontal-right', 'card-image-overlay', 'card-no-image'),
                        )
                    ),
                ),
                'blocks_post_category_query' => array(
                    'type' => 'select',
                    'label' => esc_attr__('Select Categories to Query', 'fundament_wp'),
                    'description' => esc_attr__('You may select multiple categories to query your content from.', 'fundament_wp'),
                    'multiple' => 12,
                    'choices' => $category_choices,
                    'required' => array(
                        array(
                            'setting' => 'blocks_type',
                            'operator' => 'contains',
                            'value' => array('cards-query-posts', 'carousel-query-posts'),
                        )
                    ),
                ),
                'blocks_post_tags_query' => array(
                    'type' => 'select',
                    'label' => esc_attr__('Select Tags to Query', 'fundament_wp'),
                    'description' => esc_attr__('You may select multiple tags to query your content from.', 'fundament_wp'),
                    'multiple' => 12,
                    'choices' => $tag_choices,
                    'required' => array(
                        array(
                            'setting' => 'blocks_type',
                            'operator' => 'contains',
                            'value' => array('cards-query-posts', 'carousel-query-posts'),
                        )
                    ),
                ),
                'blocks_post_pages_query' => array(
                    'type' => 'select',
                    'label' => esc_attr__('Select Specific Pages to Query', 'fundament_wp'),
                    'description' => esc_attr__('If you select pages, then the category and tag queries will be ignored.', 'fundament_wp'),
                    'multiple' => 12,
                    'choices' => $page_choices,
                    'required' => array(
                        array(
                            'setting' => 'blocks_type',
                            'operator' => 'contains',
                            'value' => array('cards-query-pages', 'carousel-query-pages'),
                        )
                    ),
                ),
                'blocks_orderby' => array(
                    'type' => 'select',
                    'label' => esc_attr__('Blocks Ordered By', 'fundament_wp'),
                    'description' => esc_attr__('Sort retrieved posts by parameter for these blocks.', 'fundament_wp'),
                    'default' => 'date',
                    'choices' => array(
                        'date' => esc_attr__('Date', 'fundament_wp'),
                        'modified' => esc_attr__('Modified Date', 'fundament_wp'),
                        'ID' => esc_attr__('ID', 'fundament_wp'),
                        'author' => esc_attr__('Author', 'fundament_wp'),
                        'title' => esc_attr__('Title', 'fundament_wp'),
                        'name' => esc_attr__('Post Slug', 'fundament_wp'),
                        'rand' => esc_attr__('Random', 'fundament_wp'),
                        'comment_count' => esc_attr__('Comment Count', 'fundament_wp'),
                        'meta_value' => esc_attr__('Meta Value', 'fundament_wp'),
                        'meta_value_num' => esc_attr__('Numeric Meta Value', 'fundament_wp')
                    ),
                    'required' => array(
                        array(
                            'setting' => 'blocks_type',
                            'operator' => 'contains',
                            'value' => array('cards-query-posts', 'cards-query-pages', 'carousel-query-posts', 'carousel-query-pages'),
                        )
                    ),
                ),
                'blocks_order' => array(
                    'type' => 'select',
                    'label' => esc_attr__('Blocks Order', 'fundament_wp'),
                    'description' => esc_attr__('Sort retrieved posts in an ascending or descending order.', 'fundament_wp'),
                    'default' => 'DESC',
                    'choices' => array(
                        'DESC' => esc_attr__('Descending (highest to lowest)', 'fundament_wp'),
                        'ASC' => esc_attr__('Ascending (lowest to highest)', 'fundament_wp')
                    ),
                    'required' => array(
                        array(
                            'setting' => 'blocks_type',
                            'operator' => 'contains',
                            'value' => array('cards-query-posts', 'cards-query-pages', 'carousel-query-posts', 'carousel-query-pages'),
                        )
                    ),
                ),
                'blocks_orderby_meta_key' => array(
                    'type' => 'text',
                    'label' => esc_attr__('Meta Key to Order By', 'fundament_wp'),
                    'description' => esc_attr__('If you choose to order by meta value, then enter the meta key defined in post custom fields.', 'fundament_wp'),
                    'default' => '',
                    'required' => array(
                        array(
                            'setting' => 'blocks_type',
                            'operator' => 'contains',
                            'value' => array('cards-query-posts', 'cards-query-pages', 'carousel-query-posts', 'carousel-query-pages'),
                        )
                    ),
                ),
                'carousel_layout_type' => array(
                    'type' => 'select',
                    'label' => esc_attr__('Carousel Layout Type', 'fundament_wp'),
                    'description' => esc_attr__('Select type of layout for your carousel.', 'fundament_wp'),
                    'default' => 'text-overlay left-aligned',
                    'choices' => array(
                        'text-overlay left-aligned' => esc_attr__('Text Overlay - Left Aligned', 'fundament_wp'),
                        'text-overlay right-aligned' => esc_attr__('Text Overlay - Right Aligned', 'fundament_wp'),
                        'center-aligned' => esc_attr__('Center Aligned Slides', 'fundament_wp'),
                        'image-on-left' => esc_attr__('Slides with Image on Left', 'fundament_wp'),
                        'image-on-right' => esc_attr__('Slides with Image on Right', 'fundament_wp')
                    ),
                    'required' => array(
                        array(
                            'setting' => 'blocks_type',
                            'operator' => 'contains',
                            'value' => array('carousel-query-posts', 'carousel-query-pages'),
                        )
                    ),
                ),
                'carousel_stretch_layout' => array(
                    'type' => 'checkbox',
                    'label' => esc_attr__('Full Width Carousel (Use without sidebar)', 'fundament_wp'),
                    'default' => false,
                    'required' => array(
                        array(
                            'setting' => 'blocks_type',
                            'operator' => 'contains',
                            'value' => array('carousel-query-posts', 'carousel-query-pages'),
                        )
                    ),
                ),
                'blocks_shortcode' => array(
                    'type' => 'textarea',
                    'label' => esc_attr__('Custom Shortcode', 'fundament_wp'),
                    'description' => esc_attr__('Enter a custom shortcode you have created to output.', 'fundament_wp'),
                    'default' => '',
                    'required' => array(
                        array(
                            'setting' => 'blocks_type',
                            'operator' => '==',
                            'value' => 'shortcode-block',
                        )
                    ),
                ),
            )
        )
);

/**
 * Predefined Card Style
 */
my_config_kirki_add_field(
        array(
            'type' => 'select',
            'settings' => 'card_predefined_style',
            'label' => esc_attr__('Predefined Card Style', 'fundament_wp'),
            'description' => esc_attr__('Select one of the predefined card styles. You may overwrite these with settings below.', 'fundament_wp'),
            'section' => 'home_blocks_section',
            'transport' => 'refresh',
            'default' => 'light-shadow',
            'choices' => array(
                'flat-style' => esc_attr__('Flat Style', 'fundament_wp'),
                'light-shadow' => esc_attr__('Light Shadow', 'fundament_wp'),
                'material-style' => esc_attr__('Material Style', 'fundament_wp'),
                'without-frame' => esc_attr__('Without Frame', 'fundament_wp'),
            ),
        )
);

/**
 * Card Border Thickness
 */
my_config_kirki_add_field(
        array(
            'type' => 'slider',
            'settings' => 'card_border_size',
            'label' => esc_attr__('Card Border Thickness', 'fundament_wp'),
            'description' => esc_attr__('Set the size of the border around cards.', 'fundament_wp'),
            'section' => 'home_blocks_section',
            'default' => '1',
            'choices' => array(
                'min' => 0,
                'max' => 6.0,
                'step' => 0.25,
                'suffix' => 'px',
            ),
            'output' => array(
                array(
                    'element' => array('.card-wrapper .card .card-inner'),
                    'property' => 'border-width',
                    'units' => 'px',
                ),
            ),
            'transport' => 'postMessage',
            'js_vars' => array(
                array(
                    'element' => array('.card-wrapper .card .card-inner'),
                    'property' => 'border-width',
                    'units' => 'px',
                ),
            ),
        )
);

/**
 * Card Border Thickness
 */
my_config_kirki_add_field(
        array(
            'type' => 'slider',
            'settings' => 'card_border_size',
            'label' => esc_attr__('Card Border Thickness', 'fundament_wp'),
            'description' => esc_attr__('Set the size of the border around cards.', 'fundament_wp'),
            'section' => 'home_blocks_section',
            'default' => '1',
            'choices' => array(
                'min' => 0,
                'max' => 6.0,
                'step' => 0.25,
                'suffix' => 'px',
            ),
            'output' => array(
                array(
                    'element' => array('.card-wrapper .card .card-inner'),
                    'property' => 'border-width',
                    'units' => 'px',
                ),
            ),
            'transport' => 'postMessage',
            'js_vars' => array(
                array(
                    'element' => array('.card-wrapper .card .card-inner'),
                    'property' => 'border-width',
                    'units' => 'px',
                ),
            ),
        )
);

/**
 * Card Border Color
 */
my_config_kirki_add_field(
        array(
            'type' => 'color',
            'settings' => 'card_border_color',
            'label' => __('Card Border Color', 'fundament_wp'),
            'description' => esc_attr__('Define the color of the border on cards.', 'fundament_wp'),
            'section' => 'home_blocks_section',
            'default' => 'rgba(0, 0, 0, 0.1);',
            'choices' => array(
                'alpha' => true,
            ),
            'output' => array(
                array(
                    'element' => '.card-wrapper .card .card-inner',
                    'property' => 'border-color',
                ),
            ),
            'transport' => 'postMessage',
            'js_vars' => array(
                array(
                    'element' => '.card-wrapper .card .card-inner',
                    'property' => 'border-color',
                ),
            ),
        )
);

/**
 * Card Top Border
 */
my_config_kirki_add_field(
        array(
            'type' => 'slider',
            'settings' => 'card_border_top_size',
            'label' => esc_attr__('Card Top Border', 'fundament_wp'),
            'description' => esc_attr__('Set the size of the top border on cards.', 'fundament_wp'),
            'section' => 'home_blocks_section',
            'default' => '5',
            'choices' => array(
                'min' => 0,
                'max' => 16.0,
                'step' => 0.5,
                'suffix' => 'px',
            ),
            'output' => array(
                array(
                    'element' => array('.card-wrapper .card .card-inner'),
                    'property' => 'border-top-width',
                    'units' => 'px',
                    'suffix' => ' !important',
                ),
            ),
            'transport' => 'postMessage',
            'js_vars' => array(
                array(
                    'element' => array('.card-wrapper .card .card-inner'),
                    'property' => 'border-top-width',
                    'units' => 'px',
                    'suffix' => ' !important',
                ),
            ),
        )
);

/**
 * Card Top Border Color
 */
my_config_kirki_add_field(
        array(
            'type' => 'color',
            'settings' => 'card_border_top_color',
            'label' => __('Card Top Border Color', 'fundament_wp'),
            'description' => esc_attr__('Define the color of the top border on cards.', 'fundament_wp'),
            'section' => 'home_blocks_section',
            'default' => '#88dbdf',
            'choices' => array(
                'alpha' => true,
            ),
            'output' => array(
                array(
                    'element' => array('.card-wrapper .card .card-inner'),
                    'property' => 'border-top-color',
                    'suffix' => ' !important',
                ),
            ),
            'transport' => 'postMessage',
            'js_vars' => array(
                array(
                    'element' => array('.card-wrapper .card .card-inner'),
                    'property' => 'border-top-color',
                    'suffix' => ' !important',
                ),
            ),
        )
);

/**
 * Display Post Categories on Cards
 */
my_config_kirki_add_field(
        array(
            'type' => 'toggle',
            'settings' => 'card_category_toggle',
            'label' => esc_attr__('Display Post Categories on Cards', 'fundament_wp'),
            'description' => esc_attr__('Select if you want to display the post categories on card items.', 'fundament_wp'),
            'section' => 'home_blocks_section',
            'default' => true,
            'transport' => 'refresh',
        )
);

/**
 * Display Author Avatar on Cards
 */
my_config_kirki_add_field(
        array(
            'type' => 'toggle',
            'settings' => 'card_avatar_toggle',
            'label' => esc_attr__('Display Author Avatar on Cards', 'fundament_wp'),
            'description' => esc_attr__('Select if you want to display the author avatar on card items.', 'fundament_wp'),
            'section' => 'home_blocks_section',
            'default' => false,
            'transport' => 'refresh',
        )
);

/**
 * Display Author Name on Cards
 */
my_config_kirki_add_field(
        array(
            'type' => 'toggle',
            'settings' => 'card_author_toggle',
            'label' => esc_attr__('Display Author Name on Cards', 'fundament_wp'),
            'description' => esc_attr__('Select if you want to display the author name on card items.', 'fundament_wp'),
            'section' => 'home_blocks_section',
            'default' => false,
            'transport' => 'refresh',
        )
);

/**
 * Display Post Date on Cards
 */
my_config_kirki_add_field(
        array(
            'type' => 'toggle',
            'settings' => 'card_postdate_toggle',
            'label' => esc_attr__('Display Post Date on Cards', 'fundament_wp'),
            'description' => esc_attr__('Select if you want to display the post date on card items.', 'fundament_wp'),
            'section' => 'home_blocks_section',
            'default' => false,
            'transport' => 'refresh',
        )
);

/**
 * Display Estimated Reading Time on Cards
 */
my_config_kirki_add_field(
        array(
            'type' => 'toggle',
            'settings' => 'card_readingtime_toggle',
            'label' => esc_attr__('Display Estimated Reading Time on Cards', 'fundament_wp'),
            'description' => esc_attr__('Select if you want to display the estimated reading time on card items.', 'fundament_wp'),
            'section' => 'home_blocks_section',
            'default' => false,
            'transport' => 'refresh',
        )
);

/**
 * Display Meta Icons on Cards
 */
my_config_kirki_add_field(
        array(
            'type' => 'toggle',
            'settings' => 'card_icons_toggle',
            'label' => esc_attr__('Display Meta Icons on Cards', 'fundament_wp'),
            'description' => esc_attr__('Select if you want to display the meta icons on card items.', 'fundament_wp'),
            'section' => 'home_blocks_section',
            'default' => false,
            'transport' => 'refresh',
        )
);

/**
 * Display Post Tags on Cards
 */
my_config_kirki_add_field(
        array(
            'type' => 'toggle',
            'settings' => 'card_tags_toggle',
            'label' => esc_attr__('Display Post Tags on Cards', 'fundament_wp'),
            'description' => esc_attr__('Select if you want to display the post tags on card items.', 'fundament_wp'),
            'section' => 'home_blocks_section',
            'default' => false,
            'transport' => 'refresh',
        )
);

/**
 * Display Read More Button on Cards
 */
my_config_kirki_add_field(
        array(
            'type' => 'toggle',
            'settings' => 'card_readmore_toggle',
            'label' => esc_attr__('Display Read More Button on Cards', 'fundament_wp'),
            'description' => esc_attr__('Select if you want to display the read more button on card items.', 'fundament_wp'),
            'section' => 'home_blocks_section',
            'default' => true,
            'transport' => 'refresh',
        )
);

/**
 * Excerpt Lenght for Blocks
 */
my_config_kirki_add_field(
        array(
            'type' => 'number',
            'settings' => 'cards_excerpt_length',
            'label' => esc_attr__('Excerpt Length for Blocks', 'fundament_wp'),
            'description' => esc_attr__('Define the amount of words you want to display in each content card from a post or a page.', 'fundament_wp'),
            'section' => 'home_blocks_section',
            'transport' => 'refresh',
            'default' => 25,
            'choices' => array(
                'min' => 0,
                'max' => 500,
                'step' => 1,
            ),
        )
);


/**
 * Single Posts Layout Order
 */
my_config_kirki_add_field(
        array(
            'type' => 'sortable',
            'settings' => 'single_posts_layout_order',
            'label' => esc_attr__('Single Posts Layout Order', 'fundament_wp'),
            'description' => esc_attr__('Set your order for the single posts layout. The order of featured image and post title applies to default page templates as well.', 'fundament_wp'),
            'section' => 'single_posts_section',
            'transport' => 'refresh',
            'default' => array('featured_image', 'post_title'),
            'choices' => array(
                'entry_meta' => esc_attr__('Post Meta Area', 'fundament_wp'),
                'featured_image' => esc_attr__('Featured Image', 'fundament_wp'),
                'post_title' => esc_attr__('Post Title', 'fundament_wp'),
                'post_teaser' => esc_attr__('Post Teaser (when excerpt is set)', 'fundament_wp'),
            ),
        )
);

/**
 * Color of Links in Articles
 */
my_config_kirki_add_field(
        array(
            'type' => 'color',
            'settings' => 'single_posts_link_color',
            'label' => __('Color of Links in Articles', 'fundament_wp'),
            'description' => esc_attr__('Define the color of the links in single posts and default page texts.', 'fundament_wp'),
            'section' => 'single_posts_section',
            'choices' => array(
                'alpha' => true,
            ),
            'output' => array(
                array(
                    'element' => array('.single main > article .entry-content a', '.page main > article .entry-content a'),
                    'property' => 'color',
                ),
                array(
                    'element' => array('.single main > article .entry-content a', '.page main > article .entry-content a'),
                    'property' => 'border-color',
                ),
            ),
            'transport' => 'postMessage',
            'js_vars' => array(
                array(
                    'element' => array('.single main > article .entry-content a', '.page main > article .entry-content a'),
                    'property' => 'color',
                ),
                array(
                    'element' => array('.single main > article .entry-content a', '.page main > article .entry-content a'),
                    'property' => 'border-color',
                ),
            ),
        )
);

/**
 * Display Post Categories on Posts
 */
my_config_kirki_add_field(
        array(
            'type' => 'toggle',
            'settings' => 'post_category_toggle',
            'label' => esc_attr__('Display Post Categories on Posts', 'fundament_wp'),
            'description' => esc_attr__('Select if you want to display the post categories on post items.', 'fundament_wp'),
            'section' => 'single_posts_section',
            'default' => true,
            'transport' => 'refresh',
        )
);

/**
 * Display Author Avatar on Posts
 */
my_config_kirki_add_field(
        array(
            'type' => 'toggle',
            'settings' => 'post_avatar_toggle',
            'label' => esc_attr__('Display Author Avatar on Posts', 'fundament_wp'),
            'description' => esc_attr__('Select if you want to display the author avatar on post items.', 'fundament_wp'),
            'section' => 'single_posts_section',
            'default' => true,
            'transport' => 'refresh',
        )
);

/**
 * Display Author Name on Posts
 */
my_config_kirki_add_field(
        array(
            'type' => 'toggle',
            'settings' => 'post_author_toggle',
            'label' => esc_attr__('Display Author Name on Posts', 'fundament_wp'),
            'description' => esc_attr__('Select if you want to display the author name on post items.', 'fundament_wp'),
            'section' => 'single_posts_section',
            'default' => true,
            'transport' => 'refresh',
        )
);

/**
 * Display Author Bio on Posts
 */
my_config_kirki_add_field(
        array(
            'type' => 'toggle',
            'settings' => 'post_authorbio_toggle',
            'label' => esc_attr__('Display Author Bio on Posts', 'fundament_wp'),
            'description' => esc_attr__('Select if you want to display the author bio on post items.', 'fundament_wp'),
            'section' => 'single_posts_section',
            'default' => true,
            'transport' => 'refresh',
        )
);

/**
 * Display Post Date on Posts
 */
my_config_kirki_add_field(
        array(
            'type' => 'toggle',
            'settings' => 'post_postdate_toggle',
            'label' => esc_attr__('Display Post Date on Posts', 'fundament_wp'),
            'description' => esc_attr__('Select if you want to display the post date on post items.', 'fundament_wp'),
            'section' => 'single_posts_section',
            'default' => true,
            'transport' => 'refresh',
        )
);

/**
 * Display Estimated Reading Time on Posts
 */
my_config_kirki_add_field(
        array(
            'type' => 'toggle',
            'settings' => 'post_readingtime_toggle',
            'label' => esc_attr__('Display Estimated Reading Time on Posts', 'fundament_wp'),
            'description' => esc_attr__('Select if you want to display the estimated reading time on post items.', 'fundament_wp'),
            'section' => 'single_posts_section',
            'default' => false,
            'transport' => 'refresh',
        )
);

/**
 * Display Meta Icons on Posts
 */
my_config_kirki_add_field(
        array(
            'type' => 'toggle',
            'settings' => 'post_icons_toggle',
            'label' => esc_attr__('Display Meta Icons on Posts', 'fundament_wp'),
            'description' => esc_attr__('Select if you want to display the meta icons on post items.', 'fundament_wp'),
            'section' => 'single_posts_section',
            'default' => false,
            'transport' => 'refresh',
        )
);

/**
 * Display Post Tags on Posts
 */
my_config_kirki_add_field(
        array(
            'type' => 'toggle',
            'settings' => 'post_tags_toggle',
            'label' => esc_attr__('Display Post Tags on Posts', 'fundament_wp'),
            'description' => esc_attr__('Select if you want to display the post tags on post items.', 'fundament_wp'),
            'section' => 'single_posts_section',
            'default' => true,
            'transport' => 'refresh',
        )
);

/**
 * Display Related Posts below an Article
 */
my_config_kirki_add_field(
        array(
            'type' => 'toggle',
            'settings' => 'post_related_posts_toggle',
            'label' => esc_attr__('Display Related Posts below an Article', 'fundament_wp'),
            'description' => esc_attr__('Select if you want to display related posts below an article.', 'fundament_wp'),
            'section' => 'single_posts_section',
            'default' => true,
            'transport' => 'refresh',
        )
);


/**
 * Archive Pages Columns per Row
 */
my_config_kirki_add_field(
        array(
            'type' => 'select',
            'settings' => 'archive_columns_per_row',
            'label' => esc_attr__('Archive Pages Columns per Row', 'fundament_wp'),
            'description' => esc_attr__('Select number of content blocks per row on archive pages such as categories and tags.', 'fundament_wp'),
            'section' => 'archive_pages_section',
            'default' => 'col-md-12',
            'choices' => array(
                'col-md-12' => esc_attr__('1', 'fundament_wp'),
                'col-md-6' => esc_attr__('2', 'fundament_wp'),
                'col-md-4' => esc_attr__('3', 'fundament_wp'),
                'col-md-3' => esc_attr__('4', 'fundament_wp'),
                'col-md-2' => esc_attr__('6', 'fundament_wp')
            ),
            'transport' => 'refresh',
        )
);

/**
 * Archive Pages Blocks Layout Type
 */
my_config_kirki_add_field(
        array(
            'type' => 'select',
            'settings' => 'archive_blocks_layout_type',
            'label' => esc_attr__('Archive Pages Blocks Layout Type', 'fundament_wp'),
            'description' => esc_attr__('Select type of layout for blocks on archive pages such as categories and tags.', 'fundament_wp'),
            'section' => 'archive_pages_section',
            'default' => 'card-vertical',
            'choices' => array(
                'card-vertical' => esc_attr__('Cards with Image on Top', 'fundament_wp'),
                'card-horizontal card-horizontal-left' => esc_attr__('Cards with Image on Left', 'fundament_wp'),
                'card-horizontal card-horizontal-right' => esc_attr__('Cards with Image on Right', 'fundament_wp'),
                'card-image-overlay' => esc_attr__('Cards with Image Overlay', 'fundament_wp'),
                'card-no-image' => esc_attr__('Cards with no Image', 'fundament_wp')
            ),
            'transport' => 'refresh',
        )
);

/**
 * Matomo ID
 */
my_config_kirki_add_field(
        array(
            'type' => 'text',
            'settings' => 'Matomo_ID',
            'label' => esc_attr__('Matomo ID', 'fundament_wp'),
            'description' => esc_attr__('Add the Matomo ID for the ACDH-CH matomo server connection', 'fundament_wp'),
            'section' => 'footer_section',
            'default' => 0,
            'transport' => 'refresh',
        )
);

/**
 * Imprint Redmine Issue
 */
my_config_kirki_add_field(
        array(
            'type' => 'text',
            'settings' => 'imprint_redmine_ID',
            'label' => esc_attr__('Imprint: Redmine issue ID', 'fundament_wp'),
            'description' => esc_attr__('Add the Redmine issue ID of your service to pull the imprint parameters from', 'fundament_wp'),
            'section' => 'footer_section',
            'default' => 9945,
            'transport' => 'refresh',
        )
);

/**
 * Imprint Output Language
 */
my_config_kirki_add_field(
        array(
            'type' => 'text',
            'settings' => 'imprint_output_lang',
            'label' => esc_attr__('Imprint Output Language', 'fundament_wp'),
            'description' => esc_attr__('Define in which language your imprint content should be. Use either en or de, or leave empty for content in both languages.', 'fundament_wp'),
            'section' => 'footer_section',
            'transport' => 'refresh',
        )
);

/**
 * Use Default Fundament Footer
 */
my_config_kirki_add_field(
        array(
            'type' => 'toggle',
            'settings' => 'footer_default_fundament',
            'label' => esc_attr__('Use Fundament Footer', 'fundament_wp'),
            'description' => esc_attr__('Select if you want to display the default Fundament footer.', 'fundament_wp'),
            'section' => 'footer_section',
            'default' => true,
            'transport' => 'refresh',
        )
);

/**
 * Primary Footer Background Color
 */
my_config_kirki_add_field(
        array(
            'type' => 'color',
            'settings' => 'footer_primary_bg_color',
            'label' => __('Primary Footer Background Color', 'fundament_wp'),
            'description' => esc_attr__('Define the background color of your primary footer. This footer block will be visible if you add some widgets to this area.', 'fundament_wp'),
            'section' => 'footer_section',
            'default' => '#ffffff',
            'choices' => array(
                'alpha' => true,
            ),
            'output' => array(
                array(
                    'element' => '#wrapper-footer-full',
                    'property' => 'background-color',
                ),
            ),
            'transport' => 'postMessage',
            'js_vars' => array(
                array(
                    'element' => '#wrapper-footer-full',
                    'property' => 'background-color',
                ),
            ),
        )
);

/**
 * Primary Footer Text Color
 */
my_config_kirki_add_field(
        array(
            'type' => 'color',
            'settings' => 'footer_primary_text_color',
            'label' => __('Primary Footer Text Color', 'fundament_wp'),
            'description' => esc_attr__('Define the text color of your primary footer.', 'fundament_wp'),
            'section' => 'footer_section',
            'default' => '#212529',
            'choices' => array(
                'alpha' => true,
            ),
            'output' => array(
                array(
                    'element' => array('#wrapper-footer-full', '#wrapper-footer-full h1', '#wrapper-footer-full h2', '#wrapper-footer-full h3', '#wrapper-footer-full h4', '#wrapper-footer-full h5', '#wrapper-footer-full h6', '#wrapper-footer-full a'),
                    'property' => 'color',
                ),
            ),
            'transport' => 'postMessage',
            'js_vars' => array(
                array(
                    'element' => array('#wrapper-footer-full', '#wrapper-footer-full h1', '#wrapper-footer-full h2', '#wrapper-footer-full h3', '#wrapper-footer-full h4', '#wrapper-footer-full h5', '#wrapper-footer-full h6', '#wrapper-footer-full a'),
                    'property' => 'color',
                ),
            ),
        )
);

/**
 * Primary Footer Widget Border Color
 */
my_config_kirki_add_field(
        array(
            'type' => 'color',
            'settings' => 'footer_primary_border_color',
            'label' => __('Primary Footer Widget Border Color', 'fundament_wp'),
            'description' => esc_attr__('Define the widget border color of your primary footer.', 'fundament_wp'),
            'section' => 'footer_section',
            'default' => 'rgba(0, 0, 0, 0.15)',
            'choices' => array(
                'alpha' => true,
            ),
            'output' => array(
                array(
                    'element' => array('#wrapper-footer-full .widget-title', '.footer-separator'),
                    'property' => 'border-bottom-color',
                ),
            ),
            'transport' => 'postMessage',
            'js_vars' => array(
                array(
                    'element' => array('#wrapper-footer-full .widget-title', '.footer-separator'),
                    'property' => 'border-bottom-color',
                ),
            ),
        )
);

/**
 * Secondary Footer Background Color
 */
my_config_kirki_add_field(
        array(
            'type' => 'color',
            'settings' => 'footer_secondary_bg_color',
            'label' => __('Secondary Footer Background Color', 'fundament_wp'),
            'description' => esc_attr__('Define the background color of your secondary footer. This footer block will be visible if you add some widgets to this area.', 'fundament_wp'),
            'section' => 'footer_section',
            'default' => '#f1f1f1',
            'choices' => array(
                'alpha' => true,
            ),
            'output' => array(
                array(
                    'element' => '#wrapper-footer-secondary',
                    'property' => 'background-color',
                ),
            ),
            'transport' => 'postMessage',
            'js_vars' => array(
                array(
                    'element' => '#wrapper-footer-secondary',
                    'property' => 'background-color',
                ),
            ),
        )
);

/**
 * Secondary Footer Widget Border Color
 */
my_config_kirki_add_field(
        array(
            'type' => 'color',
            'settings' => 'footer_secondary_border_color',
            'label' => __('Secondary Footer Widget Border Color', 'fundament_wp'),
            'description' => esc_attr__('Define the widget border color of your secondary footer.', 'fundament_wp'),
            'section' => 'footer_section',
            'default' => 'rgba(255, 255, 255, 0.3)',
            'choices' => array(
                'alpha' => true,
            ),
            'output' => array(
                array(
                    'element' => '#wrapper-footer-secondary .widget-title',
                    'property' => 'border-bottom-color',
                ),
            ),
            'transport' => 'postMessage',
            'js_vars' => array(
                array(
                    'element' => '#wrapper-footer-secondary .widget-title',
                    'property' => 'border-bottom-color',
                ),
            ),
        )
);

/**
 * Secondary Footer Text Color
 */
my_config_kirki_add_field(
        array(
            'type' => 'color',
            'settings' => 'footer_secondary_text_color',
            'label' => __('Secondary Footer Text Color', 'fundament_wp'),
            'description' => esc_attr__('Define the text color of your secondary footer.', 'fundament_wp'),
            'section' => 'footer_section',
            'default' => '#222222',
            'choices' => array(
                'alpha' => true,
            ),
            'output' => array(
                array(
                    'element' => array('#wrapper-footer-secondary', '#wrapper-footer-secondary h1', '#wrapper-footer-secondary h2', '#wrapper-footer-secondary h3', '#wrapper-footer-secondary h4', '#wrapper-footer-secondary h5', '#wrapper-footer-secondary h6', '#wrapper-footer-secondary a'),
                    'property' => 'color',
                ),
            ),
            'transport' => 'postMessage',
            'js_vars' => array(
                array(
                    'element' => array('#wrapper-footer-secondary', '#wrapper-footer-secondary h1', '#wrapper-footer-secondary h2', '#wrapper-footer-secondary h3', '#wrapper-footer-secondary h4', '#wrapper-footer-secondary h5', '#wrapper-footer-secondary h6', '#wrapper-footer-secondary a'),
                    'property' => 'color',
                ),
            ),
        )
);





