<?php
/**
 * WooCommerce Product Settings
 *
 * @author   WooThemes
 * @category Admin
 * @package  WooCommerce/Admin
 * @version  2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Jet_Woo_Builder_Shop_Settings_Page.
 */
class Jet_Woo_Builder_Shop_Settings_Page extends WC_Settings_Page {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->id    = jet_woo_builder_shop_settings()->key;
		$this->label = __( 'Jet Woo Builder', 'jet-woo-builder' );

		parent::__construct();
	}

	/**
	 * Get sections.
	 *
	 * @return array
	 */
	public function get_sections() {
		$sections = array(
			'' => __( 'General', 'jet-woo-builder' ),
		);

		return apply_filters( 'woocommerce_get_sections_' . $this->id, $sections );
	}

	/**
	 * Output the settings.
	 */
	public function output() {
		global $current_section;
		$settings = $this->get_settings( $current_section );
		WC_Admin_Settings::output_fields( $settings );
	}

	/**
	 * Save settings.
	 */
	public function save() {
		global $current_section;

		$settings = $this->get_settings( $current_section );

		WC_Admin_Settings::save_fields( $settings );
	}

	/**
	 * Get settings array.
	 *
	 * @param string $current_section Current section name.
	 * @return array
	 */
	public function get_settings( $current_section = '' ) {

		$settings = array(
			array(
				'title' => __( 'General options', 'jet-woo-builder' ),
				'type'  => 'title',
				'desc'  => '',
				'id'    => 'general_options',
			),

			array(
				'title'   => __( 'Custom Single Product', 'jet-woo-builder' ),
				'desc'    => __( 'Enable custom single product page', 'jet-woo-builder' ),
				'id'      => jet_woo_builder_shop_settings()->options_key . '[custom_single_page]',
				'default' => '',
				'type'    => 'checkbox',
			),

			array(
				'title'   => __( 'Single Product Template', 'jet-woo-builder' ),
				'desc'    => __( 'Select template to use it as global single product template', 'jet-woo-builder' ),
				'id'      => jet_woo_builder_shop_settings()->options_key . '[single_template]',
				'type'    => 'jet_woo_select_template',
				'default' => '',
				'class'   => 'wc-enhanced-select-nostd',
				'css'     => 'min-width:300px;',
			),

			array(
				'title'   => __( 'Use Native Templates', 'jet-woo-builder' ),
				'desc'    => __( 'Force use native WooCommerce templates instead of rewritten in theme', 'jet-woo-builder' ),
				'id'      => jet_woo_builder_shop_settings()->options_key . '[use_native_templates]',
				'default' => '',
				'type'    => 'checkbox',
			),

			array(
				'type' => 'sectionend',
				'id' => 'general_options',
			),
		);

		return apply_filters( 'woocommerce_get_settings_' . $this->id, $settings, $current_section );
	}
}
