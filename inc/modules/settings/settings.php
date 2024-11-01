<?php

if ( ! class_exists( 'RGM_Settings' ) ) {

	class RGM_Settings {
		/**
		 * Intialize Backup object.
		 */
		function __construct() {
		    
		    
		}
		
		/**
		 * Admin menu for Settings Operation
		 * @return array Admin menu navigation(s).
		 */
		function navigation() {
			return array(
				'rgm_manage_settings' => __( 'Settings', RGM_TEXT_DOMAIN ),
			);
		}
		
		/**
		 * Add or Edit Operation.
		 */
		function save() {
		    if( isset($_POST['rgmSaveSettingsAction'])) {
		       
    			if ( isset( $_REQUEST['_wpnonce'] ) ) {
    				$nonce = sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce'] ) ); }
    
    			if ( isset( $nonce ) and ! wp_verify_nonce( $nonce, 'rgm-nonce' ) ) {
    
    				die( 'Cheating...' );
    
    			}
    			
    			if( isset($_POST['rgm_center_lat']) && isset($_POST['rgm_center_long']) && isset($_POST['rgm_map_zoom_level']) && isset($_POST['rgm_api_key']) &&  $_POST['rgm_center_lat'] != '' &&  $_POST['rgm_center_long'] != '' &&  $_POST['rgm_map_zoom_level'] != ''&&  $_POST['rgm_api_key'] != '' && isset($_POST['rgm_language']) && $_POST['rgm_language'] != '') {
    		
        			update_option( 'rgm_language', sanitize_text_field( wp_unslash( $_POST['rgm_language'] ) ) );
        			update_option( 'rgm_api_key', sanitize_text_field( wp_unslash( $_POST['rgm_api_key'] ) ) );
        			update_option( 'rgm_center_lat', sanitize_text_field( wp_unslash( $_POST['rgm_center_lat'] ) ) );
        			update_option( 'rgm_center_long', sanitize_text_field( wp_unslash( $_POST['rgm_center_long'] ) ) );
        			update_option( 'rgm_map_zoom_level', sanitize_text_field( wp_unslash( $_POST['rgm_map_zoom_level'] ) ) );
        			
        			
        			$response['success'] = __( 'Setting(s) saved successfully.', RGM_TEXT_DOMAIN );
    			} else {
    			    $response['error'] = __( 'Please fill required fields', RGM_TEXT_DOMAIN );
    			}
    			
    			return $response;
		    }
		}
	}
}
