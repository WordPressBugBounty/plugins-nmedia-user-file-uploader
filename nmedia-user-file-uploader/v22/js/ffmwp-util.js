/* global jQuery ffmwp_vars wp */

const FFMWP_Util = {
    
    render_files: function(data) {
        var filesHTML = wp.template(`ffmwp-files-grid`);
    	
    	jQuery(`.ffmwp_files_grid`).html(filesHTML(data)).promise().done(function(){
    	    FFMWP_Util.render_modal(data);
    	 
    	    jQuery.event.trigger({
				type: "ffmwp_after_files_rendered",
				time: new Date()
			});
    	});
    	
    },
    
    // rendering inside the template
    render_template_part: function(template_id, data){
        var partial = wp.template(`${template_id}`);
        return partial(data);    
    },
    
    render_modal: function(file_data, callback) {
        // detail
        var filesHTML = wp.template('ffmwp-model');
    	jQuery("#ffmwp-model-wrapper").html(filesHTML(file_data));
    	
    	// viewer
    	if( ffmwp_vars.document_viewer ){
        	var filesHTML = wp.template('ffmwp-model-viewer');
        	jQuery("#ffmwp-model-viewer-wrapper").html(filesHTML(file_data));
    	}
    	
    	callback;
    }
    
}