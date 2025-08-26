<?php
/**
 * Template part para exibir posts
 * 
 * @package Focal_WordPress
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('blog-post'); ?>>
    
    <?php if (has_post_thumbnail()) : ?>
    <div class="blog-post__image">
        <a href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail('focal-featured', array('class' => 'blog-post__featured-image')); ?>
        </a>
    </div>
    <?php endif; ?>
    
    <div class="blog-post__content">
        
        <header class="blog-post__header">
            
            <?php if (get_theme_mod('focal_show_post_date', true)) : ?>
            <div class="blog-post__meta">
                <time class="blog-post__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                    <?php echo get_the_date(); ?>
                </time>
                
                <?php if (get_theme_mod('focal_show_post_author', true)) : ?>
                <span class="blog-post__author">
                    <?php _e('por', 'focal-wp'); ?> <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php the_author(); ?></a>
                </span>
                <?php endif; ?>
                
                <?php if (get_theme_mod('focal_show_reading_time', false)) : ?>
                <span class="blog-post__reading-time">
                    <?php printf(__('%d min de leitura', 'focal-wp'), focal_get_reading_time()); ?>
                </span>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            
            <h2 class="blog-post__title h3">
                <a href="<?php the_permalink(); ?>" class="blog-post__title-link">
                    <?php the_title(); ?>
                </a>
            </h2>
            
        </header>
        
        <div class="blog-post__excerpt">
            <?php 
            if (has_excerpt()) {
                the_excerpt();
            } else {
                echo '<p>' . focal_truncate_text(get_the_content(), 150) . '</p>';
            }
            ?>
        </div>
        
        <footer class="blog-post__footer">
            
            <?php if (has_category()) : ?>
            <div class="blog-post__categories">
                <?php _e('Categorias:', 'focal-wp'); ?> 
                <?php the_category(', '); ?>
            </div>
            <?php endif; ?>
            
            <a href="<?php the_permalink(); ?>" class="blog-post__read-more button button--secondary">
                <?php _e('Leia mais', 'focal-wp'); ?>
            </a>
            
        </footer>
        
    </div>
    
</article>