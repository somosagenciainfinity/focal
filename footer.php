<?php
/**
 * Footer do tema
 * 
 * Convertido do sections/footer.liquid do Shopify Focal
 * 
 * @package Focal_WordPress
 */
?>

<footer class="footer" role="contentinfo">
    <div class="container">
        
        <!-- Footer widgets - Convertido das seções do Shopify -->
        <?php if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') || is_active_sidebar('footer-4')) : ?>
        <div class="footer__widgets">
            <div class="footer__widgets-grid">
                
                <?php for ($i = 1; $i <= 4; $i++) : ?>
                    <?php if (is_active_sidebar('footer-' . $i)) : ?>
                    <div class="footer__widget-column">
                        <?php dynamic_sidebar('footer-' . $i); ?>
                    </div>
                    <?php endif; ?>
                <?php endfor; ?>
                
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Footer bottom -->
        <div class="footer__bottom">
            <div class="footer__bottom-content">
                
                <!-- Copyright -->
                <div class="footer__copyright">
                    <p>&copy; <?php echo date('Y'); ?> <a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>. <?php _e('Todos os direitos reservados.', 'focal-wp'); ?></p>
                </div>
                
                <!-- Menu do footer -->
                <?php if (has_nav_menu('footer')) : ?>
                <nav class="footer__navigation" role="navigation" aria-label="<?php esc_attr_e('Menu do rodapé', 'focal-wp'); ?>">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'menu_class'     => 'footer__menu',
                        'container'      => false,
                        'depth'          => 1,
                    ));
                    ?>
                </nav>
                <?php endif; ?>
                
                <!-- Links de política/termos -->
                <div class="footer__legal-links">
                    <?php
                    $privacy_page = get_option('wp_page_for_privacy_policy');
                    if ($privacy_page) :
                    ?>
                    <a href="<?php echo esc_url(get_permalink($privacy_page)); ?>" class="footer__legal-link">
                        <?php _e('Política de Privacidade', 'focal-wp'); ?>
                    </a>
                    <?php endif; ?>
                    
                    <?php
                    $terms_page = get_page_by_path('termos-de-uso');
                    if ($terms_page) :
                    ?>
                    <a href="<?php echo esc_url(get_permalink($terms_page)); ?>" class="footer__legal-link">
                        <?php _e('Termos de Uso', 'focal-wp'); ?>
                    </a>
                    <?php endif; ?>
                </div>
                
                <!-- Métodos de pagamento -->
                <?php if (class_exists('WooCommerce')) : ?>
                <div class="footer__payment-methods">
                    <div class="payment-methods">
                        <!-- Ícones dos métodos de pagamento podem ser adicionados aqui -->
                        <div class="payment-methods__title">
                            <small><?php _e('Formas de pagamento', 'focal-wp'); ?></small>
                        </div>
                        <div class="payment-methods__icons">
                            <!-- Adicionar ícones específicos conforme necessário -->
                            <img src="<?php echo FOCAL_THEME_URI; ?>/assets/images/payment-visa.svg" alt="Visa" class="payment-icon">
                            <img src="<?php echo FOCAL_THEME_URI; ?>/assets/images/payment-mastercard.svg" alt="Mastercard" class="payment-icon">
                            <img src="<?php echo FOCAL_THEME_URI; ?>/assets/images/payment-pix.svg" alt="PIX" class="payment-icon">
                            <img src="<?php echo FOCAL_THEME_URI; ?>/assets/images/payment-boleto.svg" alt="Boleto" class="payment-icon">
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Selos de segurança -->
                <div class="footer__security-badges">
                    <!-- Adicionar selos de segurança conforme necessário -->
                </div>
                
            </div>
        </div>
        
    </div>
</footer>

<!-- Back to top button -->
<button id="back-to-top" class="back-to-top" aria-label="<?php esc_attr_e('Voltar ao topo', 'focal-wp'); ?>" style="display: none;">
    <svg viewBox="0 0 24 24" width="20" height="20">
        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m18 15-6-6-6 6"></path>
    </svg>
</button>

<?php
// Mini cart drawer para WooCommerce
if (class_exists('WooCommerce') && !is_cart() && !is_checkout()) {
    get_template_part('template-parts/woocommerce/mini-cart');
}
?>

<!-- Script para funcionalidades do tema -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Back to top functionality
    const backToTopBtn = document.getElementById('back-to-top');
    
    if (backToTopBtn) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopBtn.style.display = 'block';
            } else {
                backToTopBtn.style.display = 'none';
            }
        });
        
        backToTopBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
    
    // Mobile menu toggle
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const mobileMenu = document.querySelector('#mobile-menu-drawer');
    
    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !isExpanded);
            mobileMenu.classList.toggle('active');
            document.body.classList.toggle('menu-open');
        });
    }
    
    // Search drawer toggle
    const searchToggleButtons = document.querySelectorAll('.search-toggle');
    const searchDrawer = document.querySelector('#search-drawer');
    
    searchToggleButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            if (searchDrawer) {
                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                this.setAttribute('aria-expanded', !isExpanded);
                searchDrawer.classList.toggle('active');
                
                if (!isExpanded) {
                    const searchInput = searchDrawer.querySelector('input[type="text"]');
                    if (searchInput) {
                        searchInput.focus();
                    }
                }
            }
        });
    });
    
    // Cart toggle (se necessário)
    <?php if (class_exists('WooCommerce')) : ?>
    const cartToggleButtons = document.querySelectorAll('.cart-toggle');
    const miniCart = document.querySelector('#mini-cart-drawer');
    
    cartToggleButtons.forEach(function(button) {
        if (button.getAttribute('href') === '<?php echo esc_js(wc_get_cart_url()); ?>') {
            return; // Permitir navegação normal para página do carrinho
        }
        
        button.addEventListener('click', function(e) {
            e.preventDefault();
            if (miniCart) {
                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                this.setAttribute('aria-expanded', !isExpanded);
                miniCart.classList.toggle('active');
            }
        });
    });
    
    // Atualizar contador do carrinho
    function updateCartCount() {
        fetch('<?php echo esc_js(wc_get_endpoint_url('view-cart', '', wc_get_cart_url())); ?>')
            .then(response => response.json())
            .then(data => {
                const cartCounts = document.querySelectorAll('.header__cart-count');
                cartCounts.forEach(count => {
                    count.textContent = data.cart_count || '0';
                });
            })
            .catch(error => console.error('Erro ao atualizar carrinho:', error));
    }
    
    // Listener para eventos de carrinho
    document.body.addEventListener('added_to_cart', updateCartCount);
    document.body.addEventListener('removed_from_cart', updateCartCount);
    <?php endif; ?>
});
</script>

<?php wp_footer(); ?>

</body>
</html>