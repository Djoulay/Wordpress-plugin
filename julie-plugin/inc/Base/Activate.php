<?php
/**
 * @package  JuliePlugin
 */
namespace Inc\Base;

class Activate
{
	public static function activate() {
		flush_rewrite_rules();

		if ( get_option( 'julie_plugin') ) {//si on a une option de sauvegardée alors on stop l'execution du script : on ne veut pas d'enregistrement d'option avant d'y avoir insérer un tableau de données vide pour contourner le bug
			return;
		}

		$default = array();

		update_option( 'julie_plugin', $default );
	}
}