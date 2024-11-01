<?php

if ( ! class_exists( 'RGM_Docs' ) ) {

	
	class RGM_Docs {
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
				'rgm_view_docs' => __( 'Docs', RGM_TEXT_DOMAIN ),
			);
		}
	}
}
