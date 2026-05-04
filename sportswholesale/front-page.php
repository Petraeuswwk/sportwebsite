<?php
/**
 * Front page template
 *
 * @package SportsWholesale
 */

get_header();

// Check if inquiry was submitted
$inquiry_status = isset( $_GET['inquiry'] ) ? sanitize_text_field( wp_unslash( $_GET['inquiry'] ) ) : '';
?>

<!-- Inquiry Result Notice -->
<?php if ( 'success' === $inquiry_status ) : ?>
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i><?php esc_html_e( 'Your inquiry has been sent successfully! We will contact you soon.', 'sportswholesale' ); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="<?php esc_attr_e( 'Close', 'sportswholesale' ); ?>"></button>
        </div>
    </div>
<?php elseif ( 'error' === $inquiry_status ) : ?>
    <div class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i><?php esc_html_e( 'Please fill in all required fields.', 'sportswholesale' ); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="<?php esc_attr_e( 'Close', 'sportswholesale' ); ?>"></button>
        </div>
    </div>
<?php endif; ?>

<!-- Hero Section -->
<section class="hero-section bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-7">
                <h1 class="display-4 fw-bold mb-3">
                    <?php esc_html_e( 'High-Quality Sports Equipment at Wholesale Prices', 'sportswholesale' ); ?>
                </h1>
                <p class="lead mb-4 opacity-90">
                    <?php esc_html_e( 'Your trusted B2B supplier for table tennis, badminton, tennis, pickleball, and jump ropes. Competitive pricing with OEM/ODM services available.', 'sportswholesale' ); ?>
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'product' ) ); ?>" class="btn btn-light btn-lg px-4">
                        <i class="bi bi-grid me-2"></i><?php esc_html_e( 'Browse Products', 'sportswholesale' ); ?>
                    </a>
                    <a href="#contact" class="btn btn-outline-light btn-lg px-4">
                        <i class="bi bi-envelope me-2"></i><?php esc_html_e( 'Contact Us', 'sportswholesale' ); ?>
                    </a>
                </div>
            </div>
            <div class="col-lg-5 text-center mt-4 mt-lg-0">
                <div class="hero-icon-grid">
                    <div class="hero-icon-item"><i class="bi bi-circle" style="font-size:3rem;"></i><span class="d-block small mt-1"><?php esc_html_e( 'Table Tennis', 'sportswholesale' ); ?></span></div>
                    <div class="hero-icon-item"><i class="bi bi-egg" style="font-size:3rem;"></i><span class="d-block small mt-1"><?php esc_html_e( 'Badminton', 'sportswholesale' ); ?></span></div>
                    <div class="hero-icon-item"><i class="bi bi-record-circle" style="font-size:3rem;"></i><span class="d-block small mt-1"><?php esc_html_e( 'Tennis', 'sportswholesale' ); ?></span></div>
                    <div class="hero-icon-item"><i class="bi bi-hexagon" style="font-size:3rem;"></i><span class="d-block small mt-1"><?php esc_html_e( 'Pickleball', 'sportswholesale' ); ?></span></div>
                    <div class="hero-icon-item"><i class="bi bi-arrow-repeat" style="font-size:3rem;"></i><span class="d-block small mt-1"><?php esc_html_e( 'Jump Rope', 'sportswholesale' ); ?></span></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Strip -->
<section class="bg-light py-3 border-bottom">
    <div class="container">
        <div class="row text-center g-3">
            <div class="col-6 col-md-3">
                <i class="bi bi-shield-check text-primary me-1"></i>
                <span class="small"><?php esc_html_e( 'Quality Guaranteed', 'sportswholesale' ); ?></span>
            </div>
            <div class="col-6 col-md-3">
                <i class="bi bi-truck text-primary me-1"></i>
                <span class="small"><?php esc_html_e( 'Fast Shipping', 'sportswholesale' ); ?></span>
            </div>
            <div class="col-6 col-md-3">
                <i class="bi bi-box-seam text-primary me-1"></i>
                <span class="small"><?php esc_html_e( 'OEM / ODM Service', 'sportswholesale' ); ?></span>
            </div>
            <div class="col-6 col-md-3">
                <i class="bi bi-cash-stack text-primary me-1"></i>
                <span class="small"><?php esc_html_e( 'Factory Direct Price', 'sportswholesale' ); ?></span>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-2"><?php esc_html_e( 'Product Categories', 'sportswholesale' ); ?></h2>
        <p class="text-center text-muted mb-4"><?php esc_html_e( 'Browse our wide range of sports equipment by category', 'sportswholesale' ); ?></p>

        <?php
        $categories = get_terms( [
            'taxonomy'   => 'product_category',
            'hide_empty' => false,
            'orderby'    => 'name',
        ] );

        if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) : ?>
            <div class="row g-4">
                <?php foreach ( $categories as $cat ) :
                    $color = sportswholesale_get_category_color( $cat->slug );
                    $icon  = sportswholesale_get_category_icon( $cat->slug );
                ?>
                    <div class="col-6 col-md-4 col-lg">
                        <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="text-decoration-none">
                            <div class="card category-card h-100 border-0 shadow-sm text-center p-4 transition-hover">
                                <div class="category-icon mb-3 mx-auto rounded-circle d-flex align-items-center justify-content-center" style="width:70px;height:70px;background-color:<?php echo esc_attr( $color ); ?>20;color:<?php echo esc_attr( $color ); ?>;">
                                    <i class="bi <?php echo esc_attr( $icon ); ?>" style="font-size:2rem;"></i>
                                </div>
                                <h3 class="h6 mb-1 text-dark"><?php echo esc_html( $cat->name ); ?></h3>
                                <span class="small text-muted"><?php echo esc_html( $cat->count ); ?> <?php esc_html_e( 'products', 'sportswholesale' ); ?></span>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-2"><?php esc_html_e( 'Featured Products', 'sportswholesale' ); ?></h2>
        <p class="text-center text-muted mb-4"><?php esc_html_e( 'Our most popular wholesale items', 'sportswholesale' ); ?></p>

        <?php
        $featured = new WP_Query( [
            'post_type'      => 'product',
            'posts_per_page' => 8,
            'meta_key'       => '_product_featured',
            'meta_value'     => '1',
            'orderby'        => 'date',
            'order'          => 'DESC',
        ] );

        if ( $featured->have_posts() ) : ?>
            <div class="row g-4">
                <?php while ( $featured->have_posts() ) : $featured->the_post(); ?>
                    <div class="col-md-6 col-lg-3">
                        <?php get_template_part( 'template-parts/content', 'product-card' ); ?>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
            <div class="text-center mt-4">
                <a href="<?php echo esc_url( get_post_type_archive_link( 'product' ) ); ?>" class="btn btn-primary btn-lg">
                    <?php esc_html_e( 'View All Products', 'sportswholesale' ); ?> <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        <?php else : ?>
            <p class="text-center text-muted"><?php esc_html_e( 'No featured products yet.', 'sportswholesale' ); ?></p>
        <?php endif; ?>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 cta-section text-white text-center">
    <div class="container">
        <h2 class="mb-3"><?php esc_html_e( 'Ready to Place a Wholesale Order?', 'sportswholesale' ); ?></h2>
        <p class="lead mb-4 opacity-90"><?php esc_html_e( 'Contact us today for competitive pricing and custom branding options.', 'sportswholesale' ); ?></p>
        <button type="button" class="btn btn-light btn-lg px-5 sw-inquiry-btn" data-product="">
            <i class="bi bi-envelope me-2"></i><?php esc_html_e( 'Get a Quote', 'sportswholesale' ); ?>
        </button>
    </div>
</section>

<!-- Inquiry Form Modal -->
<?php get_template_part( 'template-parts/inquiry', 'form' ); ?>

<?php get_footer(); ?>
