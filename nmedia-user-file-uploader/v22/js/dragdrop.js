"use strict"
var FFMWP_DD = {
    
    init: function() {
        
        jQuery('.wpfm_file_box').draggable({

    		revert: function() {
    
    			jQuery(this).find('.file-action').css('display', 'inline-block');
    			jQuery(this).css('border', '1px solid #ddd');
    			jQuery(this).find('.wpfm-img').css('width', '64%');
    
    			return true;
    		},
    		cursor: 'move',
    		// refreshPositions: true
    	});
    
    	jQuery('.wpfm_file_box').on("drag", function(event, ui) {
    
            
    		jQuery(this).find('.file-action').css('display', 'none');
    		jQuery(this).css('border', 'none');
    		jQuery(this).find('.wpfm-img').css('width', '40%');
    
    	});
    
    	jQuery('*[data-file_type="dir"]').droppable({
    
    		hoverClass: 'wpfm-active-droppable-box',
    
    		accept: '.wpfm_file_box',
    		drop: function(event, ui) {
    
                jQuery.blockUI({ message:  ffmwp_file_vars.labels.file_sharing});
                // console.log('ui', ui.draggable);
    			var dir_id = jQuery(this).data("node_id");
    			var node_id = ui.draggable.data('node_id');
    			jQuery("#ffmwp-wrapper").find("[data-node_id='" + node_id + "']").css('display', 'none');
    
    			var data = {
    				action: 'nm_uploadfile_move_file',
    				file_id: node_id,
    				parent_id: dir_id,
    				"wpfm_ajax_nonce": jQuery('#wpfm_ajax_nonce').val()
    			}
    
    			jQuery.post(ffmwp_vars.ajaxurl, data, function(resp) {
    
    				if (resp.success) {
    				    
    				    jQuery.unblockUI();
    				    
    				    var {message, updated_dir} = resp.data;
    				    // // removing the file
    				    var updated_files = FFMWP.current_files.filter( f => f.id !== parseInt(node_id) );
                        
    				    if( FFMWP.current_directory === 0 ){
            	            ffmwp_vars.template_data.user_files = [...updated_files];
            	        } else {
    				        FFMWP.current_files = updated_files.filter( f => f.id !== parseInt(dir_id) );
            	            const new_children = [updated_dir, ...FFMWP.current_files];
                            ffmwp_vars.template_data.user_files = update_dir_with_new_children(ffmwp_vars.template_data.user_files, FFMWP.current_directory, new_children);
            	           // const moved_node = FFMWP.get_node_by_id(node_id);
            	        }
            	        
    				    //Refresh current directory with fresh files
					    FFMWP.reload_current_dir();
    					FFMWP.alert(message, 'success');
					    
    				}
    				else {
    					FFMWP.alert(resp.data, 'error');
    					window.location.reload();
    				}
    
    			}).fail(function() {
    
    				alert("error");
    			}, 'json');
    
    		}
    	});

    	jQuery('*[data-file_type="file"]').droppable({
    
    
    		hoverClass: 'wpfm-file-droppable-box',
    
    		accept: '*[data-file_type="file"]',
    
    	});
    }
}