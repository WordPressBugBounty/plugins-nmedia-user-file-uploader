<?php
/**
 * FrontEnd FileManager Left Panel Template
 */

/*
**========== Block Direct Access ===========
*/
if( ! defined('ABSPATH' ) ){ exit; } 

$side_nav = wpfm_get_top_menu();
?>

<section class="ffmwp-search">
    <input type="text" id="ffmwp-search_files" class="ffmwp-search-input" placeholder="<?php _e('Search Files', 'wpfm');?>">
</section>

<section id="ffmwp-left-col-menu">
  <ul class="ffmwp-left-menu">
    
    <!-- Side navs -->
    <?php
    foreach($side_nav as $nav){
        $class  = 'side-nav-item ';
        $link   = isset($nav['link']) ? $nav['link'] : '';
        $class  .= isset($nav['class']) ? $nav['class'] : '';
        
        echo '<li><a href="'.esc_url($link).'" id="'.esc_attr($nav['id']).'" class="'.esc_attr($class).'">'.sprintf(__("%s", 'ffmwp'), $nav['label']).'</a>';
        if( isset($nav['children']) ){
            echo '<ul class="ffmwp-submenu">';
            foreach($nav['children'] as $child){
                $class  = 'side-nav-item-sub ';
                $class  .= isset($child['class']) ? $child['class'] : '';
                echo '<li><a href="'.esc_url($link).'" class="'.esc_attr($class).'" id="'.esc_attr($child['id']).'">'.sprintf(__("%s", 'ffmwp'), $child['label']).'</a></li>';
            }
            echo '</ul>';
        }
        echo '</li>';
    }
    ?>
    
    
  </ul>
</section>



