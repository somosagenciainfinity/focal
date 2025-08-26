<?php
/**
 * Suporte ao WooCommerce
 * 
 * Convertido das funcionalidades do Shopify para WooCommerce
 * 
 * @package Focal_WordPress
 */

// Previne acesso direto
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Remover estilos padrão do WooCommerce
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * Adicionar suporte a recursos específicos do WooCommerce
 */
function focal_woocommerce_setup() {
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'focal_woocommerce_setup');

/**
 * Modificar número de produtos por página
 */
function focal_woocommerce_products_per_page() {
    return 12;
}
add_filter('loop_shop_per_page', 'focal_woocommerce_products_per_page', 20);

/**
 * Modificar número de produtos relacionados
 */
function focal_woocommerce_related_products_args($args) {
    $args['posts_per_page'] = 4;
    $args['columns'] = 4;
    return $args;
}
add_filter('woocommerce_output_related_products_args', 'focal_woocommerce_related_products_args');

/**
 * Modificar número de produtos em cross-sells
 */
function focal_woocommerce_cross_sells_total($limit) {
    return 4;
}
add_filter('woocommerce_cross_sells_total', 'focal_woocommerce_cross_sells_total');

/**
 * Modificar número de produtos em up-sells
 */
function focal_woocommerce_upsells_total($limit) {
    return 4;
}
add_filter('woocommerce_upsells_total', 'focal_woocommerce_upsells_total');

/**
 * AJAX para busca de produtos (usado no search drawer)
 */
function focal_ajax_search_products() {
    // Verificar nonce
    if (!wp_verify_nonce($_POST['nonce'], 'focal_search_nonce')) {
        wp_die('Security check failed');
    }
    
    $search_query = sanitize_text_field($_POST['s']);
    
    if (empty($search_query) || strlen($search_query) < 2) {
        wp_send_json_error();
    }
    
    // Query para buscar produtos
    $args = array(
        'post_type' => 'product',
        's' => $search_query,
        'post_status' => 'publish',
        'posts_per_page' => 8,
        'meta_query' => array(
            array(
                'key' => '_visibility',
                'value' => array('catalog', 'visible'),
                'compare' => 'IN'
            )
        )
    );
    
    $search_query_obj = new WP_Query($args);
    
    if (!$search_query_obj->have_posts()) {
        wp_send_json_error();
    }
    
    ob_start();
    ?>
    <div class="search-results">
        <div class="search-results__header">
            <h3><?php printf(__('Resultados para "%s"', 'focal-wp'), esc_html($search_query)); ?></h3>
        </div>
        
        <div class="search-results__products">
            <?php while ($search_query_obj->have_posts()) : $search_query_obj->the_post(); ?>
                <?php global $product; ?>
                <div class="search-result-item">
                    <a href="<?php echo esc_url(get_permalink()); ?>" class="search-result-link">
                        <div class="search-result-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('focal-thumbnail'); ?>
                            <?php else : ?>
                                <div class="no-image-placeholder">
                                    <svg viewBox="0 0 24 24" width="48" height="48">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2" fill="none" stroke="currentColor" stroke-width="2"/>
                                        <circle cx="8.5" cy="8.5" r="1.5" fill="currentColor"/>
                                        <polyline points="21,15 16,10 5,21" fill="none" stroke="currentColor" stroke-width="2"/>
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="search-result-info">
                            <h4 class="search-result-title"><?php the_title(); ?></h4>
                            
                            <div class="search-result-price">
                                <?php echo $product->get_price_html(); ?>
                            </div>
                            
                            <?php if (!$product->is_in_stock()) : ?>
                            <div class="search-result-stock out-of-stock">
                                <?php _e('Fora de estoque', 'focal-wp'); ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
        
        <div class="search-results__footer">
            <a href="<?php echo esc_url(add_query_arg('s', $search_query, get_permalink(wc_get_page_id('shop')))); ?>" 
               class="search-results__view-all">
                <?php _e('Ver todos os resultados', 'focal-wp'); ?>
            </a>
        </div>
    </div>
    <?php
    
    $html = ob_get_clean();
    wp_reset_postdata();
    
    wp_send_json_success(array('html' => $html));
}
add_action('wp_ajax_focal_search_products', 'focal_ajax_search_products');
add_action('wp_ajax_nopriv_focal_search_products', 'focal_ajax_search_products');

/**
 * Modificar breadcrumbs do WooCommerce
 */
function focal_woocommerce_breadcrumbs() {
    return array(
        'delimiter'   => ' / ',
        'wrap_before' => '<nav class="woocommerce-breadcrumb breadcrumbs" aria-label="' . esc_attr__('Breadcrumb', 'focal-wp') . '">',
        'wrap_after'  => '</nav>',
        'before'      => '',
        'after'       => '',
        'home'        => __('Início', 'focal-wp'),
    );
}
add_filter('woocommerce_breadcrumb_defaults', 'focal_woocommerce_breadcrumbs');

/**
 * Adicionar classes CSS personalizadas aos produtos
 */
function focal_woocommerce_post_class($classes, $product) {
    if (!$product) {
        return $classes;
    }
    
    // Adicionar classe para produtos em promoção
    if ($product->is_on_sale()) {
        $classes[] = 'product--on-sale';
    }
    
    // Adicionar classe para produtos fora de estoque
    if (!$product->is_in_stock()) {
        $classes[] = 'product--out-of-stock';
    }
    
    // Adicionar classe para produtos em destaque
    if ($product->is_featured()) {
        $classes[] = 'product--featured';
    }
    
    return $classes;
}
add_filter('woocommerce_post_class', 'focal_woocommerce_post_class', 10, 2);

/**
 * Modificar placeholder de imagens de produtos
 */
function focal_woocommerce_placeholder_img_src($src) {
    return FOCAL_THEME_URI . '/assets/images/product-placeholder.svg';
}
add_filter('woocommerce_placeholder_img_src', 'focal_woocommerce_placeholder_img_src');

/**
 * Remover tabs padrão do produto e reorganizar
 */
function focal_woocommerce_remove_product_tabs($tabs) {
    // Remover tab de informações adicionais se vazia
    if (isset($tabs['additional_information'])) {
        global $product;
        if (!$product->has_attributes()) {
            unset($tabs['additional_information']);
        }
    }
    
    // Reorganizar ordem das tabs
    if (isset($tabs['description'])) {
        $tabs['description']['priority'] = 10;
    }
    
    if (isset($tabs['reviews'])) {
        $tabs['reviews']['priority'] = 20;
    }
    
    if (isset($tabs['additional_information'])) {
        $tabs['additional_information']['priority'] = 30;
    }
    
    return $tabs;
}
add_filter('woocommerce_product_tabs', 'focal_woocommerce_remove_product_tabs', 98);

/**
 * Modificar texto dos botões
 */
function focal_woocommerce_product_add_to_cart_text($text, $product) {
    if ($product->get_type() === 'simple') {
        return __('Comprar Agora', 'focal-wp');
    }
    
    return $text;
}
add_filter('woocommerce_product_add_to_cart_text', 'focal_woocommerce_product_add_to_cart_text', 10, 2);

/**
 * Adicionar texto personalizado após adicionar ao carrinho
 */
function focal_woocommerce_add_to_cart_message_html($message, $products) {
    $titles = array();
    $count = 0;
    
    foreach ($products as $product_id => $qty) {
        $titles[] = ($qty > 1 ? absint($qty) . ' &times; ' : '') . sprintf(_x('&ldquo;%s&rdquo;', 'Item name in quotes', 'focal-wp'), strip_tags(get_the_title($product_id)));
        $count += $qty;
    }
    
    $titles = array_filter($titles);
    $added_text = sprintf(_n('%s foi adicionado ao seu carrinho.', '%s foram adicionados ao seu carrinho.', $count, 'focal-wp'), wc_format_list_of_items($titles));
    
    $message = sprintf('%s <a href="%s" class="button wc-forward">%s</a>',
        esc_html($added_text),
        esc_url(wc_get_page_permalink('cart')),
        esc_html__('Ver carrinho', 'focal-wp')
    );
    
    return $message;
}
add_filter('wc_add_to_cart_message_html', 'focal_woocommerce_add_to_cart_message_html', 10, 2);

/**
 * Modificar campos do checkout
 */
function focal_woocommerce_checkout_fields($fields) {
    // Reorganizar campos de cobrança
    $fields['billing']['billing_first_name']['priority'] = 10;
    $fields['billing']['billing_last_name']['priority'] = 20;
    $fields['billing']['billing_email']['priority'] = 30;
    $fields['billing']['billing_phone']['priority'] = 40;
    
    return $fields;
}
add_filter('woocommerce_checkout_fields', 'focal_woocommerce_checkout_fields');

/**
 * Adicionar suporte para avaliações com estrelas
 */
function focal_woocommerce_review_display_rating() {
    return true;
}
add_filter('woocommerce_review_display_rating', 'focal_woocommerce_review_display_rating');

/**
 * Modificar número de colunas na página da loja
 */
function focal_woocommerce_loop_columns() {
    return 3; // 3 colunas no desktop
}
add_filter('loop_shop_columns', 'focal_woocommerce_loop_columns');