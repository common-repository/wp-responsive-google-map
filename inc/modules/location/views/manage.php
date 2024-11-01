

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

	

	</div>
	<div class="rgm-col rgm-col-sidebar"> </div>
</div>

<?php if ( class_exists( 'RGM_WP_List_Table' ) and ! class_exists( 'Wpgmp_Location_Table' ) ) {

	class RGM_Location_Table extends RGM_WP_List_Table{  
		public function __construct($tableinfo) {
			parent::__construct( $tableinfo ); }  }

		// Minimal Configuration :)
		global $wpdb;
		$columns   = array( 'title' => 'Title','address' => 'Address','latitude' => 'Latitude','longitude' => 'Longitude' );
		$sortable  = array( 'title','latitude','longitude' );
		$tableinfo = array(
				'table' => $wpdb->prefix .RGM_Location::DB_TABLE,
				'textdomain' => RGM_TEXT_DOMAIN,
				'singular_label' => 'location',
				'plural_label' => 'locations',
				'admin_listing_page_name' => 'rgm_manage_location',
				'admin_add_page_name' => 'rgm_form_location',
				'primary_col' => 'id',
				'columns' => $columns,
				'sortable' => $sortable,
				'per_page' => 200,
				'actions' => array( 'edit','delete' ),
				'col_showing_links' => 'title',
		);
		
		return new RGM_Location_Table( $tableinfo );

	}
	?>