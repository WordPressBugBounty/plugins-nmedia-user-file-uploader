<?php
/**
 * WPFM REST API
 * 
 **/
 
class WPFM_REST {
    
    function __construct(){
         
         add_action('rest_api_init', array($this, 'rest_api'));
     }
     
     function rest_api() {
         
        // handle add new question
        register_rest_route( 'wpfm/v1', '/file-rename', array(
 		    'methods' => 'POST',
 		    'callback' => array($this, 'rename_file'),
 		    'permission_callback' => '__return_true'
 		) );
     }
     
     // Rename the file
     function rename_file($request) {
        $params = $request->get_params();
        
        if (empty ( $_POST ) || ! wp_verify_nonce ( $_POST ['wpfm_ajax_nonce'], 'wpfm_securing_ajax' )) {
    		wp_send_json_error(__("Sorry, not allowed", "wpfm"));
    	}
    
    	$current_user = wpfm_get_current_user();
    	if( ! $current_user ) {
    		wp_send_json_error(wp_send_json_error(__("Sorry, user not found.", "wpfm")));
    	}
    	
    	$file_name = sanitize_file_name( $params['filename'] );
    	$extension = pathinfo($file_name, PATHINFO_EXTENSION);
    	// checking file type
    	$extension = strtolower($extension);
    	$allowed_types = wpfm_get_option('_file_types');
    	if( ! $allowed_types ) {
    		$good_types = apply_filters('nm_allowed_file_types', array('jpg', 'png', 'gif', 'zip','pdf') );
    	}else {
    		$good_types = explode(",", $allowed_types );
    	}
    
    	if( ! in_array($extension, $good_types ) ){
    		wp_send_json_error(__ ( 'File type not valid', 'wpfm' ) );
    	}
         
        $fileobj = new WPFM_File($params['fileid']);
        $file_dir_path = wpfm_files_setup_get_directory($fileobj->owner_id);
        $file_new = $file_dir_path.$file_name;
        $resp = rename($fileobj->path, $file_new);
        
            if( $resp )
                $fileobj->rename_file($params['filename']);
            
            wp_send_json_success(__("File renamed successfully","wpfm"));
        }
}

new WPFM_REST;