<?php
/**
 * Template para páginas estáticas
 * 
 * @package Focal_WordPress
 */

get_header();
?>

<div id="main" role="main" class="anchor">
    
    <?php while (have_posts()) : the_post(); ?>
    
    <div class="page-hero vertical-breather--tight">
        <div class="container">
            
            <?php focal_breadcrumbs(); ?>
            
            <header class="page-header">
                <h1 class="page-title h1"><?php the_title(); ?></h1>
                
                <?php if (has_excerpt()) : ?>
                <div class="page-excerpt">
                    <p class="text--large"><?php the_excerpt(); ?></p>
                </div>
                <?php endif; ?>
            </header>
            
            <?php if (has_post_thumbnail()) : ?>
            <div class="page-featured-image">
                <?php the_post_thumbnail('focal-banner'); ?>
            </div>
            <?php endif; ?>
            
        </div>
    </div>
    
    <div class="page-content vertical-breather">
        <div class="container">
            <div class="page-content__wrapper">
                
                <main class="page-main-content text-container">
                    <?php the_content(); ?>
                    
                    <?php
                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . __('Páginas:', 'focal-wp'),
                        'after'  => '</div>',
                    ));
                    ?>
                </main>
                
                <?php if (is_active_sidebar('sidebar-1')) : ?>
                <aside class="page-sidebar">
                    <?php dynamic_sidebar('sidebar-1'); ?>
                </aside>
                <?php endif; ?>
                
            </div>
        </div>
    </div>
    
    <?php endwhile; ?>
    
</div>

<?php get_footer(); ?>