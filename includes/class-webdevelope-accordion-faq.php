<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.webdevelope.net
 * @since      1.0.0
 *
 * @package    iProDev_Accordion_Faq
 * @subpackage iProDev_Accordion_Faq/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    iProDev_Accordion_Faq
 * @subpackage iProDev_Accordion_Faq/includes
 * @author     iProDev
 */
class iProDev_Accordion_Faq {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      iProDev_Accordion_Faq_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */

	protected $options;

	public function __construct() {
		$skelet_wdfa        = new Skelet("wdfa");
		$this->plugin_name  = 'webdevelope-accordion-faq';
		$this->version      = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - iProDev_Accordion_Faq_Loader. Orchestrates the hooks of the plugin.
	 * - iProDev_Accordion_Faq_i18n. Defines internationalization functionality.
	 * - iProDev_Accordion_Faq_Admin. Defines all hooks for the admin area.
	 * - iProDev_Accordion_Faq_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-webdevelope-accordion-faq-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-webdevelope-accordion-faq-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-webdevelope-accordion-faq-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-webdevelope-accordion-faq-public.php';

		$this->loader = new iProDev_Accordion_Faq_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the iProDev_Accordion_Faq_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new iProDev_Accordion_Faq_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$wdfa = new Skelet( 'wdfa' );

		$plugin_admin = new iProDev_Accordion_Faq_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        $this->loader->add_action( 'plugin_row_meta',       $plugin_admin, 'row_links', 10, 2 );
        $this->loader->add_action( 'plugin_action_links_' . $this->get_plugin_name()."/".$this->get_plugin_name().".php", $plugin_admin, 'settings_link' );
		//register post type
		$this->loader->add_action( 'init',                  $plugin_admin, 'register_cpt' );
		//register taxonomy
		$this->loader->add_action( 'init',                  $plugin_admin, 'register_taxonomy' );

		if( $wdfa->get('reorder') == 1 ) {

			global $pagenow;

			if( $pagenow == 'edit.php') {
				if ( isset($_GET['post_type'] ) && 'faq' == $_GET['post_type'] ) {
					$this->loader->add_action( 'admin_head',    $plugin_admin, 'order_load_scripts', 20 );
					$this->loader->add_action( 'pre_get_posts', $plugin_admin, 'order_reorder_list' );
				}
			} elseif( $pagenow == 'edit-tags.php' ) {
				if ( isset($_GET['post_type']) && 'faq' == $_GET['post_type'] ) {
					$this->loader->add_action( 'admin_head',        $plugin_admin, 'order_load_scripts_taxonomies', 20 );
					$this->loader->add_action( 'get_terms_orderby', $plugin_admin, 'order_reorder_taxonomies_list', 10, 2 );
				}
			}

			//ajax hooks
			if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
				$this->loader->add_action( 'wp_ajax_wdfa_order_update_posts',       $plugin_admin, 'order_save_order' );
				$this->loader->add_action( 'wp_ajax_wdfa_order_update_taxonomies',  $plugin_admin, 'order_save_taxonomies_order' );
			}
		}

		$this->loader->add_action( 'manage_faq_category_custom_column', $plugin_admin, 'manage_faq_category_custom_column', 10, 3 );
		$this->loader->add_action( 'manage_faq_posts_custom_column',    $plugin_admin, 'manage_faq_custom_column' );
		$this->loader->add_action( 'restrict_manage_posts',             $plugin_admin, 'restrict_manage_posts' );
		$this->loader->add_action( 'faq_category_edit_form_fields',     $plugin_admin, 'faq_category_edit_form_fields' );
		$this->loader->add_action( 'manage_edit-faq_category_columns',  $plugin_admin, 'manage_edit_faq_category_columns' );
		$this->loader->add_action( 'manage_edit-faq_columns',           $plugin_admin, 'manage_edit_faq_columns' );

		//help tab
		//$this->loader->add_action( 'admin_print_scripts', 		        $plugin_admin, 'help_tab' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new iProDev_Accordion_Faq_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'init',				 $plugin_public, 'register_shortcodes' );
		$this->loader->add_action( 'wp_head',        	 $plugin_public, 'dynamic_css' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    iProDev_Accordion_Faq_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
