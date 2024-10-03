<?php
/**
 * File Modal
 * Design by Najeeb
 * Date April 6, 2023
 **/
 
if( ! defined('ABSPATH' ) ){ exit; } 
?>
<div id="ffmwp-model-viewer-wrapper"></div>

<!-- The modal -->
<script type="text/html" id="tmpl-ffmwp-model-viewer">
<# _.forEach( data, function ( file ) { #>
<div id="ffmwp-modal-viewer-{{file.id}}" class="ffmwp-modal">
  <!-- Modal content -->
  <div class="ffmwp-modal-content">
  <span class="ffmwp-modal-close">&times;</span>
  <div class="ffmwp-modal-header">
    <h3 class="ffmwp-modal-title">{{file.title}}</h3>
  </div>
  <div class="ffmwp-modal-body" id="ffmwp-iframe-wrapper">
    <iframe src="{{file.url}}"></iframe>
  </div>
</div>
</div>
<# }) #>
</script>
