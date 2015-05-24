<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    restaurateur
 * @subpackage restaurateur/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    restaurateur
 * @subpackage restaurateur/admin
 * @author     Lou admin@louiedogg.com
 */
class restaurateur_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $restaurateur    The ID of this plugin.
	 */
	private $restaurateur;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $restaurateur       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $restaurateur, $version ) {

		$this->restaurateur = $restaurateur;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in restaurateur_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The restaurateur_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->restaurateur, plugin_dir_url( __FILE__ ) . 'css/restaurateur-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in restaurateur_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The restaurateur_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->restaurateur, plugin_dir_url( __FILE__ ) . 'js/restaurateur-admin.js', array( 'jquery' ), $this->version, false );

	}
	
	/** This was added by admin@louiedogg.com **/
	/**
	 * Registers a meta box for entering product information. The meta box is
	 * shown in the post editor for the "product" post type.
	 *
	 * @param   $post   WP_Post The post object to apply the meta box to
	 */
	public function add_product_information_meta_box( $post ) {
		add_meta_box(
			'product-information-meta-box',
			__( 'Product Information', $this->plugin_name ),
			array( $this, 'render_product_information_meta_box' ),
			'wp_restaurateur_product',
			'side'
		);
	}
	
	/** This was added by admin@louiedogg.com **/
	/**
	 * Renders the product information meta box for the given post (wplm_product).
	 *
	 * @param $post     WP_Post     The WordPress post object being rendered.
	 */
	public function render_product_information_meta_box( $post ) {
		$product_meta = get_post_meta( $post->ID, 'wp_restaurateur_product_meta', true );
	 
		if ( ! is_array( $product_meta ) ) {
			$product_meta = array(
				'file_bucket' => '',
				'file_name' => '',
				'version' => '',
				'tested' => '',
				'requires' => '',
				'updated' => '',
				'banner_low' => '',
				'banner_high' => ''
			);
		}
	 
		$this->render_nonce_field( 'product_meta_box' ); 
	 
		require( 'partials/product_meta_box.php' ); # This may need to be the include dislpay admin html ??
	}
	
	/** This was added by admin@louiedogg.com **/
	
	/**
	 * Saves the product information meta box contents.
	 *
	 * @param $post_id  int     The id of the post being saved.
	 */
	public function save_product_information_meta_box( $post_id ) {
		if ( ! $this->is_nonce_ok( 'product_meta_box' ) ) {
			return $post_id;
		}
	 
		// Ignore auto saves
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
	 
		// Check the user's permissions
		if ( !current_user_can( 'edit_posts', $post_id ) ) {
			return $post_id;
		}
	 
		// Read, sanitize, and store user input
		$meta = get_post_meta( $post_id, 'wp_restaurateur_product_meta', true );
		if ( $meta == '' ) {
			$meta = array();
		}
	 
		$meta['file_bucket'] = sanitize_text_field( $_POST['wp_restaurateur_product_bucket'] );
		$meta['file_name'] = sanitize_text_field( $_POST['wp_restaurateur_product_file_name'] );
		$meta['version'] = sanitize_text_field( $_POST['wp_restaurateur_product_version'] );
		$meta['tested'] = sanitize_text_field( $_POST['wp_restaurateur_product_tested'] );
		$meta['requires'] = sanitize_text_field( $_POST['wp_restaurateur_product_requires'] );
		$meta['updated'] = sanitize_text_field( $_POST['wp_restaurateur_product_updated'] );
		$meta['banner_low'] = sanitize_text_field( $_POST['wp_restaurateur_product_banner_low'] );
		$meta['banner_high'] = sanitize_text_field( $_POST['wp_restaurateur_product_banner_high'] );
	 
		// Update the meta field
		update_post_meta( $post_id, 'wp_restaurateur_product_meta', $meta );
	}
	
	/**
	 * A helper function for creating and rendering a nonce field.
	 *
	 * @param   $nonce_label  string  An internal (shorter) nonce name
	 */
	private function render_nonce_field( $nonce_label ) {
		$nonce_field_name = $this->plugin_name . '_' . $nonce_label . '_nonce';
		$nonce_name = $this->plugin_name . '_' . $nonce_label;
	 
		wp_nonce_field( $nonce_name, $nonce_field_name );
	}
	/**
	 * A helper function for checking the product meta box nonce.
	 *
	 * @param   $nonce_label string  An internal (shorter) nonce name
	 * @return  mixed   False if nonce is not OK. 1 or 2 if nonce is OK (@see wp_verify_nonce)
	 */
	
	private function is_nonce_ok( $nonce_label ) {
		$nonce_field_name = $this->plugin_name . '_' . $nonce_label . '_nonce';
		$nonce_name = $this->plugin_name . '_' . $nonce_label;
	 
		if ( ! isset( $_POST[ $nonce_field_name ] ) ) {
			return false;
		}
	 
		$nonce = $_POST[ $nonce_field_name ];
	 
		return wp_verify_nonce( $nonce, $nonce_name );
	}
	
	/**
	 * Creates the settings menu and sub menus for adding and listing licenses.
	 */
	public function add_licenses_menu_page() {
		add_menu_page(
			__( 'Licenses', $this->plugin_name ),
			__( 'Licenses', $this->plugin_name ),
			'edit_posts',
			'restaurateur-licenses',
			array( $this, 'render_licenses_menu_list' ),
			'dashicons-lock',
			'26.1'
		);
	 
		add_submenu_page(
			'wp-licenses',
			__( 'Licenses', $this->plugin_name ),
			__( 'Licenses', $this->plugin_name ),
			'edit_posts',
			'restaurateur-licenses',
			array( $this, 'render_licenses_menu_list' )
		);
	 
		add_submenu_page(
			'wp-licenses',
			__( 'Add new', $this->plugin_name ),
			__( 'Add new', $this->plugin_name ),
			'edit_posts',
			'restaurateur-licenses-new',
			array( $this, 'render_licenses_menu_new' )
		);
	}

	
	/** This was added by admin@louiedogg.com **/
	
	/**
	 * Renders the list add new license menu page using
	 * the "licenses_new.php" partial.
	 */
	public function render_licenses_menu_new() {
		// Used in the "Product" drop-down list in view
		$products = get_posts(
			array(
				'orderby'           => 'post_title',
				'order'             => 'ASC',
				'post_type'         => 'restaurateur_product',
				'post_status'       => 'publish',
				'nopaging'          => true,
				'suppress_filters'  => true
			)
		);
	 
		require plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/licenses_new.php';
	}

	/** This was added by admin@louiedogg.com **/
	
	/**
	 * Handler for the add_license action (submitting
	 * the "Add New License" form).
	 */
	public function handle_add_license() {
		global $wpdb;
	 
		if ( ! empty( $_POST )
			&& check_admin_referer( 'restaurateur-add-license',
				'restaurateur-add-license-nonce' ) ) {
	 
			// Nonce valid, handle data
	 
			$email = sanitize_text_field( $_POST['email'] );
			$valid_until = sanitize_text_field( $_POST['valid_until'] );
			$product_id = intval( $_POST['product'] );
			 
			$license_key = wp_generate_password( 24, true, false );
	 
			// Save data to database
			$table_name = $wpdb->prefix . 'product_licenses';
			$wpdb->insert(
				$table_name,
				array(
					'product_id' => $product_id,
					'email' => $email,
					'license_key' => $license_key,
					'valid_until' => $valid_until,
					'created_at' => current_time( 'mysql' ),
					'updated_at' => current_time( 'mysql' )
				),
				array(
					'%d',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s'
				)
			);
	 
			// Redirect to the list of licenses for displaying the new license
			wp_redirect( admin_url( 'admin.php?page=restaurateur' ) );
		}
	}
	
	
	/** This was added by admin@louiedogg.com **/
	/**
	 * Renders the list of licenses menu page using the "licenses_list.php" partial.
	 */
	public function render_licenses_menu_list() {
		$list_table = new Licenses_List_Table( $this->plugin_name );
		$list_table->prepare_items();
	 
		require plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/licenses_list.php';
	}
	/**
	 * Creates the settings fields for the plugin options page.
	 */
	public function add_plugin_settings_fields() {
		$settings_group_id = 'restaurateur-settings-group';
		$aws_settings_section_id = 'restaurateur-settings-section-aws';
		$settings_field_id = 'restaurateur-settings';
	 
		register_setting( $settings_group_id, $settings_field_id );
	 
		add_settings_section(
			$aws_settings_section_id,
			__( 'Amazon Web Services', $this->plugin_name ),
			array( $this, 'render_aws_settings_section' ),
			$settings_group_id
		);
	 
		add_settings_field(
			'aws-key',
			__( 'AWS public key', $this->plugin_name ),
			array( $this, 'render_aws_key_settings_field' ),
			$settings_group_id,
			$aws_settings_section_id
		);
	 
		add_settings_field(
			'aws-secret',
			__( 'AWS secret', $this->plugin_name ),
			array( $this, 'render_aws_secret_settings_field' ),
			$settings_group_id,
			$aws_settings_section_id
		);
	}
	/**
	 * Adds an options page for plugin settings.
	 */
	public function add_plugin_settings_page() {
		add_options_page(
			__( 'Restaurateur', $this->plugin_name ),
			__( 'Restaurateur Settings', $this->plugin_name ),
			'manage_options',
			'restaurateur-settings',
			array( $this, 'render_settings_page' )
		);
	}

	/**
	 * Renders the plugin's options page.
	 */
	public function render_settings_page() {
		$settings_group_id = 'restaurateur-settings-group';
		require plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/settings_page.php';
	}
	 
	/**
	 * Renders the description for the AWS settings section.
	 */
	public function render_aws_settings_section() {
		// We use a partial here to make it easier to add more complex instructions
		require plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/aws_settings_group_instructions.php';
	}
	 
	/**
	 * Renders the settings field for the AWS key.
	 */
	public function render_aws_key_settings_field() {
		$settings_field_id = 'restaurateur-settings';
		$options = get_option( $settings_field_id );
		?>
			<input type='text' name='<?php echo $settings_field_id; ?>[aws_key]' value='<?php echo $options['aws_key']; ?>' class='regular-text'>
		<?php
	}
	 
	/**
	 * Renders the settings field for the AWS secret.
	 */
	public function render_aws_secret_settings_field() {
		$settings_field_id = 'restaurateur-settings';
		$options = get_option( $settings_field_id );
		?>
		   <input type='text' name='<?php echo $settings_field_id; ?>[aws_secret]' value='<?php echo $options['aws_secret']; ?>' class='regular-text'>
		<?php
	}


}
