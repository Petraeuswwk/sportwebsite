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
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-3">
                    <?php echo esc_html( sw_t( 'High-Quality Sports Equipment at Wholesale Prices' ) ); ?>
                </h1>
                <p class="lead mb-4 opacity-90">
                    <?php echo esc_html( sw_t( 'Your trusted B2B supplier for table tennis, badminton, tennis, pickleball, and jump ropes. Competitive pricing with OEM/ODM services available.' ) ); ?>
                </p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'product' ) ); ?>" class="btn btn-light btn-lg px-4">
                        <i class="bi bi-grid me-2"></i><?php echo esc_html( sw_t( 'Browse Products' ) ); ?>
                    </a>
                    <a href="#contact" class="btn btn-outline-light btn-lg px-4">
                        <i class="bi bi-envelope me-2"></i><?php echo esc_html( sw_t( 'Contact Us' ) ); ?>
                    </a>
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
                <span class="small"><?php echo esc_html( sw_t( 'Quality Guaranteed' ) ); ?></span>
            </div>
            <div class="col-6 col-md-3">
                <i class="bi bi-truck text-primary me-1"></i>
                <span class="small"><?php echo esc_html( sw_t( 'Fast Shipping' ) ); ?></span>
            </div>
            <div class="col-6 col-md-3">
                <i class="bi bi-box-seam text-primary me-1"></i>
                <span class="small"><?php echo esc_html( sw_t( 'OEM / ODM Service' ) ); ?></span>
            </div>
            <div class="col-6 col-md-3">
                <i class="bi bi-cash-stack text-primary me-1"></i>
                <span class="small"><?php echo esc_html( sw_t( 'Factory Direct Price' ) ); ?></span>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-2"><?php echo esc_html( sw_t( 'Product Categories' ) ); ?></h2>
        <p class="text-center text-muted mb-4"><?php echo esc_html( sw_t( 'Browse our wide range of sports equipment by category' ) ); ?></p>

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

                    // Category images mapping
                    $category_images = [
                        'table-tennis'       => 'table-tennis.jpg',
                        'table-tennis-racket'=> 'table-tennis-racket.jpg',
                        'badminton'          => 'badminton.jpg',
                        'badminton-racket'   => 'badminton-racket.jpg',
                        'tennis'             => 'tennis.jpg',
                        'jump-rope'          => 'jump-rope.jpg',
                        'grip-strengthener'  => 'grip-strengthener.jpg',
                    ];

                    $has_local_image = isset( $category_images[ $cat->slug ] );
                    $local_image_url = $has_local_image ? get_template_directory_uri() . '/assets/images/categories/' . $category_images[ $cat->slug ] : '';

                    // Count products in this category
                    $lang_product_count = count( get_posts( [
                        'post_type'      => 'product',
                        'posts_per_page' => -1,
                        'fields'         => 'ids',
                        'tax_query'      => [
                            [
                                'taxonomy' => 'product_category',
                                'field'    => 'term_id',
                                'terms'    => $cat->term_id,
                            ],
                        ],
                    ] ) );
                ?>
                    <div class="col-6 col-md-4 col-lg">
                        <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="text-decoration-none">
                            <div class="card category-card h-100 border-0 shadow-sm overflow-hidden transition-hover">
                                <?php if ( $has_local_image ) : ?>
                                    <div class="category-card-img" style="height:140px;overflow:hidden;">
                                        <img src="<?php echo esc_url( $local_image_url ); ?>" class="card-img-top" alt="<?php echo esc_attr( sw_translate_category( $cat->name ) ); ?>" style="width:100%;height:100%;object-fit:cover;">
                                    </div>
                                <?php else : ?>
                                    <div class="d-flex align-items-center justify-content-center" style="height:140px;background-color:<?php echo esc_attr( $color ); ?>15;">
                                        <i class="bi <?php echo esc_attr( $icon ); ?>" style="font-size:3rem;color:<?php echo esc_attr( $color ); ?>;"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="card-body text-center py-3">
                                    <h3 class="h6 mb-1 text-dark"><?php echo esc_html( sw_translate_category( $cat->name ) ); ?></h3>
                                    <span class="small text-muted"><?php echo esc_html( $lang_product_count ); ?> <?php echo esc_html( sw_t( 'products' ) ); ?></span>
                                </div>
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
        <h2 class="text-center mb-2"><?php echo esc_html( sw_t( 'Featured Products' ) ); ?></h2>
        <p class="text-center text-muted mb-4"><?php echo esc_html( sw_t( 'Our most popular wholesale items' ) ); ?></p>

        <?php
        // Get products from each category (one per category)
        $categories = get_terms( [
            'taxonomy'   => 'product_category',
            'hide_empty' => true,
            'orderby'    => 'name',
        ] );

        $featured_products = [];
        if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) {
            foreach ( $categories as $cat ) {
                $product = get_posts( [
                    'post_type'      => 'product',
                    'posts_per_page' => 1,
                    'tax_query'      => [
                        [
                            'taxonomy' => 'product_category',
                            'field'    => 'term_id',
                            'terms'    => $cat->term_id,
                        ],
                    ],
                    'meta_query'     => [
                        [
                            'key'     => '_thumbnail_id',
                            'compare' => 'EXISTS',
                        ],
                    ],
                    'orderby'        => 'rand',
                ] );
                if ( ! empty( $product ) ) {
                    $featured_products[] = $product[0];
                }
            }
        }

        // If we have less than 8, add more products with images
        if ( count( $featured_products ) < 8 ) {
            $existing_ids = wp_list_pluck( $featured_products, 'ID' );
            $more_products = get_posts( [
                'post_type'      => 'product',
                'posts_per_page' => 8 - count( $featured_products ),
                'post__not_in'   => $existing_ids,
                'meta_query'     => [
                    [
                        'key'     => '_thumbnail_id',
                        'compare' => 'EXISTS',
                    ],
                ],
                'orderby'        => 'rand',
            ] );
            $featured_products = array_merge( $featured_products, $more_products );
        }

        if ( ! empty( $featured_products ) ) : ?>
            <div class="row g-4">
                <?php foreach ( $featured_products as $post ) : ?>
                    <?php setup_postdata( $post ); ?>
                    <div class="col-md-6 col-lg-3">
                        <?php get_template_part( 'template-parts/content', 'product-card' ); ?>
                    </div>
                <?php endforeach; wp_reset_postdata(); ?>
            </div>
            <div class="text-center mt-4">
                <a href="<?php echo esc_url( get_post_type_archive_link( 'product' ) ); ?>" class="btn btn-primary btn-lg">
                    <?php echo esc_html( sw_t( 'View All Products' ) ); ?> <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        <?php else : ?>
            <p class="text-center text-muted"><?php echo esc_html( sw_t( 'No featured products yet.' ) ); ?></p>
        <?php endif; ?>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 cta-section text-white text-center">
    <div class="container">
        <h2 class="mb-3"><?php echo esc_html( sw_t( 'Ready to Place a Wholesale Order?' ) ); ?></h2>
        <p class="lead mb-4 opacity-90"><?php echo esc_html( sw_t( 'Contact us today for competitive pricing and custom branding options.' ) ); ?></p>
        <button type="button" class="btn btn-light btn-lg px-5 sw-inquiry-btn" data-product="">
            <i class="bi bi-envelope me-2"></i><?php echo esc_html( sw_t( 'Get a Quote' ) ); ?>
        </button>
    </div>
</section>

<!-- Inquiry Form Modal -->
<?php get_template_part( 'template-parts/inquiry', 'form' ); ?>

<?php get_footer(); ?>
