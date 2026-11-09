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
<?php $sw_email = get_theme_mod( 'sw_contact_email', 'magicallsports@163.com' ); $sw_phone = get_theme_mod( 'sw_contact_phone', '' ); ?>
<div class="sw-topbar"><div class="container d-flex flex-wrap justify-content-between align-items-center gap-2">
    <div class="d-flex flex-wrap gap-3">
        <?php if ( $sw_email ) : ?><a href="mailto:<?php echo esc_attr( $sw_email ); ?>"><i class="bi bi-envelope me-1"></i><?php echo esc_html( $sw_email ); ?></a><?php endif; ?>
        <?php if ( $sw_phone ) : ?><a href="tel:<?php echo esc_attr( preg_replace( '/[^+0-9]/', '', $sw_phone ) ); ?>"><i class="bi bi-telephone me-1"></i><?php echo esc_html( $sw_phone ); ?></a><?php endif; ?>
    </div>
    <?php sportswholesale_language_switcher(); ?>
</div></div>
<header class="site-header sticky-top bg-white">
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

            <!-- Navigation and inquiry actions -->
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



                <div class="d-flex align-items-center gap-2 ms-lg-3">
                    <button type="button" class="btn sw-nav-cart position-relative" id="sw-open-cart" aria-label="<?php echo esc_attr( sw_t( 'Inquiry Cart' ) ); ?>" data-bs-toggle="modal" data-bs-target="#inquiryCartModal"><i class="bi bi-bag fs-5"></i><span id="sw-cart-count" class="badge rounded-pill bg-danger">0</span></button>
                    <button type="button" class="btn btn-danger sw-inquiry-btn" data-product=""><?php echo esc_html( sw_t( 'Get a Quote' ) ); ?></button>
                </div>
            </div>
        </div>
    </nav>
</header>

<main id="main-content" class="site-content">
