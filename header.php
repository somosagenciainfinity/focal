<?php
/**
 * Header do tema
 * 
 * Convertido do layout/theme.liquid e sections/header.liquid do Shopify Focal
 * 
 * @package Focal_WordPress
 */

// Determinar direção do texto (RTL/LTR)
$direction = is_rtl() ? 'rtl' : 'ltr';

// Obter configurações do customizer
$sticky_header = get_theme_mod('focal_sticky_header', true);
$show_icons = get_theme_mod('focal_show_header_icons', false);
$header_layout = get_theme_mod('focal_header_layout', 'logo_left_navigation_inline');
$header_bg = get_theme_mod('focal_header_background', '#ffffff');
$header_text = get_theme_mod('focal_header_text_color', '#000000');

?><!doctype html>
<html <?php language_attributes(); ?> dir="<?php echo $direction; ?>">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, height=device-height, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="theme-color" content="<?php echo esc_attr($header_bg); ?>">
    
    <!-- Preconnects para performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Preload recursos importantes -->
    <link rel="preload" as="style" href="<?php echo FOCAL_THEME_URI; ?>/assets/css/theme.css">
    <link rel="preload" as="script" href="<?php echo FOCAL_THEME_URI; ?>/assets/js/vendor.js">
    <link rel="preload" as="script" href="<?php echo FOCAL_THEME_URI; ?>/assets/js/theme.js">
    
    <?php wp_head(); ?>
    
    <style>
        :root {
            --enable-sticky-header: <?php echo $sticky_header ? '1' : '0'; ?>;
            --header-background: <?php echo focal_hex_to_rgb($header_bg); ?>;
            --header-text-color: <?php echo focal_hex_to_rgb($header_text); ?>;
            --header-border-color: <?php echo focal_hex_to_rgb(focal_mix_colors($header_bg, $header_text, 85)); ?>;
            --reduce-header-padding: 0;
        }
        
        .header {
            <?php if ($sticky_header) : ?>
            position: -webkit-sticky;
            position: sticky;
            top: 0;
            <?php endif; ?>
            z-index: 999;
        }
        
        .header__logo-image {
            max-width: 100px;
        }
        
        @media screen and (min-width: 741px) {
            .header__logo-image {
                max-width: 140px;
            }
        }
    </style>
</head>

<body <?php body_class(); ?> data-instant-allow-query-string>
    
    <!-- SVG Definitions comuns -->
    <svg class="visually-hidden">
        <linearGradient id="rating-star-gradient-half">
            <stop offset="50%" stop-color="rgb(var(--product-star-rating))" />
            <stop offset="50%" stop-color="rgb(var(--product-star-rating))" stop-opacity="0.4" />
        </linearGradient>
    </svg>
    
    <!-- Skip to content para acessibilidade -->
    <a href="#main" class="visually-hidden skip-to-content"><?php _e('Pular para o conteúdo', 'focal-wp'); ?></a>
    
    <!-- Loading bar -->
    <loading-bar class="loading-bar"></loading-bar>
    
    <?php
    // Incluir banner scroll se configurado
    get_template_part('template-parts/sections/banner-scroll');
    
    // Incluir announcement bar se configurado
    get_template_part('template-parts/sections/announcement-bar');
    
    // Incluir popup se configurado
    get_template_part('template-parts/sections/popup');
    ?>
    
    <!-- Header Principal -->
    <header class="header <?php echo $header_layout; ?> <?php if ($sticky_header) echo 'header--sticky'; ?>" role="banner">
        <div class="container">
            <div class="header__wrapper">
                
                <!-- Navegação à esquerda / Menu mobile -->
                <nav class="header__inline-navigation" role="navigation">
                    
                    <?php if (in_array($header_layout, ['logo_left_navigation_inline', 'logo_left_navigation_center', 'logo_center_navigation_inline'])) : ?>
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'menu_class'     => 'header__navigation-list',
                            'container'      => false,
                            'fallback_cb'    => false,
                        ));
                        ?>
                    <?php endif; ?>
                    
                    <div class="header__icon-list">
                        
                        <!-- Botão menu mobile -->
                        <?php if (has_nav_menu('primary')) : ?>
                        <button class="header__icon-wrapper tap-area mobile-menu-toggle <?php echo ($header_layout !== 'drawer') ? 'hidden-desk' : ''; ?>" 
                                aria-controls="mobile-menu-drawer" aria-expanded="false">
                            <span class="visually-hidden"><?php _e('Menu de navegação', 'focal-wp'); ?></span>
                            <svg class="icon icon--header-hamburger" viewBox="0 0 24 24" width="18" height="18">
                                <rect x="3" y="6" width="18" height="2"></rect>
                                <rect x="3" y="12" width="18" height="2"></rect>
                                <rect x="3" y="18" width="18" height="2"></rect>
                            </svg>
                        </button>
                        <?php endif; ?>
                        
                        <!-- Botão busca mobile -->
                        <button class="header__icon-wrapper tap-area search-toggle hidden-desk" 
                                aria-controls="search-drawer" aria-expanded="false" 
                                aria-label="<?php esc_attr_e('Buscar', 'focal-wp'); ?>">
                            <svg class="icon icon--header-search" viewBox="0 0 24 24" width="18" height="18">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-6-6m2-5a7 7 0 1 1-14 0 7 7 0 0 1 14 0z"></path>
                            </svg>
                        </button>
                        
                    </div>
                    
                    <?php if ($header_layout === 'logo_center_search_open') : ?>
                    <!-- Barra de busca para layout específico -->
                    <div class="header__search-bar predictive-search hidden-pocket">
                        <form class="predictive-search__form" action="<?php echo esc_url(home_url('/')); ?>" method="get" role="search">
                            <svg class="icon icon--header-search" viewBox="0 0 24 24" width="18" height="18">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-6-6m2-5a7 7 0 1 1-14 0 7 7 0 0 1 14 0z"></path>
                            </svg>
                            <input class="predictive-search__input" type="text" name="s" autocomplete="off" autocorrect="off" 
                                   placeholder="<?php esc_attr_e('Buscar produtos...', 'focal-wp'); ?>" 
                                   value="<?php echo get_search_query(); ?>">
                            <?php if (class_exists('WooCommerce')) : ?>
                            <input type="hidden" name="post_type" value="product">
                            <?php endif; ?>
                        </form>
                    </div>
                    <?php endif; ?>
                    
                </nav>
                
                <!-- Logo -->
                <div class="header__logo">
                    <?php if (is_front_page()) : ?>
                        <h1 class="header__logo-link">
                    <?php else : ?>
                        <div class="header__logo-link">
                    <?php endif; ?>
                    
                        <a href="<?php echo esc_url(home_url('/')); ?>">
                            <?php 
                            $custom_logo_id = get_theme_mod('custom_logo');
                            if ($custom_logo_id) :
                                $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                                ?>
                                <img class="header__logo-image" 
                                     src="<?php echo esc_url($logo[0]); ?>" 
                                     alt="<?php bloginfo('name'); ?>"
                                     width="<?php echo $logo[1]; ?>"
                                     height="<?php echo $logo[2]; ?>">
                                <?php
                            else :
                                ?>
                                <span class="header__logo-text heading h5"><?php bloginfo('name'); ?></span>
                                <?php
                            endif;
                            ?>
                        </a>
                    
                    <?php if (is_front_page()) : ?>
                        </h1>
                    <?php else : ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Links secundários -->
                <div class="header__secondary-links">
                    
                    <div class="header__icon-list">
                        
                        <!-- Busca desktop -->
                        <?php if ($header_layout !== 'logo_center_search_open') : ?>
                        <button class="header__icon-wrapper tap-area search-toggle hidden-pocket hidden-lap <?php echo (!$show_icons) ? 'hidden-desk' : ''; ?>"
                                aria-label="<?php esc_attr_e('Buscar', 'focal-wp'); ?>" 
                                aria-controls="search-drawer" aria-expanded="false">
                            <svg class="icon icon--header-search" viewBox="0 0 24 24" width="18" height="18">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-6-6m2-5a7 7 0 1 1-14 0 7 7 0 0 1 14 0z"></path>
                            </svg>
                        </button>
                        <?php endif; ?>
                        
                        <!-- Rastreamento -->
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('rastreio'))); ?>" 
                           class="header__icon-wrapper tap-area hidden-phone <?php echo (!$show_icons) ? 'hidden-desk' : ''; ?>" 
                           aria-label="<?php esc_attr_e('Rastrear Pedido', 'focal-wp'); ?>">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="transform: translateY(3.4px) scaleX(1.2);">
                                <path d="M12 2C8.13 2 5 5.13 5 9C5 14.25 12 22 12 22S19 14.25 19 9C19 5.13 15.87 2 12 2Z" stroke="currentColor" stroke-width="2.5" fill="none"/>
                                <circle cx="12" cy="9" r="2.5" stroke="currentColor" stroke-width="2.5" fill="none"/>
                            </svg>
                        </a>
                        
                        <!-- Carrinho -->
                        <?php if (class_exists('WooCommerce')) : ?>
                        <a href="<?php echo esc_url(wc_get_cart_url()); ?>" 
                           class="header__icon-wrapper tap-area cart-toggle <?php echo (!$show_icons) ? 'hidden-desk' : ''; ?>" 
                           aria-label="<?php esc_attr_e('Carrinho', 'focal-wp'); ?>">
                            <svg class="icon icon--header-cart" viewBox="0 0 24 24" width="18" height="18">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 7h14l-1 8H6L5 7Zm0 0L3 3h2m0 4 2 8m11-8v11a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V7"/>
                            </svg>
                            <span class="header__cart-count bubble-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                        </a>
                        <?php endif; ?>
                        
                    </div>
                    
                    <?php if (!$show_icons) : ?>
                    <!-- Links de texto quando ícones estão ocultos -->
                    <ul class="header__linklist list--unstyled hidden-pocket hidden-lap" role="list">
                        
                        <?php if ($header_layout !== 'logo_center_search_open') : ?>
                        <li class="header__linklist-item">
                            <button class="search-toggle" aria-controls="search-drawer" aria-expanded="false">
                                <?php _e('Buscar', 'focal-wp'); ?>
                            </button>
                        </li>
                        <?php endif; ?>
                        
                        <li class="header__linklist-item">
                            <a href="<?php echo esc_url(get_permalink(get_page_by_path('rastreio'))); ?>">
                                <?php _e('Rastrear Pedido', 'focal-wp'); ?>
                            </a>
                        </li>
                        
                        <?php if (class_exists('WooCommerce')) : ?>
                        <li class="header__linklist-item">
                            <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="cart-toggle">
                                <?php _e('Carrinho', 'focal-wp'); ?>
                                <span class="header__cart-count bubble-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                            </a>
                        </li>
                        <?php endif; ?>
                        
                    </ul>
                    <?php endif; ?>
                    
                </div>
                
            </div><!-- .header__wrapper -->
            
            <?php if ($header_layout === 'logo_center_search_open' && has_nav_menu('primary')) : ?>
            <!-- Navegação inferior para layout específico -->
            <nav class="header__bottom-navigation hidden-pocket hidden-lap" role="navigation">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class'     => 'header__navigation-list bottom-navigation',
                    'container'      => false,
                    'fallback_cb'    => false,
                ));
                ?>
            </nav>
            <?php endif; ?>
            
        </div><!-- .container -->
    </header>
    
    <!-- Cart notification -->
    <?php if (class_exists('WooCommerce')) : ?>
    <div class="cart-notification <?php echo (!$sticky_header) ? 'cart-notification--fixed' : ''; ?>" style="display: none;">
        <div class="cart-notification__content">
            <span class="cart-notification__message"></span>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Menu mobile drawer -->
    <?php get_template_part('template-parts/header/mobile-menu'); ?>
    
    <!-- Search drawer -->
    <?php get_template_part('template-parts/header/search-drawer'); ?>
    
    <script>
        // Definir altura do header para CSS
        (() => {
            const headerElement = document.querySelector('.header'),
                  headerHeight = headerElement ? headerElement.clientHeight : 0,
                  headerWrapper = headerElement ? headerElement.querySelector('.header__wrapper') : null,
                  headerHeightWithoutBottomNav = headerWrapper ? headerWrapper.clientHeight : headerHeight;
    
            document.documentElement.style.setProperty('--header-height', headerHeight + 'px');
            document.documentElement.style.setProperty('--header-height-without-bottom-nav', headerHeightWithoutBottomNav + 'px');
        })();
    </script>