<?php
/**
 * File Modal
 * Design by Najeeb
 * Date April 6, 2023
 **/
 
if( ! defined('ABSPATH' ) ){ exit; } 
?>
<div id="ffmwp-model-wrapper"></div>

<!-- The modal -->
<script type="text/html" id="tmpl-ffmwp-model">
<# _.forEach( data, function ( file ) { #>
<div id="ffmwp-modal-{{file.id}}" class="ffmwp-modal">
  <!-- Modal content -->
  <div class="ffmwp-modal-content">
  <span class="ffmwp-modal-close">&times;</span>
  <div class="ffmwp-modal-header">
    <h3 class="ffmwp-modal-title">{{file.title}}</h3>
  </div>
  <div class="ffmwp-modal-body">
    <section class="ffmwp-modal-col ffmwp-modal-col-left">
    
      <div class="ffmwp-modal-col-item">
        <img src="{{file.thumb_url}}" class="ffmwp-modal-file-thumb" alt="{{file.title}}">
      </div>
      
      {{{FFMWP_Util.render_template_part('ffmwp-modal-left', file)}}}
      
    </section>

    <section class="ffmwp-modal-col ffmwp-modal-col-right">
      {{{FFMWP_Util.render_template_part('ffmwp-modal-right', file)}}}
    </section>
    
  </div>
</div>
</div>
<# }) #>
</script>
