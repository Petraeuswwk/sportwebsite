<?php
/**
 * Header template
 *
 * @package SportsWholesale
 */

defined( 'ABSPATH' ) || exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header sticky-top bg-white shadow-sm">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <!-- Logo / Site Title -->
            <a class="navbar-brand d-flex align-items-center" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <?php if ( has_custom_logo() ) : ?>
                    <?php the_custom_logo(); ?>
                    <span class="brand-name ms-2">MAGICALL</span>
                <?php else : ?>
                    <span class="fw-bold fs-5 text-primary">
                        <i class="bi bi-trophy me-2"></i><?php bloginfo( 'name' ); ?>
                    </span>
                <?php endif; ?>
            </a>

            <!-- Mobile toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'sportswholesale' ); ?>">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation + Language Switcher -->
            <div class="collapse navbar-collapse" id="mainNav">
                <?php
                wp_nav_menu( [
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'navbar-nav me-auto mb-2 mb-lg-0',
                    'fallback_cb'    => 'sportswholesale_fallback_menu',
                    'depth'          => 2,
                    'walker'         => class_exists( 'Bootstrap_5_Nav_Walker' ) ? new Bootstrap_5_Nav_Walker() : null,
                ] );
                ?>



                <!-- Language Switcher -->
                <div class="ms-lg-3">
                    <?php sportswholesale_language_switcher(); ?>
                </div>
            </div>
        </div>
    </nav>
</header>

<main id="main-content" class="site-content">
