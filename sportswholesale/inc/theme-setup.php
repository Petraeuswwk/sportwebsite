<?php
/**
 * Theme setup: sample data, image sizes, nav menus
 *
 * @package SportsWholesale
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register nav menus.
 */
add_action( 'after_setup_theme', function () {
    register_nav_menus( [
        'primary' => __( 'Primary Navigation', 'sportswholesale' ),
    ] );

    // Add image sizes - use square for product cards (most images are portrait)
    add_image_size( 'product-card', 400, 400, [ 'center', 'center' ] );
    add_image_size( 'product-gallery', 800, 600, false );
    add_image_size( 'hero-banner', 1200, 500, true );

    // Enable featured images
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ] );
    add_theme_support( 'custom-logo', [
        'height'      => 60,
        'width'       => 200,
        'flex-width'  => true,
        'flex-height' => true,
    ] );
} );

/**
 * Insert sample products on theme activation.
 */
add_action( 'after_switch_theme', function () {
    // Only run once
    if ( get_option( 'sportswholesale_sample_data_inserted' ) ) {
        return;
    }

    $products = [
        [
            'title'    => 'Professional Table Tennis Paddle - Carbon Fiber',
            'subtitle' => 'Competition-grade carbon fiber blade with ITTF approved rubber',
            'price'    => '$8.50 - $15.00',
            'moq'      => '100 pcs',
            'material' => 'Carbon Fiber / Wood',
            'category' => 'table-tennis',
            'featured' => true,
        ],
        [
            'title'    => 'Training Table Tennis Balls - 100 Pack',
            'subtitle' => '3-star rated seamless balls for training and competition',
            'price'    => '$0.15 - $0.25 / pc',
            'moq'      => '2000 pcs',
            'material' => 'Celluloid / ABS',
            'category' => 'table-tennis',
            'featured' => true,
        ],
        [
            'title'    => 'Ultra-Light Full Carbon Badminton Racket',
            'subtitle' => 'High-tension string, head-heavy balance for powerful smashes',
            'price'    => '$12.00 - $22.00',
            'moq'      => '50 pcs',
            'material' => 'Full Carbon Graphite',
            'category' => 'badminton',
            'featured' => true,
        ],
        [
            'title'    => 'Competition Grade Goose Feather Shuttlecocks',
            'subtitle' => '16 goose feathers, cork base, tournament approved',
            'price'    => '$0.80 - $1.50 / pc',
            'moq'      => '500 pcs',
            'material' => 'Goose Feather / Cork',
            'category' => 'badminton',
            'featured' => false,
        ],
        [
            'title'    => 'Tennis Racket - Beginner to Intermediate',
            'subtitle' => 'Oversized head, lightweight frame, pre-strung',
            'price'    => '$10.00 - $18.00',
            'moq'      => '50 pcs',
            'material' => 'Aluminum / Steel',
            'category' => 'tennis',
            'featured' => true,
        ],
        [
            'title'    => 'Training Tennis Balls - Pressureless Practice',
            'subtitle' => 'Durable pressureless balls, ideal for training machines',
            'price'    => '$0.40 - $0.60 / pc',
            'moq'      => '1000 pcs',
            'material' => 'Rubber / Felt',
            'category' => 'tennis',
            'featured' => false,
        ],
        [
            'title'    => 'Pickleball Paddle - Fiberglass Face',
            'subtitle' => 'USAPA approved, polymer core, non-slip grip',
            'price'    => '$9.00 - $16.00',
            'moq'      => '50 pcs',
            'material' => 'Fiberglass / Polymer',
            'category' => 'pickleball',
            'featured' => true,
        ],
        [
            'title'    => 'Freestyle Jump Rope - Ball Bearing Speed Rope',
            'subtitle' => 'Adjustable length, steel wire rope, anti-slip handles',
            'price'    => '$1.50 - $3.00',
            'moq'      => '200 pcs',
            'material' => 'Steel Wire / PVC',
            'category' => 'jump-rope',
            'featured' => false,
        ],
    ];

    // Insert categories
    $categories = [
        'table-tennis' => __( 'Table Tennis', 'sportswholesale' ),
        'badminton'    => __( 'Badminton', 'sportswholesale' ),
        'tennis'       => __( 'Tennis', 'sportswholesale' ),
        'pickleball'   => __( 'Pickleball', 'sportswholesale' ),
        'jump-rope'    => __( 'Jump Rope', 'sportswholesale' ),
    ];

    foreach ( $categories as $slug => $name ) {
        if ( ! term_exists( $slug, 'product_category' ) ) {
            wp_insert_term( $name, 'product_category', [ 'slug' => $slug ] );
        }
    }

    // Insert products
    foreach ( $products as $product_data ) {
        $existing = get_posts( [
            'post_type'   => 'product',
            'title'       => $product_data['title'],
            'post_status' => 'any',
            'numberposts' => 1,
        ] );

        if ( ! empty( $existing ) ) {
            continue;
        }

        $post_id = wp_insert_post( [
            'post_title'   => $product_data['title'],
            'post_type'    => 'product',
            'post_status'  => 'publish',
            'post_content' => '',
            'post_excerpt'  => $product_data['subtitle'],
        ] );

        if ( $post_id && ! is_wp_error( $post_id ) ) {
            update_post_meta( $post_id, '_product_subtitle', $product_data['subtitle'] );
            update_post_meta( $post_id, '_product_price_reference', $product_data['price'] );
            update_post_meta( $post_id, '_product_moq', $product_data['moq'] );
            update_post_meta( $post_id, '_product_material', $product_data['material'] );
            update_post_meta( $post_id, '_product_featured', $product_data['featured'] ? '1' : '0' );
            update_post_meta( $post_id, '_product_gallery', [] );

            wp_set_object_terms( $post_id, $product_data['category'], 'product_category' );
        }
    }

    update_option( 'sportswholesale_sample_data_inserted', true );
} );

/**
 * Enqueue scripts and styles.
 */
add_action( 'wp_enqueue_scripts', function () {
    // Bootstrap 5 CSS
    wp_enqueue_style(
        'bootstrap',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
        [],
        '5.3.3'
    );

    // Bootstrap Icons
    wp_enqueue_style(
        'bootstrap-icons',
        'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css',
        [],
        '1.11.3'
    );

    // Theme main CSS
    wp_enqueue_style(
        'sportswholesale-main',
        get_template_directory_uri() . '/assets/css/main.css',
        [ 'bootstrap' ],
        wp_get_theme()->get( 'Version' )
    );

    // Bootstrap JS
    wp_enqueue_script(
        'bootstrap-bundle',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
        [],
        '5.3.3',
        true
    );

    // Theme main JS
    wp_enqueue_script(
        'sportswholesale-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [ 'bootstrap-bundle' ],
        wp_get_theme()->get( 'Version' ),
        true
    );

    // Localize script for AJAX or translations
    wp_localize_script( 'sportswholesale-main', 'swData', [
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'sw-nonce' ),
        'i18n'    => [
            'submitting' => __( 'Submitting...', 'sportswholesale' ),
            'required'   => __( 'Please fill in all required fields.', 'sportswholesale' ),
        ],
    ] );
} );

/**
 * Add admin menu page for viewing inquiries.
 */
add_action( 'admin_menu', function () {
    add_submenu_page(
        'edit.php?post_type=inquiry',
        __( 'Inquiry Settings', 'sportswholesale' ),
        __( 'Settings', 'sportswholesale' ),
        'manage_options',
        'inquiry-settings',
        function () {
            echo '<div class="wrap"><h1>' . esc_html__( 'Inquiry Settings', 'sportswholesale' ) . '</h1>';
            echo '<p>' . esc_html__( 'Inquiry emails are sent to the admin email address:', 'sportswholesale' ) . ' <strong>' . esc_html( get_option( 'admin_email' ) ) . '</strong></p>';
            echo '</div>';
        }
    );
} );
