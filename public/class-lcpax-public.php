<?php
/**
 * LCP Ajax Pagination: Lcpax_Public class.
 *
 * This file defines the Lcpax_Public class.
 *
 * @author     Klemens Starybrat
 *
 * @package Lcp_Ajax\includes
 * @since 0.1.0
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and hooks for
 * the public-facing stylesheet and JavaScript.
 *
 * @package    Lcp_Ajax\public
 */
class Lcpax_Public {

  /**
   * The ID of this plugin.
   *
   * @since    0.1.0
   * @access   private
   * @var      string    $plugin_name    The ID of this plugin.
   */
  private $plugin_name;

  /**
   * The version of this plugin.
   *
   * @since    0.1.0
   * @access   private
   * @var      string    $version    The current version of this plugin.
   */
  private $version;

  /**
   * Stores information about LCP instances with ajax enabled.
   *
   * @since     0.1.0
   * @access    private
   * @var array An associative array in the format $instance => $ajax_mode.
   */
  private $lcp_instances = [];

  /**
   * Shortcode parameters that this plugin adds to LCP.
   *
   * @since     0.1.0
   * @access    private
   * @var array Shortcode parameters with default values.
   */
  private $shortcode_params = [
    'ajax_pagination' => '',
    'ajax_loadmore'   => '',
  ];

  /**
   * Initializes the class and sets its properties.
   *
   * @since    0.1.0
   * @param      string    $plugin_name  The name of the plugin.
   * @param      string    $version      The version of this plugin.
   */
  public function __construct( $plugin_name, $version ) {

    $this->plugin_name = $plugin_name;
    $this->version = $version;

  }

  /**
   * Registers the stylesheets for the public-facing side of the site.
   *
   * @since    0.1.0
   */
  public function enqueue_styles() {

    wp_register_style(
      $this->plugin_name,
      plugin_dir_url( __FILE__ ) . 'dist/main.min.css',
      array(), $this->version,
      'all'
    );

  }

  /**
   * Registers the JavaScript for the public-facing side of the site.
   *
   * @since    0.1.0
   */
  public function enqueue_scripts() {

    wp_register_script(
      $this->plugin_name,
      plugin_dir_url( __FILE__ ) . 'dist/main.min.js',
      array( 'jquery' ),
      $this->version,
      false );
  }

  /**
   * Parses this plugin's shortcode parameters that are present
   * in the LCP shortcode.
   *
   * This is a callback to the 'shortcode_atts_catlist' filter hook.
   *
   * @since    0.1.0
   *
   * @param  array $out   Output array of shortcode attributes
   * @param  array $pairs Supported attributes and their defaults.
   * @param  array $atts  User defined shortcode attributes.
   * @return array        Maybe modified ouput array.
   */
  public function parse_lcp_params( $out, $pairs, $atts ) {
    // Make sure only one lcp ajax shortcode parameter is used.
    if ( 1 !== count( array_intersect_key( $this->shortcode_params, $atts ) ) ) {
      return $out;
    }

    /*
     * Make sure pagination is set properly, for user convenience.
     * Adding pagination=yes to shortcodes is not required.
     */
    $out[ 'pagination' ] = 'yes';

    // Enqueue JS and CSS.
    wp_enqueue_script( $this->plugin_name );
    wp_enqueue_style( $this->plugin_name );

    // Load more feature.
    if ( isset( $atts[ 'ajax_loadmore' ] ) && 'yes' === $atts[ 'ajax_loadmore' ] ) {
      // Change default pagination_next.
      if ( $out[ 'pagination_next' ] ===  $pairs[ 'pagination_next' ] ) {
        $out[ 'pagination_next' ] = 'Load more';
      }

      // Assign the loadmore mode to this instance and store this information.
      $this->lcp_instances[ $out[ 'instance' ] ] = 'loadmore';
    }

    // Ajax pagination feature.
    if ( isset( $atts[ 'ajax_pagination' ] ) && 'yes' === $atts[ 'ajax_pagination' ] ) {
      // Assign the ajax_pagination mode to this instance and store this information.
      $this->lcp_instances[ $out[ 'instance' ] ] = 'pagination';
    }

    return $out;
  }

  /**
   * Manipulates output HTML of LCP pagination.
   *
   * We have to tell JS what behaviour (loadmore, ajax pagination)
   * should be applied to which LCP instance. This is done by changing
   * and/or adding classes to the pagination wrapper (lcp_paginator).
   *
   * This is a callback to the 'lcp_pagination_html' filter hook.
   *
   * @since    0.1.0
   * @see   LcpPaginator
   *
   * @param  string $pag_output  LCP pagination HTML.
   * @param  array  $params      Pagination params passed to the LcpPaginator class.
   * @param  int    $pages_count Total number of pages.
   * @return string              Maybe modified $pag_output.
   */
  public function modify_lcp_pagination( $pag_output, $params, $pages_count ) {
    // Check if this instance has ajax options enabled.
    if ( isset( $this->lcp_instances[ $params[ 'instance' ] ] ) ) {
      if ( 'loadmore' === $this->lcp_instances[ $params[ 'instance' ] ] ) {
        // Change class to apply this plugin's CSS and ignore LCP styles.
        $pag_output = str_replace(
          'lcp_paginator',
          "lcpax-loadmore lcpax-instance-{$params[ 'instance' ]}",
          $pag_output
        );

        // Add a spinner element for front end JS manipulation.
        $pag_output = str_replace(
          '</ul>',
          '<img ' .
            'src="' . esc_url( plugin_dir_url( __FILE__ ) ) . 'img/Spinner-1s-200px.svg" ' .
            'alt="' . __( 'Loading', 'lcp-ajax' ) . '" ' .
            'class="lcpax-spinner"' .
            '/></ul>',
          $pag_output
        );
      } else if ( 'pagination' === $this->lcp_instances[ $params[ 'instance' ] ] ) {
        $pag_output = str_replace(
          'lcp_paginator',
          "lcp_paginator lcpax-pagination lcpax-instance-{$params[ 'instance' ]}",
          $pag_output
        );
      }
    }

    return $pag_output;
  }
}
