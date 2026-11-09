<?php
/**
 * Excel Product Importer
 *
 * Admin page to import products from processed Excel data.
 *
 * @package SportsWholesale
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add admin menu item.
 */
add_action( 'admin_menu', function () {
    add_submenu_page(
        'edit.php?post_type=product',
        __( 'Import Products', 'sportswholesale' ),
        __( 'Import Products', 'sportswholesale' ),
        'manage_options',
        'sw-import-products',
        'sw_import_products_page'
    );
} );

/**
 * Admin page callback.
 */
function sw_import_products_page() {
    // Handle import action
    if ( isset( $_POST['sw_run_import'] ) && check_admin_referer( 'sw_import_nonce' ) ) {
        $result = sw_run_product_import();
        echo '<div class="notice notice-' . ( $result['success'] ? 'success' : 'error' ) . '"><p>' . esc_html( $result['message'] ) . '</p></div>';
    }

    $data_dir = get_template_directory() . '/import_data';
    $json_file = $data_dir . '/products.json';
    $images_dir = $data_dir . '/images';

    $file_exists = file_exists( $json_file );
    $product_count = 0;
    $image_count = 0;

    if ( $file_exists ) {
        $data = json_decode( file_get_contents( $json_file ), true );
        $product_count = is_array( $data ) ? count( $data ) : 0;
        if ( is_dir( $images_dir ) ) {
            $image_count = count( glob( $images_dir . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE ) );
        }
    }

    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Import Products from Excel', 'sportswholesale' ); ?></h1>

        <?php if ( ! $file_exists ) : ?>
            <div class="notice notice-warning">
                <p><?php esc_html_e( 'Import data not found. Please run the Python script first to process the Excel file.', 'sportswholesale' ); ?></p>
            </div>
            <h2><?php esc_html_e( 'Instructions', 'sportswholesale' ); ?></h2>
            <ol>
                <li><?php esc_html_e( 'Place the Excel file (产品报价表.xlsx) in the Downloads folder.', 'sportswholesale' ); ?></li>
                <li><?php esc_html_e( 'Run the Python script:', 'sportswholesale' ); ?></li>
                <li><code>python3 <?php echo esc_html( get_template_directory() ); ?>/process_excel.py</code></li>
                <li><?php esc_html_e( 'Refresh this page and click Import.', 'sportswholesale' ); ?></li>
            </ol>
        <?php else : ?>
            <div class="card" style="max-width: 600px; padding: 20px; margin: 20px 0;">
                <h2><?php esc_html_e( 'Import Summary', 'sportswholesale' ); ?></h2>
                <table class="form-table">
                    <tr>
                        <th><?php esc_html_e( 'Products found', 'sportswholesale' ); ?></th>
                        <td><strong><?php echo esc_html( $product_count ); ?></strong></td>
                    </tr>
                    <tr>
                        <th><?php esc_html_e( 'Images found', 'sportswholesale' ); ?></th>
                        <td><strong><?php echo esc_html( $image_count ); ?></strong></td>
                    </tr>
                    <tr>
                        <th><?php esc_html_e( 'Data file', 'sportswholesale' ); ?></th>
                        <td><code><?php echo esc_html( $json_file ); ?></code></td>
                    </tr>
                </table>

                <h3><?php esc_html_e( 'Categories', 'sportswholesale' ); ?></h3>
                <ul>
                    <?php
                    $categories = [];
                    foreach ( $data as $product ) {
                        $cat = $product['category_name'];
                        if ( ! isset( $categories[ $cat ] ) ) {
                            $categories[ $cat ] = 0;
                        }
                        $categories[ $cat ]++;
                    }
                    foreach ( $categories as $name => $count ) :
                    ?>
                        <li><?php echo esc_html( $name ); ?>: <?php echo esc_html( $count ); ?> <?php esc_html_e( 'products', 'sportswholesale' ); ?></li>
                    <?php endforeach; ?>
                </ul>

                <form method="post">
                    <?php wp_nonce_field( 'sw_import_nonce' ); ?>
                    <p>
                        <label>
                            <?php esc_html_e( 'Product Language:', 'sportswholesale' ); ?>
                            <select name="sw_import_lang" style="margin-left: 10px;">
                                <option value="zh_CN">简体中文</option>
                                <option value="en_US">English</option>
                                <option value="ar">العربية</option>
                                <option value="es_ES">Español</option>
                            </select>
                        </label>
                    </p>
                    <p>
                        <label>
                            <input type="checkbox" name="sw_skip_duplicates" value="1" checked>
                            <?php esc_html_e( 'Skip products with existing titles', 'sportswholesale' ); ?>
                        </label>
                    </p>
                    <p>
                        <label>
                            <input type="checkbox" name="sw_import_images" value="1" checked>
                            <?php esc_html_e( 'Import product images', 'sportswholesale' ); ?>
                        </label>
                    </p>
                    <p class="submit">
                        <input type="submit" name="sw_run_import" class="button button-primary" value="<?php esc_attr_e( 'Start Import', 'sportswholesale' ); ?>"
                               onclick="return confirm('<?php esc_attr_e( 'Are you sure you want to import all products?', 'sportswholesale' ); ?>');">
                    </p>
                </form>
            </div>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Run the product import.
 */
function sw_run_product_import() {
    $data_dir = get_template_directory() . '/import_data';
    $json_file = $data_dir . '/products.json';
    $images_dir = $data_dir . '/images';

    if ( ! file_exists( $json_file ) ) {
        return [ 'success' => false, 'message' => __( 'Import data file not found.', 'sportswholesale' ) ];
    }

    $data = json_decode( file_get_contents( $json_file ), true );
    if ( ! is_array( $data ) ) {
        return [ 'success' => false, 'message' => __( 'Invalid data file format.', 'sportswholesale' ) ];
    }

    $skip_duplicates = ! empty( $_POST['sw_skip_duplicates'] );
    $import_images = ! empty( $_POST['sw_import_images'] );

    $created = 0;
    $skipped = 0;
    $errors = 0;
    $images_imported = 0;

    // Ensure categories exist
    $category_map = [];
    foreach ( $data as $product ) {
        $cat_name = $product['category_name'];
        if ( ! isset( $category_map[ $cat_name ] ) ) {
            $term = term_exists( $cat_name, 'product_category' );
            if ( ! $term ) {
                $term = wp_insert_term( $cat_name, 'product_category', [
                    'slug' => $product['category_slug'],
                ] );
            }
            if ( ! is_wp_error( $term ) ) {
                $category_map[ $cat_name ] = is_array( $term ) ? $term['term_id'] : $term;
            }
        }
    }

    foreach ( $data as $product ) {
        $title = sanitize_text_field( $product['title_en'] ?? $product['title'] ?? '' );
        if ( ! $title ) { $errors++; continue; }

        // Check for existing product
        if ( $skip_duplicates ) {
            $existing = get_posts( [
                'post_type'   => 'product',
                'post_status' => 'any',
                'title'       => $title,
                'numberposts' => 1,
                'fields'      => 'ids',
            ] );

            if ( ! empty( $existing ) ) {
                // Enriched imports update their existing product instead of creating a duplicate.
                sw_import_enriched_product( $existing[0], $product, $images_dir, $import_images );
                $skipped++;
                continue;
            }
        }

        // Create product
        $post_id = wp_insert_post( [
            'post_type'    => 'product',
            'post_title'   => $title,
            'post_content' => '',
            'post_excerpt'  => '',
            'post_status'  => 'publish',
        ] );

        if ( is_wp_error( $post_id ) ) {
            $errors++;
            continue;
        }

        // Set meta fields
        if ( ! empty( $product['unit_price'] ) ) {
            update_post_meta( $post_id, '_product_price_reference', sanitize_text_field( $product['unit_price'] ) );
        }
        if ( ! empty( $product['moq'] ) ) {
            update_post_meta( $post_id, '_product_moq', sanitize_text_field( $product['moq'] ) );
        }
        if ( ! empty( $product['material'] ) ) {
            update_post_meta( $post_id, '_product_material', sanitize_text_field( $product['material'] ) );
        }
        foreach ( [ 'quantity_per_box' => '_product_quantity_per_box', 'box_spec' => '_product_box_spec' ] as $field => $meta_key ) {
            if ( ! empty( $product[ $field ] ) ) { update_post_meta( $post_id, $meta_key, sanitize_text_field( $product[ $field ] ) ); }
        }

        // Set product language (default to Chinese for Excel import)
        $import_lang = ! empty( $product['title_en'] ) ? 'en_US' : ( ! empty( $_POST['sw_import_lang'] ) ? sanitize_text_field( wp_unslash( $_POST['sw_import_lang'] ) ) : 'zh_CN' );
        update_post_meta( $post_id, '_product_language', $import_lang );

        // Build subtitle from available info
        $subtitle_parts = [];
        if ( ! empty( $product['dimensions'] ) ) {
            $subtitle_parts[] = $product['dimensions'];
        }
        if ( ! empty( $product['quantity_per_box'] ) ) {
            $subtitle_parts[] = $product['quantity_per_box'];
        }
        if ( ! empty( $subtitle_parts ) ) {
            update_post_meta( $post_id, '_product_subtitle', sanitize_text_field( implode( ' | ', $subtitle_parts ) ) );
        }

        // Build description from all available info
        $desc_parts = [];
        if ( ! empty( $product['material'] ) ) {
            $desc_parts[] = '<strong>' . __( 'Material', 'sportswholesale' ) . ':</strong> ' . esc_html( $product['material'] );
        }
        if ( ! empty( $product['dimensions'] ) ) {
            $desc_parts[] = '<strong>' . __( 'Dimensions', 'sportswholesale' ) . ':</strong> ' . esc_html( $product['dimensions'] );
        }
        if ( ! empty( $product['box_spec'] ) ) {
            $desc_parts[] = '<strong>' . __( 'Box Spec', 'sportswholesale' ) . ':</strong> ' . esc_html( $product['box_spec'] );
        }
        if ( ! empty( $product['quantity_per_box'] ) ) {
            $desc_parts[] = '<strong>' . __( 'Qty per Box', 'sportswholesale' ) . ':</strong> ' . esc_html( $product['quantity_per_box'] );
        }
        if ( ! empty( $product['weight'] ) ) {
            $desc_parts[] = '<strong>' . __( 'Weight', 'sportswholesale' ) . ':</strong> ' . esc_html( $product['weight'] );
        }
        if ( ! empty( $product['total_price'] ) ) {
            $desc_parts[] = '<strong>' . __( 'Box Price', 'sportswholesale' ) . ':</strong> ' . esc_html( $product['total_price'] );
        }
        if ( ! empty( $desc_parts ) ) {
            wp_update_post( [
                'ID'           => $post_id,
                'post_content' => implode( '<br>', $desc_parts ),
            ] );
        }

        // Set category
        if ( isset( $category_map[ $product['category_name'] ] ) ) {
            wp_set_object_terms( $post_id, [ intval( $category_map[ $product['category_name'] ] ) ], 'product_category' );
        }

        // Import image
        if ( $import_images && ! empty( $product['image_file'] ) ) {
            $image_path = $images_dir . '/' . $product['image_file'];
            if ( file_exists( $image_path ) ) {
                $attachment_id = sw_sideload_image( $image_path, $post_id, $title );
                if ( $attachment_id && ! is_wp_error( $attachment_id ) ) {
                    set_post_thumbnail( $post_id, $attachment_id );
                    $images_imported++;
                }
            }
        }
        sw_import_enriched_product( $post_id, $product, $images_dir, $import_images );

        $created++;
    }

    $message = sprintf(
        __( 'Import complete! Created: %d, Skipped: %d, Errors: %d, Images: %d', 'sportswholesale' ),
        $created,
        $skipped,
        $errors,
        $images_imported
    );

    return [ 'success' => true, 'message' => $message ];
}

/** Import optional rich product data. Picture values must be local filenames. */
function sw_import_enriched_product( $post_id, $product, $images_dir, $import_images ) {
    foreach ( [ 'material' => '_product_material', 'quantity_per_box' => '_product_quantity_per_box', 'box_spec' => '_product_box_spec' ] as $field => $meta ) {
        if ( ! empty( $product[ $field ] ) ) { update_post_meta( $post_id, $meta, sanitize_text_field( $product[ $field ] ) ); }
    }
    foreach ( [ 'title_en' => '_product_title_en', 'moq_unit' => '_product_moq_unit' ] as $field => $meta ) {
        if ( isset( $product[ $field ] ) ) { update_post_meta( $post_id, $meta, sanitize_text_field( $product[ $field ] ) ); }
    }
    if ( isset( $product['lead_time_days'] ) ) { update_post_meta( $post_id, '_product_lead_time_days', absint( $product['lead_time_days'] ) ); }
    if ( isset( $product['price_tiers'] ) && is_array( $product['price_tiers'] ) ) {
        $tiers = [];
        foreach ( $product['price_tiers'] as $tier ) {
            if ( ! isset( $tier['min_qty'], $tier['price'] ) ) { continue; }
            $tiers[] = [ 'min_qty' => absint( $tier['min_qty'] ), 'price' => sanitize_text_field( $tier['price'] ) ];
        }
        usort( $tiers, function ( $a, $b ) { return $a['min_qty'] - $b['min_qty']; } );
        update_post_meta( $post_id, '_product_price_tiers', $tiers );
    }
    foreach ( [ 'specs' => '_product_specs', 'packing' => '_product_packing', 'source_ids' => '_product_source_ids' ] as $field => $meta ) {
        if ( ! isset( $product[ $field ] ) || ! is_array( $product[ $field ] ) ) { continue; }
        $clean = [];
        foreach ( $product[ $field ] as $key => $value ) { if ( is_scalar( $value ) ) { $clean[ sanitize_text_field( $key ) ] = sanitize_text_field( $value ); } }
        update_post_meta( $post_id, $meta, $clean );
    }
    if ( ! $import_images ) { return; }
    $image_cache = [];
    $local_image = function ( $file ) use ( $images_dir, $post_id, &$image_cache ) {
        if ( ! is_string( $file ) || ! $file || basename( $file ) !== $file ) { return 0; }
        if ( isset( $image_cache[ $file ] ) ) { return $image_cache[ $file ]; }
        $path = $images_dir . '/' . $file;
        $image_cache[ $file ] = is_file( $path ) ? sw_sideload_image( $path, $post_id, $file ) : 0;
        return is_wp_error( $image_cache[ $file ] ) ? 0 : (int) $image_cache[ $file ];
    };
    foreach ( [ 'gallery' => '_product_gallery', 'detail_images' => '_product_detail_images' ] as $field => $meta ) {
        if ( empty( $product[ $field ] ) || ! is_array( $product[ $field ] ) ) { continue; }
        $ids = array_filter( array_map( $local_image, $product[ $field ] ) );
        update_post_meta( $post_id, $meta, array_values( $ids ) );
        if ( 'gallery' === $field && ! has_post_thumbnail( $post_id ) && $ids ) { set_post_thumbnail( $post_id, reset( $ids ) ); }
    }
    if ( ! empty( $product['colors'] ) && is_array( $product['colors'] ) ) {
        $colors = [];
        foreach ( $product['colors'] as $color ) { $colors[] = [ 'code' => sanitize_text_field( $color['code'] ?? '' ), 'picture_id' => $local_image( $color['picture'] ?? '' ) ]; }
        update_post_meta( $post_id, '_product_colors', $colors );
    }
}

/**
 * Sideload an image from a local file path.
 */
function sw_sideload_image( $file_path, $post_id, $title = '' ) {
    if ( ! function_exists( 'media_handle_sideload' ) ) {
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';
    }

    $temporary_file = wp_tempnam( basename( $file_path ) );
    if ( ! $temporary_file || ! copy( $file_path, $temporary_file ) ) {
        return new WP_Error( 'image_copy_failed', 'Could not copy local image for import.' );
    }
    $file_array = [
        'name'     => basename( $file_path ),
        'tmp_name' => $temporary_file,
    ];

    // Check file type
    $wp_filetype = wp_check_filetype( $file_array['name'] );
    if ( ! $wp_filetype['type'] ) {
        unlink( $temporary_file );
        return new WP_Error( 'invalid_type', 'Invalid file type' );
    }

    $attachment_id = media_handle_sideload( $file_array, $post_id, $title );
    if ( is_wp_error( $attachment_id ) && file_exists( $temporary_file ) ) { unlink( $temporary_file ); }

    return $attachment_id;
}
