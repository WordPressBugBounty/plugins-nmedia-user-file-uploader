<?php
/**
 * File Grid View
 * By Najeeb
 * Date April 6, 2023
 **/

if( ! defined('ABSPATH' ) ){ exit; }

$wrapper_class = 'ffmwp-files ffmwp_files_grid';
if( wpfm_get_option('_enable_table') === 'yes' ) {
  $wrapper_class .= ' ffmwp-files-list';
}
?>
<div class="<?php echo esc_attr($wrapper_class);?>"></div>

<script type="text/html" id="tmpl-ffmwp-files-grid">
<# _.forEach( data, function ( file ) { #>

  <div class="ffmwp-file wpfm_file_box file-margin-bottom {{file.title}} col-sm-2 parent-0 mix wpfm-file ui-droppable node-{{file.id}}" 
        id="node-{{file.id}}"
        data-file_type="{{file.node_type}}"
        data-title="{{file.title}}"
        data-file_size="{{file.size}}"
        data-pid="0"
        data-node_id="{{file.id}}">
    <div class="ffmwp-file-thumbnail">
      <img src="{{file.thumb_url}}" alt="{{file.title}}">
    </div>
    <div class="ffmwp-file-info">
      <span class="ffmwp-file-name">{{file.title}}</span>
    </div>
    <div class="ffmwp-file-actions">
    
      <# if(file.node_type == 'dir'){ #>
    	    {{{file.share_button}}}
    	    {{{file.delete_button}}}
          <a href="#" class="ffmwp-file-icons-content ffmwp-eye wpfm-dir" data-node_id="{{file.id}}" data-title="{{file.title}}"><span class="dashicons dashicons-visibility"></span></a>
    
        <# }else{ #>
        
    	    {{{file.share_button}}}
    	    
    	    {{{file.view_button}}}
    	    
    	    {{{file.delete_button}}}
    	    
    	    {{{file.download_button}}}
    	    
    	    {{{file.document_viewer_button}}}
    	   <# } #>
    	   
    </div>
  </div>
  
<# }) #>
</script>