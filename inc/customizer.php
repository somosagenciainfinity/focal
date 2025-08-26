<?php
/**
 * Configurações adicionais do Customizer
 * 
 * @package Focal_WordPress
 */

// Previne acesso direto
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Adicionar configurações extras do customizer
 */
function focal_customize_register_additional($wp_customize) {
    
    // Seção de configurações da loja
    if (class_exists('WooCommerce')) {
        $wp_customize->add_section('focal_shop', array(
            'title'    => __('Configurações da Loja', 'focal-wp'),
            'priority' => 50,
        ));
        
        // Mostrar preços na navegação
        $wp_customize->add_setting('focal_show_prices_navigation', array(
            'default'           => true,
            'sanitize_callback' => 'focal_sanitize_checkbox',
        ));
        
        $wp_customize->add_control('focal_show_prices_navigation', array(
            'label'   => __('Mostrar Preços na Navegação', 'focal-wp'),
            'section' => 'focal_shop',
            'type'    => 'checkbox',
        ));
        
        // Habilitar zoom nas imagens de produtos
        $wp_customize->add_setting('focal_enable_product_zoom', array(
            'default'           => true,
            'sanitize_callback' => 'focal_sanitize_checkbox',
        ));
        
        $wp_customize->add_control('focal_enable_product_zoom', array(
            'label'   => __('Habilitar Zoom nas Imagens de Produtos', 'focal-wp'),
            'section' => 'focal_shop',
            'type'    => 'checkbox',
        ));
        
        // Habilitar quick view
        $wp_customize->add_setting('focal_enable_quick_view', array(
            'default'           => true,
            'sanitize_callback' => 'focal_sanitize_checkbox',
        ));
        
        $wp_customize->add_control('focal_enable_quick_view', array(
            'label'   => __('Habilitar Visualização Rápida', 'focal-wp'),
            'section' => 'focal_shop',
            'type'    => 'checkbox',
        ));
    }
    
    // Seção de configurações do blog
    $wp_customize->add_section('focal_blog', array(
        'title'    => __('Configurações do Blog', 'focal-wp'),
        'priority' => 60,
    ));
    
    // Mostrar data nos posts
    $wp_customize->add_setting('focal_show_post_date', array(
        'default'           => true,
        'sanitize_callback' => 'focal_sanitize_checkbox',
    ));
    
    $wp_customize->add_control('focal_show_post_date', array(
        'label'   => __('Mostrar Data nos Posts', 'focal-wp'),
        'section' => 'focal_blog',
        'type'    => 'checkbox',
    ));
    
    // Mostrar autor nos posts
    $wp_customize->add_setting('focal_show_post_author', array(
        'default'           => true,
        'sanitize_callback' => 'focal_sanitize_checkbox',
    ));
    
    $wp_customize->add_control('focal_show_post_author', array(
        'label'   => __('Mostrar Autor nos Posts', 'focal-wp'),
        'section' => 'focal_blog',
        'type'    => 'checkbox',
    ));
    
    // Mostrar tempo de leitura
    $wp_customize->add_setting('focal_show_reading_time', array(
        'default'           => false,
        'sanitize_callback' => 'focal_sanitize_checkbox',
    ));
    
    $wp_customize->add_control('focal_show_reading_time', array(
        'label'   => __('Mostrar Tempo de Leitura', 'focal-wp'),
        'section' => 'focal_blog',
        'type'    => 'checkbox',
    ));
    
    // Seção de configurações de performance
    $wp_customize->add_section('focal_performance', array(
        'title'    => __('Performance', 'focal-wp'),
        'priority' => 70,
    ));
    
    // Lazy loading para imagens
    $wp_customize->add_setting('focal_lazy_loading', array(
        'default'           => true,
        'sanitize_callback' => 'focal_sanitize_checkbox',
    ));
    
    $wp_customize->add_control('focal_lazy_loading', array(
        'label'   => __('Lazy Loading para Imagens', 'focal-wp'),
        'section' => 'focal_performance',
        'type'    => 'checkbox',
    ));
    
    // Preload de fontes
    $wp_customize->add_setting('focal_preload_fonts', array(
        'default'           => true,
        'sanitize_callback' => 'focal_sanitize_checkbox',
    ));
    
    $wp_customize->add_control('focal_preload_fonts', array(
        'label'   => __('Preload de Fontes', 'focal-wp'),
        'section' => 'focal_performance',
        'type'    => 'checkbox',
    ));
    
    // Seção de configurações de newsletter
    $wp_customize->add_section('focal_newsletter', array(
        'title'    => __('Newsletter', 'focal-wp'),
        'priority' => 80,
    ));
    
    // Habilitar newsletter
    $wp_customize->add_setting('focal_enable_newsletter', array(
        'default'           => false,
        'sanitize_callback' => 'focal_sanitize_checkbox',
    ));
    
    $wp_customize->add_control('focal_enable_newsletter', array(
        'label'   => __('Habilitar Newsletter', 'focal-wp'),
        'section' => 'focal_newsletter',
        'type'    => 'checkbox',
    ));
    
    // Título da newsletter
    $wp_customize->add_setting('focal_newsletter_title', array(
        'default'           => __('Assine nossa newsletter', 'focal-wp'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('focal_newsletter_title', array(
        'label'   => __('Título da Newsletter', 'focal-wp'),
        'section' => 'focal_newsletter',
        'type'    => 'text',
    ));
    
    // Descrição da newsletter
    $wp_customize->add_setting('focal_newsletter_description', array(
        'default'           => __('Receba nossas ofertas e novidades em primeira mão.', 'focal-wp'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    
    $wp_customize->add_control('focal_newsletter_description', array(
        'label'   => __('Descrição da Newsletter', 'focal-wp'),
        'section' => 'focal_newsletter',
        'type'    => 'textarea',
    ));
    
    // Código do formulário da newsletter
    $wp_customize->add_setting('focal_newsletter_form_code', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ));
    
    $wp_customize->add_control('focal_newsletter_form_code', array(
        'label'       => __('Código do Formulário', 'focal-wp'),
        'description' => __('Cole aqui o código HTML do formulário de newsletter (MailChimp, etc.)', 'focal-wp'),
        'section'     => 'focal_newsletter',
        'type'        => 'textarea',
    ));
    
    // Seção de configurações de redes sociais
    $wp_customize->add_section('focal_social', array(
        'title'    => __('Redes Sociais', 'focal-wp'),
        'priority' => 90,
    ));
    
    $social_networks = array(
        'facebook' => 'Facebook',
        'instagram' => 'Instagram',
        'twitter' => 'Twitter',
        'youtube' => 'YouTube',
        'linkedin' => 'LinkedIn',
        'pinterest' => 'Pinterest',
        'whatsapp' => 'WhatsApp',
        'telegram' => 'Telegram',
    );
    
    foreach ($social_networks as $network => $label) {
        $wp_customize->add_setting('focal_social_' . $network, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        
        $wp_customize->add_control('focal_social_' . $network, array(
            'label'   => $label . ' URL',
            'section' => 'focal_social',
            'type'    => 'url',
        ));
    }
    
    // Seção de configurações de contato
    $wp_customize->add_section('focal_contact', array(
        'title'    => __('Informações de Contato', 'focal-wp'),
        'priority' => 100,
    ));
    
    // Telefone
    $wp_customize->add_setting('focal_contact_phone', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('focal_contact_phone', array(
        'label'   => __('Telefone', 'focal-wp'),
        'section' => 'focal_contact',
        'type'    => 'text',
    ));
    
    // Email
    $wp_customize->add_setting('focal_contact_email', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
    ));
    
    $wp_customize->add_control('focal_contact_email', array(
        'label'   => __('Email', 'focal-wp'),
        'section' => 'focal_contact',
        'type'    => 'email',
    ));
    
    // Endereço
    $wp_customize->add_setting('focal_contact_address', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    
    $wp_customize->add_control('focal_contact_address', array(
        'label'   => __('Endereço', 'focal-wp'),
        'section' => 'focal_contact',
        'type'    => 'textarea',
    ));
    
    // Horário de funcionamento
    $wp_customize->add_setting('focal_contact_hours', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    
    $wp_customize->add_control('focal_contact_hours', array(
        'label'   => __('Horário de Funcionamento', 'focal-wp'),
        'section' => 'focal_contact',
        'type'    => 'textarea',
    ));
}
add_action('customize_register', 'focal_customize_register_additional');

/**
 * Output de CSS personalizado baseado nas configurações do customizer
 */
function focal_customizer_css() {
    $header_bg = get_theme_mod('focal_header_background', '#ffffff');
    $header_text = get_theme_mod('focal_header_text_color', '#000000');
    $sticky_header = get_theme_mod('focal_sticky_header', true);
    $show_icons = get_theme_mod('focal_show_header_icons', false);
    
    ?>
    <style type="text/css">
        :root {
            --header-background-rgb: <?php echo focal_hex_to_rgb($header_bg); ?>;
            --header-text-color-rgb: <?php echo focal_hex_to_rgb($header_text); ?>;
            --enable-sticky-header: <?php echo $sticky_header ? '1' : '0'; ?>;
        }
        
        .header {
            background-color: rgb(var(--header-background-rgb));
            color: rgb(var(--header-text-color-rgb));
        }
        
        .header a {
            color: rgb(var(--header-text-color-rgb));
        }
        
        <?php if (!$show_icons) : ?>
        .header .hidden-desk {
            display: none !important;
        }
        <?php endif; ?>
        
        <?php if ($sticky_header) : ?>
        .header {
            position: sticky;
            top: 0;
            z-index: 999;
        }
        <?php endif; ?>
    </style>
    <?php
}
add_action('wp_head', 'focal_customizer_css');

/**
 * Sanitização para campos de text area que permitem HTML
 */
function focal_sanitize_html($input) {
    return wp_kses_post($input);
}