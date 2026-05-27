<?php
/**
 * Single product template
 *
 * @package SportsWholesale
 */

get_header();

while ( have_posts() ) :
    the_post();

    $post_id     = get_the_ID();
    $subtitle    = get_post_meta( $post_id, '_product_subtitle', true );
    $price       = get_post_meta( $post_id, '_product_price_reference', true );
    $moq         = get_post_meta( $post_id, '_product_moq', true );
    $material    = get_post_meta( $post_id, '_product_material', true );
    $featured    = sportswholesale_is_featured( $post_id );
    $gallery_ids = sportswholesale_get_gallery_ids( $post_id );
    $cat_terms   = get_the_terms( $post_id, 'product_category' );
    $cat_name    = ( $cat_terms && ! is_wp_error( $cat_terms ) ) ? $cat_terms[0]->name : '';
    $cat_slug    = ( $cat_terms && ! is_wp_error( $cat_terms ) ) ? $cat_terms[0]->slug : '';

    // Build image array: thumbnail + gallery
    $images = [];
    if ( has_post_thumbnail() ) {
        $images[] = [
            'full' => get_the_post_thumbnail_url( $post_id, 'full' ),
            'thumb' => get_the_post_thumbnail_url( $post_id, 'thumbnail' ),
        ];
    }
    foreach ( $gallery_ids as $img_id ) {
        $full_url  = wp_get_attachment_image_url( $img_id, 'full' );
        $thumb_url = wp_get_attachment_image_url( $img_id, 'thumbnail' );
        if ( $full_url ) {
            $images[] = [
                'full'  => $full_url,
                'thumb' => $thumb_url,
            ];
        }
    }

    // Inquiry result notice
    $inquiry_status = isset( $_GET['inquiry'] ) ? sanitize_text_field( wp_unslash( $_GET['inquiry'] ) ) : '';
?>

<?php if ( 'success' === $inquiry_status ) : ?>
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i><?php esc_html_e( 'Your inquiry has been sent successfully! We will contact you soon.', 'sportswholesale' ); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="<?php esc_attr_e( 'Close', 'sportswholesale' ); ?>"></button>
        </div>
    </div>
<?php endif; ?>

<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="<?php esc_attr_e( 'Breadcrumb', 'sportswholesale' ); ?>" class="mb-3">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-decoration-none"><?php echo esc_html( sw_t( 'Home' ) ); ?></a></li>
            <li class="breadcrumb-item"><a href="<?php echo esc_url( get_post_type_archive_link( 'product' ) ); ?>" class="text-decoration-none"><?php echo esc_html( sw_t( 'Products' ) ); ?></a></li>
            <?php if ( $cat_terms && ! is_wp_error( $cat_terms ) ) : ?>
                <li class="breadcrumb-item"><a href="<?php echo esc_url( get_term_link( $cat_terms[0] ) ); ?>" class="text-decoration-none"><?php echo esc_html( sw_translate_category( $cat_name ) ); ?></a></li>
            <?php endif; ?>
            <li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Image Gallery -->
        <div class="col-lg-6">
            <div class="product-gallery">
                <!-- Main Image -->
                <div class="main-image mb-3 border rounded overflow-hidden">
                    <?php if ( ! empty( $images ) ) : ?>
                        <img id="sw-main-image" src="<?php echo esc_url( $images[0]['full'] ); ?>" alt="<?php the_title_attribute(); ?>" class="img-fluid w-100" style="max-height:500px;object-fit:contain;">
                    <?php else : ?>
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height:400px;">
                            <i class="bi bi-image text-muted" style="font-size:4rem;"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <!-- Thumbnails -->
                <?php if ( count( $images ) > 1 ) : ?>
                    <div class="d-flex gap-2 flex-wrap gallery-thumbnails">
                        <?php foreach ( $images as $idx => $img ) : ?>
                            <button type="button" class="btn p-0 border gallery-thumb<?php echo 0 === $idx ? ' active' : ''; ?>" data-full="<?php echo esc_url( $img['full'] ); ?>">
                                <img src="<?php echo esc_url( $img['thumb'] ); ?>" alt="" class="img-fluid" style="width:70px;height:70px;object-fit:cover;">
                            </button>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-lg-6">
            <?php if ( $cat_name ) : ?>
                <a href="<?php echo esc_url( get_term_link( $cat_terms[0] ) ); ?>" class="badge text-decoration-none mb-2" style="background-color:<?php echo esc_attr( sportswholesale_get_category_color( $cat_slug ) ); ?>;"><?php echo esc_html( sw_translate_category( $cat_name ) ); ?></a>
            <?php endif; ?>

            <h1 class="h3 mb-2"><?php the_title(); ?></h1>

            <?php if ( $subtitle ) : ?>
                <p class="text-muted mb-3"><?php echo esc_html( sw_translate_quantity( $subtitle ) ); ?></p>
            <?php endif; ?>

            <?php if ( $featured ) : ?>
                <span class="badge bg-warning text-dark mb-3"><i class="bi bi-star-fill me-1"></i><?php echo esc_html( sw_t( 'Featured' ) ); ?></span>
            <?php endif; ?>

            <!-- Product Details Table -->
            <div class="card border-0 bg-light mb-4">
                <div class="card-body">
                    <?php if ( $price ) : ?>
                        <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                            <span class="text-muted"><?php echo esc_html( sw_t( 'Reference Price' ) ); ?></span>
                            <span class="fw-bold text-primary fs-5"><?php echo esc_html( sw_translate_price( $price ) ); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if ( $moq ) : ?>
                        <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                            <span class="text-muted"><?php echo esc_html( sw_t( 'MOQ' ) ); ?></span>
                            <span class="fw-semibold"><?php echo esc_html( sw_translate_moq( $moq ) ); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if ( $material ) : ?>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted"><?php echo esc_html( sw_t( 'Material' ) ); ?></span>
                            <span class="fw-semibold"><?php echo esc_html( sw_translate_meta( $material ) ); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 mb-4">
                <button type="button" class="btn btn-primary btn-lg flex-grow-1 sw-inquiry-btn" data-product="<?php echo esc_attr( get_the_title() ); ?>">
                    <i class="bi bi-envelope me-2"></i><?php echo esc_html( sw_t( 'Get a Quote' ) ); ?>
                </button>
                <button type="button" class="btn btn-outline-secondary btn-lg" onclick="window.print();" title="<?php esc_attr_e( 'Print', 'sportswholesale' ); ?>">
                    <i class="bi bi-printer"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary btn-lg" id="sw-share-btn" title="<?php esc_attr_e( 'Share', 'sportswholesale' ); ?>">
                    <i class="bi bi-share"></i>
                </button>
            </div>

            <!-- Description -->
            <?php if ( get_the_content() ) : ?>
                <div class="product-description">
                    <h3 class="h5 mb-3"><?php echo esc_html( sw_t( 'Product Description' ) ); ?></h3>
                    <div class="content-area">
                        <?php the_content(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Related Products -->
    <?php
    $related_args = [
        'post_type'      => 'product',
        'posts_per_page' => 4,
        'post__not_in'   => [ $post_id ],
        'orderby'        => 'rand',
    ];

    if ( $cat_terms && ! is_wp_error( $cat_terms ) ) {
        $related_args['tax_query'] = [
            [
                'taxonomy' => 'product_category',
                'field'    => 'term_id',
                'terms'    => $cat_terms[0]->term_id,
            ],
        ];
    }

    $related = new WP_Query( $related_args );

    if ( $related->have_posts() ) : ?>
        <section class="mt-5 pt-4 border-top">
            <h2 class="h4 mb-4"><?php echo esc_html( sw_t( 'Related Products' ) ); ?></h2>
            <div class="row g-4">
                <?php while ( $related->have_posts() ) : $related->the_post(); ?>
                    <div class="col-md-6 col-lg-3">
                        <?php get_template_part( 'template-parts/content', 'product-card' ); ?>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </section>
    <?php endif; ?>
</div>

<?php endwhile; ?>

<!-- Inquiry Form Modal -->
<?php get_template_part( 'template-parts/inquiry', 'form' ); ?>

<?php get_footer(); ?>
