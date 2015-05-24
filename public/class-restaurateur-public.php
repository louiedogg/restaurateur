<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    restaurateur
 * @subpackage restaurateur/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    restaurateur
 * @subpackage restaurateur/public
 * @author     Your Name <email@example.com>
 */
class restaurateur_Public {

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
	
	
	/** This was added by admin@louiedogg.com **/
	/**
	* @var     License_Manager_API     The API handler
	*/
	private $api;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $restaurateur       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $restaurateur, $version ) {

		$this->restaurateur = $restaurateur;
		$this->version = $version;

		$this->api = new restaurateur_API(); 
	
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->restaurateur, plugin_dir_url( __FILE__ ) . 'css/restaurateur-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_script( $this->restaurateur, plugin_dir_url( __FILE__ ) . 'js/restaurateur-public.js', array( 'jquery' ), $this->version, false );

	}
	
	/** This was added by admin@louiedogg.com **/
	/**
	 * Register the new "products" post type to use for products that
	 * are available for purchase through the license manager.
	 */
	public function add_products_post_type() {
		register_post_type( 'wp_restaurateur_product',
			array(
				'labels' => array(
					'name' => __( 'Products', $this->plugin_name ),
					'singular_name' => __( 'Product', $this->plugin_name ),
					'menu_name' => __( 'Products', $this->plugin_name ),
					'name_admin_bar' => __( 'Products', $this->plugin_name ),
					'add_new' => __( 'Add New', $this->plugin_name ),
					'add_new_item' => __( 'Add New Product', $this->plugin_name ),
					'edit_item' => __( 'Edit Product', $this->plugin_name ),
					'new_item' => __( 'New Product', $this->plugin_name ),
					'view_item' => __( 'View Product', $this->plugin_name ),
					'search_item' => __( 'Search Products', $this->plugin_name ),
					'not_found' => __( 'No products found', $this->plugin_name ),
					'not_found_in_trash' => __( 'No products found in trash', $this->plugin_name ),
					'all_items' => __( 'All Products', $this->plugin_name ),
				),
				'public' => true,
				'has_archive' => true,
				'supports' => array( 'title', 'editor', 'author', 'revisions', 'thumbnail' ),
				'rewrite' => array( 'slug' => 'products' ),
				'menu_icon' => 'dashicons-products',
			)
		);
	}

	/**
	 * Defines the query variables used by the API.
	 *
	 * @param $vars     array   Existing query variables from WordPress.
	 * @return array    The $vars array appended with our new variables
	 */
	public function add_api_query_vars( $vars ) {
		// The parameter used for checking the action used
		$vars []= '__restaurateur_api';
	 
		// Additional parameters defined by the API requests
		$api_vars = $this->api->get_api_vars();
	 
		return array_merge( $vars, $api_vars );
	}
	
	/** This was added by admin@louiedogg.com **/
	/**
	 * Returns a list of variables used by the API
	 *
	 * @return  array    An array of query variable names.
	 */
	public function get_api_vars() {
		return array( 'l',  'e', 'p' );
	}

	/** This was added by admin@louiedogg.com **/
	/**
	 * A sniffer function that looks for API calls and passes them to our API handler.
	 */
	public function sniff_api_requests() {
		global $wp;
		if ( isset( $wp->query_vars['__restaurateur_api'] ) ) {
			$action = $wp->query_vars['__restaurateur_api'];
			$this->api->handle_request( $action, $wp->query_vars );
	 
			exit;
		}
	}
	
	/**
	 * The handler function that receives the API calls and passes them on to the
	 * proper handlers.
	 *
	 * @param $action   string  The name of the action
	 * @param $params   array   Request parameters
	 */
	public function handle_request( $action, $params ) {
		switch ( $action ) {
			case 'info':
				$response = $this->verify_license_and_execute( array( $this, 'product_info' ), $params );
				break;
	 
			case 'get':
				$response = $this->verify_license_and_execute( array( $this, 'get_product' ), $params );
				break;
				
	 
			default:
				$response = $this->error_response( 'No such API action' );
				break;
		}
	 
		$this->send_response( $response );
	}
	
	/**
	 * Prints out the JSON response for an API call.
	 *
	 * @param $response array   The response as associative array.
	 */
	private function send_response( $response ) {
		echo json_encode( $response );
	}
	
	/**
	 * The permalink structure definition for API calls.
	 */
	public function add_api_endpoint_rules() {
		add_rewrite_rule( 'api/restaurateur/v1/(info|get)/?',
			'index.php?__restaurateur_api=$matches[1]', 'top' );
	 
		// If this was the first time, flush rules
		if ( get_option( 'wp-restaurateur-rewrite-rules-version' ) != '1.1' ) {
			flush_rewrite_rules();
			update_option( 'wp-restaurateur-rewrite-rules-version', '1.1' );
		}
	}
	/** This was added by admin@louiedogg.com , also not sure if this goes here...**/
	/**
	 * The handler for the "info" request. Checks the user's license information and
	 * returns information about the product (latest version, name, update url).
	 *
	 * @param   $product        WP_Post   The product object
	 * @param   $product_id     string    The product id (slug)
	 * @param   $email          string    The email address associated with the license
	 * @param   $license_key    string  The license key associated with the license
	 *
	 * @return  array           The API response as an array.
	 */
	private function product_info( $product, $product_id, $email, $license_key ) {
		// Collect all the metadata we have and return it to the caller
		$meta = get_post_meta( $product->ID, 'wp_license_manager_product_meta', true );
	 
		$version = isset( $meta['version'] ) ? $meta['version'] : '';       
		$tested = isset( $meta['tested'] ) ? $meta['tested'] : '';
		$last_updated = isset( $meta['updated'] ) ? $meta['updated'] : '';
		$author = isset( $meta['author'] ) ? $meta['author'] : '';
		$banner_low = isset( $meta['banner_low'] ) ? $meta['banner_low'] : '';
		$banner_high = isset( $meta['banner_high'] ) ? $meta['banner_high'] : '';
	 
		return array(
			'name' => $product->post_title,
			'description' => $product->post_content,
			'version' => $version,
			'tested' => $tested,
			'author' => $author,
			'last_updated' => $last_updated,
			'banner_low' => $banner_low,
			'banner_high' => $banner_high,
			"package_url" => home_url( '/api/license-manager/v1/get?p=' . $product_id . '&e=' . $email . '&l=' . urlencode( $license_key ) ),
			"description_url" => get_permalink( $product->ID ) . '#v=' . $version
		);
	}
	
	/**
	 * The handler for the "get" request. Redirects to the file download.
	 *
	 * @param   $product    WP_Post     The product object
	 */
	private function get_product( $product, $product_id, $email, $license_key ) {
		// Get the AWS data from post meta fields
		$meta = get_post_meta( $product->ID, 'restaurateur_product_meta', true );
		$bucket = isset ( $meta['file_bucket'] ) ? $meta['file_bucket'] : '';
		$file_name = isset ( $meta['file_name'] ) ? $meta['file_name'] : '';
	 
		if ( $bucket == '' || $file_name == '' ) {
			// No file set, return error
			return $this->error_response( 'No download defined for product.' );
		}
	 
		// Use the AWS API to set up the download
		// This API method is called directly by WordPress so we need to adhere to its
		// requirements and skip the JSON. WordPress expects to receive a ZIP file...
	 
		$s3_url = restaurateur_S3::get_s3_url( $bucket, $file_name );
		wp_redirect( $s3_url, 302 );
	}


}
