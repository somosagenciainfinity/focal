<?php
/**
 * Template para posts únicos
 * 
 * @package Focal_WordPress
 */

get_header();
?>

<div id="main" role="main" class="anchor">
    <div class="container">
        
        <?php while (have_posts()) : the_post(); ?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
            
            <header class="single-post__header vertical-breather--tight">
                
                <?php focal_breadcrumbs(); ?>
                
                <?php if (get_theme_mod('focal_show_post_date', true)) : ?>
                <div class="single-post__meta">
                    <time class="single-post__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                        <?php echo get_the_date(); ?>
                    </time>
                    
                    <?php if (get_theme_mod('focal_show_post_author', true)) : ?>
                    <span class="single-post__author">
                        <?php _e('por', 'focal-wp'); ?> <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php the_author(); ?></a>
                    </span>
                    <?php endif; ?>
                    
                    <?php if (get_theme_mod('focal_show_reading_time', false)) : ?>
                    <span class="single-post__reading-time">
                        <?php printf(__('%d min de leitura', 'focal-wp'), focal_get_reading_time()); ?>
                    </span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                
                <h1 class="single-post__title h1"><?php the_title(); ?></h1>
                
                <?php if (has_post_thumbnail()) : ?>
                <div class="single-post__featured-image">
                    <?php the_post_thumbnail('focal-banner'); ?>
                </div>
                <?php endif; ?>
                
            </header>
            
            <div class="single-post__content text-container">
                <?php the_content(); ?>
            </div>
            
            <?php if (has_tag()) : ?>
            <footer class="single-post__footer">
                <div class="single-post__tags">
                    <strong><?php _e('Tags:', 'focal-wp'); ?></strong>
                    <?php the_tags('', ', ', ''); ?>
                </div>
            </footer>
            <?php endif; ?>
            
        </article>
        
        <!-- Navegação entre posts -->
        <nav class="post-navigation vertical-breather--tight">
            <div class="post-navigation__links">
                
                <?php
                $prev_post = get_previous_post();
                if ($prev_post) :
                ?>
                <div class="post-navigation__prev">
                    <span class="post-navigation__label"><?php _e('Post anterior', 'focal-wp'); ?></span>
                    <h3 class="post-navigation__title h6">
                        <a href="<?php echo esc_url(get_permalink($prev_post)); ?>">
                            <?php echo esc_html($prev_post->post_title); ?>
                        </a>
                    </h3>
                </div>
                <?php endif; ?>
                
                <?php
                $next_post = get_next_post();
                if ($next_post) :
                ?>
                <div class="post-navigation__next">
                    <span class="post-navigation__label"><?php _e('Próximo post', 'focal-wp'); ?></span>
                    <h3 class="post-navigation__title h6">
                        <a href="<?php echo esc_url(get_permalink($next_post)); ?>">
                            <?php echo esc_html($next_post->post_title); ?>
                        </a>
                    </h3>
                </div>
                <?php endif; ?>
                
            </div>
        </nav>
        
        <!-- Posts relacionados -->
        <?php
        $related_posts = get_posts(array(
            'category__in' => wp_get_post_categories(get_the_ID()),
            'numberposts'  => 3,
            'post__not_in' => array(get_the_ID()),
        ));
        
        if ($related_posts) :
        ?>
        <section class="related-posts vertical-breather">
            <div class="container">
                <h2 class="related-posts__title h3"><?php _e('Posts relacionados', 'focal-wp'); ?></h2>
                
                <div class="related-posts__grid">
                    <?php foreach ($related_posts as $post) : setup_postdata($post); ?>
                    <article class="related-post">
                        
                        <?php if (has_post_thumbnail()) : ?>
                        <div class="related-post__image">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('focal-thumbnail'); ?>
                            </a>
                        </div>
                        <?php endif; ?>
                        
                        <div class="related-post__content">
                            <h3 class="related-post__title h6">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            
                            <div class="related-post__meta">
                                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                    <?php echo get_the_date(); ?>
                                </time>
                            </div>
                        </div>
                        
                    </article>
                    <?php endforeach; wp_reset_postdata(); ?>
                </div>
                
            </div>
        </section>
        <?php endif; ?>
        
        <!-- Comentários -->
        <?php if (comments_open() || get_comments_number()) : ?>
        <section class="comments-section vertical-breather">
            <div class="container">
                <?php comments_template(); ?>
            </div>
        </section>
        <?php endif; ?>
        
        <?php endwhile; ?>
        
    </div>
</div>

<?php get_footer(); ?>