<?php
/**
 * FrontEnd FileManager WP Util Files Template
 * Showing File details after file selected (not uploaded yet)
 */

if( ! defined('ABSPATH' ) ){ exit; }

// File revision addon: If file is being revised/uploaded
$existing_file_id = isset($_GET['file_id']) ? $_GET['file_id'] : '';
?>

<form id="ffmwp-form-data">
    <?php wp_nonce_field('wpfm_saving_file','wpfm_save_nonce'); ?>
    <input type="hidden" name="action" value="wpfm_save_file_data">
    <input type="hidden" name="wpfm_bp_group_id" value="<?php echo esc_attr($wpfm_bp_group_id);?>">
    <input type="hidden" name="shortcode_groups" value="<?php echo esc_attr($shortcode_groups);?>">
    <input type="hidden" name="shortcode_groups" value="<?php echo esc_attr($shortcode_groups);?>">
    <input type="hidden" name="exist_file_id" value="<?php echo esc_attr($existing_file_id);?>">
    
    <div class="ffmwp_files_preview_wrapper" id="ffmwp_files_preview_wrapper"></div>
    
    <div class="ffmwp-save-file-btn" style="display: none;">
        <button id="ffmwp_save_files_btn" class="ffmwp-button"><?php 
    				$save_file_label = wpfm_get_option ( '_upload_title' );
    			    $save_file_label	= (!$save_file_label == '') ? $save_file_label : 'Select Files';
    				printf(__('%s', 'wpfm'), $save_file_label);
    			?>
    	</button>
    	<button class="ffmwp-cancel-btn ffmwp-file-remove" style="margin-left: 10px;">Cancel</button>
	</div>
</form>

<script type="text/html" id="tmpl-ffmwp-preview-files">
    
    <div class="row file-preview-wrapper {{data.file_id}}" data-file_id="{{data.file_id}}">
    
    <section class="file-preview-wrapper-img ffmwp-center">
        <img width="{{ffmwp_file_vars.image_size}}" src="{{data.preview_thumb}}">
        <div class="progressbar">
            <div class="progress text-center {{data.file_id}}"></div>
        </div>
        
        <div class="ffmwp-remove-file">
        <a href="#" class="ffmwp-file-remove" data-node_id="{{data.file_id}}" data-title="{{ffmwp_vars.labels.file_remove}}"><span class="dashicons dashicons-dismiss"></span></a></div>
    </section>
    
    <section class="file-preview-wrapper-inputs">
    
        <input type="hidden" id="file_name-{{data.file_id}}" name="uploaded_files[{{data.file_id}}][filename]" value="">
        <p class="ffmwp-form-group-inline">
        <label for="title-{{data.file_id}}" class="ffmwp-label title"><?php _e('File Title', 'wpfm');?></label>
        <input class="ffmwp-text title" id="title-{{data.file_id}}" value="{{data.file.name}}" type="text" class="ffmwp-uploadfile-title" name="uploaded_files[{{data.file_id}}][title]" placeholder="File name">
        </p>
        
        <p class="ffmwp-form-group-inline">
        <label for="desc-{{data.file_id}}" class="ffmwp-label desc"><?php _e('File Detail', 'wpfm');?></label>
            <textarea class="ffmwp-textarea desc" id="desc-{{data.file_id}}" name="uploaded_files[{{data.file_id}}][file_details]"/></textarea>
        </p>
        <# 
        // If members allow to select groups
        if( ffmwp_file_vars.file_groups.length > 0 &&  (ffmwp_file_vars.allow_group_frontend === 'yes')  ) { 
        #>
        <header class="ffmwp-subheader"><?php _e("Select Group(s)", 'ffmwp');?></header>
        
        <select  multiple="multiple" class="ffmwp-select2 ffmwp-groups ffmwp-select" name="uploaded_files[{{data.file_id}}][file_group][]">
        <# _.forEach( ffmwp_file_vars.file_groups, function ( group ) { #>
            <option value="{{group.term_id}}" >{{group.name}}</option>
        <# }) #>
        </select>
        
        <# }// end if
        
        // if file meta found
        if( ffmwp_file_vars.file_meta != '' ){
        #>
            <section class="row ffmwp_upload_file_meta">
            <header class="ffmwp-subheader"><?php _e("File Meta", 'ffmwp');?></header>
            <#
                _.forEach( ffmwp_file_vars.file_meta, function ( meta ) {
                    var fmeta = {meta: meta, file_id: data.file_id}
                    // console.log(fmeta)
                    var type = meta.type;
            #>
                <div class="ffmwp_upload_file_field file-meta-{{meta.data_name}}">
                {{{FFMWP_Util.render_template_part(`ffmwp-file-meta-${type}`, fmeta)}}}
                </div>
            <#
                });
            #>
            </section>
            <#
            }
            #>
        <!-- AWS Amazon Addon Data -->
        <div id="aws-data-{{data.file_id}}"></div>
            
    </section>
    
    <!-- file data url -->
    <input type="hidden" name="uploaded_files[{{data.file_id}}][dataurl]" value="{{data.preview_thumb}}">
    
    </div> <!-- #file-wrapper-{{data.file_id}} -->
    
</script>