<?php
/**
 * Template para arquivo de produtos (shop page)
 * 
 * Convertido das funcionalidades do Shopify para WooCommerce
 * 
 * @package Focal_WordPress
 */

defined('ABSPATH') || exit;

get_header('shop');

?>

<div id="main" role="main" class="anchor shop-page">
    
    <?php if (woocommerce_product_loop()) : ?>
    
    <!-- Shop Header -->
    <div class="shop-header vertical-breather--tight">
        <div class="container">
            
            <?php focal_breadcrumbs(); ?>
            
            <header class="shop-page__header">
                
                <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
                <h1 class="shop-page__title h1"><?php woocommerce_page_title(); ?></h1>
                <?php endif; ?>
                
                <?php
                /**
                 * Hook: woocommerce_archive_description
                 * 
                 * @hooked woocommerce_taxonomy_archive_description - 10
                 * @hooked woocommerce_product_archive_description - 10
                 */
                do_action('woocommerce_archive_description');
                ?>
                
            </header>
            
        </div>
    </div>
    
    <!-- Shop Toolbar -->
    <div class="shop-toolbar">
        <div class="container">
            <div class="shop-toolbar__wrapper">
                
                <!-- Results count -->
                <div class="shop-toolbar__results">
                    <?php woocommerce_result_count(); ?>
                </div>
                
                <!-- Ordering -->
                <div class="shop-toolbar__ordering">
                    <?php woocommerce_catalog_ordering(); ?>
                </div>
                
            </div>
        </div>
    </div>
    
    <!-- Shop Content -->
    <div class="shop-content vertical-breather">
        <div class="container">
            <div class="shop-content__wrapper">
                
                <!-- Sidebar with filters -->
                <?php if (is_active_sidebar('shop-sidebar')) : ?>
                <aside class="shop-sidebar">
                    <div class="shop-filters">
                        <?php dynamic_sidebar('shop-sidebar'); ?>
                    </div>
                </aside>
                <?php endif; ?>
                
                <!-- Products grid -->
                <main class="shop-main">
                    
                    <?php
                    /**
                     * Hook: woocommerce_before_shop_loop
                     * 
                     * @hooked woocommerce_output_all_notices - 10
                     */
                    do_action('woocommerce_before_shop_loop');
                    ?>
                    
                    <div class="products-grid">
                        
                        <?php
                        woocommerce_product_loop_start();
                        
                        if (wc_get_loop_prop('is_shortcode')) {
                            $columns = absint(wc_get_loop_prop('columns'));
                        } else {
                            $columns = wc_get_default_products_per_row();
                        }
                        
                        while (have_posts()) :
                            the_post();
                            
                            /**
                             * Hook: woocommerce_shop_loop
                             */
                            do_action('woocommerce_shop_loop');
                            
                            wc_get_template_part('content', 'product');
                            
                        endwhile;
                        
                        woocommerce_product_loop_end();
                        ?>
                        
                    </div>
                    
                    <?php
                    /**
                     * Hook: woocommerce_after_shop_loop
                     * 
                     * @hooked woocommerce_pagination - 10
                     */
                    do_action('woocommerce_after_shop_loop');
                    ?>
                    
                </main>
                
            </div>
        </div>
    </div>
    
    <?php else : ?>
    
    <!-- No products found -->
    <div class="shop-no-products vertical-breather">
        <div class="container">
            <div class="no-products-found">
                
                <?php
                /**
                 * Hook: woocommerce_no_products_found
                 * 
                 * @hooked wc_no_products_found - 10
                 */
                do_action('woocommerce_no_products_found');
                ?>
                
            </div>
        </div>
    </div>
    
    <?php endif; ?>
    
</div>

<?php
get_footer('shop');