<?php
/**
 * FrontEnd FileManager WP Util Modal left content
 */

/*
**========== Block Direct Access ===========
*/
if( ! defined('ABSPATH' ) ){ exit; } 
?>

<script type="text/html" id="tmpl-ffmwp-modal-left">
<div class="ffmwp-modal-left-wrapper">
    
    <?php if( wpfm_is_user_to_edit_file() ) {?>
    <section class="ffmwp-form-group">
      <input type="text" class="ffmwp-text wpfm_filename" name="wpfm_filename" value="{{data.name}}"/>
      <button data-fileid="{{data.id}}" class="ffmwp-button ffmwp-rename-edit-btn"><?php _e("Rename","ffmwp");?>
      </button>
      
      <# if(ffmwp_vars.is_revision_addon){ #>
          {{{data.update_button}}}
      <# } #>
    </section>
    <?php } ?>
    
    <div class="ffmwp-modal-col-item">
      <span class="ffmwp-modal-col-label">{{ffmwp_vars.labels.file_size}}</span>
      <span class="ffmwp-modal-col-value">{{data.size}}</span>
    </div>
    
    <# if(data.video_duration !== ""){ #>
      <div class="ffmwp-modal-col-item">
        <span class="ffmwp-modal-col-label">{{ffmwp_vars.labels.duration}}</span>
        <span class="ffmwp-modal-col-value">{{data.video_duration_formatted}}</span>
      </div>
    <# } #>
    
    <div class="ffmwp-modal-col-item">
      <span class="ffmwp-modal-col-label">{{ffmwp_vars.labels.file_id}}</span>
      <span class="ffmwp-modal-col-value">{{data.id}}</span>
    </div>
    
    <div class="ffmwp-modal-col-item">
      <span class="ffmwp-modal-col-label">{{ffmwp_vars.labels.total_downloads}}</span>
      <span class="ffmwp-modal-col-value">{{data.total_downloads}}</span>
    </div>
    
    <# if(ffmwp_vars.is_revision_addon){ #>
      <div class="ffmwp-modal-col-item">
        <span class="ffmwp-modal-col-label">{{ffmwp_vars.labels.revisions}}</span>
        <span class="ffmwp-modal-col-value">{{{data.exist_filenames}}}</span>
      </div>
    <# } #>
    
    <div class="ffmwp-modal-col-item">
      <span class="ffmwp-modal-col-label">{{ffmwp_vars.labels.uploaded_on}}</span>
      <span class="ffmwp-modal-col-value">{{data.created_on}}</span>
    </div>
    
    <div class="ffmwp-modal-col-item">
      <span class="ffmwp-modal-col-label">{{ffmwp_vars.labels.file_source}}</span>
      <span class="ffmwp-modal-col-value">{{data.location == 'amazon' ? ffmwp_vars.labels.file_source_aws : ffmwp_vars.labels.file_source_local }}</span>
    </div>
    
    
</div>

</script>