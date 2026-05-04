<?php
/**
 * Inquiry form handler
 *
 * @package SportsWholesale
 */

defined( 'ABSPATH' ) || exit;

/**
 * Target countries list.
 */
function sportswholesale_get_countries() {
    return apply_filters( 'sportswholesale_countries', [
        ''   => __( 'Select Country', 'sportswholesale' ),
        'SA' => __( 'Saudi Arabia', 'sportswholesale' ),
        'AE' => __( 'United Arab Emirates', 'sportswholesale' ),
        'EG' => __( 'Egypt', 'sportswholesale' ),
        'NG' => __( 'Nigeria', 'sportswholesale' ),
        'ZA' => __( 'South Africa', 'sportswholesale' ),
        'KE' => __( 'Kenya', 'sportswholesale' ),
        'GH' => __( 'Ghana', 'sportswholesale' ),
        'BR' => __( 'Brazil', 'sportswholesale' ),
        'MX' => __( 'Mexico', 'sportswholesale' ),
        'CO' => __( 'Colombia', 'sportswholesale' ),
        'AR' => __( 'Argentina', 'sportswholesale' ),
        'CL' => __( 'Chile', 'sportswholesale' ),
        'PE' => __( 'Peru', 'sportswholesale' ),
        'ES' => __( 'Spain', 'sportswholesale' ),
        'PT' => __( 'Portugal', 'sportswholesale' ),
        'IT' => __( 'Italy', 'sportswholesale' ),
        'DE' => __( 'Germany', 'sportswholesale' ),
        'FR' => __( 'France', 'sportswholesale' ),
        'GB' => __( 'United Kingdom', 'sportswholesale' ),
        'TR' => __( 'Turkey', 'sportswholesale' ),
        'IQ' => __( 'Iraq', 'sportswholesale' ),
        'JO' => __( 'Jordan', 'sportswholesale' ),
        'LB' => __( 'Lebanon', 'sportswholesale' ),
        'KW' => __( 'Kuwait', 'sportswholesale' ),
        'QA' => __( 'Qatar', 'sportswholesale' ),
        'OM' => __( 'Oman', 'sportswholesale' ),
        'BH' => __( 'Bahrain', 'sportswholesale' ),
        'IN' => __( 'India', 'sportswholesale' ),
        'PK' => __( 'Pakistan', 'sportswholesale' ),
        'BD' => __( 'Bangladesh', 'sportswholesale' ),
        'PH' => __( 'Philippines', 'sportswholesale' ),
        'ID' => __( 'Indonesia', 'sportswholesale' ),
        'MY' => __( 'Malaysia', 'sportswholesale' ),
        'TH' => __( 'Thailand', 'sportswholesale' ),
        'VN' => __( 'Vietnam', 'sportswholesale' ),
        'CN' => __( 'China', 'sportswholesale' ),
        'US' => __( 'United States', 'sportswholesale' ),
    ] );
}

/**
 * Handle inquiry form submission (via admin-post.php).
 */
add_action( 'admin_post_sw_inquiry', 'sportswholesale_handle_inquiry' );
add_action( 'admin_post_nopriv_sw_inquiry', 'sportswholesale_handle_inquiry' );

function sportswholesale_handle_inquiry() {
    if ( ! isset( $_POST['sw_inquiry_submit'] ) ) {
        return;
    }

    if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['sw_inquiry_nonce'] ?? '' ) ), 'sw_inquiry_form' ) ) {
        return;
    }

    // Honeypot check - if filled, it's a bot
    if ( ! empty( $_POST['sw_company_url'] ) ) {
        // Silent reject for bots
        wp_safe_redirect( add_query_arg( 'inquiry', 'success', wp_get_referer() ) );
        exit;
    }

    $name    = sanitize_text_field( wp_unslash( $_POST['sw_name'] ?? '' ) );
    $email   = sanitize_email( wp_unslash( $_POST['sw_email'] ?? '' ) );
    $phone   = sanitize_text_field( wp_unslash( $_POST['sw_phone'] ?? '' ) );
    $country = sanitize_text_field( wp_unslash( $_POST['sw_country'] ?? '' ) );
    $product = sanitize_text_field( wp_unslash( $_POST['sw_product'] ?? '' ) );
    $message = sanitize_textarea_field( wp_unslash( $_POST['sw_message'] ?? '' ) );

    if ( empty( $name ) || empty( $email ) ) {
        wp_safe_redirect( add_query_arg( 'inquiry', 'error', wp_get_referer() ) );
        exit;
    }

    // Save inquiry as CPT
    $inquiry_id = wp_insert_post( [
        'post_title'  => sprintf( '%s - %s', $name, $product ?: __( 'General Inquiry', 'sportswholesale' ) ),
        'post_type'   => 'inquiry',
        'post_status' => 'private',
        'post_content'=> $message,
    ] );

    if ( $inquiry_id && ! is_wp_error( $inquiry_id ) ) {
        update_post_meta( $inquiry_id, '_inquiry_name', $name );
        update_post_meta( $inquiry_id, '_inquiry_email', $email );
        update_post_meta( $inquiry_id, '_inquiry_phone', $phone );
        update_post_meta( $inquiry_id, '_inquiry_country', $country );
        update_post_meta( $inquiry_id, '_inquiry_product', $product );
    }

    // Send email to admin
    $to = get_option( 'admin_email' );
    $subject = sprintf(
        /* translators: %s: customer name */
        __( '[Sports Wholesale] New Inquiry from %s', 'sportswholesale' ),
        $name
    );
    $body = sprintf( __( 'Name: %s', 'sportswholesale' ), $name ) . "\n";
    $body .= sprintf( __( 'Email: %s', 'sportswholesale' ), $email ) . "\n";
    $body .= sprintf( __( 'Phone/WhatsApp: %s', 'sportswholesale' ), $phone ) . "\n";
    $body .= sprintf( __( 'Country: %s', 'sportswholesale' ), $country ) . "\n";
    $body .= sprintf( __( 'Interested Product: %s', 'sportswholesale' ), $product ) . "\n\n";
    $body .= sprintf( __( 'Message: %s', 'sportswholesale' ), $message ) . "\n";

    $headers = [ 'Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $name . ' <' . $email . '>' ];

    wp_mail( $to, $subject, $body, $headers );

    wp_safe_redirect( add_query_arg( 'inquiry', 'success', wp_get_referer() ) );
    exit;
}
