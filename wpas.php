<?php
// load all general resources for WPAS
function wpas_html_editor_general_resources() {
	wp_enqueue_style('wpas-bootstrap-css', plugin_dir_url( __FILE__ ) . 'css/bootstrap.css', false, null, false);
	wp_enqueue_style('wpas-switch', plugin_dir_url( __FILE__ ) . 'css/wpas.css', false, null, false);
	wp_enqueue_style('wpas-fontawesome', plugin_dir_url( __FILE__ ) . 'css/font-awesome.min.css', false, null, false);
	wp_enqueue_script('wpas-popper-js',    plugin_dir_url( __FILE__ ) . 'js/popper.js', 'jquery', null, true);
	wp_enqueue_script('wpas-bootstrap-js',  plugin_dir_url( __FILE__ ) . 'js/bootstrap.js','jquery' ,null, true);
}
?>

