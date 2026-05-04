<?php
/**
 * Custom Post Type and Taxonomy registration
 *
 * @package SportsWholesale
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register custom post type: product
 */
add_action( 'init', function () {
    $labels = [
        'name'               => _x( 'Products', 'post type general name', 'sportswholesale' ),
        'singular_name'      => _x( 'Product', 'post type singular name', 'sportswholesale' ),
        'menu_name'          => _x( 'Products', 'admin menu', 'sportswholesale' ),
        'add_new'            => __( 'Add New', 'sportswholesale' ),
        'add_new_item'       => __( 'Add New Product', 'sportswholesale' ),
        'edit_item'          => __( 'Edit Product', 'sportswholesale' ),
        'new_item'           => __( 'New Product', 'sportswholesale' ),
        'view_item'          => __( 'View Product', 'sportswholesale' ),
        'search_items'       => __( 'Search Products', 'sportswholesale' ),
        'not_found'          => __( 'No products found', 'sportswholesale' ),
        'not_found_in_trash' => __( 'No products found in Trash', 'sportswholesale' ),
        'all_items'          => __( 'All Products', 'sportswholesale' ),
    ];

    $args = [
        'labels'              => $labels,
        'public'              => true,
        'has_archive'         => true,
        'rewrite'             => [ 'slug' => 'products', 'with_front' => false ],
        'supports'            => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
        'menu_icon'           => 'dashicons-cart',
        'show_in_rest'        => true,
        'capability_type'     => 'post',
        'map_meta_cap'        => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
    ];

    register_post_type( 'product', $args );
} );

/**
 * Register custom taxonomy: product_category
 */
add_action( 'init', function () {
    $labels = [
        'name'              => _x( 'Product Categories', 'taxonomy general name', 'sportswholesale' ),
        'singular_name'     => _x( 'Product Category', 'taxonomy singular name', 'sportswholesale' ),
        'search_items'      => __( 'Search Categories', 'sportswholesale' ),
        'all_items'         => __( 'All Categories', 'sportswholesale' ),
        'parent_item'       => __( 'Parent Category', 'sportswholesale' ),
        'parent_item_colon' => __( 'Parent Category:', 'sportswholesale' ),
        'edit_item'         => __( 'Edit Category', 'sportswholesale' ),
        'update_item'       => __( 'Update Category', 'sportswholesale' ),
        'add_new_item'      => __( 'Add New Category', 'sportswholesale' ),
        'new_item_name'     => __( 'New Category Name', 'sportswholesale' ),
        'menu_name'         => __( 'Categories', 'sportswholesale' ),
    ];

    $args = [
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => true,
        'rewrite'           => [ 'slug' => 'product-category', 'with_front' => false ],
        'show_in_rest'      => true,
        'show_admin_column' => true,
    ];

    register_taxonomy( 'product_category', 'product', $args );
} );

/**
 * Register custom post type: inquiry
 */
add_action( 'init', function () {
    $labels = [
        'name'               => _x( 'Inquiries', 'post type general name', 'sportswholesale' ),
        'singular_name'      => _x( 'Inquiry', 'post type singular name', 'sportswholesale' ),
        'menu_name'          => _x( 'Inquiries', 'admin menu', 'sportswholesale' ),
        'add_new'            => __( 'Add New', 'sportswholesale' ),
        'add_new_item'       => __( 'Add New Inquiry', 'sportswholesale' ),
        'edit_item'          => __( 'Edit Inquiry', 'sportswholesale' ),
        'all_items'          => __( 'All Inquiries', 'sportswholesale' ),
        'view_item'          => __( 'View Inquiry', 'sportswholesale' ),
        'search_items'       => __( 'Search Inquiries', 'sportswholesale' ),
        'not_found'          => __( 'No inquiries found', 'sportswholesale' ),
        'not_found_in_trash' => __( 'No inquiries found in Trash', 'sportswholesale' ),
    ];

    $args = [
        'labels'              => $labels,
        'public'              => false,
        'show_ui'             => true,
        'has_archive'         => false,
        'menu_icon'           => 'dashicons-email-alt',
        'supports'            => [ 'title', 'editor' ],
        'show_in_rest'        => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => false,
    ];

    register_post_type( 'inquiry', $args );
} );

/**
 * Add custom columns to product list in admin.
 */
add_filter( 'manage_product_posts_columns', function ( $columns ) {
    $new_columns = [];
    foreach ( $columns as $key => $value ) {
        $new_columns[ $key ] = $value;
        if ( 'title' === $key ) {
            $new_columns['product_price']   = __( 'Price', 'sportswholesale' );
            $new_columns['product_moq']     = __( 'MOQ', 'sportswholesale' );
            $new_columns['product_category'] = __( 'Category', 'sportswholesale' );
        }
    }
    return $new_columns;
} );

add_action( 'manage_product_posts_custom_column', function ( $column, $post_id ) {
    switch ( $column ) {
        case 'product_price':
            echo esc_html( get_post_meta( $post_id, '_product_price_reference', true ) );
            break;
        case 'product_moq':
            echo esc_html( get_post_meta( $post_id, '_product_moq', true ) );
            break;
        case 'product_category':
            $terms = get_the_terms( $post_id, 'product_category' );
            if ( $terms && ! is_wp_error( $terms ) ) {
                echo esc_html( implode( ', ', wp_list_pluck( $terms, 'name' ) ) );
            }
            break;
    }
}, 10, 2 );

/**
 * Add custom columns to inquiry list in admin.
 */
add_filter( 'manage_inquiry_posts_columns', function ( $columns ) {
    $new_columns = [];
    foreach ( $columns as $key => $value ) {
        $new_columns[ $key ] = $value;
        if ( 'title' === $key ) {
            $new_columns['inquiry_email']   = __( 'Email', 'sportswholesale' );
            $new_columns['inquiry_country'] = __( 'Country', 'sportswholesale' );
            $new_columns['inquiry_phone']   = __( 'Phone/WhatsApp', 'sportswholesale' );
        }
    }
    return $new_columns;
} );

add_action( 'manage_inquiry_posts_custom_column', function ( $column, $post_id ) {
    switch ( $column ) {
        case 'inquiry_email':
            echo esc_html( get_post_meta( $post_id, '_inquiry_email', true ) );
            break;
        case 'inquiry_country':
            echo esc_html( get_post_meta( $post_id, '_inquiry_country', true ) );
            break;
        case 'inquiry_phone':
            echo esc_html( get_post_meta( $post_id, '_inquiry_phone', true ) );
            break;
    }
}, 10, 2 );

/**
 * Flush rewrite rules on theme activation.
 */
add_action( 'after_switch_theme', function () {
    flush_rewrite_rules();
} );
