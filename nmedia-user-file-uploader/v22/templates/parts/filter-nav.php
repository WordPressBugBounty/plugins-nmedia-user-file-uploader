<?php
/**
 * Filter Nav
 * Design by Najeeb
 * Date April 6, 2023
 **/
 
if( ! defined('ABSPATH' ) ){ exit; } 
?>
<nav class="ffmwp-navbar-2">
  <div class="ffmwp-breadcrumbs">
    <ul class="ffmwp-bc-list"></ul>
  </div>


  <div class="ffmwp-filter">
    <label for="ffmwp-sort"><?php _e( "Sorted by", "wpfm"); ?></label>
    <select class="ffmwp-sort" id="wpfm_sorted_by">
      <option value="title"><?php _e( "Name","wpfm"); ?></option>
			<option value="file_type"><?php _e( "Type", "wpfm"); ?></option>
			<option value="file_size"><?php _e( "Size", "wpfm"); ?></option>
    </select>
    
    <label>
        <input type="radio" name="wpfm_sortorder" checked="" value="asc">
        <span class="ffmwp-radio-label"><?php _e( "Asc", "wpfm"); ?></span>					
    </label>
    
    <label>
        <input type="radio" name="wpfm_sortorder" value="desc">
        <span class="ffmwp-radio-label"><?php _e( "Desc", "wpfm"); ?></span>
    </label>

  </div>
</nav>
