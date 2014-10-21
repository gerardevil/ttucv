<?php
/*
Plugin Name: Widget Bootstrap Carousel using Netxgen Gallery
Version: 1.0
Plugin URI: http://blog.gopymes.pe/wordpress-widget-bootstrap-carousel-using-netxgen-gallery/
Description: This plugin is a widget that will made a Carousel Bootstrap using a gallery of the plugin Gallery Netxgen
Author: GoPymes SAC
Author URI: http://www.gopymes.pe/
*/
function gocarousel_bootstrap_widget(){
	require_once plugin_dir_path( __FILE__ ).'gocarouselboot.inc.php';
	register_widget('gocarouselboot');
}
add_action('widgets_init','gocarousel_bootstrap_widget');


function gocarousel_bootstrap_head() {
	if(get_option('gocaroboot_head')==1) {
		//plugin_dir_url() : The URL of the directory that contains the plugin, including a trailing slash ("/")
		$url_boot_css = plugin_dir_url( __FILE__ ).'bootstrap'.get_option('gocaroboot_version').'/css/bootstrap.min.css';
		$url_boot_js = plugin_dir_url( __FILE__ ).'bootstrap'.get_option('gocaroboot_version').'/js/bootstrap.min.js';

		wp_enqueue_style( 'gocarousel_bootstrap_css', $url_boot_css );
		wp_enqueue_script( 'gocarousel_bootstrap_js', $url_boot_js, array( 'jquery' ), '', true );
	}
}
add_action('wp_head', 'gocarousel_bootstrap_head');


/*******************************
	LINK ADMIN PLUGIN
********************************/
function gocarousel_bootstrap_links( $links ) {
	$settings = array(
		'settings' => sprintf('<a href="%s">%s</a>', admin_url( 'widgets.php' ), __( 'Goto Widgets', 'gocarousel' ) )
	);

	return array_merge( $settings, $links );
}
add_filter( 'plugin_action_links_'.plugin_basename( __FILE__ ), 'gocarousel_bootstrap_links' );

/*****************************
	LOCALIZATION
******************************/
function gocarousel_bootstrap_localization() {
	load_plugin_textdomain( 'gocarousel', false, dirname( plugin_basename( __FILE__ ) ).'/languages/' );
}
//add_action('plugins_loaded','gocarousel_bootstrap_localization');
?>