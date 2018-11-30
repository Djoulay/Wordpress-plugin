<?php 
/**
 * @package  JuliePlugin
 */
namespace Inc\Api\Callbacks;

class CptCallbacks
{

	public function cptSectionManager()
	{
		echo 'Créez vos Custom Post Types';
	}

	//Reprise des input par wordpress pour les passer en BDD
	public function cptSanitize( $input )
	{
		//var_dump($input);
		//die();//----->array(5) { ["post_type"]=> string(8) "ustainfo" ["singular_name"]=> string(9) "Usta info" ["plural_name"]=> string(10) "Usta Infos" ["public"]=> string(1) "1" ["has_archive"]=> string(1) "1" }
		$output = get_option('julie_plugin_cpt');//on prend en compte les infos qu'il y a déjà dans la BDD

		if ( count($output ) == 0 ) {//s'il n'y a rien d'entrer dans les champs
			$output[$input['post_type']] = $input;//on stock le nouveau CPT

			return $output;
		}

		//S'il y a des données dans la BDD
		//si l'input post type est égal à la clef alors mise à jour de la clef sinon on prend en compte cette nouvelle clef
		foreach ($output as $key => $value) {
			if ($input['post_type'] === $key) {
				$output[$key] = $input;
			} else {
				$output[$input['post_type']] = $input;
			}
		}
		
		return $output;
	}



	public function textField( $args )
	{
		$name = $args['label_for'];
		$option_name = $args['option_name'];
		$input = get_option( $option_name );
	

		echo '<input type="text" class="regular-text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="" placeholder="' . $args['placeholder'] . '">';
	}

	public function checkboxField( $args )
	{
		$name = $args['label_for'];
		$classes = $args['class'];
		$option_name = $args['option_name'];
		$checkbox = get_option( $option_name );

		echo '<div class="' . $classes . '"><input type="checkbox" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="1" class=""><label for="' . $name . '"><div></div></label></div>';
	}
}