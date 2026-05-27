<?php
/**
 * Product archive template
 *
 * @package SportsWholesale
 */

get_header();

$current_cat = get_queried_object();
$is_tax      = is_tax( 'product_category' );
$cat_name    = $is_tax ? $current_cat->name : '';
$cat_desc    = $is_tax ? $current_cat->description : '';

// Sorting
$orderby  = isset( $_GET['orderby'] ) ? sanitize_text_field( wp_unslash( $_GET['orderby'] ) ) : 'date';
$order    = 'DESC';
$meta_key = '';

switch ( $orderby ) {
    case 'price_low':
        $meta_key = '_product_price_reference';
        $order    = 'ASC';
        $orderby  = 'meta_value';
        break;
    case 'price_high':
        $meta_key = '_product_price_reference';
        $order    = 'DESC';
        $orderby  = 'meta_value';
        break;
    case 'title':
        $orderby = 'title';
        $order   = 'ASC';
        break;
    default:
        $orderby = 'date';
        $order   = 'DESC';
}

$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

$args = [
    'post_type'      => 'product',
    'posts_per_page' => 12,
    'paged'          => $paged,
    'orderby'        => $orderby,
    'order'          => $order,
];

if ( $meta_key ) {
    $args['meta_key'] = $meta_key;
}

if ( $is_tax ) {
    $args['tax_query'] = [
        [
            'taxonomy' => 'product_category',
            'field'    => 'term_id',
            'terms'    => $current_cat->term_id,
        ],
    ];
}

// Material filter
if ( ! empty( $_GET['material'] ) ) {
    $args['meta_query'][] = [
        'key'     => '_product_material',
        'value'   => sanitize_text_field( wp_unslash( $_GET['material'] ) ),
        'compare' => 'LIKE',
    ];
}

$query = new WP_Query( $args );

// Get unique materials for filter
$all_materials = get_posts( [
    'post_type'      => 'product',
    'posts_per_page' => -1,
    'fields'         => 'ids',
    'meta_key'       => '_product_material',
] );
$materials = [];
foreach ( $all_materials as $pid ) {
    $m = get_post_meta( $pid, '_product_material', true );
    if ( $m && ! in_array( $m, $materials, true ) ) {
        $materials[] = $m;
    }
}
sort( $materials );
?>

<!-- Inquiry Result Notice -->
<?php
$inquiry_status = isset( $_GET['inquiry'] ) ? sanitize_text_field( wp_unslash( $_GET['inquiry'] ) ) : '';
if ( 'success' === $inquiry_status ) : ?>
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i><?php esc_html_e( 'Your inquiry has been sent successfully! We will contact you soon.', 'sportswholesale' ); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="<?php esc_attr_e( 'Close', 'sportswholesale' ); ?>"></button>
        </div>
    </div>
<?php endif; ?>

<div class="container py-4">
    <!-- Page Header -->
    <div class="mb-4">
        <?php if ( $is_tax ) : ?>
            <h1 class="h3 mb-2"><?php echo esc_html( sw_translate_category( $cat_name ) ); ?></h1>
            <?php if ( $cat_desc ) : ?>
                <p class="text-muted"><?php echo esc_html( $cat_desc ); ?></p>
            <?php endif; ?>
        <?php else : ?>
            <h1 class="h3 mb-2"><?php echo esc_html( sw_t( 'All Products' ) ); ?></h1>
            <p class="text-muted"><?php echo esc_html( sw_t( 'Browse our complete catalog of wholesale sports equipment' ) ); ?></p>
        <?php endif; ?>
    </div>

    <!-- Filters & Sort Bar -->
    <div class="row g-3 mb-4 align-items-end">
        <div class="col-md-4">
            <form method="get" action="" class="d-flex gap-2">
                <?php if ( $is_tax ) : ?>
                    <input type="hidden" name="product_category" value="<?php echo esc_attr( $current_cat->slug ); ?>">
                <?php endif; ?>
                <select name="orderby" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="date" <?php selected( $orderby, 'date' ); ?>><?php echo esc_html( sw_t( 'Sort: Newest' ) ); ?></option>
                    <option value="price_low" <?php selected( $orderby, 'price_low' ); ?>><?php echo esc_html( sw_t( 'Sort: Price Low to High' ) ); ?></option>
                    <option value="price_high" <?php selected( $orderby, 'price_high' ); ?>><?php echo esc_html( sw_t( 'Sort: Price High to Low' ) ); ?></option>
                    <option value="title" <?php selected( $orderby, 'title' ); ?>><?php echo esc_html( sw_t( 'Sort: Name A-Z' ) ); ?></option>
                </select>
            </form>
        </div>
        <div class="col-md-4">
            <?php if ( ! empty( $materials ) ) : ?>
                <form method="get" action="">
                    <?php if ( $is_tax ) : ?>
                        <input type="hidden" name="product_category" value="<?php echo esc_attr( $current_cat->slug ); ?>">
                    <?php endif; ?>
                    <select name="material" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value=""><?php echo esc_html( sw_t( 'Filter by Material' ) ); ?></option>
                        <?php foreach ( $materials as $m ) : ?>
                            <option value="<?php echo esc_attr( $m ); ?>" <?php selected( isset( $_GET['material'] ) ? sanitize_text_field( wp_unslash( $_GET['material'] ) ) : '', $m ); ?>><?php echo esc_html( sw_translate_meta( $m ) ); ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>
            <?php endif; ?>
        </div>
        <div class="col-md-4 text-end">
            <span class="text-muted small"><?php echo esc_html( $query->found_posts ); ?> <?php echo esc_html( sw_t( 'products found' ) ); ?></span>
        </div>
    </div>

    <!-- Product Grid -->
    <?php if ( $query->have_posts() ) : ?>
        <div class="row g-4">
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <?php get_template_part( 'template-parts/content', 'product-card' ); ?>
                </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>

        <!-- Pagination -->
        <div class="mt-4 text-center">
            <?php
            echo '<div class="page-links">';
            echo paginate_links( [
                'total'     => $query->max_num_pages,
                'current'   => $paged,
                'prev_text' => '&laquo;',
                'next_text' => '&raquo;',
            ] );
            echo '</div>';
            ?>
        </div>
    <?php else : ?>
        <div class="text-center py-5">
            <i class="bi bi-inbox text-muted" style="font-size:3rem;"></i>
            <p class="mt-3 text-muted"><?php echo esc_html( sw_t( 'No products found matching your criteria.' ) ); ?></p>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'product' ) ); ?>" class="btn btn-outline-primary"><?php echo esc_html( sw_t( 'Clear Filters' ) ); ?></a>
        </div>
    <?php endif; ?>
</div>

<!-- Inquiry Form Modal -->
<?php get_template_part( 'template-parts/inquiry', 'form' ); ?>

<?php get_footer(); ?>
