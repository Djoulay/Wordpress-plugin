<?php
/**
 * @package  JuliePlugin
 */
namespace Inc\Base;

use Inc\Api\SettingsApi;//1 appel des classes nécesaires
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;

/**
 * 
 **/
 
 class CustomPostTypeController extends BaseController
 {
 	public $callbacks;

 	public $subpages = array();//2 déclaration d'un tableau vide stocké dans une variable publique

 	public $custom_post_types = array();//A : déclaration d'une liste de CPT

 	public function register()//pour déclencher un nouveau controleur. Créer un CPT page et un CPT basic
 	{	

		if ( ! $this->activated ( 'cpt_manager' ) ) return; //'il n'y a pas de cpt_manager affiché suite à l'exécution de la méthode activated alors return : stop la méthode register
		
 		$this->settings = new SettingsApi();//3 nouvelle instance de SettingsApi dans la methode register

 		$this->callbacks = new AdminCallbacks();

 		$this->setSubpages();//4 appel de la méthod setSubpages

 		$this->settings->addSubPages( $this->subpages )->register();

 		$this->storeCpt();

 		//Toujours éviter de lancer une méthode inutilement s'il n'y en a pas besoin
 		if ( ! empty( $this->custom_post_types ) ) {//si le tableau de CPT n'est pas vide
			add_action( 'init', array( $this, 'registerCpt' ) );//appelle méthod init puis this classe sera liée à la méthode registerCpt détaillée ci après
			}

	}

 	public function setSubpages()
	{
		$this->subpages = array(
			array(
				'parent_slug' => 'julie_plugin', 
				'page_title' => 'Custom Post Types', 
				'menu_title' => 'CPT Manager', 
				'capability' => 'manage_options', 
				'menu_slug' => 'julie_cpt', 
				'callback' => array( $this->callbacks, 'adminCpt' )
			),
		);
	}

//POUR CHAQUE CUSTOM POST TYPE INSERE DANS LE TABLEAU MULTIDIMENSIONNEL
 	public function storeCpt()
 	{
 		$this->custom_post_types = array(
 			array(
 				'post_type' => 'julie_slider',//ID
 				'name' => 'Slider',
 				'singular_name' => 'Slider',
 				'public' => true,
 				'has-archive' => true
 			), array(
 				'post_type' => 'julie_leasing',//ID
 				'name' => 'Cell Phone Rental',
 				'singular_name' => 'Cell Phone Rental',
 				'public' => true,
 				'has-archive' => false
 			)
 		);
 	}


//JE VEUX ENREGISTRER LE CPT
 	public function registerCpt()
 	{
 		foreach ($this->custom_post_types as $post_type) {
 			register_post_type( $post_type['post_type'],//nom du CPT =>ex julie_slider
 				array(
 					'labels' => array(
 						'name' => $post_type['name'],
 						'singular_name' => $post_type['singular_name']
 					),
 					'public' => $post_type['public'],
 					'has_archive' => $post_type['post_type']
 				)
 			);
 		}
 	}
 }