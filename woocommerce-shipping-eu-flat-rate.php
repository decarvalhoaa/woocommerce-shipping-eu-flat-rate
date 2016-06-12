<?php
/**
 * Plugin Name: Woocommerce Shipping EU Flat Rate
 * Plugin URI: https://github.com/decarvalhoaa/woocommerce-shipping-eu-flat-rate/
 * Description: Plugin for adding Shipping EU Flat Rate to Woocommerce
 * Author: Antonio de Carvalho
 * Author URI: http://https://github.com/decarvalhoaa/
 * Version: 1.0.0
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Returns the main instance of TLC_Woocommerce_Shipping_EU_Flat_Rate to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object TLC_Woocommerce_Shipping_EU_Flat_Rate
 */
function TLC_Woocommerce_Shipping_EU_Flat_Rate() {
	return TLC_Woocommerce_Shipping_EU_Flat_Rate::instance();
} // End TLC_Woocommerce_Shipping_EU_Flat_Rate()

TLC_Woocommerce_Shipping_EU_Flat_Rate();

/**
 * Main TLC_Woocommerce_Shipping_EU_Flat_Rate Class
 *
 * @class TLC_Woocommerce_Shipping_EU_Flat_Rate
 * @version 1.0.0
 * @since 1.0.0
 * @package TLC_Woocommerce_Shipping_EU_Flat_Rate
 * @author Antonio de Carvalho
 */
final class TLC_Woocommerce_Shipping_EU_Flat_Rate {
	/**
	 * TLC_Woocommerce_Shipping_EU_Flat_Rate The single instance of TLC_Woocommerce_Shipping_EU_Flat_Rate.
	 * @var	   object
	 * @access private
	 * @since  1.0.0
	 */
	private static $_instance = null;

	/**
	 * The token.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $token;

	/**
	 * The version number.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $version;

	/**
	 * Constructor function.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function __construct () {
		$this->token 			= 'woocommerce-shipping-eu-flat-rate';
		$this->plugin_url 		= plugin_dir_url( __FILE__ );
		$this->plugin_path 		= plugin_dir_path( __FILE__ );
		$this->version 			= '1.0.0';

		register_activation_hook( __FILE__, array( $this, 'install' ) );

		add_action( 'plugins_loaded', array( $this, 'woocommerce_shipping_eu_flat_rate_setup' ) );
	} // End __construct()

	/**
	 * Main TLC_Woocommerce_Shipping_EU_Flat_Rate Instance
	 *
	 * Ensures only one instance of TLC_Woocommerce_Shipping_EU_Flat_Rate is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see SPH_Poly_Integration()
	 * @return Main TLC_Woocommerce_Shipping_EU_Flat_Rate instance
	 */
	public static function instance () {
		if ( is_null( self::$_instance ) )
			self::$_instance = new self();
		return self::$_instance;
	} // End instance()

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), '1.0.0' );
	} // End __clone()

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), '1.0.0' );
	} // End __wakeup()

	/**
	 * Installation. Runs on activation.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function install () {
		$this->_log_version_number();
	} // End install()

	/**
	 * Log the plugin version number.
	 * @access  private
	 * @since   1.0.0
	 * @return  void
	 */
	private function _log_version_number () {
		// Log the version number.
		update_option( $this->token . '-version', $this->version );
	} // End _log_version_number()

	/**
	 * Setup all the things, if woocommerce is active
	 * @return void
	 */
	public function woocommerce_shipping_eu_flat_rate_setup() {

		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

			if ( ! class_exists( 'WC_Shipping_EU_Delivery' ) ) {

				function eu_flat_rate_shipping_method_init() {
					include_once( 'includes/class-wc-shipping-eu-delivery.php' );
				}
				add_action( 'woocommerce_shipping_init', 'eu_flat_rate_shipping_method_init' );

				function add_eu_flat_rate_shipping_method( $methods ) {
					$methods[] = 'WC_Shipping_EU_Delivery';
					return $methods;
				}
				add_filter( 'woocommerce_shipping_methods', 'add_eu_flat_rate_shipping_method' );

			}
		}

	} // End woocommerce_shipping_eu_flat_rate_setup()

}
