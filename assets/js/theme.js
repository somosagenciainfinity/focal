/**
 * Focal WordPress Theme JavaScript
 * 
 * Funcionalidades principais convertidas do tema Shopify Focal
 * 
 * @package Focal_WordPress
 * @version 1.0.0
 */

(function($) {
    'use strict';

    // Variáveis globais
    var $window = $(window);
    var $document = $(document);
    var $body = $('body');

    /**
     * Inicializar tema
     */
    function initTheme() {
        initMobileMenu();
        initSearchDrawer();
        initStickyHeader();
        initBackToTop();
        initProductSearch();
        initCartFunctionality();
        initKeyboardNavigation();
        initLazyLoading();
    }

    /**
     * Menu Mobile
     */
    function initMobileMenu() {
        var $mobileToggle = $('.mobile-menu-toggle');
        var $mobileDrawer = $('.mobile-menu-drawer');
        var $mobileClose = $('.mobile-menu-drawer__close');
        var $mobileOverlay = $('.mobile-menu-drawer__overlay');

        // Abrir menu mobile
        $mobileToggle.on('click', function(e) {
            e.preventDefault();
            openMobileMenu();
        });

        // Fechar menu mobile
        $mobileClose.add($mobileOverlay).on('click', function(e) {
            e.preventDefault();
            closeMobileMenu();
        });

        // Submenu toggle
        $('.submenu-toggle').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            var $this = $(this);
            var $submenu = $this.next('.mobile-submenu');
            var isExpanded = $this.attr('aria-expanded') === 'true';
            
            $this.attr('aria-expanded', !isExpanded);
            $submenu.slideToggle(300);
        });

        function openMobileMenu() {
            $mobileDrawer.addClass('active');
            $body.addClass('menu-open lock-mobile');
            $mobileToggle.attr('aria-expanded', 'true');
        }

        function closeMobileMenu() {
            $mobileDrawer.removeClass('active');
            $body.removeClass('menu-open lock-mobile');
            $mobileToggle.attr('aria-expanded', 'false');
        }

        // Fechar com ESC
        $document.on('keydown', function(e) {
            if (e.key === 'Escape' && $mobileDrawer.hasClass('active')) {
                closeMobileMenu();
            }
        });
    }

    /**
     * Search Drawer
     */
    function initSearchDrawer() {
        var $searchToggle = $('.search-toggle');
        var $searchDrawer = $('.search-drawer');
        var $searchClose = $('.search-drawer__close');
        var $searchOverlay = $('.search-drawer__overlay');
        var $searchInput = $('.search-drawer__input');

        // Abrir busca
        $searchToggle.on('click', function(e) {
            e.preventDefault();
            openSearchDrawer();
        });

        // Fechar busca
        $searchClose.add($searchOverlay).on('click', function(e) {
            e.preventDefault();
            closeSearchDrawer();
        });

        function openSearchDrawer() {
            $searchDrawer.addClass('active');
            $body.addClass('search-open');
            $searchToggle.attr('aria-expanded', 'true');
            
            // Focar no input após animação
            setTimeout(function() {
                $searchInput.focus();
            }, 300);
        }

        function closeSearchDrawer() {
            $searchDrawer.removeClass('active');
            $body.removeClass('search-open');
            $searchToggle.attr('aria-expanded', 'false');
        }

        // Fechar com ESC
        $document.on('keydown', function(e) {
            if (e.key === 'Escape' && $searchDrawer.hasClass('active')) {
                closeSearchDrawer();
            }
        });
    }

    /**
     * Header Sticky
     */
    function initStickyHeader() {
        var $header = $('.header--sticky');
        var headerOffset = 0;
        var isSticky = false;

        if (!$header.length) return;

        headerOffset = $header.offset().top;

        $window.on('scroll', function() {
            var scrollTop = $window.scrollTop();
            
            if (scrollTop > headerOffset && !isSticky) {
                $header.addClass('is-sticky');
                isSticky = true;
            } else if (scrollTop <= headerOffset && isSticky) {
                $header.removeClass('is-sticky');
                isSticky = false;
            }
        });
    }

    /**
     * Back to Top
     */
    function initBackToTop() {
        var $backToTop = $('.back-to-top');
        
        if (!$backToTop.length) return;

        $window.on('scroll', function() {
            if ($window.scrollTop() > 300) {
                $backToTop.fadeIn();
            } else {
                $backToTop.fadeOut();
            }
        });

        $backToTop.on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: 0
            }, 800);
        });
    }

    /**
     * Busca de Produtos (AJAX)
     */
    function initProductSearch() {
        var $searchInput = $('.predictive-search__input');
        var $resultsContainer = $('#search-results-list');
        var $loadingState = $('#search-loading');
        var $emptyState = $('#search-empty');
        var $quickLinks = $('#search-quick-links');
        
        var searchTimeout;
        var currentRequest;

        if (!$searchInput.length || typeof focal_vars === 'undefined') return;

        $searchInput.on('input', function() {
            var query = $(this).val().trim();
            
            clearTimeout(searchTimeout);
            
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

            searchTimeout = setTimeout(function() {
                performSearch(query);
            }, 300);
        });

        function showQuickLinks() {
            $resultsContainer.hide();
            $loadingState.hide();
            $emptyState.hide();
            $quickLinks.show();
        }

        function showLoading() {
            $resultsContainer.hide();
            $emptyState.hide();
            $quickLinks.hide();
            $loadingState.show();
        }

        function showEmpty() {
            $resultsContainer.hide();
            $loadingState.hide();
            $quickLinks.hide();
            $emptyState.show();
        }

        function showResults(html) {
            $loadingState.hide();
            $emptyState.hide();
            $quickLinks.hide();
            $resultsContainer.html(html).show();
        }

        function performSearch(query) {
            showLoading();

            currentRequest = $.ajax({
                url: focal_vars.ajax_url,
                type: 'POST',
                data: {
                    action: 'focal_search_products',
                    nonce: focal_vars.nonce,
                    s: query
                },
                success: function(response) {
                    if (response.success && response.data.html) {
                        showResults(response.data.html);
                    } else {
                        showEmpty();
                    }
                },
                error: function() {
                    showEmpty();
                },
                complete: function() {
                    currentRequest = null;
                }
            });
        }
    }

    /**
     * Funcionalidades do Carrinho
     */
    function initCartFunctionality() {
        if (typeof wc_add_to_cart_params === 'undefined') return;

        // Atualizar contador do carrinho após adicionar produto
        $document.on('added_to_cart', function(event, fragments, cart_hash, $button) {
            updateCartCount();
            showCartNotification($button);
        });

        // Remover do carrinho
        $document.on('click', '.remove-from-cart', function(e) {
            e.preventDefault();
            // Implementar lógica de remoção
        });

        function updateCartCount() {
            $.ajax({
                url: wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'get_refreshed_fragments'),
                type: 'POST',
                success: function(data) {
                    if (data && data.fragments) {
                        $.each(data.fragments, function(key, value) {
                            $(key).replaceWith(value);
                        });
                    }
                }
            });
        }

        function showCartNotification($button) {
            var $notification = $('.cart-notification');
            var productName = $button.closest('.product-item, .single-product').find('.product-title, .product_title').text();
            
            $notification.find('.cart-notification__message').text(
                focal_vars.strings.add_to_cart_message.replace('%s', productName)
            );
            
            $notification.addClass('active');
            
            setTimeout(function() {
                $notification.removeClass('active');
            }, 3000);
        }
    }

    /**
     * Navegação por Teclado
     */
    function initKeyboardNavigation() {
        // Focar com Tab apenas quando necessário
        $body.on('keydown', function(e) {
            if (e.key === 'Tab') {
                $body.removeClass('no-focus-outline');
            }
        });

        $body.on('mousedown', function() {
            $body.addClass('no-focus-outline');
        });

        // Navegação por setas no menu
        $('.header__navigation-list').on('keydown', 'a', function(e) {
            var $this = $(this);
            var $items = $this.closest('ul').find('a');
            var currentIndex = $items.index($this);
            
            if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
                e.preventDefault();
                var nextIndex = (currentIndex + 1) % $items.length;
                $items.eq(nextIndex).focus();
            } else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
                e.preventDefault();
                var prevIndex = currentIndex === 0 ? $items.length - 1 : currentIndex - 1;
                $items.eq(prevIndex).focus();
            }
        });
    }

    /**
     * Lazy Loading para Imagens
     */
    function initLazyLoading() {
        if (!('IntersectionObserver' in window)) return;

        var imageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    var img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    img.classList.add('loaded');
                    imageObserver.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(function(img) {
            imageObserver.observe(img);
        });
    }

    /**
     * Utilitários
     */
    function debounce(func, wait, immediate) {
        var timeout;
        return function() {
            var context = this;
            var args = arguments;
            var later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }

    /**
     * Inicialização
     */
    $document.ready(function() {
        initTheme();
    });

    // Redimensionamento de janela
    $window.on('resize', debounce(function() {
        // Atualizar altura do header
        document.documentElement.style.setProperty('--header-height', 
            document.querySelector('.header').offsetHeight + 'px');
    }, 250));

    // Expor funções globalmente se necessário
    window.FocalTheme = {
        init: initTheme,
        mobileMenu: {
            open: function() { $('.mobile-menu-toggle').trigger('click'); },
            close: function() { $('.mobile-menu-drawer__close').trigger('click'); }
        },
        search: {
            open: function() { $('.search-toggle').trigger('click'); },
            close: function() { $('.search-drawer__close').trigger('click'); }
        }
    };

})(jQuery);