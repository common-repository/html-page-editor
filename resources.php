<?php

function wpas_html_editor_resources() {

	if (get_current_screen()){
		$screen = get_current_screen();

		if ($screen->id == 'page'){
			// all files loaded from local folder
			wp_enqueue_script( 'wpas-editor', plugin_dir_url( __FILE__ ) . 'js/editor.js', null, false, false );

			wp_enqueue_script( 'wpas-html', plugin_dir_url( __FILE__ ) . 'js/modes/htmlmixed.js', 'wpas-editor', false, true );
			wp_enqueue_script( 'wpas-xml', plugin_dir_url( __FILE__ ) . 'js/modes/xml.js', 'wpas-editor', false, true );
			wp_enqueue_script( 'wpas-css', plugin_dir_url( __FILE__ ) . 'js/modes/css.js', 'wpas-editor', false, true );
			wp_enqueue_script( 'wpas-js', plugin_dir_url( __FILE__ ) . 'js/modes/javascript.js', 'wpas-editor', false, true );
			wp_enqueue_script( 'wpas-php', plugin_dir_url( __FILE__ ) . 'js/modes/php.js', 'wpas-editor', false, true );

			wp_enqueue_script( 'wpas-sublime-keymap ', plugin_dir_url( __FILE__ ) . 'js/keymap/sublime.js', 'wpas-editor', false, true );
			wp_enqueue_script( 'wpas-emmet', plugin_dir_url( __FILE__ ) . 'js/keymap/emmet.js', 'wpas-editor', false, false );

			wp_deregister_style('wpas-bootstrap-css');
			wp_enqueue_style( 'wpas-editor-styles', plugin_dir_url( __FILE__ ) . 'css/editor.css', 'wpas-editor', false, false );
			wp_enqueue_script('wpas-bootstrap-css');

			wp_enqueue_style( 'wpas-editor-emmet', plugin_dir_url( __FILE__ ) . 'css/emmet.css', 'wpas-editor', false, false );

			wp_enqueue_script( 'wpas-editor-utilities', plugin_dir_url( __FILE__ ) . 'js/utilities/utilities.js', 'wpas-editor', false, false );

			$editor_options = get_option('wpas_editor');
			wp_enqueue_style( 'wpas-editor-theme', plugin_dir_url( __FILE__ ) . 'css/themes/' .  $editor_options->theme  .'.css', false, false );
		}
	} else {
		echo 'Screen not defined';
	}

}
add_action( 'admin_enqueue_scripts', 'wpas_html_editor_resources' );