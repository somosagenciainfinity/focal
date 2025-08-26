<?php
/**
 * Funções auxiliares para templates
 * 
 * @package Focal_WordPress
 */

// Previne acesso direto
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Converter cor hex para RGB
 * 
 * @param string $hex Cor em hexadecimal
 * @return string RGB values separated by commas
 */
function focal_hex_to_rgb($hex) {
    $hex = ltrim($hex, '#');
    
    if (strlen($hex) === 3) {
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }
    
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    
    return "$r, $g, $b";
}

/**
 * Misturar duas cores
 * 
 * @param string $color1 Primeira cor em hex
 * @param string $color2 Segunda cor em hex 
 * @param int $percentage Porcentagem de mistura
 * @return string Cor resultante em hex
 */
function focal_mix_colors($color1, $color2, $percentage) {
    $color1 = ltrim($color1, '#');
    $color2 = ltrim($color2, '#');
    
    if (strlen($color1) === 3) {
        $color1 = $color1[0] . $color1[0] . $color1[1] . $color1[1] . $color1[2] . $color1[2];
    }
    if (strlen($color2) === 3) {
        $color2 = $color2[0] . $color2[0] . $color2[1] . $color2[1] . $color2[2] . $color2[2];
    }
    
    $r1 = hexdec(substr($color1, 0, 2));
    $g1 = hexdec(substr($color1, 2, 2));
    $b1 = hexdec(substr($color1, 4, 2));
    
    $r2 = hexdec(substr($color2, 0, 2));
    $g2 = hexdec(substr($color2, 2, 2));
    $b2 = hexdec(substr($color2, 4, 2));
    
    $r = round($r1 + ($r2 - $r1) * ($percentage / 100));
    $g = round($g1 + ($g2 - $g1) * ($percentage / 100));
    $b = round($b1 + ($b2 - $b1) * ($percentage / 100));
    
    return sprintf("#%02x%02x%02x", $r, $g, $b);
}

/**
 * Obter ícone SVG
 * 
 * Convertido do snippet/icon.liquid do Shopify
 * 
 * @param string $icon_name Nome do ícone
 * @param int $width Largura do ícone
 * @param int $height Altura do ícone
 * @return string HTML do ícone SVG
 */
function focal_get_icon($icon_name, $width = 18, $height = 18) {
    $icons = array(
        'header-hamburger' => '<svg viewBox="0 0 24 24" width="' . $width . '" height="' . $height . '"><rect x="3" y="6" width="18" height="2"></rect><rect x="3" y="12" width="18" height="2"></rect><rect x="3" y="18" width="18" height="2"></rect></svg>',
        
        'header-search' => '<svg viewBox="0 0 24 24" width="' . $width . '" height="' . $height . '"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-6-6m2-5a7 7 0 1 1-14 0 7 7 0 0 1 14 0z"></path></svg>',
        
        'header-cart' => '<svg viewBox="0 0 24 24" width="' . $width . '" height="' . $height . '"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 7h14l-1 8H6L5 7Zm0 0L3 3h2m0 4 2 8m11-8v11a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V7"></path></svg>',
        
        'header-shopping-cart' => '<svg viewBox="0 0 24 24" width="' . $width . '" height="' . $height . '"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>',
        
        'header-tote-bag' => '<svg viewBox="0 0 24 24" width="' . $width . '" height="' . $height . '"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7h-3V6a4 4 0 0 0-8 0v1H5a1 1 0 0 0-1 1v11a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V8a1 1 0 0 0-1-1ZM10 6a2 2 0 0 1 4 0v1h-4V6Z"></path></svg>',
        
        'chevron' => '<svg viewBox="0 0 12 8" width="' . $width . '" height="' . $height . '"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="m1 1 5 5 5-5"></path></svg>',
        
        'close' => '<svg viewBox="0 0 24 24" width="' . $width . '" height="' . $height . '"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 6 6 18M6 6l12 12"></path></svg>',
        
        'arrow-left' => '<svg viewBox="0 0 24 24" width="' . $width . '" height="' . $height . '"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 18-6-6 6-6"></path></svg>',
        
        'arrow-right' => '<svg viewBox="0 0 24 24" width="' . $width . '" height="' . $height . '"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 18 6-6-6-6"></path></svg>',
        
        'filters' => '<svg viewBox="0 0 24 24" width="' . $width . '" height="' . $height . '"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M7 12h10m-7 6h4"></path></svg>',
        
        'star' => '<svg viewBox="0 0 24 24" width="' . $width . '" height="' . $height . '"><polygon fill="currentColor" points="12,2 15,9 22,9 17,14 19,21 12,17 5,21 7,14 2,9 9,9"></polygon></svg>',
        
        'star-outline' => '<svg viewBox="0 0 24 24" width="' . $width . '" height="' . $height . '"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>',
    );
    
    return isset($icons[$icon_name]) ? $icons[$icon_name] : '';
}

/**
 * Renderizar ícone SVG
 * 
 * @param string $icon_name Nome do ícone
 * @param int $width Largura do ícone
 * @param int $height Altura do ícone
 */
function focal_render_icon($icon_name, $width = 18, $height = 18) {
    echo focal_get_icon($icon_name, $width, $height);
}

/**
 * Obter atributos de imagem para responsividade
 * Convertido do snippet/image-attributes.liquid
 * 
 * @param int $image_id ID da imagem
 * @param array $sizes Array de tamanhos
 * @return string Atributos HTML da imagem
 */
function focal_get_image_attributes($image_id, $sizes = array()) {
    if (empty($sizes)) {
        $sizes = array(400, 500, 600, 700, 800, 900, 1000, 1100, 1200);
    }
    
    $srcset = array();
    
    foreach ($sizes as $size) {
        $img = wp_get_attachment_image_src($image_id, array($size, $size));
        if ($img) {
            $srcset[] = $img[0] . ' ' . $size . 'w';
        }
    }
    
    return !empty($srcset) ? 'srcset="' . implode(', ', $srcset) . '"' : '';
}

/**
 * Obter breadcrumbs
 */
function focal_breadcrumbs() {
    if (is_front_page()) {
        return;
    }
    
    echo '<nav class="breadcrumbs" aria-label="' . esc_attr__('Breadcrumb', 'focal-wp') . '">';
    echo '<ol class="breadcrumbs-list">';
    
    // Home
    echo '<li class="breadcrumbs-item">';
    echo '<a href="' . esc_url(home_url('/')) . '">' . __('Início', 'focal-wp') . '</a>';
    echo '</li>';
    
    if (is_category() || is_single()) {
        if (is_single()) {
            $categories = get_the_category();
            if (!empty($categories)) {
                $category = $categories[0];
                echo '<li class="breadcrumbs-item">';
                echo '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a>';
                echo '</li>';
            }
            echo '<li class="breadcrumbs-item current">' . get_the_title() . '</li>';
        } else {
            echo '<li class="breadcrumbs-item current">' . single_cat_title('', false) . '</li>';
        }
    } elseif (is_page()) {
        if (wp_get_post_parent_id(get_the_ID())) {
            $parents = array();
            $parent_id = wp_get_post_parent_id(get_the_ID());
            
            while ($parent_id) {
                $parents[] = get_post($parent_id);
                $parent_id = wp_get_post_parent_id($parent_id);
            }
            
            $parents = array_reverse($parents);
            
            foreach ($parents as $parent) {
                echo '<li class="breadcrumbs-item">';
                echo '<a href="' . esc_url(get_permalink($parent->ID)) . '">' . esc_html($parent->post_title) . '</a>';
                echo '</li>';
            }
        }
        echo '<li class="breadcrumbs-item current">' . get_the_title() . '</li>';
    } elseif (is_search()) {
        echo '<li class="breadcrumbs-item current">' . sprintf(__('Resultados de busca para: %s', 'focal-wp'), get_search_query()) . '</li>';
    } elseif (is_404()) {
        echo '<li class="breadcrumbs-item current">' . __('404 - Página não encontrada', 'focal-wp') . '</li>';
    }
    
    echo '</ol>';
    echo '</nav>';
}

/**
 * Pagination customizada
 */
function focal_pagination($args = array()) {
    $defaults = array(
        'prev_text' => focal_get_icon('arrow-left', 12, 12) . ' ' . __('Anterior', 'focal-wp'),
        'next_text' => __('Próximo', 'focal-wp') . ' ' . focal_get_icon('arrow-right', 12, 12),
        'type'      => 'list',
        'class'     => 'pagination',
    );
    
    $args = wp_parse_args($args, $defaults);
    
    return paginate_links($args);
}

/**
 * Truncar texto preservando palavras
 */
function focal_truncate_text($text, $limit = 100, $suffix = '...') {
    if (mb_strlen($text) <= $limit) {
        return $text;
    }
    
    $text = mb_substr($text, 0, $limit);
    $last_space = mb_strrpos($text, ' ');
    
    if ($last_space !== false) {
        $text = mb_substr($text, 0, $last_space);
    }
    
    return $text . $suffix;
}

/**
 * Obter tempo de leitura estimado
 */
function focal_get_reading_time($content = null) {
    if (!$content) {
        $content = get_post_field('post_content', get_the_ID());
    }
    
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Assumindo 200 palavras por minuto
    
    return $reading_time;
}

/**
 * Verificar se é mobile
 */
function focal_is_mobile() {
    return wp_is_mobile();
}

/**
 * Obter classes CSS do produto (para WooCommerce)
 */
function focal_get_product_classes($additional_classes = array()) {
    if (!class_exists('WooCommerce')) {
        return implode(' ', $additional_classes);
    }
    
    global $product;
    
    if (!$product) {
        return implode(' ', $additional_classes);
    }
    
    $classes = array('product-item');
    
    // Classes baseadas no tipo de produto
    if ($product->is_on_sale()) {
        $classes[] = 'product-item--on-sale';
    }
    
    if (!$product->is_in_stock()) {
        $classes[] = 'product-item--out-of-stock';
    }
    
    if ($product->is_featured()) {
        $classes[] = 'product-item--featured';
    }
    
    // Adicionar classes extras
    if (!empty($additional_classes)) {
        $classes = array_merge($classes, $additional_classes);
    }
    
    return implode(' ', array_unique($classes));
}