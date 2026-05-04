<?php
/**
 * The main template file (fallback)
 *
 * @package SportsWholesale
 */

get_header();
?>

<main id="main-content" class="site-main py-5">
    <div class="container">
        <?php if ( have_posts() ) : ?>
            <div class="row g-4">
                <?php while ( have_posts() ) : the_post(); ?>
                    <div class="col-md-6 col-lg-4">
                        <article id="post-<?php the_ID(); ?>" <?php post_class( 'card h-100' ); ?>>
                            <?php if ( has_post_thumbnail() ) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail( 'medium_large', [ 'class' => 'card-img-top' ] ); ?>
                                </a>
                            <?php endif; ?>
                            <div class="card-body">
                                <h2 class="card-title h5">
                                    <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark"><?php the_title(); ?></a>
                                </h2>
                                <div class="card-text"><?php the_excerpt(); ?></div>
                            </div>
                        </article>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="mt-4">
                <?php the_posts_pagination(); ?>
            </div>
        <?php else : ?>
            <div class="text-center py-5">
                <h2><?php esc_html_e( '暂无内容', 'sportswholesale' ); ?></h2>
                <p><?php esc_html_e( '暂时没有可显示的文章。', 'sportswholesale' ); ?></p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
