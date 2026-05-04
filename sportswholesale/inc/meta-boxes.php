<?php
/**
 * Meta boxes for Product custom post type
 *
 * @package SportsWholesale
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add meta box for product details.
 */
add_action( 'add_meta_boxes', function () {
    add_meta_box(
        'product_details',
        __( 'Product Details', 'sportswholesale' ),
        'sportswholesale_product_meta_box_callback',
        'product',
        'normal',
        'high'
    );
} );

/**
 * Meta box callback.
 */
function sportswholesale_product_meta_box_callback( $post ) {
    wp_nonce_field( 'sportswholesale_product_meta', 'sportswholesale_product_nonce' );

    $subtitle   = get_post_meta( $post->ID, '_product_subtitle', true );
    $price      = get_post_meta( $post->ID, '_product_price_reference', true );
    $moq        = get_post_meta( $post->ID, '_product_moq', true );
    $material   = get_post_meta( $post->ID, '_product_material', true );
    $featured   = get_post_meta( $post->ID, '_product_featured', true );
    $gallery    = get_post_meta( $post->ID, '_product_gallery', true );
    $gallery_ids = is_array( $gallery ) ? $gallery : [];
    ?>
    <table class="form-table">
        <tr>
            <th><label for="product_subtitle"><?php esc_html_e( 'Subtitle / Short Selling Point', 'sportswholesale' ); ?></label></th>
            <td><input type="text" id="product_subtitle" name="product_subtitle" value="<?php echo esc_attr( $subtitle ); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="product_price_reference"><?php esc_html_e( 'Reference Price', 'sportswholesale' ); ?></label></th>
            <td><input type="text" id="product_price_reference" name="product_price_reference" value="<?php echo esc_attr( $price ); ?>" class="regular-text" placeholder="$12.00" /></td>
        </tr>
        <tr>
            <th><label for="product_moq"><?php esc_html_e( 'Minimum Order Quantity (MOQ)', 'sportswholesale' ); ?></label></th>
            <td><input type="text" id="product_moq" name="product_moq" value="<?php echo esc_attr( $moq ); ?>" class="regular-text" placeholder="100 pcs" /></td>
        </tr>
        <tr>
            <th><label for="product_material"><?php esc_html_e( 'Material', 'sportswholesale' ); ?></label></th>
            <td><input type="text" id="product_material" name="product_material" value="<?php echo esc_attr( $material ); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="product_featured"><?php esc_html_e( 'Featured Product', 'sportswholesale' ); ?></label></th>
            <td>
                <label><input type="checkbox" id="product_featured" name="product_featured" value="1" <?php checked( $featured, '1' ); ?> /> <?php esc_html_e( 'Mark as featured', 'sportswholesale' ); ?></label>
            </td>
        </tr>
        <tr>
            <th><?php esc_html_e( 'Product Gallery', 'sportswholesale' ); ?></th>
            <td>
                <div id="product-gallery-container">
                    <?php foreach ( $gallery_ids as $img_id ) :
                        $img_url = wp_get_attachment_image_url( $img_id, 'thumbnail' );
                        if ( $img_url ) : ?>
                            <div class="sw-gallery-item" style="display:inline-block;margin:4px;position:relative;">
                                <img src="<?php echo esc_url( $img_url ); ?>" style="width:80px;height:80px;object-fit:cover;" />
                                <input type="hidden" name="product_gallery[]" value="<?php echo esc_attr( $img_id ); ?>" />
                                <button type="button" class="sw-gallery-remove" style="position:absolute;top:-4px;right:-4px;background:red;color:#fff;border:none;border-radius:50%;width:18px;height:18px;font-size:12px;line-height:1;cursor:pointer;">&times;</button>
                            </div>
                        <?php endif;
                    endforeach; ?>
                </div>
                <button type="button" id="sw-add-gallery-images" class="button"><?php esc_html_e( 'Add Images', 'sportswholesale' ); ?></button>
                <p class="description"><?php esc_html_e( 'Select multiple images for the product gallery.', 'sportswholesale' ); ?></p>
            </td>
        </tr>
    </table>
    <script>
    (function() {
        var frame;
        document.getElementById('sw-add-gallery-images').addEventListener('click', function(e) {
            e.preventDefault();
            if (frame) { frame.open(); return; }
            frame = wp.media({
                title: '<?php esc_html_e( 'Select Product Images', 'sportswholesale' ); ?>',
                multiple: true,
                library: { type: 'image' },
                button: { text: '<?php esc_html_e( 'Add to Gallery', 'sportswholesale' ); ?>' }
            });
            frame.on('select', function() {
                var attachments = frame.state().get('selection').toJSON();
                var container = document.getElementById('product-gallery-container');
                attachments.forEach(function(att) {
                    var div = document.createElement('div');
                    div.className = 'sw-gallery-item';
                    div.style.cssText = 'display:inline-block;margin:4px;position:relative;';
                    div.innerHTML = '<img src="' + att.sizes.thumbnail.url + '" style="width:80px;height:80px;object-fit:cover;" />' +
                        '<input type="hidden" name="product_gallery[]" value="' + att.id + '" />' +
                        '<button type="button" class="sw-gallery-remove" style="position:absolute;top:-4px;right:-4px;background:red;color:#fff;border:none;border-radius:50%;width:18px;height:18px;font-size:12px;line-height:1;cursor:pointer;">&times;</button>';
                    container.appendChild(div);
                });
            });
            frame.open();
        });
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('sw-gallery-remove')) {
                e.target.parentElement.remove();
            }
        });
    })();
    </script>
    <?php
}

/**
 * Save product meta.
 */
add_action( 'save_post_product', function ( $post_id ) {
    if ( ! isset( $_POST['sportswholesale_product_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['sportswholesale_product_nonce'] ) ), 'sportswholesale_product_meta' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $fields = [
        'product_subtitle'         => '_product_subtitle',
        'product_price_reference'  => '_product_price_reference',
        'product_moq'              => '_product_moq',
        'product_material'         => '_product_material',
    ];

    foreach ( $fields as $field_name => $meta_key ) {
        if ( isset( $_POST[ $field_name ] ) ) {
            update_post_meta( $post_id, $meta_key, sanitize_text_field( wp_unslash( $_POST[ $field_name ] ) ) );
        }
    }

    $featured = isset( $_POST['product_featured'] ) ? '1' : '0';
    update_post_meta( $post_id, '_product_featured', $featured );

    // Gallery
    if ( isset( $_POST['product_gallery'] ) && is_array( $_POST['product_gallery'] ) ) {
        $gallery_ids = array_map( 'intval', $_POST['product_gallery'] );
        update_post_meta( $post_id, '_product_gallery', $gallery_ids );
    } else {
        delete_post_meta( $post_id, '_product_gallery' );
    }
} );

/**
 * Register post meta for REST API (optional, for Gutenberg).
 */
add_action( 'init', function () {
    $meta_fields = [
        '_product_subtitle'        => 'string',
        '_product_price_reference' => 'string',
        '_product_moq'             => 'string',
        '_product_material'        => 'string',
        '_product_featured'        => 'string',
        '_product_gallery'         => 'array',
    ];

    foreach ( $meta_fields as $key => $type ) {
        $args = [
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => $type,
            'auth_callback' => function () {
                return current_user_can( 'edit_posts' );
            },
        ];

        if ( 'array' === $type ) {
            $args['show_in_rest'] = [
                'schema' => [
                    'type'  => 'array',
                    'items' => [ 'type' => 'integer' ],
                ],
            ];
        }

        register_post_meta( 'product', $key, $args );
    }
} );
