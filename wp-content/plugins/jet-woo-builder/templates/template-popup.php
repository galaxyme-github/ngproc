<?php
/**
 * Teamplte type popup
 */

$checked = ' checked';
?>
<div class="jet-template-popup">
	<div class="jet-template-popup__overlay"></div>
	<div class="jet-template-popup__content">
		<h3 class="jet-template-popup__heading"><?php
			esc_html_e( 'Select Template', 'jet-theme-core' );
		?></h3>
		<form class="jet-template-popup__form" id="jet_woo_template_form" method="POST" action="<?php echo $action; ?>" >
			<div class="jet-template-popup__form-row"><?php
				foreach ( $this->predesigned_templates() as $id => $data ) {
					?>
					<div class="jet-template-popup__item">
						<label class="jet-template-popup__label">
							<input type="radio" name="template" value="<?php echo $id; ?>"<?php echo $checked; ?>>
							<img src="<?php echo $data['thumb']; ?>" alt="">
						</label>
					</div>
					<?php
					$checked = '';
				}
			?></div>
			<div class="jet-template-popup__form-actions">
				<button type="submit" id="templates_type_submit" class="button button-primary button-hero"><?php
					esc_html_e( 'Create Template', 'jet-theme-core' );
				?></button>
			</div>
		</form>
	</div>
</div>