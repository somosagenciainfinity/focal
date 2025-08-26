<?php
/**
 * Template para resultados de busca
 * 
 * @package Focal_WordPress
 */

get_header();
?>

<div id="main" role="main" class="anchor search-results">
    <div class="container">
        
        <header class="search-results__header vertical-breather--tight">
            
            <?php focal_breadcrumbs(); ?>
            
            <h1 class="search-results__title h1">
                <?php 
                printf(
                    __('Resultados de busca para: %s', 'focal-wp'),
                    '<span class="search-term">' . get_search_query() . '</span>'
                );
                ?>
            </h1>
            
            <?php if (have_posts()) : ?>
            <div class="search-results__count">
                <?php
                global $wp_query;
                printf(
                    _n(
                        '%d resultado encontrado',
                        '%d resultados encontrados',
                        $wp_query->found_posts,
                        'focal-wp'
                    ),
                    $wp_query->found_posts
                );
                ?>
            </div>
            <?php endif; ?>
            
        </header>
        
        <div class="search-results__content">
            
            <?php if (have_posts()) : ?>
            
            <div class="search-results__list">
                
                <?php while (have_posts()) : the_post(); ?>
                
                <article id="post-<?php the_ID(); ?>" <?php post_class('search-result-item'); ?>>
                    
                    <?php if (has_post_thumbnail()) : ?>
                    <div class="search-result-item__image">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('focal-thumbnail'); ?>
                        </a>
                    </div>
                    <?php endif; ?>
                    
                    <div class="search-result-item__content">
                        
                        <header class="search-result-item__header">
                            
                            <div class="search-result-item__meta">
                                <span class="search-result-item__type">
                                    <?php 
                                    $post_type_obj = get_post_type_object(get_post_type());
                                    echo esc_html($post_type_obj->labels->singular_name);
                                    ?>
                                </span>
                                
                                <time class="search-result-item__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                    <?php echo get_the_date(); ?>
                                </time>
                            </div>
                            
                            <h2 class="search-result-item__title h4">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            
                        </header>
                        
                        <div class="search-result-item__excerpt">
                            <?php 
                            if (has_excerpt()) {
                                the_excerpt();
                            } else {
                                echo '<p>' . focal_truncate_text(get_the_content(), 120) . '</p>';
                            }
                            ?>
                        </div>
                        
                        <?php if (get_post_type() === 'product' && class_exists('WooCommerce')) : ?>
                        <?php global $product; ?>
                        <div class="search-result-item__product-info">
                            <div class="search-result-item__price">
                                <?php echo $product->get_price_html(); ?>
                            </div>
                            
                            <?php if (!$product->is_in_stock()) : ?>
                            <span class="search-result-item__stock out-of-stock">
                                <?php _e('Fora de estoque', 'focal-wp'); ?>
                            </span>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                        
                    </div>
                    
                </article>
                
                <?php endwhile; ?>
                
            </div>
            
            <?php
            // Paginação
            the_posts_navigation(array(
                'prev_text' => __('Resultados anteriores', 'focal-wp'),
                'next_text' => __('Próximos resultados', 'focal-wp'),
            ));
            ?>
            
            <?php else : ?>
            
            <div class="search-no-results">
                
                <div class="no-results-content">
                    <h2 class="no-results__title h3">
                        <?php _e('Nenhum resultado encontrado', 'focal-wp'); ?>
                    </h2>
                    
                    <p><?php _e('Sua busca não retornou resultados. Tente usar termos diferentes ou verifique a ortografia.', 'focal-wp'); ?></p>
                    
                    <!-- Formulário de busca -->
                    <div class="no-results__search">
                        <?php get_search_form(); ?>
                    </div>
                    
                    <!-- Sugestões -->
                    <div class="no-results__suggestions">
                        <h3 class="h5"><?php _e('Sugestões:', 'focal-wp'); ?></h3>
                        <ul>
                            <li><?php _e('Verifique a ortografia das palavras-chave', 'focal-wp'); ?></li>
                            <li><?php _e('Use termos mais gerais', 'focal-wp'); ?></li>
                            <li><?php _e('Tente sinônimos', 'focal-wp'); ?></li>
                            <li><?php _e('Use menos palavras-chave', 'focal-wp'); ?></li>
                        </ul>
                    </div>
                    
                    <!-- Links úteis -->
                    <?php if (class_exists('WooCommerce')) : ?>
                    <div class="no-results__links">
                        <h3 class="h5"><?php _e('Explorar:', 'focal-wp'); ?></h3>
                        <ul>
                            <li><a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>"><?php _e('Todos os produtos', 'focal-wp'); ?></a></li>
                            <?php
                            $product_categories = get_terms('product_cat', array(
                                'number' => 5,
                                'hide_empty' => true,
                            ));
                            
                            if ($product_categories && !is_wp_error($product_categories)) {
                                foreach ($product_categories as $category) {
                                    echo '<li><a href="' . esc_url(get_term_link($category)) . '">' . esc_html($category->name) . '</a></li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    
                </div>
                
            </div>
            
            <?php endif; ?>
            
        </div>
        
    </div>
</div>

<?php get_footer(); ?>