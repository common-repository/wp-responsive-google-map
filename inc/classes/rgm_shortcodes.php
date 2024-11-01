<?php 
if ( ! class_exists( 'RGM_Shortcodes' ) ) {
	
	class RGM_Shortcodes {
		
		public static function showMap($atts) {
			wp_enqueue_script('rgm-google-api');
			wp_enqueue_script('rgm-frontend');
			$html = "<script type='text/javascript'>
						var rgmParams = {'mapCenterLat':'".get_option( 'rgm_center_lat' )."', 'mapCenterLong':'".get_option( 'rgm_center_long' )."', 'zoomLevel':'".get_option( 'rgm_map_zoom_level' )."', 'imagesPath':'".RGM_IMAGES."'};
					</script>";
			
			$html .= "<style>
			.map-block {
				position: relative;
				padding-bottom: 35%; // This is the aspect ratio
			}
			.map-block #mapImage {
				position: absolute;
				top: 0;
				left: 0;
				width: 100% !important;
				height: 100% !important;
			}
			</style>";
			$html .= '<div class="map-block" id="mabBlock">					
		        <div id="mapImage" class="googlemap"
		       		data-position-latitude=\'['.RGM_Helper_functions::getMapLatitudes().']\'
		            data-position-longitude=\'['. RGM_Helper_functions::getMapLongtude().']\'
					data-info=\'['. RGM_Helper_functions::getMapMessage().']\'
					data-marker-img="'. RGM_IMAGES.'marker.png"
		            data-marker-width="33"
		            data-marker-height="30"
		            data-address=\'['.RGM_Helper_functions::getMapAdresses().']\',
		            data-titles=\'['.RGM_Helper_functions::getMapTitles().']\' >
	            </div>      
	        </div>'; 
            
			return $html;
		}	
		
	}
}