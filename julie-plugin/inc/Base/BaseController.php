<?php 
/**
 * @package  JuliePlugin
 */
namespace Inc\Base;

class BaseController
{
	public $plugin_path;

	public $plugin_url;

	public $plugin;

	public $managers = array();

	public function __construct() {
		$this->plugin_path = plugin_dir_path( dirname( __FILE__, 2 ) );
		$this->plugin_url = plugin_dir_url( dirname( __FILE__, 2 ) );
		$this->plugin = plugin_basename( dirname( __FILE__, 3 ) ) . '/julie-plugin.php';
//on se réfère à this class pour y attrinuer un tableau d'options : extension de la class admin s'appliquant à la méthode setFields
//tableau associatif clef => valeur

		$this->managers = array(
			'cpt_manager' => 'CPT Manager',
			'taxonomy_manager' => 'Taxonomy Manager',
			'media_widget' => 'Media Widget',
			'gallery_manager' => 'Gallery Manager',
			'testimonial_manager' => 'Testimonial Manager',
			'templates_manager' => 'Templates Manager',
			'login_manager' => 'Ajax Login/Signup',
			'membership_manager' => 'Membership Manager',
			'chat_manager' => 'Chat Manager'

		);
	}

	//Vérifier si l'option est activée
	//Si l'option n'existe pas ou n'a pas de valeur, la valeur de retour sera false.
	// Si la clef se retrouve dans la BDD on retourne la clef son false
	public function activated( string $key )
	{
		$option = get_option( 'julie_plugin' );

		return isset( $option[ $key ] ) ? $option[ $key ] : false;
	}
}