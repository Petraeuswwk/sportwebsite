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
                    <?php esc_html_e( 'Your trusted partner for high-quality sports equipment at competitive wholesale prices. Serving clients across the Middle East, Africa, South America, and Europe.', 'sportswholesale' ); ?>
                </p>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-4">
                <h6 class="mb-3 text-uppercase"><?php esc_html_e( 'Quick Links', 'sportswholesale' ); ?></h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-secondary text-decoration-none"><?php esc_html_e( 'Home', 'sportswholesale' ); ?></a></li>
                    <li class="mb-2"><a href="<?php echo esc_url( get_post_type_archive_link( 'product' ) ); ?>" class="text-secondary text-decoration-none"><?php esc_html_e( 'All Products', 'sportswholesale' ); ?></a></li>
                    <?php
                    $categories = get_terms( [ 'taxonomy' => 'product_category', 'hide_empty' => false ] );
                    if ( ! is_wp_error( $categories ) ) :
                        foreach ( array_slice( $categories, 0, 5 ) as $cat ) : ?>
                            <li class="mb-2"><a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="text-secondary text-decoration-none"><?php echo esc_html( $cat->name ); ?></a></li>
                        <?php endforeach;
                    endif; ?>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-3 col-md-4">
                <h6 class="mb-3 text-uppercase"><?php esc_html_e( 'Contact Us', 'sportswholesale' ); ?></h6>
                <ul class="list-unstyled small text-secondary">
                    <li class="mb-2"><i class="bi bi-envelope me-2"></i>info@example.com</li>
                    <li class="mb-2"><i class="bi bi-phone me-2"></i>+86 138 0000 0000</li>
                    <li class="mb-2"><i class="bi bi-whatsapp me-2"></i>+86 138 0000 0000</li>
                    <li class="mb-2"><i class="bi bi-geo-alt me-2"></i><?php esc_html_e( 'China', 'sportswholesale' ); ?></li>
                </ul>
            </div>

            <!-- Social Media -->
            <div class="col-lg-3 col-md-4">
                <h6 class="mb-3 text-uppercase"><?php esc_html_e( 'Follow Us', 'sportswholesale' ); ?></h6>
                <div class="d-flex gap-3">
                    <a href="#" class="text-secondary fs-5" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-secondary fs-5" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-secondary fs-5" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                    <a href="#" class="text-secondary fs-5" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                    <a href="#" class="text-secondary fs-5" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                </div>
                <p class="mt-3 small text-secondary">
                    <?php esc_html_e( 'OEM & ODM orders welcome. Custom branding available.', 'sportswholesale' ); ?>
                </p>
            </div>
        </div>

        <hr class="border-secondary my-4">

        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="small text-secondary mb-0">
                    &copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'sportswholesale' ); ?>
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="small text-secondary mb-0">
                    <?php esc_html_e( 'B2B Wholesale Sports Equipment Supplier', 'sportswholesale' ); ?>
                </p>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
