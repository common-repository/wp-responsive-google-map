<?php
if (! class_exists ( 'RGM_Location' )) {
	class RGM_Location {
		const DB_TABLE = 'rgm_map_locations';
		/**
		 * Intialize Backup object.
		 */
		function __construct() {
		}
		
		/**
		 * Admin menu for Settings Operation
		 * 
		 * @return array Admin menu navigation(s).
		 */
		function navigation() {
			return array (
					'rgm_form_location' => __ ( 'Add Location', RGM_TEXT_DOMAIN ),
					'rgm_manage_location' => __ ( 'Locations', RGM_TEXT_DOMAIN ) 
			);
		}
		public function install() {
			global $wpdb;
			
			$mapLocation = 'CREATE TABLE ' . $wpdb->prefix . RGM_Location::DB_TABLE.' (
                id int(11) NOT NULL AUTO_INCREMENT,
                title varchar(255) DEFAULT NULL,
                address varchar(255) DEFAULT NULL,
                latitude varchar(255) DEFAULT NULL,
                longitude varchar(255) DEFAULT NULL,
                city varchar(255) DEFAULT NULL,
                description text DEFAULT NULL,
                PRIMARY KEY  (id)
                ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;';
			
			return $mapLocation;
		}
		
		public function verifyData($data) {
			$fields = array (
					'rgm_title' => __ ( 'Location name', RGM_TEXT_DOMAIN ),
					'rgm_address' => __ ( 'Location address', RGM_TEXT_DOMAIN ),
					'rgm_latitude' => __ ( 'Location Latitude', RGM_TEXT_DOMAIN ),
					'rgm_longitude' => __ ( 'Location Longitude', RGM_TEXT_DOMAIN ) 
			);
			
			$errors = array ();
			foreach ( $fields as $key => $item ) {
				if (isset ( $_POST [$key] ) && trim ( $_POST [$key] ) == '') {
					$errors [] = $item . ' ' . __ ( 'is required', RGM_TEXT_DOMAIN );
				}
			}
			
			return $errors;
		}
		
		public function formatData($data) {
			$fields = array (
					'rgm_title' => '%s',
					'rgm_address' => '%s',
					'rgm_latitude' => '%f',
					'rgm_longitude' =>'%f',
					'rgm_city' => '%s',
					'rgm_description' => '%s'
			);
			
			$postData = array();
			
			foreach ($fields as $key=>$format) {
				
				if (isset($_POST[$key]) && $_POST[$key] != '') {
					$keyDatabase = str_replace('rgm_', '', $key);
					$postData['data'][$keyDatabase] = sanitize_text_field( wp_unslash($_POST[$key]));
					$postData['format'][] = "'$format'";
				}
			}
						
			return $postData;
		}
		
		public function fetch ($id) {
			global $wpdb;
			
			$table = $wpdb->prefix .RGM_Location::DB_TABLE;
			$data = $wpdb->get_row( "SELECT * FROM $table WHERE id = ".$id);
			
			$newData = array();
			if (is_object($data)) {
				foreach ((array)$data as $key=>$attr) {
					$newData['rgm_'.$key] = $attr;
				}
			}
			
			return $newData;
		}
		
		/**
		 * Add or Edit Operation.
		 */
		function save() {
			global $wpdb;
			
			$action = 'create';
			if (isset($_GET['doaction']) && $_GET['doaction'] == 'edit' && isset($_GET['id']) && (int)$_GET['id'] > 0 ) {
				$action = 'edit';
			}
			
			if (isset ( $_POST ['rgmSaveLocationAction'] )) {
				
				if (isset ( $_REQUEST ['_wpnonce'] )) {
					$nonce = sanitize_text_field ( wp_unslash ( $_REQUEST ['_wpnonce'] ) );
				}
				
				if (isset ( $nonce ) and ! wp_verify_nonce ( $nonce, 'rgm-nonce' )) {
					
					die ( 'Cheating...' );
				}
				
				$errors = $this->verifyData ( $_POST );
				
				if (count ( $errors ) == 0) {
					
					$data = $this->formatData($_POST);

					if ($action == 'create') {
						$status = $wpdb->insert(  $wpdb->prefix .RGM_Location::DB_TABLE, $data['data'], $data['format']);
					}
					
					if ($action == 'edit') {
						$status = $wpdb->update( $wpdb->prefix .RGM_Location::DB_TABLE, $data['data'], array('id' => $_GET['id']), $data['format'] );
					}
					
					
					if ($status == true) {
						$response ['success'] = __ ( 'Location saved successfully.', RGM_TEXT_DOMAIN );
						$response ['redirectUrl'] = admin_url( 'admin.php?page=rgm_manage_location' );
					} else {
						$response ['error'] =  __ ( 'ERROR, try again later', RGM_TEXT_DOMAIN );
					}
				} else {
					$response ['error'] = implode ( '<br/>', $errors );
				}
				
				$response ['data'] = $_POST;
				
				return $response;
			}
		}
	}
}
