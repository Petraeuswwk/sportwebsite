<?php
/**
 * Sports Wholesale Theme Functions
 *
 * @package SportsWholesale
 */

defined( 'ABSPATH' ) || exit;

/**
 * Theme version constant.
 */
define( 'SPORTSWHOLESALE_VERSION', '1.0.0' );

/**
 * Load include files.
 */
require_once get_template_directory() . '/inc/locale-filter.php';
require_once get_template_directory() . '/inc/language-switcher.php';
require_once get_template_directory() . '/inc/post-types.php';
require_once get_template_directory() . '/inc/meta-boxes.php';
require_once get_template_directory() . '/inc/inquiry-handler.php';
require_once get_template_directory() . '/inc/theme-setup.php';

/**
 * Fallback navigation menu when no menu is assigned.
 */
function sportswholesale_fallback_menu() {
    echo '<ul class="navbar-nav me-auto mb-2 mb-lg-0">';
    echo '<li class="nav-item"><a class="nav-link" href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'sportswholesale' ) . '</a></li>';

    $categories = get_terms( [ 'taxonomy' => 'product_category', 'hide_empty' => false ] );
    if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) {
        echo '<li class="nav-item dropdown">';
        echo '<a class="nav-link dropdown-toggle" href="' . esc_url( get_post_type_archive_link( 'product' ) ) . '" role="button" data-bs-toggle="dropdown" aria-expanded="false">' . esc_html__( 'Products', 'sportswholesale' ) . '</a>';
        echo '<ul class="dropdown-menu">';
        echo '<li><a class="dropdown-item" href="' . esc_url( get_post_type_archive_link( 'product' ) ) . '">' . esc_html__( 'All Products', 'sportswholesale' ) . '</a></li>';
        echo '<li><hr class="dropdown-divider"></li>';
        foreach ( $categories as $cat ) {
            echo '<li><a class="dropdown-item" href="' . esc_url( get_term_link( $cat ) ) . '">' . esc_html( $cat->name ) . '</a></li>';
        }
        echo '</ul></li>';
    } else {
        echo '<li class="nav-item"><a class="nav-link" href="' . esc_url( get_post_type_archive_link( 'product' ) ) . '">' . esc_html__( 'Products', 'sportswholesale' ) . '</a></li>';
    }

    echo '<li class="nav-item"><a class="nav-link" href="#contact">' . esc_html__( 'Contact', 'sportswholesale' ) . '</a></li>';
    echo '</ul>';
}

/**
 * Helper: Get product meta field.
 */
function sportswholesale_get_product_meta( $post_id, $key, $single = true ) {
    return get_post_meta( $post_id, $key, $single );
}

/**
 * Helper: Check if product is featured.
 */
function sportswholesale_is_featured( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    return '1' === get_post_meta( $post_id, '_product_featured', true );
}

/**
 * Helper: Get product gallery image IDs.
 */
function sportswholesale_get_gallery_ids( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    $gallery = get_post_meta( $post_id, '_product_gallery', true );
    return is_array( $gallery ) ? array_map( 'intval', $gallery ) : [];
}

/**
 * Helper: Get product category slugs.
 */
function sportswholesale_get_product_categories( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    $terms = get_the_terms( $post_id, 'product_category' );
    if ( is_wp_error( $terms ) || empty( $terms ) ) {
        return [];
    }
    return wp_list_pluck( $terms, 'slug' );
}

/**
 * Helper: Get category icon class for Bootstrap Icons.
 */
function sportswholesale_get_category_icon( $slug ) {
    $icons = apply_filters( 'sportswholesale_category_icons', [
        'table-tennis' => 'bi-circle',
        'badminton'    => 'bi-egg',
        'tennis'       => 'bi-record-circle',
        'pickleball'   => 'bi-hexagon',
        'jump-rope'    => 'bi-arrow-repeat',
    ] );
    return isset( $icons[ $slug ] ) ? $icons[ $slug ] : 'bi-tag';
}

/**
 * Helper: Get category color for cards.
 */
function sportswholesale_get_category_color( $slug ) {
    $colors = apply_filters( 'sportswholesale_category_colors', [
        'table-tennis' => '#e74c3c',
        'badminton'    => '#2ecc71',
        'tennis'       => '#f1c40f',
        'pickleball'   => '#3498db',
        'jump-rope'    => '#9b59b6',
    ] );
    return isset( $colors[ $slug ] ) ? $colors[ $slug ] : '#95a5a6';
}

/**
 * Custom excerpt length.
 */
add_filter( 'excerpt_length', function ( $length ) {
    return 20;
}, 999 );

/**
 * Custom excerpt more.
 */
add_filter( 'excerpt_more', function ( $more ) {
    return '...';
} );

/**
 * Add preload hint for Bootstrap CSS/JS for performance.
 */
add_action( 'wp_head', function () {
    echo '<link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>' . "\n";
}, 1 );
