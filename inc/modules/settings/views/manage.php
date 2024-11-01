

<div class="rgm-wrap" >
	<div class="rgm-col rgm-col-main" >
		<div class="product_header">
			<div class="product_name"><?php _e('WP Responsive Google Map', RGM_TEXT_DOMAIN)?> <span
					class="fc-badge" ><?php echo RGM_VERSION?></span>
			</div>
		</div>
		
		<?php if($response['success']):?>
            <div class="notice notice-success is-dismissible"><p><?=$response['success']?></p></div><br />
        <?php endif;?>
        <?php if($response['error']):?>
            <div class="notice notice-error is-dismissible"><p><?=$response['error']?></p></div><br />
        <?php endif;?>

		<div class="page-tab" >
			<form method="post" >
			
			

				<table class="form-table" >
					<tbody>
						<tr>
							<th scope="row" ><label for="rgm_api_key" ><?php _e( 'Google Maps API Key', RGM_TEXT_DOMAIN)?></label></th>
							<td><input name="rgm_api_key" type="text"
								value="<?php echo sanitize_text_field( wp_unslash( get_option('rgm_api_key') ) ) ?>" size="60" >
								<p class="help-block" >
								    <?php _e( 'Get here', RGM_TEXT_DOMAIN)?> <a target="_blank" href="https://developers.google.com/maps/documentation/javascript/get-api-key" > <?php _e( 'Api Key', RGM_TEXT_DOMAIN)?> </a> <?php _e( 'and insert here.', RGM_TEXT_DOMAIN)?>
								</p>
							</td>
						</tr>
						
						<tr>
							<th scope="row" ><label for="rgm_latitude" ><?php _e( 'Map Center Latitude and Longitude', RGM_TEXT_DOMAIN)?>*</label></th>
							<td>
								<input name="rgm_center_lat" type="text" placeholder="<?php _e( 'Enter Latitude', RGM_TEXT_DOMAIN)?>" value="<?php echo sanitize_text_field( wp_unslash( get_option('rgm_center_lat') ) ) ?>" size="20" >
								<input name="rgm_center_long" type="text" placeholder="<?php _e( 'Enter Longitude', RGM_TEXT_DOMAIN)?>" value="<?php echo sanitize_text_field( wp_unslash( get_option('rgm_center_long') ) ) ?>" size="20" >
							</td>
						</tr>
						<tr>
							<th scope="row" ><label for="rgm_latitude" ><?php _e( 'Map Zoom level', RGM_TEXT_DOMAIN)?>*</label></th>
							<td>
								<select id="map_zoom_level" class="fc_select2 form-control " name="rgm_map_zoom_level">
									<?php $currentZoom= get_option( 'rgm_map_zoom_level' ) ?>
									<?php for ($i = 0; $i < 20; $i++):?>
									<option value="<?=$i?>"  <?=($currentZoom == $i) ? 'selected' : ''?> ><?=$i?></option>
									<?php endfor;?>
								</select>
							 
							</td>
						</tr>

						<tr>
							<th scope="row" ><label for="rgm_language" ><?php _e( 'Google Map Language', RGM_TEXT_DOMAIN)?></label></th>
							<td>
							<?php $languages = array(
                                    'en' => __( 'ENGLISH', RGM_TEXT_DOMAIN ),
                                    'ar' => __( 'ARABIC', RGM_TEXT_DOMAIN ),
                                    'eu' => __( 'BASQUE', RGM_TEXT_DOMAIN ),
                                    'bg' => __( 'BULGARIAN', RGM_TEXT_DOMAIN ),
                                    'bn' => __( 'BENGALI', RGM_TEXT_DOMAIN ),
                                    'ca' => __( 'CATALAN', RGM_TEXT_DOMAIN ),
                                    'cs' => __( 'CZECH', RGM_TEXT_DOMAIN ),
                                    'da' => __( 'DANISH', RGM_TEXT_DOMAIN ),
                                    'de' => __( 'GERMAN', RGM_TEXT_DOMAIN ),
                                    'el' => __( 'GREEK', RGM_TEXT_DOMAIN ),
                                    'en-AU' => __( 'ENGLISH (AUSTRALIAN)', RGM_TEXT_DOMAIN ),
                                    'en-GB' => __( 'ENGLISH (GREAT BRITAIN)', RGM_TEXT_DOMAIN ),
                                    'es' => __( 'SPANISH', RGM_TEXT_DOMAIN ),
                                    'fa' => __( 'FARSI', RGM_TEXT_DOMAIN ),
                                    'fi' => __( 'FINNISH', RGM_TEXT_DOMAIN ),
                                    'fil' => __( 'FILIPINO', RGM_TEXT_DOMAIN ),
                                    'fr' => __( 'FRENCH', RGM_TEXT_DOMAIN ),
                                    'gl' => __( 'GALICIAN', RGM_TEXT_DOMAIN ),
                                    'gu' => __( 'GUJARATI', RGM_TEXT_DOMAIN ),
                                    'hi' => __( 'HINDI', RGM_TEXT_DOMAIN ),
                                    'hr' => __( 'CROATIAN', RGM_TEXT_DOMAIN ),
                                    'hu' => __( 'HUNGARIAN', RGM_TEXT_DOMAIN ),
                                    'id' => __( 'INDONESIAN', RGM_TEXT_DOMAIN ),
                                    'it' => __( 'ITALIAN', RGM_TEXT_DOMAIN ),
                                    'iw' => __( 'HEBREW', RGM_TEXT_DOMAIN ),
                                    'ja' => __( 'JAPANESE', RGM_TEXT_DOMAIN ),
                                    'kn' => __( 'KANNADA', RGM_TEXT_DOMAIN ),
                                    'ko' => __( 'KOREAN', RGM_TEXT_DOMAIN ),
                                    'lt' => __( 'LITHUANIAN', RGM_TEXT_DOMAIN ),
                                    'lv' => __( 'LATVIAN', RGM_TEXT_DOMAIN ),
                                    'ml' => __( 'MALAYALAM', RGM_TEXT_DOMAIN ),
                                    'it' => __( 'ITALIAN', RGM_TEXT_DOMAIN ),
                                    'mr' => __( 'MARATHI', RGM_TEXT_DOMAIN ),
                                    'nl' => __( 'DUTCH', RGM_TEXT_DOMAIN ),
                                    'no' => __( 'NORWEGIAN', RGM_TEXT_DOMAIN ),
                                    'pl' => __( 'POLISH', RGM_TEXT_DOMAIN ),
                                    'pt' => __( 'PORTUGUESE', RGM_TEXT_DOMAIN ),
                                    'pt-BR' => __( 'PORTUGUESE (BRAZIL)', RGM_TEXT_DOMAIN ),
                                    'pt-PT' => __( 'PORTUGUESE (PORTUGAL)', RGM_TEXT_DOMAIN ),
                                    'ro' => __( 'ROMANIAN', RGM_TEXT_DOMAIN ),
                                    'ru' => __( 'RUSSIAN', RGM_TEXT_DOMAIN ),
                                    'sk' => __( 'SLOVAK', RGM_TEXT_DOMAIN ),
                                    'sl' => __( 'SLOVENIAN', RGM_TEXT_DOMAIN ),
                                    'sr' => __( 'SERBIAN', RGM_TEXT_DOMAIN ),
                                    'sv' => __( 'SWEDISH', RGM_TEXT_DOMAIN ),
                                    'tl' => __( 'TAGALOG', RGM_TEXT_DOMAIN ),
                                    'ta' => __( 'TAMIL', RGM_TEXT_DOMAIN ),
                                    'te' => __( 'TELUGU', RGM_TEXT_DOMAIN ),
                                    'th' => __( 'THAI', RGM_TEXT_DOMAIN ),
                                    'tr' => __( 'TURKISH', RGM_TEXT_DOMAIN ),
                                    'uk' => __( 'UKRAINIAN', RGM_TEXT_DOMAIN ),
                                    'vi' => __( 'VIETNAMESE', RGM_TEXT_DOMAIN ),
                                    'zh-CN' => __( 'CHINESE (SIMPLIFIED)', RGM_TEXT_DOMAIN ),
                                    'zh-TW' => __( 'CHINESE (TRADITIONAL)', RGM_TEXT_DOMAIN ),
                                    );
							
							$currentLanguage = get_option( 'rgm_language' )?>
							<select id="rgm_language" class="form-control" name="rgm_language" => '
									<?php foreach ($languages as $key => $language):?>
									<option <?=($currentLanguage == $key) ? 'selected' : ''?> value="<?=$key?>"><?=$language?></option>
									<?php endforeach;?>
							</select>
								<p class="help-block" ><?php _e( 'Choose your language for map. Default is English.', RGM_TEXT_DOMAIN)?></p>
							</td>
						</tr>
					</tbody>
				</table>
                <input type="hidden" name="operation" value="save" />
				<input type="submit" name="rgmSaveSettingsAction" class="button button-primary" value="<?php _e('Save Settings', RGM_TEXT_DOMAIN)?>" />
			</form>
		</div>
	</div>
	<div class="rgm-col rgm-col-sidebar"> </div>
</div>