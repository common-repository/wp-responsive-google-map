<?php
/*
 * Plugin Name: Wordpress responsive google map
 * Plugin URI: https://wordpress.org/plugins/wp-responsive-google-map/
 * Description: A Responsive Google Maps plugin to display custom markers on the google maps. Show custom message with links on a marker click.
 * Author: SOftas
 * Author URI: http://nerijuso.lt
 * Version: 1.0.0
 * Text Domain: wp-responsive-google-map
 * Domain Path: /lang/
 */
defined('ABSPATH') or die('Cheatin\' uh?');

if (! class_exists('NOResponsiveGoogleMaps')) {

    class NOResponsiveGoogleMaps
    {

        private $activeModules = array();
        
        public function __construct()
        {
            $this->defineConstants();
            $this->loadModulesFiles();
            register_activation_hook(__FILE__, array(
                $this,
                'pluginActivation'
            ));
            register_deactivation_hook(__FILE__, array(
                $this,
                'plugin_deactivation'
            ));
            
            if (is_multisite()) {
                add_action('wpmu_new_blog', array(
                    $this,
                    'wpgmp_on_blog_new_generate'
                ), 10, 6);
                add_filter('wpmu_drop_tables', array(
                    $this,
                    'wpgmp_on_blog_delete'
                ));
            }
            
            // add_action( 'plugins_loaded', array( $this, 'load_plugin_languages' ) );
            add_action('init', array(
                $this,
                'initRGM'
            ));
            add_action('widgets_init', array(
                $this,
                'wpgmp_google_map_widget'
            ));
         
            
        }
        
        function afterPluginActivation(  ) {
        		exit( wp_redirect( admin_url( 'admin.php?page=rgm_view_docs' ) ) );
        	
        }
        
        /**
         * Call hook on plugin activation for both multi-site and single-site.
         */
        function pluginActivation( $network_wide ) {
        
            if ( is_multisite() && $network_wide ) {
                global $wpdb;
                $currentblog = $wpdb->blogid;
                $activated = array();
                $sql = "SELECT blog_id FROM {$wpdb->blogs}";
                $blog_ids = $wpdb->get_col( $wpdb->prepare( $sql, null ) );
        
                foreach ( $blog_ids as $blog_id ) {
                    switch_to_blog( $blog_id );
                    $this->activateRGMPlugin();
                    $activated[] = $blog_id;
                }
        
                switch_to_blog( $currentblog );
                update_site_option( 'op_activated', $activated );
        
            } else {
                $this->activateRGMPlugin();
            }
            
            add_option('rgm_do_activation_redirect', true);
            
            
        }
        
        
        function rgmAdminInit() {
        	if (get_option('rgm_do_activation_redirect', false)) {
        		delete_option('rgm_do_activation_redirect');
        		if(!isset($_GET['activate-multi']))
        		{
        			$this->afterPluginActivation();exit;
        		}
        	}
        }
        
        function activateRGMPlugin() {
        
            global $wpdb;
       
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        
            $modules = $this->activeModules;
            $pagehooks = array();
           
            if ( is_array( $modules ) ) {
                foreach ( $modules as $module ) {
                    $object = new $module;
                   
                    if ( method_exists( $object,'install' ) ) {
                        $tables[] = $object->install();
                    }
                }
            }
        
            if ( is_array( $tables ) ) {
                foreach ( $tables as $i => $sql ) {
                    dbDelta( $sql );
                }
            }
        
        }

        private function defineConstants()
        {
            global $wpdb;
            
            define('RGM_ASSETS_IMG_URL', realpath(plugin_dir_url(__FILE__) . 'img/') . '/img');
            define('RGM_VERSION', '1.0.0');
            
            if (! defined('RGM_DIR')) {
                define('RGM_DIR', plugin_dir_path(__FILE__));
            }
            
            if (! defined('RGM_PLUGIN_CLASSES')) {
                define('RGM_PLUGIN_CLASSES', RGM_DIR . 'classes/');
            }
            
            if (! defined('RGM_FOLDER')) {
                define('RGM_FOLDER', basename(dirname(__FILE__)));
            }
            
            if (! defined('RGM_TEXT_DOMAIN')) {
                define('RGM_TEXT_DOMAIN', 'wp-responsive-google-map');
            }
            
            if (! defined('RGM_SLUG')) {
                define('RGM_SLUG', 'rgm_view_overview');
            }
            
            if (! defined('RGM_URL')) {
                define('RGM_URL', plugin_dir_url(RGM_FOLDER) . RGM_FOLDER . '/');
            }
            
            if (! defined('RGM_IMAGES')) {
                define('RGM_IMAGES', RGM_URL . 'assets/images/');
            }
            
            if (! defined('RGM_MODEL')) {
                define('RGM_MODEL', RGM_DIR . 'inc/modules/');
            }
            
            if (! defined('RGM_CLASSES')) {
            	define('RGM_CLASSES', RGM_DIR . 'inc/classes/');
            }
            
            if (! defined('RGM_CSS')) {
                define('RGM_CSS', RGM_URL.'assets/css/');
            }
            
            if (! defined('RGM_JS')) {
            	define('RGM_JS', RGM_URL.'assets/js/');
            }
            
        }
        

        function initRGM()
        {
            global $wpdb;
            
            add_action('admin_menu', array(
                $this,
                'createAdminMenu'
            ));
            
            add_shortcode( 'rgm_view_map', array( $this, 'rgmViewMap' ) );
            
            add_action( 'wp_enqueue_scripts', array( $this, 'rgmAddFrontendScripts' ) );
            
            
            add_action( 'admin_init', array( $this, 'rgmAdminInit' ) );
            
            // add_action( 'admin_print_scripts', array( $this, 'wpgmp_backend_styles' ) );
        }
        
        function rgmViewMap ($atts) {
        	return RGM_Shortcodes::showMap($atts);
        }

        function createAdminMenu()
        {
            $pagehook = add_menu_page(__('Google Maps', RGM_TEXT_DOMAIN), __('Google Maps', RGM_TEXT_DOMAIN), 'rgm_admin_options', RGM_SLUG, array( $this,'processor' ), RGM_IMAGES . '/rgm.png', 10);
            
            if ( current_user_can( 'manage_options' )  ) {
                $role = get_role( 'administrator' );
                $role->add_cap( 'rgm_admin_options' );
            }
            
            $this->loadModulesMenu();
            
             add_action( 'load-'.$pagehook, array( $this, 'rgmBackendScripts' ) );
        }
        
        function loadModulesMenu()
        {
            
            $modules = $this->activeModules;
			$pagehooks = array();
			if ( is_array( $modules ) ) {
				foreach ( $modules as $module ) {

					$object = new $module;

					if ( method_exists( $object, 'navigation' ) ) {

						if ( ! is_array( $object->navigation() ) ) {
							continue;
						}

						foreach ( $object->navigation() as $nav => $title ) {

						    if ( current_user_can( 'manage_options' ) && is_admin() ) {
								$role = get_role( 'administrator' );
								$role->add_cap( $nav );
							}
						    
							$pagehooks[] = add_submenu_page(
								RGM_SLUG,
								$title,
								$title,
								$nav,
								$nav,
								array( $this, 'processor' )
							);

						}
					}
				}
			}
			
			if ( is_array( $pagehooks ) ) {
			
			    foreach ( $pagehooks as $key => $pagehook ) {
			        add_action( 'load-'.$pagehooks[ $key ], array( $this, 'rgmBackendScripts' ) );
			    }
			}
        }
        
        function rgmBackendScripts () {
        
            $admin_styles = array(
                'rgm-backend-style' => RGM_CSS.'admin.css',
            );
            
            if ( $admin_styles ) {
                foreach ( $admin_styles as $admin_style_key => $admin_style_value ) {
                    wp_enqueue_style( $admin_style_key, $admin_style_value );
                }
            }
        }
        
        function rgmAddFrontendScripts () {
        	wp_enqueue_script( 'jquery' );
        	
        	if ( isset( $_SERVER['HTTPS'] ) && ( 'on' == $_SERVER['HTTPS'] || 1 == $_SERVER['HTTPS'] ) || isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && 'https' == $_SERVER['HTTP_X_FORWARDED_PROTO'] ) {
        		$protocol = 'https';
        	} else {
        		$protocol = 'http';
        	}
        	
        	$language = get_option( 'rgm_language' );
        	
        	if ( $language == '' ) {
        		$language = 'en';
        	}
        	
        	if ( get_option( 'rgm_api_key' ) != '' ) {
        		$gjs = $protocol.'://maps.google.com/maps/api/js?key='.get_option( 'rgm_api_key' ).'&v=3.exp&libraries=geometry,places,weather,panoramio,drawing&language='.$language;
        	} else {
        		$gjs = $protocol.'://maps.google.com/maps/api/js?libraries=geometry,places,weather,panoramio,drawing&v=3.exp&language='.$language;
        	}
        	
        	
        	$scripts[] = array(
        			'handle'  => 'rgm-google-api',
        			'src'   => $gjs,
        			'deps'    => array(),
        	);
        	
        	$scripts[] = array(
        			'handle'  => 'rgm-frontend',
        			'src'   => RGM_JS.'frontend.js',
        			'deps'    => array(),
        	);
        	
        	
        	if ( $scripts ) {
        		foreach ( $scripts as $script ) {
        			wp_register_script( $script['handle'], $script['src'], $script['deps'], '', false);
        		}
        	}
        	
        }
        
        function processor()
        {
            error_reporting(E_ERROR | E_PARSE);
            
            $return = '';
            if (isset($_GET['page'])) {
                $page = sanitize_text_field(wp_unslash($_GET['page']));
            } else {
                $page = RGM_SLUG;
            }
            
            $pageData = explode('_', $page);
            $obj_type = $pageData[2];
            $obj_operation = $pageData[1];
           
            if (count($pageData) < 3) {
                die('Cheating!');
            }
            
            try {
                if (count($pageData) > 3) {
                    $obj_type = $pageData[2] . '_' . $pageData[3];
                }
               
                if(file_exists(RGM_MODEL. "{$obj_type}/views/".$obj_operation.'.php')) {
                    
                    if ( isset( $_POST['operation'] ) and sanitize_text_field( wp_unslash( $_POST['operation'] ) ) != '' ) {
                        $operation = sanitize_text_field( wp_unslash( $_POST['operation'] ) );
                        
                        $class_name =  'RGM_' . ucwords($obj_type);
                        $class = new $class_name;
                       
                        if(method_exists($class, $operation)){
                            $response = $class->$operation();
                        }
                    }
                    
                    if (isset($_GET['doaction']) && $_GET['doaction'] == 'edit' && isset($_GET['id']) && (int)$_GET['id'] > 0 ) {
                    	$class_name =  'RGM_' . ucwords($obj_type);
                    	$class = new $class_name;
                    	$response['data'] = $class->fetch($_GET['id']);
                    }
                  
                    return include( RGM_MODEL. "{$obj_type}/views/".$obj_operation .'.php');
                } 
                
            } catch (Exception $e) {
              
            }
        }

        private function loadModulesFiles()
        {
        	$plugin_files_to_include = array('rgm_wp_list_table.php', 'rgm_shortcodes.php', 'rgm_helper_functions.php');
        	
        	foreach ( $plugin_files_to_include as $file ) {
        		
        		if(file_exists(RGM_CLASSES . $file))
        			require_once( RGM_CLASSES. $file );
        	}
        	
            // Load all modules.
            $coreModules = array(
                'location',
                'settings',
                'docs',
                
            );
            if (is_array($coreModules)) {
                foreach ($coreModules as $module) {
                    
                    $file = RGM_MODEL . $module . '/' . $module . '.php';
                  
                    if (file_exists($file)) {
                        include_once ($file);
                        $class_name = 'RGM_' . ucwords($module);
                        array_push($this->activeModules , $class_name);
                    }
                }
            }
        }
    }
}

new NOResponsiveGoogleMaps();