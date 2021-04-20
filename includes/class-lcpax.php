<?php
/**
 * LCP Ajax Pagination: Lcpax class.
 *
 * This file defines the Lcpax class.
 *
 * @author     Klemens Starybrat
 *
 * @package Lcp_Ajax\includes
 * @since 0.1.0
 */

/**
 * The core plugin class.
 *
 * This is used to define hooks and load dependencies.
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      0.1.0
 */
class Lcpax {

  /**
   * The loader that's responsible for maintaining and registering all hooks that power
   * the plugin.
   *
   * @since    0.1.0
   * @access   protected
   * @var      Lcpax_Loader    $loader    Maintains and registers all hooks for the plugin.
   */
  protected $loader;

  /**
   * The unique identifier of this plugin.
   *
   * @since    0.1.0
   * @access   protected
   * @var      string    $plugin_name    The string used to uniquely identify this plugin.
   */
  protected $plugin_name;

  /**
   * The current version of the plugin.
   *
   * @since    0.1.0
   * @access   protected
   * @var      string    $version    The current version of the plugin.
   */
  protected $version;

  /**
   * Defines the core functionality of the plugin.
   *
   * Sets the plugin name and the plugin version that can be used throughout the plugin.
   * Loads the dependencies, defines the locale, and sets the hooks for the admin area and
   * the public-facing side of the site.
   *
   * @since    0.1.0
   */
  public function __construct() {
    if ( defined( 'LCP_AJAX_VERSION' ) ) {
      $this->version = LCP_AJAX_VERSION;
    } else {
      $this->version = '0.1.0';
    }
    $this->plugin_name = 'lcp-ajax';

    $this->load_dependencies();
    // $this->define_admin_hooks();
    $this->define_public_hooks();

  }

  /**
   * Loads the required dependencies for this plugin.
   *
   * Included the following files that make up the plugin:
   *
   * - Lcpax_Loader. Orchestrates the hooks of the plugin.
   * - Lcpax_Public. Defines all hooks for the public area.
   *
   * Create an instance of the loader which will be used to register the hooks
   * with WordPress.
   *
   * @since    0.1.0
   * @access   private
   */
  private function load_dependencies() {

    /**
     * The class responsible for orchestrating the actions and filters of the
     * core plugin.
     */
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-lcpax-loader.php';

    /**
     * The class responsible for defining all actions that occur in the admin area.
     */
    // require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-lcpax-admin.php';

    /**
     * The class responsible for defining all actions that occur in the public-facing
     * side of the site.
     */
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-lcpax-public.php';

    $this->loader = new Lcpax_Loader();

  }

  /**
   * Registers all of the hooks related to the admin area functionality
   * of the plugin.
   *
   * @since    0.1.0
   * @access   private
   */
  private function define_admin_hooks() {

    // $plugin_admin = new Lcpax_Admin( $this->get_plugin_name(), $this->get_version() );

  }

  /**
   * Registers all of the hooks related to the public-facing functionality
   * of the plugin.
   *
   * @since    0.1.0
   * @access   private
   */
  private function define_public_hooks() {

    $plugin_public = new Lcpax_Public( $this->get_plugin_name(), $this->get_version() );

    // Styles and scripts.
    $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
    $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

    // LCP hooks.
    $this->loader->add_filter( 'shortcode_atts_catlist', $plugin_public, 'parse_lcp_params', 10, 3 );
    $this->loader->add_filter( 'lcp_pagination_html', $plugin_public, 'modify_lcp_pagination', 10, 3 );

  }

  /**
   * Runs the loader to execute all of the hooks with WordPress.
   *
   * @since    0.1.0
   */
  public function run() {
    $this->loader->run();
  }

  /**
   * The name of the plugin used to uniquely identify it within the context of
   * WordPress.
   *
   * @since     0.1.0
   * @return    string    The name of the plugin.
   */
  public function get_plugin_name() {
    return $this->plugin_name;
  }

  /**
   * The reference to the class that orchestrates the hooks with the plugin.
   *
   * @since     0.1.0
   * @return    Lcpax_Loader    Orchestrates the hooks of the plugin.
   */
  public function get_loader() {
    return $this->loader;
  }

  /**
   * Retrieves the version number of the plugin.
   *
   * @since     0.1.0
   * @return    string    The version number of the plugin.
   */
  public function get_version() {
    return $this->version;
  }

}
