<?php
/**
 * FrontEnd FileManager WP Util Modal right content
 */

/*
**========== Block Direct Access ===========
*/
if( ! defined('ABSPATH' ) ){ exit; } 
?>

<script type="text/html" id="tmpl-ffmwp-modal-right">
<section class="ffmwp-modal-right-wrapper">
    <form id="ffmwp-file-single-form">
      <input type="hidden" name="file_id" value="{{data.id}}"/>
      <input type="hidden" name="action" value="wpfm_edit_file_title_desc"/>
      <div style="margin-bottom: 10px;">
        <label for="title-{{data.id}}" class="ffmwp-label"><?php _e('File Title', 'wpfm');?></label>
        <input type="text" id="title-{{data.id}}"
        value="{{data.title}}" 
        name="file_title" 
        data-id="{{data.id}}" 
        class="ffmwp-text">
      </div>
      <div style="margin-bottom: 10px;">
        <label for="desc-{{data.id}}" class="ffmwp-label"><?php _e('File Description', 'wpfm');?></label>
        <textarea name="file_content" class="ffmwp-textarea" id="desc-{{data.id}}">{{data.description}}</textarea>
      </div>
      <button type="submit" class="ffmwp-button"><?php _e('Update', 'ffmwp');?></button>
    </form>
    
    <# 
    if( ffmwp_vars.file_meta.length ) {
    #>
        <section class="ffmwp-file-meta-wrapper">
            <header class="ffmwp-header"><?php _e('File Meta', 'ffmwp');?></header>
          
            <form class="ffmwp-update-file-meta ffmwp-modal-form">
                <input type="hidden" name="action" value="wpfm_file_meta_update"/>
                {{{data.file_meta_html}}}
                
                <input type="submit" class="ffmwp-button" value="{{ffmwp_vars.labels.button_meta_save}}" />
            </form>
        </section>
    <#
    }
    #>
    
    <# 
    if( ffmwp_vars.template_data.enable_email_share ) {
    #>
    
    <section class="ffmwp-email-msg-wrapper">
      <header class="ffmwp-header"><?php _e('Share File by Email', 'ffmwp');?></header>
      <form class="ffmwp-send-file-in-email ffmwp-modal-form">
        <input type="hidden" name="file_id" value="{{data.id}}"/>
        <input type="hidden" name="action" value="wpfm_send_file_in_email"/>
        <div class="ffmwp-form-group">
          <label for="emailaddress" class="ffmwp-label"><?php _e('Email', 'ffmwp');?></label>
          <input type="email" id="emailaddress" name="emailaddress" class="ffmwp-text" required/>
        </div>
        <div class="ffmwp-form-group">
          <label for="message" class="ffmwp-label"><?php printf(__('Message <small>%s</small>', 'ffmwp'), 'optional');?></label>
          <textarea id="message" name="message" class="ffmwp-textarea"></textarea>
        </div>
        <div class="ffmwp-form-group">
          <input type="submit" class="ffmwp-send-email-btn ffmwp-button" value="Send" />
          <span class="ffmwp-sending-file" style="display:none">Sending file ...</span>
        </div>
      </form>
    </section>

    
    
    
    <#
    }
    #>
    
</section>

</script>