<?php
/**
 * Plugin Name: Airborne M-Pesa Gateway
 * Plugin URI:  https://github.com/benstarbwoy/airborne-mpesa-
 * Description: WooCommerce payment gateway that integrates with Africa's Talking (M-Pesa / mobile payments). Enter your Africa's Talking credentials in WooCommerce > Settings > Payments > Airborne M-Pesa.
 * Version:     1.0.0
 * Author:      Benstarbwoy
 * Text Domain: airborne-mpesa
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'AIRBORNE_M_PESA_PATH', plugin_dir_path( __FILE__ ) );
define( 'AIRBORNE_M_PESA_URL', plugin_dir_url( __FILE__ ) );

/**
 * Required files
 */
if ( ! class_exists( 'WC_Payment_Gateway' ) ) {
    // WooCommerce is required
    add_action( 'admin_notices', function() {
        echo '<div class="error"><p><strong>Airborne M-Pesa:</strong> WooCommerce is required and must be active for this plugin to work.</p></div>';
    } );
    return;
}

require_once AIRBORNE_M_PESA_PATH . 'includes/africastalking.php';
require_once AIRBORNE_M_PESA_PATH . 'includes/class-airborne-mpesa-gateway.php';

/**
 * Register the gateway with WooCommerce
 */
add_filter( 'woocommerce_payment_gateways', function ( $gateways ) {
    $gateways[] = 'Airborne_Mpesa_Gateway';
    return $gateways;
} );

/**
 * Load plugin text domain (if needed)
 */
add_action( 'plugins_loaded', function () {
    load_plugin_textdomain( 'airborne-mpesa', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
} );

/**
 * Add plugin action links (Settings)
 */
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), function ( $links ) {
    $settings_link = '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=checkout&section=airborne_mpesa' ) . '">Settings</a>';
    array_unshift( $links, $settings_link );
    return $links;
} );
