<?php
/**
 * Template part para exibir produtos no loop
 * 
 * Convertido do product-item.liquid do Shopify Focal
 * 
 * @package Focal_WordPress
 */

defined('ABSPATH') || exit;

global $product;

// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
    return;
}

?>

<li <?php wc_product_class('product-item', $product); ?>>
    
    <div class="product-item__wrapper">
        
        <!-- Product Image -->
        <div class="product-item__image">
            <a href="<?php the_permalink(); ?>" class="product-item__image-link">
                
                <?php
                /**
                 * Hook: woocommerce_before_shop_loop_item_title
                 * 
                 * @hooked woocommerce_show_product_loop_sale_flash - 10
                 * @hooked woocommerce_template_loop_product_thumbnail - 10
                 */
                do_action('woocommerce_before_shop_loop_item_title');
                ?>
                
                <!-- Product badges -->
                <div class="product-item__badges">
                    
                    <?php if ($product->is_on_sale()) : ?>
                    <span class="product-badge product-badge--sale">
                        <?php _e('Promoção', 'focal-wp'); ?>
                    </span>
                    <?php endif; ?>
                    
                    <?php if (!$product->is_in_stock()) : ?>
                    <span class="product-badge product-badge--out-of-stock">
                        <?php _e('Fora de estoque', 'focal-wp'); ?>
                    </span>
                    <?php endif; ?>
                    
                    <?php if ($product->is_featured()) : ?>
                    <span class="product-badge product-badge--featured">
                        <?php _e('Destaque', 'focal-wp'); ?>
                    </span>
                    <?php endif; ?>
                    
                    <?php
                    // Badge para produtos novos (últimos 30 dias)
                    $created_date = strtotime($product->get_date_created());
                    $thirty_days_ago = strtotime('-30 days');
                    
                    if ($created_date > $thirty_days_ago) :
                    ?>
                    <span class="product-badge product-badge--new">
                        <?php _e('Novo', 'focal-wp'); ?>
                    </span>
                    <?php endif; ?>
                    
                </div>
                
                <!-- Quick view button (se habilitado) -->
                <?php if (get_theme_mod('focal_enable_quick_view', true)) : ?>
                <button class="product-item__quick-view" 
                        data-product-id="<?php echo esc_attr($product->get_id()); ?>"
                        aria-label="<?php esc_attr_e('Visualização rápida', 'focal-wp'); ?>">
                    <svg viewBox="0 0 24 24" width="18" height="18">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
                <?php endif; ?>
                
            </a>
        </div>
        
        <!-- Product Info -->
        <div class="product-item__info">
            
            <!-- Product Title -->
            <h3 class="product-item__title">
                <a href="<?php the_permalink(); ?>" class="product-item__title-link">
                    <?php
                    /**
                     * Hook: woocommerce_shop_loop_item_title
                     * 
                     * @hooked woocommerce_template_loop_product_title - 10
                     */
                    do_action('woocommerce_shop_loop_item_title');
                    ?>
                </a>
            </h3>
            
            <!-- Product Rating -->
            <?php if (wc_review_ratings_enabled()) : ?>
            <div class="product-item__rating">
                <?php
                /**
                 * Hook: woocommerce_after_shop_loop_item_title
                 * 
                 * @hooked woocommerce_template_loop_rating - 5
                 * @hooked woocommerce_template_loop_price - 10
                 */
                $rating_html = wc_get_rating_html($product->get_average_rating());
                if ($rating_html) {
                    echo $rating_html;
                } else {
                    echo '<div class="star-rating-empty">';
                    echo str_repeat('<span class="star-empty">☆</span>', 5);
                    echo '</div>';
                }
                ?>
            </div>
            <?php endif; ?>
            
            <!-- Product Price -->
            <div class="product-item__price">
                <?php
                /**
                 * Hook: woocommerce_after_shop_loop_item_title
                 * 
                 * @hooked woocommerce_template_loop_price - 10
                 */
                echo $product->get_price_html();
                ?>
            </div>
            
            <!-- Product Short Description (se disponível) -->
            <?php if ($product->get_short_description()) : ?>
            <div class="product-item__description">
                <?php echo wp_trim_words($product->get_short_description(), 15); ?>
            </div>
            <?php endif; ?>
            
            <!-- Add to Cart Button -->
            <div class="product-item__actions">
                <?php
                /**
                 * Hook: woocommerce_after_shop_loop_item
                 * 
                 * @hooked woocommerce_template_loop_add_to_cart - 10
                 */
                do_action('woocommerce_after_shop_loop_item');
                ?>
                
                <!-- Wishlist button (se plugin estiver ativo) -->
                <?php if (function_exists('YITH_WCWL')) : ?>
                <button class="product-item__wishlist" 
                        data-product-id="<?php echo esc_attr($product->get_id()); ?>"
                        aria-label="<?php esc_attr_e('Adicionar à lista de desejos', 'focal-wp'); ?>">
                    <svg viewBox="0 0 24 24" width="18" height="18">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg>
                </button>
                <?php endif; ?>
                
                <!-- Compare button (se plugin estiver ativo) -->
                <?php if (class_exists('YITH_Woocompare')) : ?>
                <button class="product-item__compare" 
                        data-product-id="<?php echo esc_attr($product->get_id()); ?>"
                        aria-label="<?php esc_attr_e('Comparar produto', 'focal-wp'); ?>">
                    <svg viewBox="0 0 24 24" width="18" height="18">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19c-5 0-8-3-8-8s3-8 8-8 8 3 8 8-3 8-8 8"/>
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 14 1.5 1.5L14 11"/>
                    </svg>
                </button>
                <?php endif; ?>
            </div>
            
        </div>
        
    </div>
    
</li>