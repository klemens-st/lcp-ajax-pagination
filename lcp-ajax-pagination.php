<?php
/**
 * @package   Lcp_Ajax
 * @author    Klemens Starybrat
 * @license   GPL-3.0
 * @link      https://github.com/klemens-st/lcp-ajax-pagination
 * @copyright 2021 Klemens Starybrat
 *
 * @wordpress-plugin
 * Plugin Name:       LCP Ajax Pagination
 * Plugin URI:        https://github.com/klemens-st/lcp-ajax-pagination
 * Description:       Ajax pagination add-on plugin for List Category Posts.
 * Version:           0.1.5
 * Author:            Klemens Starybrat
 * Author URI:        https://github.com/klemens-st
 * License:           GPL-3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       lcp-ajax
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see https://www.gnu.org/licenses/gpl-3.0.txt.
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}

/**
 * Current plugin version.
 */
define( 'LCP_AJAX_VERSION', '0.1.5' );

/**
 * The core plugin class that is used to define plugin's hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-lcpax.php';

/**
 * Begins execution of the plugin.
 *
 * @since    0.1.0
 */
function lcpax_run() {

  $plugin = new Lcpax();
  $plugin->run();

}
lcpax_run();
