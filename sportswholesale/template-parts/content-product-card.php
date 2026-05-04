<?php
/**
 * Template part: Product card
 *
 * @package SportsWholesale
 */

defined( 'ABSPATH' ) || exit;

$post_id     = get_the_ID();
$subtitle    = get_post_meta( $post_id, '_product_subtitle', true );
$price       = get_post_meta( $post_id, '_product_price_reference', true );
$moq         = get_post_meta( $post_id, '_product_moq', true );
$material    = get_post_meta( $post_id, '_product_material', true );
$is_featured = sportswholesale_is_featured( $post_id );
$cat_terms   = get_the_terms( $post_id, 'product_category' );
$cat_name    = ( $cat_terms && ! is_wp_error( $cat_terms ) ) ? $cat_terms[0]->name : '';
$cat_slug    = ( $cat_terms && ! is_wp_error( $cat_terms ) ) ? $cat_terms[0]->slug : '';
$cat_color   = sportswholesale_get_category_color( $cat_slug );
?>
<div class="card product-card h-100 border-0 shadow-sm position-relative">
    <?php if ( $is_featured ) : ?>
        <span class="badge bg-warning text-dark position-absolute top-0 start-0 z-1 m-2"><?php esc_html_e( 'Featured', 'sportswholesale' ); ?></span>
    <?php endif; ?>

    <?php if ( has_post_thumbnail() ) : ?>
        <a href="<?php the_permalink(); ?>" class="product-card-img-link">
            <?php the_post_thumbnail( 'product-card', [ 'class' => 'card-img-top', 'style' => 'height:220px;object-fit:cover;' ] ); ?>
        </a>
    <?php else : ?>
        <a href="<?php the_permalink(); ?>" class="product-card-img-link">
            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:220px;">
                <i class="bi bi-image text-muted" style="font-size:3rem;"></i>
            </div>
        </a>
    <?php endif; ?>

    <div class="card-body d-flex flex-column">
        <?php if ( $cat_name ) : ?>
            <a href="<?php echo esc_url( get_term_link( $cat_terms[0] ) ); ?>" class="badge text-decoration-none mb-2 align-self-start" style="background-color:<?php echo esc_attr( $cat_color ); ?>;"><?php echo esc_html( $cat_name ); ?></a>
        <?php endif; ?>

        <h3 class="card-title h6 mb-1">
            <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark stretched-link-name"><?php the_title(); ?></a>
        </h3>

        <?php if ( $subtitle ) : ?>
            <p class="card-text small text-muted mb-2"><?php echo esc_html( $subtitle ); ?></p>
        <?php endif; ?>

        <div class="mt-auto">
            <?php if ( $price ) : ?>
                <div class="fw-bold text-primary mb-1"><?php echo esc_html( $price ); ?></div>
            <?php endif; ?>
            <?php if ( $moq ) : ?>
                <div class="small text-muted mb-2"><?php esc_html_e( 'MOQ:', 'sportswholesale' ); ?> <?php echo esc_html( $moq ); ?></div>
            <?php endif; ?>
            <button type="button" class="btn btn-outline-primary btn-sm w-100 sw-inquiry-btn"
                    data-product="<?php echo esc_attr( get_the_title() ); ?>">
                <i class="bi bi-envelope me-1"></i><?php esc_html_e( 'Inquire Now', 'sportswholesale' ); ?>
            </button>
        </div>
    </div>
</div>
