/* global ffmwp_vars mixitup NM_INIT_POPUP jQuery FFMWP_Util swal FFMWP_File FFMWP_DD */

var FFMWP = {

  init: function() {

    // filter user own files
    this.all_files = ffmwp_vars.template_data.user_files;
    this.my_files = ffmwp_vars.template_data.user_files.filter(file => Number(file.owner_id) === Number(ffmwp_vars.user_id));
    this.file_view = 'my';
    this.shared_files = []; // via user specific addon
    
    // load files into current_files based on file_view
    this.current_files = this.load_files_by_view('my');
    
    this.modal = document.getElementById("ffmwp-modal");
    this.current_directory = 0;
    this.BC = [ffmwp_vars.default_bc];
    this.render_bc();
    this.selected_files = [];
    
    // after files rendered
    jQuery(document).on('ffmwp_after_files_rendered', function(e){
      // Modal init
      FFMWP.handle_file_modals();
	    
  	  // Attaching file events
  	  FFMWP.init_single_file_events();
	  });
	  
	  // on directory open
	  jQuery(document).on('ffmwp_on_dir_open', function(e){
	    
	    FFMWP.current_directory = e.dir.id;
	    FFMWP.add_to_bc(e.dir, e.context);
	    
	    if( !e.dir.id ) return;
	    
	    jQuery('.ffmwp-dir-empty').remove();
	    if( e.dir.children.length === 0 ){
	      jQuery('<div/>').addClass('ffmwp-dir-empty').appendTo('.ffmwp-files')
	      .html('<span style="font-size:100px" class="dashicons dashicons-open-folder"></span>');
	    }
	  });
	  
	  jQuery(document).on('wpfm_after_dir_created', function(e){
	    
	   jQuery(`.ffmwp-click-to-reveal-block`).toggle();
	   //const current_node = FFMWP.get_node_by_id(FFMWP.current_directory);
	   // console.log(current_node);
	   // FFMWP.add_to_bc(current_node, 'new-item-created');
	  });
	  
    this.handle_breadcrumb_topbar_events();
	  this.handle_new_dir_button_toggle();
    this.handle_create_new_directy();
    this.handle_save_files();
    this.handle_delete_selected_files();
    this.handle_filter_by_group();
    this.handle_side_nav_click_event();
    this.handle_load_all_files();
    
    if( ffmwp_vars.files_area_display === '1' ){
      this.mixer = mixitup(`.ffmwp_files_grid`);
      FFMWP_Util.render_files(this.current_files);
    }
  },
  
  load_files_by_view: function(view) {
    this.file_view = view;
    if( 'all' === this.file_view ) {
      return this.all_files;
    } else if( 'my' === this.file_view ){
      return this.my_files;
    } else if( 'shared' === this.file_view ) {
      return this.shared_files;
    }
      console.log(this.file_view, this.current_files);
  },
  
  init_single_file_events: function () {
    this.handle_add_mixitup();
    this.handle_search_file_keyup_event();
    this.handle_sorted_by_event();
    this.handle_sort_radio_event();
    this.handle_form_file_title_desc_events();
    this.handle_form_file_meta_update();
    this.handle_form_send_file_via_email();
    this.handle_form_file_name_rename();
    this.handle_file_delete_event();
    this.handle_directory_open();
    
    // bulk delete
    ffmwp_vars.bulk_delete_allow && this.handle_node_click_and_select();
    
    // file drag/drop
    ffmwp_vars.dragdrop_allow && FFMWP_DD.init();
  },
  
  handle_file_modals: function() {
      
    // file detial modal
    jQuery(document).on('click', '.ffmwp-file-view', function(e){
        e.preventDefault();
        const modal = `#ffmwp-modal-${jQuery(this).data('fileid')}`;
        jQuery(modal).show();
    });
    
    jQuery(document).on('click', '.ffmwp-file-viewer', function(e){
        e.preventDefault();
        const modal = `#ffmwp-modal-viewer-${jQuery(this).data('fileid')}`;
        jQuery(modal).show();
    });
    
    
    
    jQuery(document).on('click', '.ffmwp-modal-close', function(e){
        FFMWP.handle_modal_close();
    });
    
  },
  
  handle_modal_close: function(){
      jQuery('.ffmwp-modal').hide();
      jQuery('.ffmwp-modal-viewer').hide();
  },
  
  handle_add_mixitup: function() {

    // var mix = jQuery('.ffmwp_files_grid').mixItUp();
    this.mixer.destroy();
    this.mixer = mixitup(`.ffmwp_files_grid`,{
      animation: {
        queueLimit:5,
      }
    });
  },
  
  handle_form_file_title_desc_events: function() {

    // file-title-desc
    jQuery(document).on('submit', '#ffmwp-file-single-form', function(e) {
      e.preventDefault();
      var data = jQuery(this).serialize();
      // console.log(data);

      jQuery.post(ffmwp_vars.ajaxurl, data, function(resp) {
        
        if (resp.success) {
          
          var {message, file} = resp.data;
				  
					FFMWP.alert(message, 'success');
        }
        else {
          swal('error', resp.data, "error");
          window.location.reload();
        }

      }).fail(function() {
        swal('error', "File not update", "error");
      });

    });
  },
  
  handle_form_file_meta_update: function() {

    // file-email-msg
    jQuery(document).on('submit', '.ffmwp-update-file-meta', function(e) {
      e.preventDefault();

      var wpfm_ajax_nonce = jQuery('#wpfm_ajax_nonce').val();

      var data = jQuery(this).serialize();
      data = data+`&wpfm_ajax_nonce=${wpfm_ajax_nonce}`;
      // console.log(data);

      jQuery.post(ffmwp_vars.ajaxurl, data, function(resp) {

        var {data, success} = resp;
        var alert_type = success ? 'success' : 'error';
        FFMWP.alert(data, alert_type);
        
      }, 'json');

    });
  },
  
  handle_form_send_file_via_email: function() {

    // file-email-msg
    jQuery(document).on('submit', '.ffmwp-send-file-in-email', function(e) {
      e.preventDefault();

      jQuery('.ffmwp-sending-file').show();

      var wpfm_ajax_nonce = jQuery('#wpfm_ajax_nonce').val();

      var data = jQuery(this).serialize();
      data = data+`&wpfm_ajax_nonce=${wpfm_ajax_nonce}`;
      // console.log(data);

      jQuery.post(ffmwp_vars.ajaxurl, data, function(resp) {

        if (resp.success) {
          swal('success', resp.data, "success");
          // WPFM.alert(resp.data, 'success');	
        }
        else {
          swal('error', resp.data, "error");
          // WPFM.alert(resp.data, 'error');
        }

        jQuery('.ffmwp-sending-file').toggle();

      }, 'json');

    });
  },
  
  handle_form_file_name_rename: function(){

  	jQuery(document).on('click', '.ffmwp-rename-edit-btn', function(e) {
       e.preventDefault();
      
  		const filename = jQuery(this).closest('section').find('input.wpfm_filename').val();
  		const file_id = jQuery(this).attr('data-fileid');
  		const url = ffmwp_vars.rest_api_url + '/file-rename';
  		var wp_nonce_value = jQuery('#wpfm_ajax_nonce').val(); 
  		// var data = { fileid: file_id, filename: filename,wpfm_ajax_nonce:wp_nonce_value};
  		var data = `fileid=${file_id}&filename=${filename}&wpfm_ajax_nonce=${wp_nonce_value}`;
  		// const params = ;
  		   jQuery.ajax({
      		  type: 'POST',
            url: url,
            data: data,
            dataType: 'json',
            beforeSend: function ( xhr ) {
                xhr.setRequestHeader( 'X-WP-Nonce', ffmwp_vars._nonce );
            },
            success: function(resp){
              const {success, data} = resp;
              if( success ) {
                FFMWP.alert(data, 'success');
              }else {
                FFMWP.alert(data, 'error');
              }
            },
            error: function(err){
              console.log(err)
            }
      		});
  		});
  },
  
  handle_file_delete_event: function(){
	  
      jQuery(document).on('click', '.ffmwp-delete-file', function(e) {
        
      e.preventDefault();
      
      var file_id = jQuery(this).data('id');
      
      swal({
      	title: ffmwp_vars.labels.file_delete,
      	icon: "warning",
      	showCancelButton: true,
      	buttons: true,
      	buttons: [ffmwp_vars.labels.text_cancel, ffmwp_vars.labels.text_yes],
      	dangerMode: true
      }).then(function(willDelete) {
      	if (willDelete) {
      
      		swal(ffmwp_vars.labels.file_deleting, {
      
      			className: "red-bg",
      			buttons: false,
      
      		});
      
      		FFMWP.delete_file(file_id);
      
      	}
      	else {
      		jQuery('html').css('overflow', 'visible')
      		jQuery('body').css('overflow', 'visible')
      	}
      });
      
      });
	},
	
	delete_file: function(file_id){
	  
	  //first hide modal
		var modal_id = `ffmwp-files-popup-${file_id}`;

		jQuery(modal_id).hide();
		
		// get the file object
		const fileObj = this.get_node_by_id(file_id);
		const file_ids = extract_ids_from_a_file(fileObj, []);
		// return console.log(fileObj);
		
		// if( fileObj.location === 'amazon' ){
		//   const {key, bucket} = fileObj.amazon_data;
		//   deleteFileFromS3(bucket, key)
  //     .then((data) => {
  //       console.log('Object deleted successfully:', data);
  //     })
  //     .catch((err) => {
  //       console.log('Error deleting object:', err);
  //     });

		//   return;
		// }
		
		var data = {
			'action': 'wpfm_delete_file',
			'file_id': file_id,
			'file_ids': file_ids,
			"wpfm_ajax_nonce" :jQuery('#wpfm_ajax_nonce').val()
		}

		jQuery.post(ffmwp_vars.ajaxurl, data, function(resp) {

			if( resp.success ) {
			  
			  var {message} = resp.data;
			  
				FFMWP.alert(message, 'success');
				
				jQuery.event.trigger({
					type: "wpfm_after_item_deleted",
					file_id: file_id,
					time: new Date()
				});
				
				// window.location.reload();
				
			}else{
				FFMWP.alert(resp.data, 'error');
			}
		},'json');
			
	},
  
  handle_search_file_keyup_event: function(){
    
      jQuery(document).on('keyup', '#ffmwp-search_files', function(event) {
  		// Delay function invoked to make sure user stopped typing
  
  		var inputText;
  		var $matching = jQuery();
  		inputText = jQuery("#ffmwp-search_files").val().toLowerCase();
    
  		// Check to see if input field is empty
  		if (inputText.length > 0) {
  			jQuery('.mix').each(function() {
  				// add item to be filtered out if input text matches items inside the title   
  				if (jQuery(this).find('.ffmwp-file-name').text().toLowerCase().match(inputText)) {
  					$matching = $matching.add(this);
  				}
  				else {
  					// removes any previously matched item
  					$matching = $matching.not(this);
  				}
  			});
      		FFMWP.mixer.filter($matching);
  		}
  		else {
  		  FFMWP.mixer.filter('all');
  		}
  	});
    
  },
  
  handle_filter_by_group: function() {
    
    // disable Group main nav
    jQuery('#side-nav-file-groups').on('click', function(e) {
        e.preventDefault();
    });
    
    // Add click event to each group item
    jQuery('.ffmwp-group-item').on('click', function(e) {
      e.preventDefault();
      // Get the group ID
      var group_id = jQuery(this).attr('id');
      
      if( group_id === 'all' ){
        return FFMWP.mixer.filter('all');
      }
      
      group_id = Number(group_id);
      // Get the file IDs for the group
      var file_ids = ffmwp_vars.file_groups.find(function(group) {
        return group.term_id === group_id;
      }).file_ids;
      
      // Filter files by the file IDs
      var matching_files = FFMWP.current_files.filter(function(file) {
        return file.id && file_ids.includes(file.id);
      });
      
      // Hide all files
      FFMWP.mixer.filter('none');
      
      // Show the matching files
      var $matching = jQuery();
      matching_files.forEach(function(file) {
        var $file_item = jQuery('[data-node_id="' + file.id + '"]');
        $matching = $matching.add($file_item);
      });
      FFMWP.mixer.filter($matching);
    });
  },

  
  handle_sorted_by_event: function(){
    
      jQuery(document).on('change', '#wpfm_sorted_by', function(event) {
    		var orderby = jQuery(this).val();
    		var order = jQuery('input[name="wpfm_sortorder"]:checked').val();
    		FFMWP.mixer.sort(`${orderby}:${order}`);
    	});
  },
  
  handle_sort_radio_event: function(){
    
      jQuery(document).on('change', 'input[name="wpfm_sortorder"]', function(event) {
    		var order = jQuery(this).val();
    		var orderby = jQuery("#wpfm_sorted_by").val();
    		FFMWP.mixer.sort(`${orderby}:${order}`);
    	});
  },
  
  handle_breadcrumb_topbar_events: function() {
    
    jQuery(document).on('click', '.ffmwp-bc-item', function(e){
      e.preventDefault();
        var dir_id = jQuery(this).data('node_id');
        // console.log(dir_id);
        let context = 'bc-click';
        if( dir_id === 0 ){
          FFMWP.current_files = FFMWP.load_files_by_view(FFMWP.file_view);
          context = 'home-click';
        }
		    // var dir_title = jQuery(this).data('title');
		    var dir_node = FFMWP.get_node_by_id(dir_id);
	      FFMWP.open_directory(dir_node, context); 
    })
    
  },
  
  handle_new_dir_button_toggle: function() {

    jQuery(document).on('click', '.ffmwp-click-to-reveal, .ffmwp-uploadarea-cancel-btn ', function(e) {
      e.preventDefault();
      jQuery(`.ffmwp-click-to-reveal-block`).toggle();
    });
  },
  
  handle_create_new_directy: function(){
    
      jQuery('#ffmwp-create-dir-form').on('submit', function(e){
        
        jQuery.blockUI({ message:  ffmwp_file_vars.labels.file_sharing});
        
        e.preventDefault();
        var data = jQuery(this).serialize();
        var wp_nonce_value = jQuery('#wpfm_ajax_nonce').val();
        
        data += `&wpfm_ajax_nonce=${wp_nonce_value}&parent_id=${FFMWP.current_directory}`;
        
        jQuery.post(ffmwp_vars.ajaxurl, data, function(resp) {

				if(resp.success) {
				  
				  jQuery.unblockUI();
				  
				  var {message, user_files, dir_id, new_dir} = resp.data;
				  
					FFMWP.alert(message, 'success');
					
					if( FFMWP.current_directory === 0 ){
              FFMWP.my_files = [new_dir, ...FFMWP.current_files];
          } else {
              const new_children = [new_dir, ...FFMWP.current_files];
              FFMWP.my_files = update_dir_with_new_children(ffmwp_vars.template_data.user_files, FFMWP.current_directory, new_children);
          }
					
          FFMWP.reload_current_dir();
          
					jQuery.event.trigger({
						type: "wpfm_after_dir_created",
						dir_id: dir_id,
						time: new Date()
					});
					
				// 	FFMWP_Util.render_files(user_files);
					
				}else{
				  
					FFMWP.alert(resp.data, 'error');
				// 	window.location.reload(false);
				}

			}).fail(function() {
				FFMWP.alert(ffmwp_vars.messages.http_server_error, 'error');
			}, 'json');
        
      })
  },
  
  reload_current_dir: function(){
    
    // console.log(FFMWP.current_directory);
    if( FFMWP.current_directory === 0 ){
      this.current_files = this.load_files_by_view(this.file_view);
	    return FFMWP_Util.render_files(this.current_files);
	  }
	  
	  var dir_node = FFMWP.get_node_by_id(FFMWP.current_directory);
	  const context = 'new-item-created';
		FFMWP.open_directory(dir_node, context); 
	},
  
  handle_directory_open: function(){
    
      jQuery(document).off('click', '.ffmwp-eye.wpfm-dir');
      
		  jQuery(document).on('click', '.ffmwp-eye.wpfm-dir', function(e){
		    e.preventDefault();
		    // e.stopPropagation();
		    
		    var dir_id = parseInt(jQuery(this).attr('data-node_id'));
		    
        console.log(dir_id);
		    const current_dir = FFMWP.get_node_by_id(dir_id);
		    
		    // FFMWP.current_files = current_dir.children;
		    FFMWP.open_directory(current_dir);
		  });
		},
		
	open_directory: function(dir_node, context='dir-click'){
		    // FFMWP.current_files = dir_node.children === undefined ? ffmwp_vars.template_data.user_files : dir_node.children;
		    // console.log(context);
		    this.current_files = context === 'home-click' ? this.load_files_by_view(this.file_view) : dir_node.children;
		    
        FFMWP_Util.render_files(FFMWP.current_files);
	      jQuery.event.trigger({
  				type: "ffmwp_on_dir_open",
  				time: new Date(),
  				dir: dir_node,
  				context:context,
  			});  
	},
	
	handle_save_files: function() {
    
      jQuery(document).on('click', '#ffmwp_save_files_btn', function(e){
        e.preventDefault();
        FFMWP_File.upload_files();
        
      });
  },
  
  handle_delete_selected_files: function(){
    
    jQuery(document).on('click','.ffmwp-delete-selected', function(e){
      // get the file object
    let file_ids = [];
		FFMWP.selected_files.forEach(file => {
      const fileObj = FFMWP.get_node_by_id(file);
      const node_ids = extract_ids_from_a_file(fileObj, []);
      file_ids = [...node_ids, ...file_ids];
    });
    
    swal({
      	title: ffmwp_vars.labels.file_delete,
      	icon: "warning",
      	showCancelButton: true,
      	buttons: true,
      	buttons: [ffmwp_vars.labels.text_cancel, ffmwp_vars.labels.text_yes],
      	dangerMode: true
      }).then(function(willDelete) {
      	if (willDelete) {
      
      		swal(ffmwp_vars.labels.file_deleting, {
      
      			className: "red-bg",
      			buttons: false,
      
      		});
      		
      		// jQuery.blockUI({ message:  ffmwp_file_vars.labels.file_sharing});
      
      		var data = {
      			'action': 'wpfm_delete_file',
      			'file_id': file_ids[0],
      			'file_ids': file_ids,
      			'is_multiple': true,
      			"wpfm_ajax_nonce" :jQuery('#wpfm_ajax_nonce').val()
      		}
      
      		jQuery.post(ffmwp_vars.ajaxurl, data, function(resp) {
      
      			if( resp.success ) {
      			  
      			 // jQuery.unblockUI();
      			  
      			  var {message} = resp.data;
      			  
      				FFMWP.alert(message, 'success');
      				
      				window.location.reload();
      				
      			}else{
      				FFMWP.alert(resp.data, 'error');
      			}
      		},'json');
      
      	}
      	else {
      		jQuery('html').css('overflow', 'visible')
      		jQuery('body').css('overflow', 'visible')
      	}
      });
      
    });
  },
  
  add_to_bc: function(node, context) {

    console.log(context);
    switch (context) {
      case 'new-item-created':
      case 'bc-click':
        let index = this.BC.findIndex(bc => bc.id === node.id);
        this.BC = this.BC.splice(0, index+1);
        break;
      case 'dir-click':
  			if (node.id !== undefined) {
  			  console.log(this.BC);
  				var new_node = { id: node.id, title: node.title };
  				this.BC = [...this.BC, new_node];
  			}
  			break;
  		case 'home-click':
  		  this.BC = [];
  		  this.BC.push(ffmwp_vars.default_bc);
  		  break;
    }

		this.render_bc();
		},
		
	render_bc: function() {

      var wpfm_bc_dom = jQuery('.ffmwp-breadcrumbs ul').html('');
      const breadcrumb = this.BC;
      jQuery.each(breadcrumb, function(i, bc) {
        var BCItem = jQuery('<li/>')
          .attr('data-node_id', bc.id)
					.attr('data-title', bc.title)
					.addClass('ffmwp-bc-item')
					.addClass('ffmwp-left-bc')
          .html('<a href="#">' + bc.title + '</a>')
          .appendTo(wpfm_bc_dom);
      
        if (i < breadcrumb.length - 1) {
          jQuery('<span/>').css('margin', '0 3px').html('/').appendTo(wpfm_bc_dom);
        }
      });
		},
		
  get_node_by_id: function(node_id, children){
		  
    var file_found = Array();
    
    if (node_id == 0) return file_found;
    
    var searchable_files = children ? children : this.load_files_by_view(this.file_view);
    // var searchable_files = [...files_bank, ...this.current_files];
    
    jQuery.each(searchable_files, function(i, file) {
      if (file.id === node_id) {
      	file_found = file;
      	return false;
      }else {
      	if (file.node_type === 'dir' && file.children.length > 0 && file_found.length == 0) {
      		file_found = FFMWP.get_node_by_id(node_id, file.children);
      	}
      }
    });
    
    console.log(searchable_files);
    
    return file_found;
  },
  
  handle_node_click_and_select: function(){
    
    jQuery(document).off('click', '.ffmwp-file');
    
    jQuery(document).on('click', '.ffmwp-file', function(e) {4
      jQuery(this).toggleClass('node-selected');
      
      FFMWP.selected_files = [];
      jQuery('.ffmwp-delete-selected').hide();
      jQuery('.ffmwp-file').each(function() {
        if (jQuery(this).hasClass('node-selected')) {
          FFMWP.selected_files.push(jQuery(this).data('node_id'));
        }
      });
      // console.log(FFMWP.selected_files);
      if(FFMWP.selected_files.length > 0){
        jQuery('.ffmwp-delete-selected')
        .show()
        .find('.del-count')
        .html(`(${FFMWP.selected_files.length})`)
      }

    });
  },
  
  handle_side_nav_click_event: function(){
    
    jQuery('#side-nav-my-files').on('click', function(e){
      e.preventDefault();
      FFMWP.current_files = FFMWP.load_files_by_view('my');
      FFMWP_Util.render_files(FFMWP.current_files);
      jQuery("#upload_files_btn_area").show();
    })
    
  },
  
  handle_load_all_files: function(){
    jQuery('#side-nav-all-files').on('click', function(e){
      e.preventDefault();
      FFMWP.current_files = FFMWP.load_files_by_view('all');
      FFMWP_Util.render_files(FFMWP.current_files);
      // hide upload area
      jQuery("#upload_files_btn_area").hide();
    });
  },
  
  alert: function(message, type) {
		type = undefined ? 'success' : type
		return swal(message, "", type);
	},
}

FFMWP.init();

// When the user presses the "Esc" key, close the modal
document.onkeydown = function(event) {
  if (event.keyCode == 27) {
    FFMWP.handle_modal_close();
  }
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == FFMWP.modal) {
    FFMWP.handle_modal_close();
  }
}

// it will return ids of directory and it's child
function extract_ids_from_a_file(obj, ids) {
  ids.push(obj.id);
  
  if (obj.children) {
    for (var i = 0; i < obj.children.length; i++) {
      extract_ids_from_a_file(obj.children[i], ids);
    }
  }
  
  // sort the ids array in ascending order before returning it
  ids.sort(function(a, b) {
    return b - a;
  });
  
  return ids;
}

// update the given files array with new children of dir
function update_dir_with_new_children(arr, id, newChildren) {
  return arr.map(function(obj) {
    if (obj.id === id) {
      return Object.assign({}, obj, { children: newChildren });
    } else if (obj.children) {
      return Object.assign({}, obj, { children: update_dir_with_new_children(obj.children, id, newChildren) });
    } else {
      return obj;
    }
  });
}

// saving video_duration for video types
jQuery(document).on("ffmwp_after_file_preview", handleAfterFilePreview);
function handleAfterFilePreview(event) {
  var file = event.file;
  
  // Check if the file type is video
  if (file.type.indexOf('video') !== -1) {
    // Create a video element
    var video = document.createElement('video');

    // Set the source of the video element to the file URL
    video.src = URL.createObjectURL(file);

    // Wait for the video metadata to load
    video.addEventListener('loadedmetadata', function() {
      // Get the duration in seconds
      var duration = video.duration;
      
      // Create a hidden input element
      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = `uploaded_files[${file._id}][video_duration]`;
      input.value = duration;
      
      // Append the hidden input to #ffmwp-form-data
      jQuery('#ffmwp-form-data').append(input);
    });
  }
}



