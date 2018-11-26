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

 	public function register()//pour déclencher un nouveau controleur. Créer un CPT page et un CPT basic
 	{	
 		//Activer le CPT
 		$option = get_option( 'julie_plugin' );
		$activated = isset($option['cpt_manager']) ? $option['cpt_manager'] : false;

		//Vérif : var_dump($activated);

		if ( ! $activated ) return;
		

 		$this->settings = new SettingsApi();//3 nouvelle instance de SettingsApi dans la methode register

 		$this->callbacks = new AdminCallbacks();

 		$this->setSubpages();//4 appel de la méthod setSubpages

 		$this->settings->addSubPages( $this->subpages )->register();

 		add_action( 'init', array( $this, 'activate' ) );//appelle méthod init puis this classe sera liée à la méthode activate détaillée ci après
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


 	public function activate()
 	{
 		register_post_type('julie_slider',//nom du CPT
 			array(
 				'labels' => array(
 					'name' => 'Slider',
 					'singular_name' => 'Slider'
 				),
 				'public' => true,
 				'has_archive' => true,
 			)
 		);
 	}
 }