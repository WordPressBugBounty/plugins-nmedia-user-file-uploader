<?php
/**
 * FrontEnd FileManager WP Upload Area Template
 */

/*
**========== Block Direct Access ===========
*/
if( ! defined('ABSPATH' ) ){ exit; } 

?>

<div id="upload_files_btn_area" class="wpfm_upload_button ffmwp-uploadarea-content">
	
	<?php do_action("ffmwp_before_upload_buttons", $wpfm_bp_group_id, $shortcode_groups); ?>
	
	<div class="ffmwp-upload-buttons">
	  <label class="ffmwp-select-input-wrap ffmwp_choosefile_lebel" for="ffmwp_choosefile">
		<div class="ffmwp-upload-button">
		<span><?php printf(__("%s", 'wpfm'), wpfm_get_option ( '_button_title', __('Select File', 'wpfm') ));?></span>
		<input type="file" id="ffmwp_choosefile" multiple accept="<?php echo wpfm_get_file_types(); ?>" />
		</div>
		</label>
		
		<?php if( wpfm_can_user_create_directory() ): 
		$dir_create_lbl = wpfm_get_option( '_create_directory_label', __('Create Directory', 'wpfm') );
		?>
		
		<button class="ffmwp-button ffmwp-click-to-reveal"><?php printf(__('%s', 'wpfm'), $dir_create_lbl); ?></button>
		
		<?php endif; ?>
		
		<button class="ffmwp-cancel-btn ffmwp-delete-selected"><?php _e("Delete", "wpfm"); ?> <span class="del-count"></span></button>
	  
	</div>



	
	<?php if( wpfm_can_user_create_directory() ):
	/**
	 * action space for third party plugins
	 **/
	do_action('ffmwp_after_create_directory_button', $wpfm_bp_group_id, $shortcode_groups);
	?>
	
	<div class="ffmwp-click-to-reveal-block">
	  	<form id="ffmwp-create-dir-form">
	  		<input type="hidden" name="action" value="wpfm_create_directory">
	  		<input type="hidden" name="wpfm_bp_group_id" value="<?php echo esc_attr($wpfm_bp_group_id);?>">
	  		<input type="hidden" name="shortcode_groups" value="<?php echo esc_attr($shortcode_groups);?>">
	  		
		  	<div class="ffmwp-uploadarea-form-content">
		    	<label class="ffmwp-inputs ffmwp-lable" for="wpfm-dirname"><?php _e( "Directory Name", "wpfm" ); ?></label>
		    	<input type="text" id="wpfm-dirname" required name="dir_name" class="ffmwp-text">
		    	<label class="ffmwp-inputs ffmwp-lable"for="wpfm-description"><?php _e( "Description", "wpfm" ); ?></label>
		    	<input type="text" id="wpfm-description" name="directory_detail" class="ffmwp-text">
		  		<button class="ffmwp-uploadarea-btn ffmwp-button" id="wpfm-dir-created-btn"><?php _e( "Create", "wpfm" ); ?></button>
		  		<button class="ffmwp-uploadarea-btn ffmwp-uploadarea-cancel-btn ffmwp-cancel-btn"><?php _e( "Cancel", "wpfm" ); ?></button>
		  	</div>
		</form>
  	</div>
  	<?php
  	endif;
  	?>
  	
</div>