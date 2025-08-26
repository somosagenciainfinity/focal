<?php
/**
 * Search Drawer
 * 
 * Convertido do snippet/predictive-search.liquid do Shopify Focal
 * 
 * @package Focal_WordPress
 */
?>

<div id="search-drawer" class="search-drawer" role="dialog" aria-label="<?php esc_attr_e('Busca', 'focal-wp'); ?>">
    
    <!-- Overlay -->
    <div class="search-drawer__overlay"></div>
    
    <!-- Content -->
    <div class="search-drawer__content">
        
        <!-- Header com formulário de busca -->
        <div class="search-drawer__header">
            <form class="search-drawer__form predictive-search__form" action="<?php echo esc_url(home_url('/')); ?>" method="get" role="search">
                <div class="search-drawer__input-wrapper">
                    <?php focal_render_icon('header-search', 18, 18); ?>
                    <input type="text" name="s" class="search-drawer__input predictive-search__input" 
                           placeholder="<?php esc_attr_e('Buscar produtos...', 'focal-wp'); ?>"
                           value="<?php echo get_search_query(); ?>"
                           autocomplete="off" autocorrect="off">
                    <?php if (class_exists('WooCommerce')) : ?>
                    <input type="hidden" name="post_type" value="product">
                    <?php endif; ?>
                </div>
                
                <button type="button" class="search-drawer__close tap-area" aria-label="<?php esc_attr_e('Fechar busca', 'focal-wp'); ?>">
                    <?php focal_render_icon('close', 18, 18); ?>
                </button>
            </form>
        </div>
        
        <!-- Resultados da busca -->
        <div class="search-drawer__results predictive-search__results" id="search-results">
            
            <!-- Loading state -->
            <div class="search-drawer__loading" id="search-loading" style="display: none;">
                <div class="loading-spinner">
                    <div class="spinner"></div>
                </div>
                <p><?php _e('Buscando...', 'focal-wp'); ?></p>
            </div>
            
            <!-- Empty state -->
            <div class="search-drawer__empty" id="search-empty" style="display: none;">
                <div class="search-empty-state">
                    <svg viewBox="0 0 24 24" width="48" height="48" class="search-empty-icon">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-6-6m2-5a7 7 0 1 1-14 0 7 7 0 0 1 14 0z"></path>
                    </svg>
                    <h3><?php _e('Nenhum resultado encontrado', 'focal-wp'); ?></h3>
                    <p><?php _e('Tente usar termos diferentes ou verifique a ortografia.', 'focal-wp'); ?></p>
                </div>
            </div>
            
            <!-- Results container -->
            <div class="search-drawer__results-list" id="search-results-list">
                <!-- Results will be inserted here via JavaScript -->
            </div>
            
            <!-- Quick links quando não há busca -->
            <div class="search-drawer__quick-links" id="search-quick-links">
                <h3><?php _e('Links rápidos', 'focal-wp'); ?></h3>
                
                <?php
                // Menu de links rápidos (se configurado)
                if (has_nav_menu('search-menu')) {
                    wp_nav_menu(array(
                        'theme_location' => 'search-menu',
                        'menu_class'     => 'search-quick-menu',
                        'container'      => false,
                        'depth'          => 1,
                    ));
                } else {
                    // Links padrão
                    ?>
                    <ul class="search-quick-menu">
                        <?php if (class_exists('WooCommerce')) : ?>
                        <li><a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>"><?php _e('Todos os Produtos', 'focal-wp'); ?></a></li>
                        <?php 
                        // Categorias populares
                        $product_categories = get_terms('product_cat', array(
                            'number' => 5,
                            'hide_empty' => true,
                            'orderby' => 'count',
                            'order' => 'DESC'
                        ));
                        
                        if ($product_categories && !is_wp_error($product_categories)) {
                            foreach ($product_categories as $category) {
                                echo '<li><a href="' . esc_url(get_term_link($category)) . '">' . esc_html($category->name) . '</a></li>';
                            }
                        }
                        ?>
                        <?php endif; ?>
                        
                        <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('contato'))); ?>"><?php _e('Contato', 'focal-wp'); ?></a></li>
                        <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('sobre'))); ?>"><?php _e('Sobre Nós', 'focal-wp'); ?></a></li>
                    </ul>
                    <?php
                }
                ?>
            </div>
            
        </div>
        
    </div>
    
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchDrawer = document.getElementById('search-drawer');
    const searchInput = searchDrawer ? searchDrawer.querySelector('.search-drawer__input') : null;
    const closeButton = searchDrawer ? searchDrawer.querySelector('.search-drawer__close') : null;
    const overlay = searchDrawer ? searchDrawer.querySelector('.search-drawer__overlay') : null;
    const resultsContainer = document.getElementById('search-results-list');
    const loadingState = document.getElementById('search-loading');
    const emptyState = document.getElementById('search-empty');
    const quickLinks = document.getElementById('search-quick-links');
    
    let searchTimeout;
    let currentRequest = null;
    
    // Fechar busca
    function closeSearch() {
        if (searchDrawer) {
            searchDrawer.classList.remove('active');
            
            // Resetar estado dos botões toggle
            const searchToggleButtons = document.querySelectorAll('.search-toggle');
            searchToggleButtons.forEach(function(button) {
                button.setAttribute('aria-expanded', 'false');
            });
        }
    }
    
    // Event listeners para fechar
    if (closeButton) {
        closeButton.addEventListener('click', closeSearch);
    }
    
    if (overlay) {
        overlay.addEventListener('click', closeSearch);
    }
    
    // Fechar com ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && searchDrawer && searchDrawer.classList.contains('active')) {
            closeSearch();
        }
    });
    
    // Busca em tempo real (se WooCommerce estiver ativo)
    <?php if (class_exists('WooCommerce')) : ?>
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            
            // Limpar timeout anterior
            clearTimeout(searchTimeout);
            
            // Cancelar requisição anterior
            if (currentRequest) {
                currentRequest.abort();
            }
            
            if (query.length === 0) {
                showQuickLinks();
                return;
            }
            
            if (query.length < 2) {
                return;
            }
            
            // Delay para evitar muitas requisições
            searchTimeout = setTimeout(function() {
                performSearch(query);
            }, 300);
        });
    }
    
    function showQuickLinks() {
        if (resultsContainer) resultsContainer.innerHTML = '';
        if (loadingState) loadingState.style.display = 'none';
        if (emptyState) emptyState.style.display = 'none';
        if (quickLinks) quickLinks.style.display = 'block';
    }
    
    function showLoading() {
        if (resultsContainer) resultsContainer.innerHTML = '';
        if (emptyState) emptyState.style.display = 'none';
        if (quickLinks) quickLinks.style.display = 'none';
        if (loadingState) loadingState.style.display = 'block';
    }
    
    function showEmpty() {
        if (resultsContainer) resultsContainer.innerHTML = '';
        if (loadingState) loadingState.style.display = 'none';
        if (quickLinks) quickLinks.style.display = 'none';
        if (emptyState) emptyState.style.display = 'block';
    }
    
    function showResults(html) {
        if (loadingState) loadingState.style.display = 'none';
        if (emptyState) emptyState.style.display = 'none';
        if (quickLinks) quickLinks.style.display = 'none';
        if (resultsContainer) {
            resultsContainer.style.display = 'block';
            resultsContainer.innerHTML = html;
        }
    }
    
    function performSearch(query) {
        showLoading();
        
        const formData = new FormData();
        formData.append('action', 'focal_search_products');
        formData.append('nonce', '<?php echo wp_create_nonce("focal_search_nonce"); ?>');
        formData.append('s', query);
        
        currentRequest = new XMLHttpRequest();
        currentRequest.open('POST', '<?php echo admin_url("admin-ajax.php"); ?>');
        
        currentRequest.onload = function() {
            if (currentRequest.status === 200) {
                try {
                    const response = JSON.parse(currentRequest.responseText);
                    if (response.success && response.data.html) {
                        showResults(response.data.html);
                    } else {
                        showEmpty();
                    }
                } catch (e) {
                    showEmpty();
                }
            } else {
                showEmpty();
            }
            currentRequest = null;
        };
        
        currentRequest.onerror = function() {
            showEmpty();
            currentRequest = null;
        };
        
        currentRequest.send(formData);
    }
    <?php else : ?>
    // Sem WooCommerce, apenas mostrar quick links
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            if (query.length === 0) {
                showQuickLinks();
            }
        });
    }
    
    function showQuickLinks() {
        if (quickLinks) quickLinks.style.display = 'block';
    }
    <?php endif; ?>
});
</script>