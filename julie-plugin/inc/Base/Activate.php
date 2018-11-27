<?php
/**
 * @package  JuliePlugin
 */
namespace Inc\Base;

class Activate
{
	public static function activate() {
		flush_rewrite_rules();

		if ( get_option( 'julie_plugin' ) ) {
			return;
		}

		$default = array();

		update_option( 'julie_plugin', $default );
	}
}