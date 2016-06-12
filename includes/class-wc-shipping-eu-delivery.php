<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if WooCommerce is active
 */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	if ( ! class_exists( 'WC_Shipping_EU_Delivery' ) ) {

		/**
		 * EU Delivery - Based on the International Delivery Shipping Method.
		 *
		 * @class 		WC_Shipping_Flat_Rate
		 * @version		1.0.0
		 * @package		TLC_Woocommerce_Shipping_EU_Flat_Rate/Classes
		 * @author 		Antonio de Carvalho
		 */
		class WC_Shipping_EU_Delivery extends WC_Shipping_International_Delivery {

			/**
			 * Constructor.
			 */
			public function __construct() {
				$this->id                 = 'eu_delivery';
				$this->method_title       = __( 'EU Flat Rate', 'woocommerce-shipping-eu-flat-rate' );
				$this->method_description = __( 'EU Flat Rate Shipping lets you charge a fixed rate for shipping.', 'woocommerce-shipping-eu-flat-rate' );
				$this->init();

				add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
			}

		}

	}

}
