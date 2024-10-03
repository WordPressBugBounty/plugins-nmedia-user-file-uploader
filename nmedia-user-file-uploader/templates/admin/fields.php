<?php
    // not run if accessed directly
    if( ! defined("ABSPATH" ) )
        die("Not Allewed");

    $wpfm_meta = get_option(WPFM_SHORT_NAME . '_file_meta', true);
    $wpfm_meta = json_decode($wpfm_meta, true);
    $wpfm_default_meta = WPFM_META()->meta_array();
    $wpfm_field_index = 1;
    $option  = wpfm_get_option('_file_groups_add');
    
    // wpfm_pa($wpfm_meta);
    wp_nonce_field('wpfm_securing_ajax','wpfm_ajax_nonce');
    
?>
<div class="card card-design">
   <p class="text-center">
       <button class="button button-primary" data-toggle="modal" data-target="#wpfm_metas">
           <?php _e('Add Field', 'ffmwp');?>
        </button>
   </p>
   
   <div class="main-div wpfm-fields-append" data-field-box="have_values">

    <?php 
    if ( !empty($wpfm_meta) && is_array($wpfm_meta) ) {
        $f_index = 1;
        foreach ($wpfm_meta as $field_index => $field) {
        ?>
            <div class="wpfm-slider wpfm-arrange-id <?php echo esc_attr($field_index)?>">
            <?php
                foreach ($field as $field_type => $save_data) {
                    $wpfm_field_meta = $wpfm_default_meta[$field_type];
                    $field_meta = $wpfm_field_meta['field_meta'];
                    $field_title = $wpfm_field_meta['title'];
                    $field_desc = $wpfm_field_meta['description'];
                 ?>
                 
                 
                <header class="meta-header wpfm_check">
                    <h3 class="title"><?php echo sprintf(__("%s","wp-registration"),$field_title) ?></h3>
                    <span class="ffmwp-header-tools">
                        <i class="fa fa-times wpfm-remove-field" aria-hidden="true" title="Remove" data-fieldid="<?php echo esc_attr($field_index)?>"></i>
                        <i class="fa fa-angle-double-down wpfm-toggle-field" aria-hidden="true" title="Slide" data-fieldid="<?php echo esc_attr($field_index)?>"></i>
                        <!--<i class="fa fa-files-o wpfm-copy-field" aria-hidden="true" title="Copy" data-copy-field_id="<?php echo esc_attr($field_type); ?>" data-fieldid="<?php echo esc_attr($field_index)?>"></i>-->
                    </span>
                </header>
            
                <div class="wpfm-slider-inner wpfm_slide_toggle dccc container-fluid <?php echo esc_attr($field_index)?>">
                    <!--<p class="meta-desc"><?php echo sprintf(__("%s","wp-registration"),$field_desc) ?></p>-->

                 <?php   
                    // wpfm_pa($wpfm_field_meta);
                    echo WPFM_META()->render_field_meta($field_meta, $field_type, $f_index, $save_data);  
                }

                $wpfm_field_index = $f_index;
                $wpfm_field_index++;
                $f_index++;
                ?>
                
                </div>
            </div>
        <?php
        }
    }

    echo '<input type="hidden" id="field_index" value="'.$wpfm_field_index.'">';
    ?>
   </div>
</div>
<div class="save-meta-wrapper">
    <button class="button button-primary save-meta-btn">
        <?php _e('Save Meta', 'wpfm');?>
    </button>
    <span class="loading-area pull-right"><img src="<?php echo admin_url("images/spinner.gif"); ?>"> </span>
</div>

 <!-- Modal -->
<div class="modal fade" id="wpfm_metas" role="dialog" style="margin-top: 80px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                <h4 class="modal-title"><?php _e('Select Field' , 'wpfm'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="sk-cube-grid wpfm-loader">
                    <div class="sk-cube sk-cube1"></div>
                    <div class="sk-cube sk-cube2"></div>
                    <div class="sk-cube sk-cube3"></div>
                    <div class="sk-cube sk-cube4"></div>
                    <div class="sk-cube sk-cube5"></div>
                    <div class="sk-cube sk-cube6"></div>
                    <div class="sk-cube sk-cube7"></div>
                    <div class="sk-cube sk-cube8"></div>
                    <div class="sk-cube sk-cube9"></div>
                </div>

                <div class="wpfm_fields_hidden rm-fields">
                    <ul class="list-group list-inline form-row">
                        <?php
                            $clone_id = 0;
                            $fields = WPFM_META()->meta_array();
                            foreach ($fields as $id => $save_data) {
                        ?> 
                        <li class="wpfm-fields wpfm-fields-clone list-group-item col-2 push_button red" data-field-id="<?php echo $id; ?>">
                            <span class=" field-text wpfm-fields-icon" style=""><?php echo $save_data['icon']; ?>
                            </span>
                            <span class=" field-text">
                                <?php echo $save_data['title'];  ?>
                                    
                            </span>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default close-model" data-dismiss="modal"><?php _e('Close' , 'wpfm'); ?></button>
            </div>
        </div>
    </div>
</div>

<div style ="display: none">
    <?php  WPFM_META()->render_field_settings(); ?>
</div>