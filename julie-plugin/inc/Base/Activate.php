<?php
/**
 * @package  JuliePlugin
 */
namespace Inc\Base;

//Gestion de la première activation de plugin et autres options pour insérer un tableau vide dans la BDD au préalable sinon un bug apparaît
class Activate
{
	public static function activate() {
		flush_rewrite_rules();

		$default = array();//stock un tableau vide par défaut dans la BDD

		if ( ! get_option( 'julie_plugin' ) ) {//si on n'a pas l'option julie_plugin dans la BDD
			update_option( 'julie_plugin', $default );//alors mise à jour de l'option avec un tableau vide
		}

		if ( ! get_option( 'julie_plugin_cpt' ) ) {
			update_option( 'julie_plugin_cpt', $default );
		}
	}
}