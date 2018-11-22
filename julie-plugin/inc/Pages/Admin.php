<?php 
/**
 * @package  JuliePlugin
 */
namespace Inc\Pages;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\ManagerCallbacks;

/**
* 
*/
class Admin extends BaseController
{
	public $settings;

	public $callbacks;
	public $callbacks_mngr;

	public $pages = array();

	public $subpages = array();

	public function register() 
	{
		$this->settings = new SettingsApi();

		$this->callbacks = new AdminCallbacks();
		$this->callbacks_mngr = new ManagerCallbacks();

		$this->setPages();

		$this->setSubpages();

		$this->setSettings();
		$this->setSections();
		$this->setFields();

		$this->settings->addPages( $this->pages )->withSubPage( 'Options' )->addSubPages( $this->subpages )->register();
	}

	public function setPages() 
	{
		$this->pages = array(
			array(
				'page_title' => 'Julie Plugin', 
				'menu_title' => 'Julie Options', 
				'capability' => 'manage_options', 
				'menu_slug' => 'julie_plugin', 
				'callback' => array( $this->callbacks, 'adminDashboard' ), 
				'icon_url' => 'dashicons-store', 
				'position' => 110
			)
		);
	}

	public function setSubpages()
	{
		$this->subpages = array(
			array(
				'parent_slug' => 'julie_plugin', 
				'page_title' => 'Custom Post Types', 
				'menu_title' => 'CPT', 
				'capability' => 'manage_options', 
				'menu_slug' => 'julie_cpt', 
				'callback' => array( $this->callbacks, 'adminCpt' )
			),
			array(
				'parent_slug' => 'alecaddd_plugin', 
				'page_title' => 'Custom Taxonomies', 
				'menu_title' => 'Taxonomies', 
				'capability' => 'manage_options', 
				'menu_slug' => 'julie_taxonomies', 
				'callback' => array( $this->callbacks, 'adminTaxonomy' )
			),
			array(
				'parent_slug' => 'julie_plugin', 
				'page_title' => 'Custom Widgets', 
				'menu_title' => 'Widgets', 
				'capability' => 'manage_options', 
				'menu_slug' => 'julie_widgets', 
				'callback' => array( $this->callbacks, 'adminWidget' )
			)
		);
	}

//Regroupe toutes les options et d'appeler une callback
	public function setSettings()
	{
		$args = array(
			array(
				'option_group' => 'julie_plugin_settings',
				'option_name' => 'cpt_manager',
				'callback' => array( $this->callbacks, 'checkboxSanitize' )
			),
			array(
				'option_group' => 'julie_plugin_settings',
				'option_name' => 'taxonomy_manager',
				'callback' => array( $this->callbacks, 'checkboxSanitize' )
			),
			array(
				'option_group' => 'julie_plugin_settings',
				'option_name' => 'media_widget',
				'callback' => array( $this->callbacks, 'checkboxSanitize' )
			),
			array(
				'option_group' => 'julie_plugin_settings',
				'option_name' => 'gallery_manager',
				'callback' => array( $this->callbacks, 'checkboxSanitize' )
			),
			array(
				'option_group' => 'julie_plugin_settings',
				'option_name' => 'testimonial_manager',
				'callback' => array( $this->callbacks, 'checkboxSanitize' )
			),
			array(
				'option_group' => 'julie_plugin_settings',
				'option_name' => 'templates_manager',
				'callback' => array( $this->callbacks, 'checkboxSanitize' )
			),
			array(
				'option_group' => 'julie_plugin_settings',
				'option_name' => 'login_manager',
				'callback' => array( $this->callbacks, 'checkboxSanitize' )
			),
			array(
				'option_group' => 'julie_plugin_settings',
				'option_name' => 'membership_manager',
				'callback' => array( $this->callbacks, 'checkboxSanitize' )
			),
			array(
				'option_group' => 'julie_plugin_settings',
				'option_name' => 'chat_manager',
				'callback' => array( $this->callbacks, 'checkboxSanitize' )
			),
		);

		$this->settings->setSettings( $args );
	}

	public function setSections()
	{
		$args = array(
			array(
				'id' => 'julie_admin_index',
				'title' => 'Options du manager',
				'callback' => array( $this->callbacks_mngr, 'adminSectionManager' ),
				'page' => 'julie_plugin'
			)
		);

		$this->settings->setSections( $args );
	}

	public function setFields()
	{
		$args = array(
			array(
				'id' => 'cpt_manager',
				'title' => 'Activer la gestion des CPT',
				'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
				'page' => 'julie_plugin',
				'section' => 'julie_admin_index',//égal à l'ID dans setSection
				'args' => array(
					'label_for' => 'cpt_manager',
					'class' => 'ui-toggle'
				)
			),
			array(
				'id' => 'taxonomy_manager',
				'title' => 'Activer la gestion des taxonomy ',
				'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
				'page' => 'julie_plugin',
				'section' => 'julie_admin_index',//égal à l'ID dans setSection
				'args' => array(
					'label_for' => 'taxonomy_manager',
					'class' => 'ui-toggle'
				)
			),
			array(
				'id' => 'media_manager',
				'title' => 'Activer la gestion des médias',
				'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
				'page' => 'julie_plugin',
				'section' => 'julie_admin_index',//égal à l'ID dans setSection
				'args' => array(
					'label_for' => 'media_manager',
					'class' => 'ui-toggle'
				)
			),
			array(
				'id' => 'gallery_manager',
				'title' => 'Activer la gestion des images',
				'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
				'page' => 'julie_plugin',
				'section' => 'julie_admin_index',//égal à l'ID dans setSection
				'args' => array(
					'label_for' => 'gallery_manager',
					'class' => 'ui-toggle'
				)
			),
			array(
				'id' => 'testimonial_manager',
				'title' => 'Activer la gestion des commentaires',
				'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
				'page' => 'julie_plugin',
				'section' => 'julie_admin_index',//égal à l'ID dans setSection
				'args' => array(
					'label_for' => 'testimonial_manager',
					'class' => 'ui-toggle'
				)
			),
			array(
				'id' => 'templates_manager',
				'title' => 'Activer la gestion des templates',
				'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
				'page' => 'julie_plugin',
				'section' => 'julie_admin_index',//égal à l'ID dans setSection
				'args' => array(
					'label_for' => 'templates_manager',
					'class' => 'ui-toggle'
				)
			),
			array(
				'id' => 'login_manager',
				'title' => 'Activer la gestion du mot de passe',
				'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
				'page' => 'julie_plugin',
				'section' => 'julie_admin_index',//égal à l'ID dans setSection
				'args' => array(
					'label_for' => 'login_manager',
					'class' => 'ui-toggle'
				)
			),
			array(
				'id' => 'membership_manager',
				'title' => 'Activer la gestion des membres',
				'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
				'page' => 'julie_plugin',
				'section' => 'julie_admin_index',//égal à l'ID dans setSection
				'args' => array(
					'label_for' => 'membership_manager',
					'class' => 'ui-toggle'
				)
			),
			array(
				'id' => 'chat_manager',
				'title' => 'Activer la gestion du chat',
				'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
				'page' => 'julie_plugin',
				'section' => 'julie_admin_index',//égal à l'ID dans setSection
				'args' => array(
					'label_for' => 'chat_manager',
					'class' => 'ui-toggle'
				)
			)
		);

		$this->settings->setFields( $args );
	}
}