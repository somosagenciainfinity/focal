<?php
/**
 * Template para página 404 (Página não encontrada)
 * 
 * @package Focal_WordPress
 */

get_header();
?>

<div id="main" role="main" class="anchor page-404">
    <div class="container">
        
        <div class="error-404 vertical-breather">
            
            <div class="error-404__content">
                
                <div class="error-404__icon">
                    <svg viewBox="0 0 24 24" width="120" height="120">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                        <line x1="12" y1="9" x2="12" y2="13"/>
                        <line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                </div>
                
                <header class="error-404__header">
                    <h1 class="error-404__title h1">404</h1>
                    <h2 class="error-404__subtitle h2"><?php _e('Página não encontrada', 'focal-wp'); ?></h2>
                </header>
                
                <div class="error-404__description">
                    <p class="text--large">
                        <?php _e('Oops! A página que você está procurando não existe ou foi movida para outro local.', 'focal-wp'); ?>
                    </p>
                </div>
                
                <!-- Busca -->
                <div class="error-404__search">
                    <h3 class="h5"><?php _e('Tente buscar pelo que você precisa:', 'focal-wp'); ?></h3>
                    <?php get_search_form(); ?>
                </div>
                
                <!-- Links úteis -->
                <div class="error-404__links">
                    <h3 class="h5"><?php _e('Ou visite uma dessas páginas:', 'focal-wp'); ?></h3>
                    
                    <div class="error-404__link-grid">
                        
                        <!-- Home -->
                        <div class="error-404__link-item">
                            <h4 class="h6">
                                <a href="<?php echo esc_url(home_url('/')); ?>">
                                    <svg viewBox="0 0 24 24" width="20" height="20">
                                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                        <polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" points="9,22 9,12 15,12 15,22"/>
                                    </svg>
                                    <?php _e('Página Inicial', 'focal-wp'); ?>
                                </a>
                            </h4>
                            <p><?php _e('Volte para a página principal do site', 'focal-wp'); ?></p>
                        </div>
                        
                        <!-- Loja (se WooCommerce estiver ativo) -->
                        <?php if (class_exists('WooCommerce')) : ?>
                        <div class="error-404__link-item">
                            <h4 class="h6">
                                <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>">
                                    <svg viewBox="0 0 24 24" width="20" height="20">
                                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 7h14l-1 8H6L5 7Zm0 0L3 3h2m0 4 2 8"/>
                                    </svg>
                                    <?php _e('Nossa Loja', 'focal-wp'); ?>
                                </a>
                            </h4>
                            <p><?php _e('Explore todos os nossos produtos', 'focal-wp'); ?></p>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Blog -->
                        <?php if (get_option('page_for_posts')) : ?>
                        <div class="error-404__link-item">
                            <h4 class="h6">
                                <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>">
                                    <svg viewBox="0 0 24 24" width="20" height="20">
                                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                        <polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" points="14,2 14,8 20,8"/>
                                        <line x1="16" y1="13" x2="8" y2="13"/>
                                        <line x1="16" y1="17" x2="8" y2="17"/>
                                        <polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" points="10,9 9,9 8,9"/>
                                    </svg>
                                    <?php _e('Blog', 'focal-wp'); ?>
                                </a>
                            </h4>
                            <p><?php _e('Leia nossos artigos e novidades', 'focal-wp'); ?></p>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Contato -->
                        <?php $contact_page = get_page_by_path('contato'); ?>
                        <?php if ($contact_page) : ?>
                        <div class="error-404__link-item">
                            <h4 class="h6">
                                <a href="<?php echo esc_url(get_permalink($contact_page)); ?>">
                                    <svg viewBox="0 0 24 24" width="20" height="20">
                                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                    </svg>
                                    <?php _e('Contato', 'focal-wp'); ?>
                                </a>
                            </h4>
                            <p><?php _e('Entre em contato conosco', 'focal-wp'); ?></p>
                        </div>
                        <?php endif; ?>
                        
                    </div>
                </div>
                
                <!-- Categorias populares (se WooCommerce estiver ativo) -->
                <?php if (class_exists('WooCommerce')) : ?>
                <?php
                $product_categories = get_terms('product_cat', array(
                    'number' => 6,
                    'hide_empty' => true,
                    'orderby' => 'count',
                    'order' => 'DESC',
                ));
                
                if ($product_categories && !is_wp_error($product_categories)) :
                ?>
                <div class="error-404__categories">
                    <h3 class="h5"><?php _e('Categorias populares:', 'focal-wp'); ?></h3>
                    
                    <div class="category-grid">
                        <?php foreach ($product_categories as $category) : ?>
                        <a href="<?php echo esc_url(get_term_link($category)); ?>" class="category-item">
                            <?php echo esc_html($category->name); ?>
                            <span class="category-count">(<?php echo $category->count; ?>)</span>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
                <?php endif; ?>
                
                <!-- Botão voltar -->
                <div class="error-404__back">
                    <button onclick="history.back()" class="button button--secondary">
                        <svg viewBox="0 0 24 24" width="16" height="16">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 18-6-6 6-6"/>
                        </svg>
                        <?php _e('Voltar à página anterior', 'focal-wp'); ?>
                    </button>
                </div>
                
            </div>
            
        </div>
        
    </div>
</div>

<style>
.error-404 {
    text-align: center;
    max-width: 800px;
    margin: 0 auto;
}

.error-404__icon {
    margin-bottom: 30px;
    opacity: 0.6;
}

.error-404__title {
    font-size: 120px;
    font-weight: bold;
    margin-bottom: 20px;
    opacity: 0.8;
}

.error-404__subtitle {
    margin-bottom: 20px;
}

.error-404__search {
    margin: 40px 0;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
}

.error-404__link-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    margin-top: 30px;
}

.error-404__link-item {
    text-align: left;
    padding: 20px;
    border: 1px solid rgb(var(--border-color));
    border-radius: 8px;
}

.error-404__link-item h4 a {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    margin-bottom: 10px;
}

.error-404__categories {
    margin: 40px 0;
}

.category-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    justify-content: center;
    margin-top: 20px;
}

.category-item {
    padding: 8px 16px;
    background: rgb(var(--border-color));
    border-radius: 20px;
    text-decoration: none;
    font-size: 14px;
    transition: all 0.2s;
}

.category-item:hover {
    background: rgb(var(--accent-color));
    color: white;
}

.category-count {
    opacity: 0.7;
    font-size: 12px;
}

.error-404__back {
    margin-top: 40px;
}

@media (max-width: 740px) {
    .error-404__title {
        font-size: 80px;
    }
    
    .error-404__link-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php get_footer(); ?>