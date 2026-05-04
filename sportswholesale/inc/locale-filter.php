<?php
/**
 * Locale filter and translation loading
 *
 * Hooks into WordPress locale to dynamically set the language
 * based on Cookie or GET parameter.
 *
 * @package SportsWholesale
 */

defined( 'ABSPATH' ) || exit;

/**
 * Available languages configuration.
 */
function sportswholesale_get_languages() {
    return apply_filters( 'sportswholesale_languages', [
        'en_US' => [
            'name'  => 'English',
            'dir'   => 'ltr',
            'label' => 'EN',
        ],
        'zh_CN' => [
            'name'  => '简体中文',
            'dir'   => 'ltr',
            'label' => '中',
        ],
        'ar' => [
            'name'  => 'العربية',
            'dir'   => 'rtl',
            'label' => 'ع',
        ],
        'es_ES' => [
            'name'  => 'Español',
            'dir'   => 'ltr',
            'label' => 'ES',
        ],
    ] );
}

/**
 * Get the current active language code.
 */
function sportswholesale_get_current_lang() {
    static $current = null;
    if ( null !== $current ) {
        return $current;
    }

    $languages = sportswholesale_get_languages();

    // 1. Check GET parameter
    if ( isset( $_GET['lang'] ) ) {
        $lang = sanitize_text_field( wp_unslash( $_GET['lang'] ) );
        // Map short codes to full locale
        $map = [ 'zh' => 'zh_CN', 'en' => 'en_US', 'ar' => 'ar', 'es' => 'es_ES' ];
        if ( isset( $map[ $lang ] ) ) {
            $lang = $map[ $lang ];
        }
        if ( array_key_exists( $lang, $languages ) ) {
            setcookie( 'sportswholesale_lang', $lang, time() + 30 * DAY_IN_SECONDS, '/' );
            $_COOKIE['sportswholesale_lang'] = $lang;
            $current = $lang;
            return $current;
        }
    }

    // 2. Check Cookie
    if ( isset( $_COOKIE['sportswholesale_lang'] ) ) {
        $lang = sanitize_text_field( wp_unslash( $_COOKIE['sportswholesale_lang'] ) );
        if ( array_key_exists( $lang, $languages ) ) {
            $current = $lang;
            return $current;
        }
    }

    // 3. Default: English
    $current = 'en_US';
    return $current;
}

/**
 * Filter the WordPress locale.
 */
add_filter( 'locale', function ( $locale ) {
    return sportswholesale_get_current_lang();
} );

/**
 * Load theme textdomain after locale is set.
 */
add_action( 'after_setup_theme', function () {
    load_theme_textdomain( 'sportswholesale', get_template_directory() . '/languages' );
} );

/**
 * Output language attributes on <html> tag.
 */
add_filter( 'language_attributes', function ( $output ) {
    $lang    = sportswholesale_get_current_lang();
    $langs   = sportswholesale_get_languages();
    $dir     = isset( $langs[ $lang ] ) ? $langs[ $lang ]['dir'] : 'ltr';
    $output  = 'lang="' . esc_attr( $lang ) . '" dir="' . esc_attr( $dir ) . '"';
    return $output;
} );
