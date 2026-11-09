<?php
/**
 * Footer template
 *
 * @package SportsWholesale
 */

defined( 'ABSPATH' ) || exit;
?>
</main><!-- #main-content -->

<footer id="contact" class="site-footer bg-dark text-light pt-5 pb-4 mt-5">
    <div class="container">
        <div class="row g-4">
            <!-- Company Info -->
            <div class="col-lg-4">
                <h5 class="mb-3">
                    <?php if ( has_custom_logo() ) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <i class="bi bi-trophy me-2"></i><?php bloginfo( 'name' ); ?>
                    <?php endif; ?>
                </h5>
                <p class="text-secondary small">
                    <?php echo esc_html( sw_t( 'Browse our sports equipment catalog and send a product list for a wholesale quote.' ) ); ?>
                </p>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-4">
                <h6 class="mb-3 text-uppercase"><?php echo esc_html( sw_t( 'Quick Links' ) ); ?></h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-secondary text-decoration-none"><?php echo esc_html( sw_t( 'Home' ) ); ?></a></li>
                    <li class="mb-2"><a href="<?php echo esc_url( get_post_type_archive_link( 'product' ) ); ?>" class="text-secondary text-decoration-none"><?php echo esc_html( sw_t( 'All Products' ) ); ?></a></li>
                    <?php
                    $categories = get_terms( [ 'taxonomy' => 'product_category', 'hide_empty' => false ] );
                    if ( ! is_wp_error( $categories ) ) :
                        foreach ( array_slice( $categories, 0, 5 ) as $cat ) : ?>
                            <li class="mb-2"><a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="text-secondary text-decoration-none"><?php echo esc_html( sw_translate_category( $cat->name ) ); ?></a></li>
                        <?php endforeach;
                    endif; ?>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-3 col-md-4">
                <h6 class="mb-3 text-uppercase"><?php echo esc_html( sw_t( 'Contact Us' ) ); ?></h6>
                <ul class="list-unstyled small text-secondary">
                    <?php $sw_email = get_theme_mod( 'sw_contact_email', 'magicallsports@163.com' ); $sw_phone = get_theme_mod( 'sw_contact_phone', '' ); $sw_whatsapp = get_theme_mod( 'sw_contact_whatsapp', '' ); ?>
                    <?php if ( $sw_email ) : ?><li class="mb-2"><i class="bi bi-envelope me-2"></i><a href="mailto:<?php echo esc_attr( $sw_email ); ?>"><?php echo esc_html( $sw_email ); ?></a></li><?php endif; ?>
                    <?php if ( $sw_phone ) : ?><li class="mb-2"><i class="bi bi-phone me-2"></i><?php echo esc_html( $sw_phone ); ?></li><?php endif; ?>
                    <?php if ( $sw_whatsapp ) : ?><li class="mb-2"><i class="bi bi-whatsapp me-2"></i><?php echo esc_html( $sw_whatsapp ); ?></li><?php endif; ?>
                    <li class="mb-2"><i class="bi bi-geo-alt me-2"></i><?php echo esc_html( sw_t( 'China' ) ); ?></li>
                </ul>
            </div>

            <!-- Social Media -->
            <div class="col-lg-3 col-md-4">
                <h6 class="mb-3 text-uppercase"><?php echo esc_html( sw_t( 'Wholesale inquiries' ) ); ?></h6>
                <div class="d-flex gap-3">
                    <?php if ( $sw_whatsapp ) : ?><a href="<?php echo esc_url( 'https://wa.me/' . preg_replace( '/\D/', '', $sw_whatsapp ) . '?text=' . rawurlencode( 'Hello MAGICALL, I would like to ask about your wholesale products.' ) ); ?>" class="text-secondary fs-5" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a><?php endif; ?>
                </div>
                <p class="mt-3 small text-secondary">
                    <?php echo esc_html( sw_t( 'OEM & ODM orders welcome. Custom branding available.' ) ); ?>
                </p>
            </div>
        </div>

        <hr class="border-secondary my-4">

        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="small text-secondary mb-0">
                    &copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php echo esc_html( sw_t( 'All rights reserved.' ) ); ?>
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="small text-secondary mb-0">
                    <?php echo esc_html( sw_t( 'B2B Wholesale Sports Equipment Supplier' ) ); ?>
                </p>
            </div>
        </div>
    </div>
</footer>
<?php if ( $sw_whatsapp ) : ?>
    <?php $sw_wa_text = is_singular( 'product' ) ? 'Hello MAGICALL, I would like to ask about ' . get_the_title() . '.' : 'Hello MAGICALL, I would like to ask about your wholesale products.'; ?>
    <a class="sw-whatsapp-float" href="<?php echo esc_url( 'https://wa.me/' . preg_replace( '/\D/', '', $sw_whatsapp ) . '?text=' . rawurlencode( $sw_wa_text ) ); ?>" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
<?php endif; ?>
<?php get_template_part( 'template-parts/inquiry', 'form' ); ?>

<?php wp_footer(); ?>
</body>
</html>
