<div class="rgm-wrap" >
	<div class="rgm-col rgm-col-main" >
		<div class="product_header">
			<div class="product_name"><?php _e('WP Responsive Google Map', RGM_TEXT_DOMAIN)?> <span
					class="fc-badge" ><?php echo RGM_VERSION?></span>
			</div>
		</div>
		<?php if(isset($response['redirectUrl']) && $response['redirectUrl'] != ''):?>
			<script>setTimeout(function(){window.location.href="<?=$response['redirectUrl']?>"},3000);</script>			
		<?php endif;?>
		
		<?php if(isset($response['success']) && $response['success']):?>
            <div class="notice notice-success is-dismissible"><p><?=$response['success']?></p></div><br />
        <?php endif;?>
   		<?php if(isset($response['error']) && $response['error']):?>
            <div class="notice notice-error is-dismissible"><p><?=$response['error']?></p></div><br />
        <?php endif;?>

		<div class="page-tab" >
			<form method="post" >
			
				<table class="form-table" >
					<tbody>
						<tr>
							<th scope="row" ><label for="rgm_title" ><?php _e( 'Location name', RGM_TEXT_DOMAIN)?>*</label></th>
							<td>
								<input name="rgm_title" type="text" placeholder="<?php _e( 'Enter title', RGM_TEXT_DOMAIN)?>" value="<?php echo (isset($response['data']['rgm_title'])) ? htmlspecialchars($response['data']['rgm_title']) :'' ?>" size="60" >
							</td>
						</tr>
						<tr>
							<th scope="row" ><label for="rgm_address" ><?php _e( 'Location Address', RGM_TEXT_DOMAIN)?>*</label></th>
							<td>
								<input name="rgm_address" type="text" placeholder="<?php _e( 'Enter Address', RGM_TEXT_DOMAIN)?>" value="<?php echo (isset($response['data']['rgm_address'])) ? htmlspecialchars($response['data']['rgm_address']) :'' ?>" size="60" >
							</td>
						</tr>
						<tr>
							<th scope="row" ><label for="rgm_latitude" ><?php _e( 'Latitude and Longitude', RGM_TEXT_DOMAIN)?>*</label></th>
							<td>
								<input name="rgm_latitude" type="text" placeholder="<?php _e( 'Enter Latitude', RGM_TEXT_DOMAIN)?>" value="<?php echo (isset($response['data']['rgm_latitude'])) ? htmlspecialchars($response['data']['rgm_latitude']) :'' ?>" size="20" >
								<input name="rgm_longitude" type="text" placeholder="<?php _e( 'Enter Longitude', RGM_TEXT_DOMAIN)?>" value="<?php echo (isset($response['data']['rgm_longitude'])) ? htmlspecialchars($response['data']['rgm_longitude']) :'' ?>" size="20" >
							</td>
						</tr>
						<?php /*?><tr>
							<th scope="row" ><label for="rgm_city" ><?php _e( 'City', RGM_TEXT_DOMAIN)?></label></th>
							<td>
								<input name="rgm_city" type="text" placeholder="<?php _e( 'Enter city', RGM_TEXT_DOMAIN)?>" value="<?php echo (isset($response['data']['rgm_city'])) ? htmlspecialchars($response['data']['rgm_city']) :'' ?>" size="60" >
							</td>
						</tr>*/?>
						<tr>
							<th scope="row" ><label for="rgm_description" ><?php _e( 'Info popup message', RGM_TEXT_DOMAIN)?></label></th>
							<td>
								<textarea name="rgm_description"><?php echo (isset($response['data']['rgm_title'])) ? htmlspecialchars($response['data']['rgm_description']) :'' ?></textarea>
							</td>
						</tr>
					</table>
				</table>

				
                <input type="hidden" name="operation" value="save" />
				<input type="submit" name="rgmSaveLocationAction" class="button button-primary" value="<?php _e('Save', RGM_TEXT_DOMAIN)?>" />
			</form>
		</div>
	</div>
	<div class="rgm-col rgm-col-sidebar"> </div>
</div>