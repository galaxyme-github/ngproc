<?php

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Manages product variations
 *
 * Here product variations functions are defined and managed.
 *
 * @version        1.0.0
 * @package        implecode-product-variations/includes
 * @author        Norbert Dreszer
 */
add_action( 'wp_ajax_get_viariation_details', 'ic_ajax_get_viariation_details' );
add_action( 'wp_ajax_nopriv_get_viariation_details', 'ic_ajax_get_viariation_details' );

/**
 * Handles ajax variations fields
 *
 */
function ic_ajax_get_viariation_details() {
	$what				 = is_array( $_POST[ 'variation_field' ] ) ? array_map( 'sanitize_text_field', $_POST[ 'variation_field' ] ) : sanitize_text_field( $_POST[ 'variation_field' ] );
	$selected_variation	 = sanitize_text_field( $_POST[ 'selected_variation' ] );
	$variation_id		 = intval( $_POST[ 'variation_id' ] );
	$product_id			 = intval( $_POST[ 'product_id' ] );
	$out				 = array();
	if ( $selected_variation != '' && !empty( $variation_id ) ) {
		$variation_id = 1; // Details are available only for first variation
		foreach ( $what as $element ) {
			ob_start();
			if ( $element == 'in_cart' ) {
				$product_variations_settings = get_product_variations_settings();
				foreach ( $_POST[ 'selected_variation' ] as $var_id => $var_value ) {
					$_POST[ $var_id ] = $var_value;
				}
				$current_product_variations = get_current_product_variations_string( $product_id, $product_variations_settings );
				if ( $current_product_variations ) {
					$cart_id = $product_id . $current_product_variations;
				}
				$cart_content = shopping_cart_products_array();
				if ( is_ic_product_in_cart( $cart_id, $cart_content ) ) {
					echo 1;
				}
			}
			$out[] = ob_get_clean();
		}
	}
	echo json_encode( $out );
	wp_die();
}
