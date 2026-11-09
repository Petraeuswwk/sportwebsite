<?php
/** Front page matching the approved V5 interaction design. */
get_header();
$asset = get_template_directory_uri() . '/assets/images/';
$archive = get_post_type_archive_link( 'product' );
$cats = get_terms( [ 'taxonomy' => 'product_category', 'hide_empty' => true, 'orderby' => 'name' ] );
if ( is_wp_error( $cats ) ) { $cats = []; }
$product_count = (int) wp_count_posts( 'product' )->publish;
?>
<section class="hero-v3">
  <div class="container"><div class="row align-items-center g-5">
    <div class="col-lg-6">
      <span class="hero-badge"><i class="bi bi-globe2"></i><?php echo esc_html( sw_t( 'Wholesale sports equipment from Yiwu, China' ) ); ?></span>
      <h1 class="hero-title mt-3"><?php echo esc_html( sw_t( 'Racket Sports Wholesale' ) ); ?><span class="text-accent"><?php echo esc_html( sw_t( 'for Global Buyers' ) ); ?></span></h1>
      <p class="lead hero-lead mb-4"><?php echo esc_html( sw_t( 'Explore badminton, table tennis, tennis and fitness products. Build a mixed inquiry and ask us about carton pricing, packing and OEM options.' ) ); ?></p>
      <div class="d-flex flex-wrap gap-3"><a class="btn btn-primary btn-lg px-4" href="#products"><?php echo esc_html( sw_t( 'Browse Products' ) ); ?></a><button class="btn btn-outline-primary btn-lg px-4 sw-inquiry-btn" data-product="" type="button"><?php echo esc_html( sw_t( 'Get a Quote' ) ); ?></button></div>
    </div>
    <div class="col-lg-6 hero-visual"><div class="hero-carousel carousel slide" id="swHeroCarousel" data-bs-ride="carousel" data-bs-interval="4000" data-bs-pause="hover">
      <div class="carousel-indicators"><?php for ( $i = 0; $i < 3; $i++ ) : ?><button type="button" data-bs-target="#swHeroCarousel" data-bs-slide-to="<?php echo esc_attr( $i ); ?>" class="<?php echo 0 === $i ? 'active' : ''; ?>" aria-label="<?php echo esc_attr( 'Slide ' . ( $i + 1 ) ); ?>" <?php echo 0 === $i ? 'aria-current="true"' : ''; ?>></button><?php endfor; ?></div>
      <div class="carousel-inner">
        <?php foreach ( [ [ 'hero-badminton-court.jpg', 'Badminton court' ], [ 'hero-badminton-player.jpg', 'Badminton player' ], [ 'hero-tennis-court.jpg', 'Tennis court' ] ] as $i => $slide ) : ?>
        <div class="carousel-item <?php echo 0 === $i ? 'active' : ''; ?>"><img src="<?php echo esc_url( $asset . 'hero/' . $slide[0] ); ?>" alt="<?php echo esc_attr( $slide[1] ); ?>"></div>
        <?php endforeach; ?>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#swHeroCarousel" data-bs-slide="prev" aria-label="Previous"><span class="carousel-control-prev-icon"></span></button>
      <button class="carousel-control-next" type="button" data-bs-target="#swHeroCarousel" data-bs-slide="next" aria-label="Next"><span class="carousel-control-next-icon"></span></button>
      <span class="hero-chip"><span class="hero-chip-dot"></span><?php echo esc_html( sw_t( 'MOQ shown on every product' ) ); ?></span>
    </div></div>
  </div></div>
</section>
<section class="py-5" id="about"><div class="container"><div class="row text-center g-4 sw-stats">
  <div class="col-6 col-md-3"><div class="sw-stat-number"><span class="count-up" data-count="<?php echo esc_attr( $product_count ); ?>"><?php echo esc_html( $product_count ); ?></span></div><div class="sw-stat-label"><?php echo esc_html( sw_t( 'Products' ) ); ?></div></div>
  <div class="col-6 col-md-3"><div class="sw-stat-number"><span class="count-up" data-count="<?php echo esc_attr( count( $cats ) ); ?>"><?php echo esc_html( count( $cats ) ); ?></span></div><div class="sw-stat-label"><?php echo esc_html( sw_t( 'Categories' ) ); ?></div></div>
  <div class="col-6 col-md-3"><div class="sw-stat-number"><span class="count-up" data-count="4">4</span></div><div class="sw-stat-label"><?php echo esc_html( sw_t( 'Languages' ) ); ?></div></div>
  <div class="col-6 col-md-3"><div class="sw-stat-number">OEM</div><div class="sw-stat-label"><?php echo esc_html( sw_t( 'On request' ) ); ?></div></div>
</div></div></section>
<section class="py-5 sw-categories"><div class="container"><h2 class="text-center mb-2"><?php echo esc_html( sw_t( 'Product Categories' ) ); ?></h2><p class="text-center text-muted mb-4"><?php echo esc_html( sw_t( 'Browse by sport and product type' ) ); ?></p><div class="row g-4">
<?php foreach ( $cats as $cat ) :
  $img = get_template_directory() . '/assets/images/categories/' . $cat->slug . '.jpg';
  $url = file_exists( $img ) ? $asset . 'categories/' . $cat->slug . '.jpg' : '';
?>
<div class="col-6 col-md-4 col-lg sw-category-cell"><a href="<?php echo esc_url( add_query_arg( 'category', $cat->slug, $archive ) ); ?>" class="text-decoration-none"><div class="card category-card h-100 border-0 shadow-sm overflow-hidden">
<div class="category-card-img"><?php if ( $url ) : ?><img src="<?php echo esc_url( $url ); ?>" alt="<?php echo esc_attr( sw_translate_category( $cat->name ) ); ?>" loading="lazy"><?php else : ?><div class="sw-category-placeholder"><i class="bi <?php echo esc_attr( sportswholesale_get_category_icon( $cat->slug ) ); ?>"></i></div><?php endif; ?></div>
<div class="card-body text-center py-3"><h3 class="h6 mb-1 text-dark"><?php echo esc_html( sw_translate_category( $cat->name ) ); ?></h3><span class="small text-muted"><?php echo esc_html( $cat->count ); ?> <?php echo esc_html( sw_t( 'products' ) ); ?></span></div></div></a></div>
<?php endforeach; ?></div></div></section>
<section class="py-5 bg-light" id="products"><div class="container"><h2 class="text-center mb-2"><?php echo esc_html( sw_t( 'Featured Products' ) ); ?></h2><p class="text-center text-muted mb-4"><?php echo esc_html( sw_t( 'Compare products, pack sizes and MOQ' ) ); ?></p>
<div class="d-flex flex-wrap justify-content-center gap-2 mb-4 sw-filters"><button type="button" class="btn btn-primary rounded-pill px-4 js-filter active" data-filter="all"><?php echo esc_html( sw_t( 'All' ) ); ?></button>
<?php foreach ( $cats as $cat ) : ?><button type="button" class="btn btn-outline-primary rounded-pill px-4 js-filter" data-filter="<?php echo esc_attr( $cat->slug ); ?>"><?php echo esc_html( sw_translate_category( $cat->name ) ); ?></button><?php endforeach; ?></div>
<div class="row g-4" id="sw-featured-grid">
<?php
$featured_ids = [];
foreach ( $cats as $cat ) {
    $category_products = get_posts( [ 'post_type' => 'product', 'posts_per_page' => 3, 'fields' => 'ids', 'tax_query' => [ [ 'taxonomy' => 'product_category', 'field' => 'term_id', 'terms' => $cat->term_id ] ], 'meta_query' => [ [ 'key' => '_thumbnail_id', 'compare' => 'EXISTS' ] ], 'orderby' => 'date', 'order' => 'DESC' ] );
    $featured_ids = array_merge( $featured_ids, $category_products );
}
$featured = new WP_Query( [ 'post_type' => 'product', 'posts_per_page' => count( $featured_ids ), 'post__in' => $featured_ids ?: [ 0 ], 'orderby' => 'post__in' ] );
while ( $featured->have_posts() ) : $featured->the_post(); $slugs = sportswholesale_get_product_categories(); ?>
<div class="col-md-6 col-lg-3 product-cell" data-group="<?php echo esc_attr( implode( ' ', $slugs ) ); ?>"><?php get_template_part( 'template-parts/content', 'product-card' ); ?></div>
<?php endwhile; wp_reset_postdata(); ?>
</div><p class="text-center text-muted d-none" id="sw-filter-empty"><?php echo esc_html( sw_t( 'No products in this selection.' ) ); ?></p><div class="text-center mt-4"><a class="btn btn-primary btn-lg" href="<?php echo esc_url( $archive ); ?>"><?php echo esc_html( sw_t( 'View All Products' ) ); ?></a></div>
</div></section>
<section class="factory-band"><div class="container"><div class="d-flex flex-wrap justify-content-between align-items-end mb-4"><div><div class="band-kicker"><?php echo esc_html( sw_t( 'FACTORY & WAREHOUSE' ) ); ?></div><h2 class="text-white mb-2"><?php echo esc_html( sw_t( 'Ask to see packing and dispatch' ) ); ?></h2><p class="band-sub mb-0"><?php echo esc_html( sw_t( 'We work with partner factories. Request a video call to discuss products, packing and shipping.' ) ); ?></p></div><button type="button" class="btn btn-light sw-inquiry-btn mt-3 mt-lg-0" data-product="" data-message="Factory video call request"><?php echo esc_html( sw_t( 'Book a factory video call' ) ); ?></button></div>
<div class="row g-3"><div class="col-lg-6"><figure class="band-photo band-photo-lg"><img src="<?php echo esc_url( $asset . 'factory/warehouse.jpg' ); ?>" alt="Warehouse reference image" loading="lazy"><figcaption><?php echo esc_html( sw_t( 'Warehouse' ) ); ?></figcaption></figure></div><div class="col-lg-6"><div class="row g-3">
<?php foreach ( [ [ 'stringing.jpg', 'Stringing & quality check' ], [ 'packing.jpg', 'Packing line' ], [ 'loading.jpg', 'Container loading' ] ] as $photo ) : ?><div class="col-sm-6"><figure class="band-photo"><img src="<?php echo esc_url( $asset . 'factory/' . $photo[0] ); ?>" alt="<?php echo esc_attr( $photo[1] . ' reference image' ); ?>" loading="lazy"><figcaption><?php echo esc_html( sw_t( $photo[1] ) ); ?></figcaption></figure></div><?php endforeach; ?>
</div></div></div><div class="d-flex flex-wrap gap-2 mt-4"><?php foreach ( [ 'Southeast Asia', 'Middle East', 'Central Asia', 'South America' ] as $market ) : ?><span class="sw-market-chip"><?php echo esc_html( sw_t( $market ) ); ?></span><?php endforeach; ?></div><p class="small text-white-50 mt-3 mb-0"><?php echo esc_html( sw_t( 'Reference images. Factory photos to be replaced with verified partner photos before launch.' ) ); ?></p></div></section>
<section class="py-5 sw-steps"><div class="container"><h2 class="text-center mb-4"><?php echo esc_html( sw_t( 'How ordering works' ) ); ?></h2><div class="row g-4">
<?php foreach ( [ [ 'Choose & inquire', 'Add products and quantities to your inquiry.' ], [ 'Confirm a quote', 'We confirm pricing, packing and terms with you.' ], [ 'Sample or produce', 'Review samples or confirm production details.' ], [ 'Pack & ship', 'Confirm packing and shipment arrangements.' ] ] as $i => $step ) : ?><div class="col-md-6 col-lg-3"><div class="step-card"><div class="step-num"><?php echo esc_html( $i + 1 ); ?></div><h3 class="h6 mb-2"><?php echo esc_html( sw_t( $step[0] ) ); ?></h3><p><?php echo esc_html( sw_t( $step[1] ) ); ?></p></div></div><?php endforeach; ?>
</div></div></section>
<section class="py-5 bg-light sw-faq"><div class="container" style="max-width:860px"><h2 class="text-center mb-4"><?php echo esc_html( sw_t( 'Questions buyers ask us' ) ); ?></h2><div class="accordion" id="faqAcc">
<?php foreach ( [ [ 'What is the minimum order?', 'MOQ varies by product. Check the product page and inquire to confirm carton units.' ], [ 'How do payment and shipping work?', 'We confirm payment and EXW or FOB terms in your quotation.' ], [ 'How long is the lead time?', 'Lead time depends on product, stock and customization. Ask for a current estimate.' ], [ 'Can you print our logo (OEM)?', 'Logo printing is available on request for volume orders. Send your artwork to discuss options.' ], [ 'Can I request samples?', 'Ask us about sample availability and shipping for the products you need.' ] ] as $i => $item ) : $id = 'faq' . $i; ?><div class="accordion-item"><h3 class="accordion-header"><button class="accordion-button <?php echo $i ? 'collapsed' : ''; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo esc_attr( $id ); ?>" aria-expanded="<?php echo $i ? 'false' : 'true'; ?>"><?php echo esc_html( sw_t( $item[0] ) ); ?></button></h3><div class="accordion-collapse collapse <?php echo $i ? '' : 'show'; ?>" id="<?php echo esc_attr( $id ); ?>" data-bs-parent="#faqAcc"><div class="accordion-body"><?php echo esc_html( sw_t( $item[1] ) ); ?></div></div></div><?php endforeach; ?>
</div></div></section>
<section class="py-5 cta-section text-white text-center"><div class="container"><h2 class="mb-3"><?php echo esc_html( sw_t( 'Ready to Place a Wholesale Order?' ) ); ?></h2><p class="lead mb-4"><?php echo esc_html( sw_t( 'Send your product list and quantities for a tailored quote.' ) ); ?></p><button type="button" class="btn btn-light btn-lg sw-inquiry-btn" data-product=""><?php echo esc_html( sw_t( 'Get a Quote' ) ); ?></button></div></section>
<?php get_footer(); ?>
