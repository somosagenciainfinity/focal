<?php
/**
 * Mobile Menu Drawer
 * 
 * Convertido do snippet/mobile-menu.liquid do Shopify Focal
 * 
 * @package Focal_WordPress
 */

// Obter menu para mobile (usar menu específico ou menu principal)
$mobile_menu_location = has_nav_menu('mobile') ? 'mobile' : 'primary';
$menu_exists = has_nav_menu($mobile_menu_location);

if (!$menu_exists) {
    return;
}
?>

<div id="mobile-menu-drawer" class="mobile-menu-drawer" role="dialog" aria-label="<?php esc_attr_e('Menu de navegação', 'focal-wp'); ?>">
    
    <!-- Overlay -->
    <div class="mobile-menu-drawer__overlay"></div>
    
    <!-- Content -->
    <div class="mobile-menu-drawer__content">
        
        <!-- Header -->
        <div class="mobile-menu-drawer__header">
            <h2 class="mobile-menu-drawer__title"><?php _e('Menu', 'focal-wp'); ?></h2>
            <button type="button" class="mobile-menu-drawer__close tap-area" aria-label="<?php esc_attr_e('Fechar menu', 'focal-wp'); ?>">
                <?php focal_render_icon('close', 18, 18); ?>
            </button>
        </div>
        
        <!-- Navigation -->
        <nav class="mobile-menu-drawer__navigation" role="navigation">
            <?php
            wp_nav_menu(array(
                'theme_location' => $mobile_menu_location,
                'menu_class'     => 'mobile-menu-list',
                'container'      => false,
                'walker'         => new Focal_Mobile_Menu_Walker(),
            ));
            ?>
        </nav>
        
        <!-- Footer links -->
        <div class="mobile-menu-drawer__footer">
            
            <!-- Busca -->
            <div class="mobile-menu-search">
                <form class="mobile-menu-search__form" action="<?php echo esc_url(home_url('/')); ?>" method="get" role="search">
                    <input type="text" name="s" class="mobile-menu-search__input" 
                           placeholder="<?php esc_attr_e('Buscar...', 'focal-wp'); ?>" 
                           value="<?php echo get_search_query(); ?>">
                    <button type="submit" class="mobile-menu-search__button">
                        <?php focal_render_icon('header-search', 16, 16); ?>
                    </button>
                    <?php if (class_exists('WooCommerce')) : ?>
                    <input type="hidden" name="post_type" value="product">
                    <?php endif; ?>
                </form>
            </div>
            
            <!-- Links úteis -->
            <div class="mobile-menu-links">
                
                <?php if (class_exists('WooCommerce')) : ?>
                <!-- Minha conta -->
                <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="mobile-menu-link">
                    <svg viewBox="0 0 24 24" width="18" height="18">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2M12 3a4 4 0 1 0 0 8 4 4 0 0 0 0-8z"></path>
                    </svg>
                    <span><?php _e('Minha Conta', 'focal-wp'); ?></span>
                </a>
                
                <!-- Lista de desejos (se plugin estiver ativo) -->
                <?php if (function_exists('YITH_WCWL')) : ?>
                <a href="<?php echo esc_url(YITH_WCWL()->get_wishlist_url()); ?>" class="mobile-menu-link">
                    <svg viewBox="0 0 24 24" width="18" height="18">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                    <span><?php _e('Lista de Desejos', 'focal-wp'); ?></span>
                </a>
                <?php endif; ?>
                <?php endif; ?>
                
                <!-- Rastreamento -->
                <?php if (get_page_by_path('rastreio')) : ?>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('rastreio'))); ?>" class="mobile-menu-link">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M12 2C8.13 2 5 5.13 5 9C5 14.25 12 22 12 22S19 14.25 19 9C19 5.13 15.87 2 12 2Z" stroke="currentColor" stroke-width="2" fill="none"/>
                        <circle cx="12" cy="9" r="2.5" stroke="currentColor" stroke-width="2" fill="none"/>
                    </svg>
                    <span><?php _e('Rastrear Pedido', 'focal-wp'); ?></span>
                </a>
                <?php endif; ?>
                
                <!-- Contato -->
                <?php if (get_page_by_path('contato')) : ?>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('contato'))); ?>" class="mobile-menu-link">
                    <svg viewBox="0 0 24 24" width="18" height="18">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                    <span><?php _e('Contato', 'focal-wp'); ?></span>
                </a>
                <?php endif; ?>
                
            </div>
            
            <!-- Informações da loja -->
            <div class="mobile-menu-info">
                <div class="site-info">
                    <h3><?php bloginfo('name'); ?></h3>
                    <?php if (get_bloginfo('description')) : ?>
                    <p><?php bloginfo('description'); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            
        </div>
        
    </div>
    
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuDrawer = document.getElementById('mobile-menu-drawer');
    const closeButton = mobileMenuDrawer ? mobileMenuDrawer.querySelector('.mobile-menu-drawer__close') : null;
    const overlay = mobileMenuDrawer ? mobileMenuDrawer.querySelector('.mobile-menu-drawer__overlay') : null;
    
    // Fechar menu
    function closeMobileMenu() {
        if (mobileMenuDrawer) {
            mobileMenuDrawer.classList.remove('active');
            document.body.classList.remove('menu-open');
            
            // Resetar estado do botão toggle
            const toggleButton = document.querySelector('.mobile-menu-toggle');
            if (toggleButton) {
                toggleButton.setAttribute('aria-expanded', 'false');
            }
        }
    }
    
    // Event listeners para fechar menu
    if (closeButton) {
        closeButton.addEventListener('click', closeMobileMenu);
    }
    
    if (overlay) {
        overlay.addEventListener('click', closeMobileMenu);
    }
    
    // Fechar com ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileMenuDrawer && mobileMenuDrawer.classList.contains('active')) {
            closeMobileMenu();
        }
    });
    
    // Submenu toggle para menus com dropdown
    const submenuToggles = mobileMenuDrawer ? mobileMenuDrawer.querySelectorAll('.submenu-toggle') : [];
    
    submenuToggles.forEach(function(toggle) {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const submenu = this.nextElementSibling;
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            
            this.setAttribute('aria-expanded', !isExpanded);
            
            if (submenu) {
                submenu.style.display = isExpanded ? 'none' : 'block';
            }
        });
    });
});
</script>