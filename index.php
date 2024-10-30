<?php
/**
 * Plugin Name: HTML Page Editor
 * Plugin URI: https://lloanalas.com
 * Description: HTML Page Editor - Provides an alternative version of the editor for developers. This is the basic editor version, part of WP Admin Suite.
 * Version: 1.0.0
 * Author: Lloan Alas
 * Author URI: http://lloanalas.com
 * License: GPLv2 or later
 */

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

*/
function wpas_html_editor_get_current_user() {
	if (current_user_can( 'administrator' )) {
		include( 'wpas.php' );
		include( 'editor.php' );
		add_action( 'admin_enqueue_scripts', 'wpas_html_editor_general_resources' );
	}
}
add_action( 'init', 'wpas_html_editor_get_current_user', 10 );

?>
