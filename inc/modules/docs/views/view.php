<div class="rgm-wrap">
	<div class="rgm-col rgm-col-main">
		<div class="product_header">
			<div class="product_name"><?php _e('WP Responsive Google Map', RGM_TEXT_DOMAIN)?> <span
					class="fc-badge"><?php echo RGM_VERSION?></span>
			</div>
		</div>

		<div class="page-tab">
				<h4 class="fc-title-blue">How to Create your Map?</h4>
				<ol>
					<li>First create a <a href="http://bit.ly/29Rlmfc" target="_blank">Google Map API Key</a>. Then go to <a href="<?=admin_url( 'admin.php?page=rgm_manage_settings' )?>">Settings </a> page and insert your google maps API Key and save.
					</li>

					<li>Create a location by using<a href="<?=admin_url( 'admin.php?page=rgm_view_overview' )?>" target="_blank"> Locations</a> page.
					</li>

					<li>Go to any page/post editor where you want to display map and insert shortcode [rgm_view_map]
					</li>

				</ol>

				<h4 class="fc-title-blue">Google Map API Troubleshooting</h4>
				<div class="wpgmp-overview">
					<p>If your google maps is not working. Make sure you have checked
						following things.</p>
					<ul>
						<li>1. Make sure you have assigned locations to your map.</li>
						<li>2. You must have google maps api key.</li>
						<li>3. Check HTTP referrers. It must be *.yourwebsite.com/*</li>
					</ul>
					<p>
						<img src="/wp-content/plugins/wp-responsive-google-map/assets/images/referrer.jpg" />
					</p>
				</div>
			</div>
	</div>
	<div class="rgm-col rgm-col-sidebar"></div>
</div>