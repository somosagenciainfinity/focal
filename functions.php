<?php
/**
 * Focal WordPress Theme Functions
 * 
 * Convertido do tema Shopify Focal para WordPress/WooCommerce
 * 
 * @package Focal_WordPress
 * @version 1.0.0
 */

// Previne acesso direto
if (!defined('ABSPATH')) {
    exit;
}

// Define constantes do tema
define('FOCAL_THEME_VERSION', '1.0.0');
define('FOCAL_THEME_PATH', get_template_directory());
define('FOCAL_THEME_URI', get_template_directory_uri());

/**
 * Configuração básica do tema
 */
function focal_setup() {
    // Suporte a tradução
    load_theme_textdomain('focal-wp', get_template_directory() . '/languages');
    
    // Suporte a feeds RSS automáticos
    add_theme_support('automatic-feed-links');
    
    // Suporte a title tag
    add_theme_support('title-tag');
    
    // Suporte a imagens destacadas
    add_theme_support('post-thumbnails');
    
    // Suporte a logo customizável
    add_theme_support('custom-logo', array(
        'height'      => 80,
        'width'       => 280,
        'flex-width'  => true,
        'flex-height' => true,
    ));
    
    // Suporte a menus
    register_nav_menus(array(
        'primary'   => __('Menu Principal', 'focal-wp'),
        'mobile'    => __('Menu Mobile', 'focal-wp'),
        'footer'    => __('Menu Rodapé', 'focal-wp'),
    ));
    
    // Suporte a HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // Suporte a customização em tempo real
    add_theme_support('customize-selective-refresh-widgets');
    
    // Suporte a WooCommerce
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    
    // Tamanhos de imagem personalizados
    add_image_size('focal-featured', 1200, 600, true);
    add_image_size('focal-product', 600, 600, true);
    add_image_size('focal-thumbnail', 400, 400, true);
    add_image_size('focal-banner', 1600, 800, true);
}
add_action('after_setup_theme', 'focal_setup');

/**
 * Enfileirar estilos e scripts
 */
function focal_scripts() {
    // CSS principal do tema (convertido do Shopify)
    wp_enqueue_style('focal-theme', FOCAL_THEME_URI . '/assets/css/theme.css', array(), FOCAL_THEME_VERSION);
    
    // CSS customizado
    wp_enqueue_style('focal-style', get_stylesheet_uri(), array('focal-theme'), FOCAL_THEME_VERSION);
    
    // jQuery (já incluído no WordPress)
    
    // Scripts do tema (convertidos do Shopify)
    wp_enqueue_script('focal-vendor', FOCAL_THEME_URI . '/assets/js/vendor.js', array('jquery'), FOCAL_THEME_VERSION, true);
    wp_enqueue_script('focal-theme', FOCAL_THEME_URI . '/assets/js/theme.js', array('jquery', 'focal-vendor'), FOCAL_THEME_VERSION, true);
    wp_enqueue_script('focal-custom', FOCAL_THEME_URI . '/assets/js/custom.js', array('jquery', 'focal-theme'), FOCAL_THEME_VERSION, true);
    
    // Flickity para sliders
    wp_enqueue_script('focal-flickity', FOCAL_THEME_URI . '/assets/js/flickity.js', array('jquery'), FOCAL_THEME_VERSION, true);
    
    // PhotoSwipe para galeria
    wp_enqueue_script('focal-photoswipe', FOCAL_THEME_URI . '/assets/js/photoswipe.js', array('jquery'), FOCAL_THEME_VERSION, true);
    
    // Variáveis JavaScript para o tema
    wp_localize_script('focal-theme', 'focal_vars', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('focal_nonce'),
        'site_url' => home_url('/'),
        'cart_url' => wc_get_cart_url(),
        'checkout_url' => wc_get_checkout_url(),
        'is_rtl' => is_rtl(),
        'currency_symbol' => get_woocommerce_currency_symbol(),
        'strings' => array(
            'add_to_cart' => __('Adicionar ao Carrinho', 'focal-wp'),
            'view_cart' => __('Ver Carrinho', 'focal-wp'),
            'checkout' => __('Finalizar Compra', 'focal-wp'),
            'search_placeholder' => __('Buscar produtos...', 'focal-wp'),
        )
    ));
    
    // Script para comentários se necessário
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'focal_scripts');

/**
 * Configurar content width
 */
function focal_content_width() {
    $GLOBALS['content_width'] = apply_filters('focal_content_width', 1200);
}
add_action('after_setup_theme', 'focal_content_width', 0);

/**
 * Registrar áreas de widgets
 */
function focal_widgets_init() {
    // Sidebar principal
    register_sidebar(array(
        'name'          => __('Sidebar Principal', 'focal-wp'),
        'id'            => 'sidebar-1',
        'description'   => __('Aparece na lateral das páginas.', 'focal-wp'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    // Footer widgets (convertido do tema Shopify)
    for ($i = 1; $i <= 4; $i++) {
        register_sidebar(array(
            'name'          => sprintf(__('Footer %d', 'focal-wp'), $i),
            'id'            => 'footer-' . $i,
            'description'   => sprintf(__('Área de widget %d do rodapé.', 'focal-wp'), $i),
            'before_widget' => '<div class="footer-widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="footer-widget-title">',
            'after_title'   => '</h4>',
        ));
    }
    
    // Shop sidebar para WooCommerce
    register_sidebar(array(
        'name'          => __('Shop Sidebar', 'focal-wp'),
        'id'            => 'shop-sidebar',
        'description'   => __('Aparece na página da loja e produtos.', 'focal-wp'),
        'before_widget' => '<section id="%1$s" class="widget shop-widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="shop-widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'focal_widgets_init');

/**
 * Customizer - Configurações do tema
 */
function focal_customize_register($wp_customize) {
    // Seção de configurações do header
    $wp_customize->add_section('focal_header', array(
        'title'    => __('Configurações do Header', 'focal-wp'),
        'priority' => 30,
    ));
    
    // Header sticky
    $wp_customize->add_setting('focal_sticky_header', array(
        'default'           => true,
        'sanitize_callback' => 'focal_sanitize_checkbox',
    ));
    
    $wp_customize->add_control('focal_sticky_header', array(
        'label'   => __('Ativar Header Fixo', 'focal-wp'),
        'section' => 'focal_header',
        'type'    => 'checkbox',
    ));
    
    // Mostrar ícones no header
    $wp_customize->add_setting('focal_show_header_icons', array(
        'default'           => false,
        'sanitize_callback' => 'focal_sanitize_checkbox',
    ));
    
    $wp_customize->add_control('focal_show_header_icons', array(
        'label'   => __('Mostrar Ícones no Header', 'focal-wp'),
        'section' => 'focal_header',
        'type'    => 'checkbox',
    ));
    
    // Layout do header
    $wp_customize->add_setting('focal_header_layout', array(
        'default'           => 'logo_left_navigation_inline',
        'sanitize_callback' => 'focal_sanitize_select',
    ));
    
    $wp_customize->add_control('focal_header_layout', array(
        'label'   => __('Layout do Header', 'focal-wp'),
        'section' => 'focal_header',
        'type'    => 'select',
        'choices' => array(
            'logo_left_navigation_inline' => __('Logo à esquerda, navegação inline', 'focal-wp'),
            'logo_left_navigation_center' => __('Logo à esquerda, navegação centralizada', 'focal-wp'),
            'logo_center_navigation_inline' => __('Logo centralizado, navegação inline', 'focal-wp'),
            'logo_center_search_open' => __('Logo centralizado, busca destacada', 'focal-wp'),
            'drawer' => __('Menu gaveta', 'focal-wp'),
        ),
    ));
    
    // Cores do tema
    $wp_customize->add_section('focal_colors', array(
        'title'    => __('Cores do Tema', 'focal-wp'),
        'priority' => 40,
    ));
    
    // Cor de fundo do header
    $wp_customize->add_setting('focal_header_background', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'focal_header_background', array(
        'label'   => __('Cor de Fundo do Header', 'focal-wp'),
        'section' => 'focal_colors',
    )));
    
    // Cor do texto do header
    $wp_customize->add_setting('focal_header_text_color', array(
        'default'           => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'focal_header_text_color', array(
        'label'   => __('Cor do Texto do Header', 'focal-wp'),
        'section' => 'focal_colors',
    )));
}
add_action('customize_register', 'focal_customize_register');

/**
 * Função para sanitizar checkbox
 */
function focal_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

/**
 * Função para sanitizar select
 */
function focal_sanitize_select($input, $setting) {
    $choices = $setting->manager->get_control($setting->id)->choices;
    return (array_key_exists($input, $choices) ? $input : $setting->default);
}

/**
 * Adicionar classes CSS personalizadas ao body
 */
function focal_body_classes($classes) {
    // Adicionar classe para header fixo
    if (get_theme_mod('focal_sticky_header', true)) {
        $classes[] = 'has-sticky-header';
    }
    
    // Adicionar classe para mostrar ícones
    if (get_theme_mod('focal_show_header_icons', false)) {
        $classes[] = 'show-header-icons';
    }
    
    // Adicionar classe do layout do header
    $header_layout = get_theme_mod('focal_header_layout', 'logo_left_navigation_inline');
    $classes[] = 'header-layout-' . str_replace('_', '-', $header_layout);
    
    return $classes;
}
add_filter('body_class', 'focal_body_classes');

/**
 * Incluir arquivos do tema
 */
require_once FOCAL_THEME_PATH . '/inc/template-functions.php';
require_once FOCAL_THEME_PATH . '/inc/customizer.php';
require_once FOCAL_THEME_PATH . '/inc/class-focal-mobile-menu-walker.php';

// Se WooCommerce estiver ativo, incluir suporte
if (class_exists('WooCommerce')) {
    require_once FOCAL_THEME_PATH . '/inc/woocommerce.php';
}