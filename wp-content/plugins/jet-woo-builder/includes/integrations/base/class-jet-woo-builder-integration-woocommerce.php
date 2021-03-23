<?php
/**
 * Class description
 *
 * @package   package_name
 * @author    Cherry Team
 * @license   GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Jet_Woo_Builder_Integration_Woocommerce' ) ) {

	/**
	 * Define Jet_Woo_Builder_Integration_Woocommerce class
	 */
	class Jet_Woo_Builder_Integration_Woocommerce {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;
		private $current_template = null;

		/**
		 * Constructor for the class
		 */
		public function init() {

			add_filter( 'wc_get_template_part', array( $this, 'rewrite_templates' ), 10, 3 );

			if ( 'yes' === jet_woo_builder_shop_settings()->get( 'use_native_templates' ) ) {
				add_filter( 'wc_get_template', array( $this, 'force_wc_templates' ), 10, 2 );
			}

			// Set blank page template for editing product content with Elementor
			add_action( 'template_include', array( $this, 'set_product_template' ), 9999 );

			add_action( 'init', array( $this, 'product_meta' ), 99 );

			add_filter( 'jet-woo-builder/custom-single-template', array( $this, 'force_preview_template' ) );

		}

		/**
		 * Initialize template metabox
		 *
		 * @return void
		 */
		public function product_meta() {

			new Cherry_X_Post_Meta( array(
				'id'            => 'template-settings',
				'title'         => esc_html__( 'Jet Woo Builder Template Settings', 'jet-woo-builder' ),
				'page'          => array( 'product' ),
				'context'       => 'side',
				'priority'      => 'low',
				'callback_args' => false,
				'builder_cb'    => array( jet_woo_builder_post_type(), 'get_builder' ),
				'fields'        => array(
					'_jet_woo_template' => array(
						'type'              => 'select',
						'element'           => 'control',
						'options'           => false,
						'options_callback'  => array( jet_woo_builder_post_type(), 'get_templates_list_for_options' ),
						'label'             => esc_html__( 'Custom Template', 'jet-woo-builder' ),
						'sanitize_callback' => 'esc_attr',
					),
					'_template_type' => array(
						'type'              => 'select',
						'element'           => 'control',
						'default'           => 'default',
						'options'           => array(
							'default' => esc_html__( 'Default', 'jet-woo-builder' ),
							'canvas'  => esc_html__( 'Canvas', 'jet-woo-builder' ),
						),
						'label'             => esc_html__( 'Template Type', 'jet-woo-builder' ),
						'sanitize_callback' => 'esc_attr',
					),
				),
			) );

		}

		/**
		 * Set blank template for editor
		 */
		public function set_product_template( $template ) {

			if ( ! is_singular( 'product' ) ) {
				return $template;
			}

			$template_type = get_post_meta( get_the_ID(), '_template_type', true );

			if ( isset( $_GET['elementor-preview'] ) ) {

				$template = jet_woo_builder()->plugin_path( 'templates/blank.php' );

				do_action( 'jet-woo-builder/template-include/found' );

			}

			if ( 'canvas' === $template_type ) {

				$custom_template = $this->get_custom_single_template();

				if ( $custom_template ) {

					$this->current_template = $custom_template;
					$template = jet_woo_builder()->plugin_path( 'templates/blank-product.php' );

					do_action( 'jet-woo-builder/template-include/found' );

				}

			}



			return $template;

		}

		/**
		 * Force to use default WooCommerce templates
		 *
		 * @param  [type] $found_template [description]
		 * @param  [type] $template_name  [description]
		 * @return [type]                 [description]
		 */
		public function force_wc_templates( $found_template, $template_name ) {

			if ( false !== strpos( $template_name, 'single-product/' ) ) {
				$default_path   = WC()->plugin_path() . '/templates/';
				$found_template = $default_path . $template_name;
			}

			return $found_template;

		}

		/**
		 * Rewrite default single product template
		 *
		 * @param  [type] $template [description]
		 * @param  [type] $slug     [description]
		 * @param  [type] $name     [description]
		 * @return [type]           [description]
		 */
		public function rewrite_templates( $template, $slug, $name ) {

			if ( 'content' === $slug && 'single-product' === $name ) {

				$custom_template = $this->get_custom_single_template();

				if ( $custom_template ) {
					$this->current_template = $custom_template;
					$template = jet_woo_builder()->get_template( 'woocommerce/content-single-product.php' );
				}

			}

			return $template;

		}

		/**
		 * Returns processed single template
		 *
		 * @return mixed
		 */
		public function current_single_template() {
			return $this->current_template;
		}

		/**
		 * Get custom single template
		 *
		 * @return string
		 */
		public function get_custom_single_template() {

			$product_template = get_post_meta( get_the_ID(), '_jet_woo_template', true );

			if ( ! empty( $product_template ) ) {
				return apply_filters( 'jet-woo-builder/custom-single-template', $product_template );
			}

			$enbaled         = jet_woo_builder_shop_settings()->get( 'custom_single_page' );
			$custom_template = false;

			if ( 'yes' === $enbaled ) {
				$custom_template = jet_woo_builder_shop_settings()->get( 'single_template' );
			}

			return apply_filters( 'jet-woo-builder/custom-single-template', $custom_template );

		}


		/**
		 * Force preview template
		 *
		 * @param  [type] $custom_template [description]
		 * @return [type]                  [description]
		 */
		public function force_preview_template( $custom_template ) {

			if ( ! empty( $_GET['jet_woo_template'] ) && isset( $_GET['preview_nonce'] ) ) {
				return absint( $_GET['jet_woo_template'] );
			} else {
				return $custom_template;
			}

		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @return object
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}
	}

}

/**
 * Returns instance of Jet_Woo_Builder_Integration_Woocommerce
 *
 * @return object
 */
function jet_woo_builder_integration_woocommerce() {
	return Jet_Woo_Builder_Integration_Woocommerce::get_instance();
}
