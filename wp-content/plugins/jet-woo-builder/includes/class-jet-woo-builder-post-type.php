<?php
/**
 * Jet Woo Builder post type template
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Jet_Woo_Builder_Post_Type' ) ) {

	/**
	 * Define Jet_Woo_Builder_Post_Type class
	 */
	class Jet_Woo_Builder_Post_Type {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		protected $post_type = 'jet-woo-builder';
		protected $meta_key  = 'jet-woo-builder-item';

		/**
		 * Constructor for the class
		 */
		public function init() {

			$this->register_post_type();
			$this->init_meta();

			if ( is_admin() ) {
				add_action( 'admin_menu', array( $this, 'add_templates_page' ), 90 );
			}

			add_filter( 'option_elementor_cpt_support', array( $this, 'set_option_support' ) );
			add_filter( 'default_option_elementor_cpt_support', array( $this, 'set_option_support' ) );

			add_filter( 'body_class', array( $this, 'set_body_class' ) );
			add_filter( 'post_class', array( $this, 'set_post_class' ) );

			add_filter( 'the_content', array( $this, 'add_product_wrapper' ), 1000000 );

			add_action( 'elementor/documents/register', array( $this, 'register_elementor_document_type' ) );

			add_action( 'wp_insert_post', array( $this, 'set_document_type_on_post_create' ), 10, 2 );

			add_action( 'init', array( $this, 'fix_documents_types' ), 99 );

			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_templates_popup' ) );
			add_action( 'admin_action_jet_woo_new_template', array( $this, 'create_template' ) );

		}

		/**
		 * Create new template
		 *
		 * @return [type] [description]
		 */
		public function create_template() {

			if ( ! current_user_can( 'edit_posts' ) ) {
				wp_die(
					esc_html__( 'You don\'t have permissions to do this', 'jet-theme-core' ),
					esc_html__( 'Error', 'jet-theme-core' )
				);
			}

			$template  = isset( $_REQUEST['template'] ) ? esc_attr( $_REQUEST['template'] ) : false;
			$documents = Elementor\Plugin::instance()->documents;
			$doc_type  = $documents->get_document_type( $this->slug() );
			$templates = $this->predesigned_templates();

			if ( ! isset( $templates[ $template ] ) ) {
				wp_die(
					esc_html__( 'This template not rigestered', 'jet-theme-core' ),
					esc_html__( 'Error', 'jet-theme-core' )
				);
			}

			$data    = $templates[ $template ];
			$content = $data['content'];

			ob_start();
			include $content;
			$template_data = ob_get_clean();

			$post_data = array(
				'post_type'  => $this->slug(),
				'meta_input' => array(
					'_elementor_edit_mode'   => 'builder',
					$doc_type::TYPE_META_KEY => $this->slug(),
					'_elementor_data'        => wp_slash( $template_data ),
				),
			);

			$title = isset( $_REQUEST['template_name'] ) ? esc_attr( $_REQUEST['template_name'] ) : '';

			if ( $title ) {
				$post_data['post_title'] = $title;
			}

			$template_id = wp_insert_post( $post_data );

			if ( ! $template_id ) {
				wp_die(
					esc_html__( 'Can\'t create template. Please try again', 'jet-theme-core' ),
					esc_html__( 'Error', 'jet-theme-core' )
				);
			}

			wp_redirect( Elementor\Utils::get_edit_link( $template_id ) );
			die();

		}

		/**
		 * Enqueue templates popup assets
		 *
		 * @return [type] [description]
		 */
		public function enqueue_templates_popup( $hook ) {

			if ( 'edit.php' !== $hook ) {
				return;
			}

			if ( ! isset( $_GET['post_type'] ) || $this->slug() !== $_GET['post_type'] ) {
				return;
			}

			wp_enqueue_style(
				'jet-woo-builder-template-popup',
				jet_woo_builder()->plugin_url( 'assets/css/template-popup.css' )
			);

			wp_enqueue_script(
				'jet-woo-builder-template-popup',
				jet_woo_builder()->plugin_url( 'assets/js/template-popup.js' ),
				array( 'jquery' ),
				jet_woo_builder()->get_version(),
				true
			);

			wp_localize_script( 'jet-woo-builder-template-popup', 'JetWooPopupSettings', array(
				'button' => '<a href="#" class="page-title-action jet-woo-new-template">' . __( 'Create from predesigned template', 'jet-woo-builder' ) . '</a>',
			) );

			add_action( 'admin_footer', array( $this, 'template_popup' ) );

		}

		public function predesigned_templates() {

			$base_url = jet_woo_builder()->plugin_url( 'includes/templates/' );
			$base_dir = jet_woo_builder()->plugin_path( 'includes/templates/' );

			return apply_filters( 'jet-woo-builder/predesigned-templates', array(
				'layout-1' => array(
					'content' => $base_dir . 'layout-1/template.json',
					'thumb'   => $base_url . 'layout-1/thumbnail.png',
				),
				'layout-2' => array(
					'content' => $base_dir . 'layout-2/template.json',
					'thumb'   => $base_url . 'layout-2/thumbnail.png',
				),
				'layout-3' => array(
					'content' => $base_dir . 'layout-3/template.json',
					'thumb'   => $base_url . 'layout-3/thumbnail.png',
				),
				'layout-4' => array(
					'content' => $base_dir . 'layout-4/template.json',
					'thumb'   => $base_url . 'layout-4/thumbnail.png',
				),
				'layout-5' => array(
					'content' => $base_dir . 'layout-5/template.json',
					'thumb'   => $base_url . 'layout-5/thumbnail.png',
				),
				'layout-6' => array(
					'content' => $base_dir . 'layout-6/template.json',
					'thumb'   => $base_url . 'layout-6/thumbnail.png',
				),
				'layout-7' => array(
					'content' => $base_dir . 'layout-7/template.json',
					'thumb'   => $base_url . 'layout-7/thumbnail.png',
				),
				'layout-8' => array(
					'content' => $base_dir . 'layout-8/template.json',
					'thumb'   => $base_url . 'layout-8/thumbnail.png',
				),
			) );
		}

		/**
		 * Templatepopup content
		 *
		 * @return [type] [description]
		 */
		public function template_popup() {

			$action = add_query_arg(
				array(
					'action' => 'jet_woo_new_template',
				),
				esc_url( admin_url( 'admin.php' ) )
			);

			include jet_woo_builder()->get_template( 'template-popup.php' );

		}

		/**
		 * Manybe fix document types for Jet Woo templates
		 *
		 * @return void
		 */
		public function fix_documents_types() {

			if ( ! isset( $_GET['fix_jet_woo_templates'] ) ) {
				return;
			}

			$args = array(
				'post_type'      => $this->slug(),
				'post_status'    => array( 'publish', 'pending', 'draft', 'future' ),
				'posts_per_page' => -1,
			);

			$wp_query  = new WP_Query( $args );
			$documents = Elementor\Plugin::instance()->documents;
			$doc_type  = $documents->get_document_type( $this->slug() );

			if ( ! $wp_query->have_posts() ) {
				return false;
			}

			foreach ( $wp_query->posts as $post ) {
				update_post_meta( $post->ID, $doc_type::TYPE_META_KEY, $this->slug() );
			}

		}

		/**
		 * Set apropriate document type on post creation
		 *
		 * @param int     $post_id Created post ID.
		 * @param WP_Post $post    Created post object.
		 */
		public function set_document_type_on_post_create( $post_id, $post ) {

			if ( $post->post_type !== $this->slug() ) {
				return;
			}

			if ( ! class_exists( 'Elementor\Plugin' ) ) {
				return;
			}

			$documents = Elementor\Plugin::instance()->documents;
			$doc_type  = $documents->get_document_type( $this->slug() );

			update_post_meta( $post_id, $doc_type::TYPE_META_KEY, $this->slug() );

		}

		/**
		 * Register apropriate document type for 'jet-woo-builder' post type
		 *
		 * @param  Elementor\Core\Documents_Manager $documents_manager [description]
		 * @return void
		 */
		public function register_elementor_document_type( $documents_manager ) {
			require jet_woo_builder()->plugin_path( 'includes/class-jet-woo-builder-document.php' );
			$documents_manager->register_document_type( $this->slug(), 'Jet_Woo_Builder_Document' );
		}

		/**
		 * Add .product wrapper to content
		 *
		 * @param string $content
		 */
		public function add_product_wrapper( $content ) {

			if ( is_singular( $this->slug() ) && isset( $_GET['elementor-preview'] ) ) {
				$content = sprintf( '<div class="product">%s</div>', $content );
			}

			return $content;
		}

		/**
		 * Add 'single-product' class to body on template pages
		 *
		 * @param  array $classes Default classes list.
		 * @return array
		 */
		public function set_body_class( $classes ) {

			if ( is_singular( $this->slug() ) ) {
				$classes[] = 'single-product woocommerce';
			}

			return $classes;
		}

		/**
		 * Add 'product' class to post on template pages
		 *
		 * @param  array $classes Default classes list.
		 * @return array
		 */
		public function set_post_class( $classes ) {

			if ( is_singular( $this->slug() ) ) {
				$classes[] = 'product';
			}

			return $classes;
		}

		/**
		 * Menu page
		 */
		public function add_templates_page() {

			add_submenu_page(
				'woocommerce',
				esc_html__( 'Jet Woo Templates', 'jet-theme-core' ),
				esc_html__( 'Jet Woo Templates', 'jet-theme-core' ),
				'edit_pages',
				'edit.php?post_type=' . $this->slug()
			);

		}

		/**
		 * Returns post type slug
		 *
		 * @return string
		 */
		public function slug() {
			return $this->post_type;
		}

		/**
		 * Returns Mega Menu meta key
		 *
		 * @return string
		 */
		public function meta_key() {
			return $this->meta_key;
		}

		/**
		 * Add elementor support for mega menu items.
		 */
		public function set_option_support( $value ) {

			if ( empty( $value ) ) {
				$value = array();
			}

			return array_merge( $value, array( $this->slug() ) );
		}

		/**
		 * Register post type
		 *
		 * @return void
		 */
		public function register_post_type() {

			$labels = array(
				'name'          => esc_html__( 'Jet Woo Templates', 'jet-woo-builder' ),
				'singular_name' => esc_html__( 'Jet Woo Template', 'jet-woo-builder' ),
				'add_new'       => esc_html__( 'Add New Template', 'jet-woo-builder' ),
				'add_new_item'  => esc_html__( 'Add New Template', 'jet-woo-builder' ),
				'edit_item'     => esc_html__( 'Edit Template', 'jet-woo-builder' ),
				'menu_name'     => esc_html__( 'Jet Woo Templates', 'jet-woo-builder' ),
			);

			$args = array(
				'labels'              => $labels,
				'hierarchical'        => false,
				'description'         => 'description',
				'taxonomies'          => array(),
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => false,
				'show_in_admin_bar'   => true,
				'menu_position'       => null,
				'menu_icon'           => null,
				'show_in_nav_menus'   => false,
				'publicly_queryable'  => true,
				'exclude_from_search' => true,
				'has_archive'         => false,
				'query_var'           => true,
				'can_export'          => true,
				'rewrite'             => true,
				'capability_type'     => 'post',
				'supports'            => array( 'title' ),
			);

			register_post_type( $this->slug(), $args );

		}

		/**
		 * Initialize template metabox
		 *
		 * @return void
		 */
		public function init_meta() {

			new Cherry_X_Post_Meta( array(
				'id'            => 'template-settings',
				'title'         => esc_html__( 'Template Settings', 'jet-woo-builder' ),
				'page'          => array( $this->slug() ),
				'context'       => 'normal',
				'priority'      => 'high',
				'callback_args' => false,
				'builder_cb'    => array( $this, 'get_builder' ),
				'fields'        => array(
					'_sample_product' => array(
						'type'              => 'select',
						'element'           => 'control',
						'options'           => false,
						'options_callback'  => array( $this, 'get_products' ),
						'label'             => esc_html__( 'Sample Product for Editing (if not selected - will be used latest added)', 'jet-woo-builder' ),
						'sanitize_callback' => 'esc_attr',
					),
				),
			) );

		}

		/**
		 * Return products list
		 *
		 * @return void
		 */
		public function get_products() {

			$products = get_posts( array(
				'post_type'      => 'product',
				'post_status'    => array( 'publish', 'pending', 'draft', 'future' ),
				'posts_per_page' => 100,
			) );

			$default = array(
				'' => __( 'Select Product...', 'jet-woo-builder' ),
			);

			if ( empty( $products ) ) {
				return $default;
			}

			$products = wp_list_pluck( $products, 'post_title', 'ID' );

			return $default + $products;
		}

		/**
		 * Return UI builder instance
		 *
		 * @return [type] [description]
		 */
		public function get_builder() {

			$builder_data = jet_woo_builder()->framework->get_included_module_data( 'cherry-x-interface-builder.php' );

			return new CX_Interface_Builder(
				array(
					'path' => $builder_data['path'],
					'url'  => $builder_data['url'],
				)
			);
		}

		/**
		 * Return Templates list from options
		 *
		 * @return void
		 */
		public function get_templates_list() {

			$templates = get_posts( array(
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'post_type'      => $this->slug(),
			) );

			return $templates;
		}

		/**
		 * Returns templates list for select opptions
		 *
		 * @return [type] [description]
		 */
		public function get_templates_list_for_options() {

			$templates = $this->get_templates_list();

			$default = array(
				'' => esc_html__( 'Select Template...', 'jet-woo-builder' ),
			);

			if ( empty( $templates ) ) {
				return $default;
			}

			return $default + wp_list_pluck( $templates, 'post_title', 'ID' );

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
 * Returns instance of Jet_Woo_Builder_Post_Type
 *
 * @return object
 */
function jet_woo_builder_post_type() {
	return Jet_Woo_Builder_Post_Type::get_instance();
}
