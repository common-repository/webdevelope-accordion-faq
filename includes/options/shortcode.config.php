<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.

/**
 * Global skelet shortcodes variable
 */
  global $skelet_shortcodes;

/**
 * Feedback Survey Shortcode options and settings
 */
$skelet_shortcodes[]     = sk_shortcode_apply_prefix(array(
    'title'      => _( 'iProDev Accordion FAQ', 'webdevelope-accordion-faq' ),
    'shortcodes' => array(
        array(
            'name'      => 'faq',
            'title'     => __( 'Insert FAQs',               'webdevelope-accordion-faq' ),
            'fields'    => array (
                array (
                    'id'        => 'template',
                    'type'      => 'select',
                    'title'     => __( 'Template',         'webdevelope-accordion-faq' ),
                    'options'   => array (
                        'list'          => __( 'List',      'webdevelope-accordion-faq' ),
                        'accordion'     => __( 'Accordion', 'webdevelope-accordion-faq' ),
                        'block'         => __( 'Block',     'webdevelope-accordion-faq' ),
                        'excerpt'       => __( 'Excerpt',   'webdevelope-accordion-faq' ),
                    ),
                    'default'   => 'accordion',
                ),
                array(
                    'id'             => 'category',
                    'type'           => 'select',
                    'title'          => __( 'Faq Category', 'webdevelope-accordion-faq' ),
                    'options'        => 'categories',
                    'query_args'     => array(
                        'type'         => 'faq',
                        'taxonomy'     => 'faq_category',
                    ),
                    'default_option' => 'All Categories',
                ),
                array (
                    'id'        => 'use_search',
                    'type'      => 'switcher',
                    'title'     => __( 'Use Search?',  'webdevelope-accordion-faq' ),
                    'default'   => 1
                ),
                array (
                    'id'        => 'bg_color',
                    'type'      => 'color_picker',
                    'title'     => __( 'Background Color',  'webdevelope-accordion-faq' ),
                    'default'   => '#ef3737',
                    'dependency'   => array( 'template', '==', 'block' ),
                ),
                array (
                    'id'        => 'block_radius',
                    'type'    => 'number',
                    'title'   => 'Block Radius',
                    'default' => '0',
                    'after'   => '<i class="sk-text-muted">px</i>',
                    'dependency'   => array( 'template', '==', 'block' ),
                ),
                array (
                    'id'        => 'icon_color',
                    'type'      => 'color_picker',
                    'title'     => __( 'Icon Color',  'webdevelope-accordion-faq' ),
                    'default'   => '#ffffff',
                    'dependency'   => array( 'template', '==', 'accordion' ),
                ),
                array (
                    'id'        => 'icon_bg_color',
                    'type'      => 'color_picker',
                    'title'     => __( 'Icon Background Color',  'webdevelope-accordion-faq' ),
                    'default'   => '#ef3737',
                    'dependency'   => array( 'template', '==', 'accordion' ),
                ),
                array(
                    'id'      => 'icon_bg_radius',
                    'type'    => 'number',
                    'title'   => 'Icon Background Radius',
                    'default' => '0',
                    'after'   => '<i class="sk-text-muted">px</i>',
                    'dependency'   => array( 'template', '==', 'accordion' ),
                ),
            ),
        ),
    ),
));