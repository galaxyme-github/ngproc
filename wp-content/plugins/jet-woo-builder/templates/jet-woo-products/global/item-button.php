<?php
/**
 * Loop add to cart button
 */

if ( 'yes' !== $this->get_attr( 'show_button' ) ) {
	return;
}
global $product;
?>

<div class="jet-woo-product-button"><?php jet_woo_builder_template_functions()->get_product_add_to_cart_button(); ?></div>