<?php
/**
 * Template principal do tema
 * 
 * Convertido do theme.liquid do Shopify Focal
 * 
 * @package Focal_WordPress
 */

get_header(); ?>

<div id="main" role="main" class="anchor">
    
    <?php if (have_posts()) : ?>
        
        <div class="container">
            <div class="main-content">
                
                <?php
                // Loop principal do WordPress
                while (have_posts()) :
                    the_post();
                    
                    // Incluir template part baseado no tipo de post
                    get_template_part('template-parts/content/content', get_post_type());
                    
                endwhile;
                ?>
                
                <?php
                // Navegação de posts
                the_posts_navigation(array(
                    'prev_text' => __('Posts Anteriores', 'focal-wp'),
                    'next_text' => __('Próximos Posts', 'focal-wp'),
                ));
                ?>
                
            </div><!-- .main-content -->
            
            <?php get_sidebar(); ?>
            
        </div><!-- .container -->
        
    <?php else : ?>
        
        <div class="container">
            <div class="no-results">
                <h1><?php _e('Nada encontrado', 'focal-wp'); ?></h1>
                <p><?php _e('Parece que não conseguimos encontrar o que você está procurando. Talvez a busca possa ajudar.', 'focal-wp'); ?></p>
                <?php get_search_form(); ?>
            </div>
        </div>
        
    <?php endif; ?>
    
    <?php
    // Incluir seções estáticas (convertidas do Shopify)
    // Equivalent to: {% section 'static-text-with-icons' %}
    get_template_part('template-parts/sections/static-text-with-icons');
    
    // Equivalent to: {% section 'static-newsletter' %}
    get_template_part('template-parts/sections/static-newsletter');
    ?>
    
</div><!-- #main -->

<?php
get_footer();