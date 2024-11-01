<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.

/**
 * Framework page settings
 */
$settings = array(
    'header_title' => __('Accordion Faq Settings', 'webdevelope-accordion-faq'),
    'menu_title'   => __( 'Settings' ),
    'menu_type'    => 'add_submenu_page',
    'menu_slug'    => 'webdevelope-accordion-faq',
    'ajax_save'    => false,
);


/**
 * sections and fields option
 * @var array
 */
$options        = array();

/*
 *  Styling options tab and fields settings
 */
$options[]      = array (
    'name'        => 'general',
    'title'       => __('General', 'webdevelope-accordion-faq'),
    'icon'        => 'fa fa-cogs',
    'fields'      => array(
        array(
            'title'     => __('Drag & Drop Reorder', 'webdevelope-accordion-faq'),
            'id'        => 'reorder',
            'type'      => 'switcher',
            'default' => true
        ),
        array(
            'id'        => 'icon_closed',
            'type'      => 'icon',
            'title'     => __('Closed Icon', 'webdevelope-accordion-faq'),
            'default'   => 'si-plus3'
        ),
        array(
            'id'        => 'icon_opened',
            'type'      => 'icon',
            'title'     => __('Opened Icon', 'webdevelope-accordion-faq'),
            'default'   => 'si-minus3'
        ),
        array(
            'id'      => 'font_size_h2',
            'type'    => 'number',
            'title'   => 'Category Title Font Size',
            'after'   => ' <i class="sk-text-muted">px</i>',
            'default' => 26,
        ),
        array(
            'id'      => 'color_h2',
            'type'    => 'color_picker',
            'title'   => 'Category Title Color',
            'default' => '#000000'
        ),
        array(
            'id'      => 'font_size_h3',
            'type'    => 'number',
            'title'   => 'Faq Title Font Size',
            'after'   => ' <i class="sk-text-muted">px</i>',
            'default' => 20,
        ),
        array(
            'id'      => 'color_h3',
            'type'    => 'color_picker',
            'title'   => 'Faq Title Color',
            'default' => '#000000'
        ),
        array(
            'id'        => 'custom_css',
            'type'      => 'textarea',
            'title'     => __('Custom CSS', 'webdevelope-accordion-faq'),
        ),
    ),
);

SkeletFramework::instance( $settings, $options );
