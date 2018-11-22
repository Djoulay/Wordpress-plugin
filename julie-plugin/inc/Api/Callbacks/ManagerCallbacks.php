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
		// return filter_var($input, FILTER_SANITIZE_NUMBER_INT); : protection hack
		return ( isset($input) ? true : false );
	}

	public function adminSectionManager()
	{
		echo 'Gérez les sections et les fonctionnalités de ce plug-in en cochant les cases de la liste suivante.';
	}

//Génère automatiquement les champs : cocher décocher les options
	public function checkboxField( $args )
	{
		$name = $args['label_for'];
		$classes = $args['class'];
		$checkbox = get_option( $name );
		echo '<div class="' . $classes . '"><input type="checkbox" id="' . $name . '" name="' . $name . '" value="1" class="" ' . ($checkbox ? 'checked' : '') . '><label for="' . $name .'"><div></div></label></div>';
	}
}