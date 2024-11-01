<?php 

if ( ! class_exists( 'RGM_Helper_functions' ) ) {
	class RGM_Helper_functions {
		
		protected static function getData() {
			global $wpdb;
			
			$result = wp_cache_get( 'rgm_map_locations' );
			if ( false === $result ) {
				$table = $wpdb->prefix . 'rgm_map_locations';
				$result = $wpdb->get_results( "SELECT * FROM $table" );
				
				wp_cache_set( 'rgm_map_locations', $result );
			} 
			
			return $result;
		}
		
		protected static function implodeData($data) {
			return '"' . implode('","', $data).'"';
		}
		
		public static function getMapLatitudes() {
			$data = self::getData();
			$latitudeArray = array();
			
			foreach ($data as $row) {
				if (!empty($row->latitude)) {
					array_push($latitudeArray, $row->latitude);
				}
			}
			return self::implodeData($latitudeArray);
		}
		
		public static function getMapLongtude() {
			$data = self::getData();
			$longitudeArray = array();
			
			foreach ($data as $row) {
				if (!empty($row->longitude)) {
					array_push($longitudeArray, $row->longitude);
				}
			}
			
			return self::implodeData($longitudeArray);
		}
		
		public static function getMapMessage() {
			$data = self::getData();
			$messageArray = array();
			
			foreach ($data as $row) {
				array_push($messageArray, $row->description);
			}
			
			return self::implodeData($messageArray);
		}
		
		public static function getMapTitles() {
			$data = self::getData();
			$titleArray = array();
			
			foreach ($data as $row) {
				array_push($titleArray,  str_replace('"', '=', $row->title));
			}
			
			return self::implodeData($titleArray);
		}
		
		public static function getMapAdresses () {
			$data = self::getData();
			$newArray = array();
			
			foreach ($data as $row) {
				array_push($newArray,  str_replace('"', '=', $row->address));
			}
			
			return self::implodeData($newArray);
		}
		
	}
}