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
    <h3>{{{data.title}}}</h3>
    
    {{{data.description}}}
    
    <section class="ffmwp-file-meta-wrapper">
        <header class="ffmwp-header"><?php _e('File Meta', 'ffmwp');?></header>
      
        {{{data.file_meta_info}}}
        
    </section>
    
</section>

</script>