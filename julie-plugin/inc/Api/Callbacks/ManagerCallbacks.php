<?php 
/**
 * @package  JuliePlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class ManagerCallbacks extends BaseController
{
	public function checkboxSanitize( $input )
	{
		$output = array();
		foreach ( $this->managers as $key => $value) {
			$output[$key] = isset($input[$key]) ? true : false; // s'il y a une clef return true sinon false
		}
		return $output;
	}

	public function adminSectionManager()
	{
		echo 'Gérez les sections et les fonctionnalités de ce plug-in en cochant les cases de la liste suivante.';
	}

//Génère automatiquement les champs : cocher décocher les options
//Rassemblement des données sur les options dans un même champs sur la BDD : sérialiser les données comme le fait wordpress
//Exemple table info_option: a:9:{s:11:"cpt_manager";b:0;s:16:"taxonomy_manager";b:0;s:12:"media_widget";b:0;s:15:"gallery_manager";b:1;s:19:"testimonial_manager";b:0;s:17:"templates_manager";b:1;s:13:"login_manager";b:1;s:18:"membership_manager";b:1;s:12:"chat_manager";b:1;}

//$option_name : julie_plugin
	public function checkboxField( $args )
	{
		$name = $args['label_for'];
		$classes = $args['class'];
		$option_name = $args['option_name'];
		$checkbox = get_option( $option_name );

		$checked = isset($checkbox[$name]) ? ($checkbox[$name] ? true : false) : false;
		echo '<div class="' . $classes . '"><input type="checkbox" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="1" class="" ' . ( $checked ? 'checked' : '') . '><label for="' . $name .'"><div></div></label></div>';
	}
}
//Double condition ternaire : isset si un nom d'option est défini et est différent de NULL : alors $cheked = true sinon false
//$checkbox[$name] ? 'checked' : si $name est dans la BDD return checked
//( $checked ? 'checked' : '') : si $checked = true alors affiché checked sinon rien