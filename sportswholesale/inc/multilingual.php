<?php
/**
 * Multilingual product filtering
 *
 * Filters products based on current language and provides
 * language-aware queries throughout the theme.
 *
 * @package SportsWholesale
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get the language code for a product.
 */
function sportswholesale_get_product_lang( $post_id ) {
    return get_post_meta( $post_id, '_product_language', true ) ?: 'zh_CN';
}

/**
 * Set the language code for a product.
 */
function sportswholesale_set_product_lang( $post_id, $lang ) {
    update_post_meta( $post_id, '_product_language', $lang );
}

/**
 * Get all supported product languages.
 */
function sportswholesale_get_product_languages() {
    return [
        'zh_CN' => '简体中文',
        'en_US' => 'English',
        'ar'    => 'العربية',
        'es_ES' => 'Español',
    ];
}

/**
 * Get product count for a category.
 * Currently counts all products regardless of language.
 */
function sportswholesale_get_category_product_count( $term_id, $lang = null ) {
    $count = get_posts( [
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'tax_query'      => [
            [
                'taxonomy' => 'product_category',
                'field'    => 'term_id',
                'terms'    => $term_id,
            ],
        ],
    ] );

    return count( $count );
}

/**
 * Filter product queries to only show products in the current language.
 * Currently disabled - showing all products in all languages.
 * Uncomment the filter below to enable language-based filtering.
 */
/*
add_action( 'pre_get_posts', function ( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    // Only filter product queries
    if ( ! is_post_type_archive( 'product' ) && ! is_tax( 'product_category' ) && ! is_home() ) {
        // Also filter on front page
        if ( is_front_page() ) {
            // Allow featured products query on front page
        } else {
            return;
        }
    }

    $current_lang = sportswholesale_get_current_lang();

    $query->set( 'meta_query', [
        [
            'key'     => '_product_language',
            'value'   => $current_lang,
            'compare' => '=',
        ],
    ] );
} );
*/

/**
 * Filter featured products query on front page.
 * Currently disabled - showing all products in all languages.
 */
/*
add_filter( 'posts_where', function ( $where, $query ) {
    if ( is_admin() ) {
        return $where;
    }

    // Only filter on front page product queries
    if ( ! is_front_page() ) {
        return $where;
    }

    if ( isset( $query->query_vars['post_type'] ) && $query->query_vars['post_type'] === 'product' ) {
        global $wpdb;
        $current_lang = sportswholesale_get_current_lang();
        $where .= $wpdb->prepare(
            " AND {$wpdb->posts}.ID IN (SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_product_language' AND meta_value = %s)",
            $current_lang
        );
    }

    return $where;
}, 10, 2 );
*/

/**
 * Add language column to product list in admin.
 */
add_filter( 'manage_product_posts_columns', function ( $columns ) {
    $new_columns = [];
    foreach ( $columns as $key => $value ) {
        $new_columns[ $key ] = $value;
        if ( 'title' === $key ) {
            $new_columns['product_language'] = __( 'Language', 'sportswholesale' );
        }
    }
    return $new_columns;
} );

add_action( 'manage_product_posts_custom_column', function ( $column, $post_id ) {
    if ( 'product_language' === $column ) {
        $lang = sportswholesale_get_product_lang( $post_id );
        $languages = sportswholesale_get_product_languages();
        echo esc_html( isset( $languages[ $lang ] ) ? $languages[ $lang ] : $lang );
    }
}, 10, 2 );

/**
 * Add language meta box to product editor.
 */
add_action( 'add_meta_boxes', function () {
    add_meta_box(
        'product_language',
        __( 'Product Language', 'sportswholesale' ),
        'sportswholesale_product_language_meta_box',
        'product',
        'side',
        'default'
    );
} );

function sportswholesale_product_language_meta_box( $post ) {
    $current_lang = sportswholesale_get_product_lang( $post->ID );
    $languages = sportswholesale_get_product_languages();

    wp_nonce_field( 'sportswholesale_product_lang', 'sportswholesale_product_lang_nonce' );

    echo '<select name="product_language" style="width:100%">';
    foreach ( $languages as $code => $name ) {
        echo '<option value="' . esc_attr( $code ) . '"' . selected( $current_lang, $code, false ) . '>' . esc_html( $name ) . '</option>';
    }
    echo '</select>';
}

/**
 * Save product language.
 */
add_action( 'save_post_product', function ( $post_id ) {
    if ( ! isset( $_POST['sportswholesale_product_lang_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['sportswholesale_product_lang_nonce'] ) ), 'sportswholesale_product_lang' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['product_language'] ) ) {
        $lang = sanitize_text_field( wp_unslash( $_POST['product_language'] ) );
        sportswholesale_set_product_lang( $post_id, $lang );
    }
} );

/**
 * Bulk action to set product language.
 */
add_filter( 'bulk_actions-edit-product', function ( $actions ) {
    $languages = sportswholesale_get_product_languages();
    foreach ( $languages as $code => $name ) {
        $actions[ 'set_lang_' . $code ] = sprintf( __( 'Set language: %s', 'sportswholesale' ), $name );
    }
    return $actions;
} );

add_filter( 'handle_bulk_actions-edit-product', function ( $redirect_url, $action, $post_ids ) {
    $languages = sportswholesale_get_product_languages();

    foreach ( $languages as $code => $name ) {
        if ( $action === 'set_lang_' . $code ) {
            foreach ( $post_ids as $post_id ) {
                sportswholesale_set_product_lang( $post_id, $code );
            }
            $redirect_url = add_query_arg( 'bulk_lang_set', count( $post_ids ), $redirect_url );
            break;
        }
    }

    return $redirect_url;
}, 10, 3 );

/**
 * Add admin notice after bulk language set.
 */
add_action( 'admin_notices', function () {
    if ( isset( $_GET['bulk_lang_set'] ) ) {
        $count = intval( $_GET['bulk_lang_set'] );
        echo '<div class="notice notice-success is-dismissible"><p>';
        printf( esc_html__( 'Language set for %d products.', 'sportswholesale' ), $count );
        echo '</p></div>';
    }
} );
