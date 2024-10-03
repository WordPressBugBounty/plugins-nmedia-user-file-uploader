<?php
/**
 * FrontEnd FileManager WP Index Template
 */

/*
**========== Block Direct Access ===========
*/
if( ! defined('ABSPATH' ) ){ exit; }

/**
 * Nonce for all operations
**/
wp_nonce_field('wpfm_securing_ajax','wpfm_ajax_nonce');

echo '<div id="ffmwp-wrapper" class="ffmwp-admin-wrapper">';


    // Should only be visible when files area is enabled.
    if (wpfm_is_left_menu_visible($context)) {
        echo '<div id="ffmwp-left-col">';
        ffmwp_load_template("parts/left/index.php", ['file_groups'=>$file_groups]);
        echo '</div>';
    }
    
    
    echo '<div id="ffmwp-right-col">';
    
        if( wpfm_is_upload_form_visible( $context ) ) {
            ffmwp_load_template("parts/upload/index.php", ['wpfm_bp_group_id'=>$wpfm_bp_group_id, 'shortcode_groups' => $shortcode_groups,]);
            ffmwp_load_template("parts/upload/file-form.php", ['wpfm_bp_group_id'=>$wpfm_bp_group_id, 'shortcode_groups' => $shortcode_groups,]);
            ffmwp_load_template("parts/upload/file-meta.php");
        }
    
        if (wpfm_is_files_area_visible($context)) {
            
            if( 'yes' !== wpfm_get_option('_disable_breadcrumbs', 'no') )
                ffmwp_load_template("parts/filter-nav.php");
            
            ffmwp_load_template("parts/box.php");
            
            // file details
            ffmwp_load_template("parts/file-detail/index.php");
            ffmwp_load_template("parts/file-detail/left.php");
            if( wpfm_is_user_to_edit_file() ) {
                ffmwp_load_template("parts/file-detail/right.php");
            } else {
                ffmwp_load_template("parts/file-detail/right.readonly.php");
            }
            
            // document viewer
            if( wpfm_get_option('_enable_document_viewer') === 'yes') {
                ffmwp_load_template("parts/viewer/index.php");
            }
            
            
        }
  
    echo '</div>';

echo '</div>';