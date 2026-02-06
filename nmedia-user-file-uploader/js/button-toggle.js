jQuery(document).ready(function($) {
    // Monitor file preview wrapper for changes
    const observer = new MutationObserver(function(mutations) {
        const previewWrapper = $('#ffmwp_files_preview_wrapper');
        const uploadButtons = $('.ffmwp-upload-buttons');
        
        if (previewWrapper.children().length > 0) {
            uploadButtons.addClass('hidden');
        } else {
            uploadButtons.removeClass('hidden');
        }
    });
    
    // Start observing
    const previewElement = document.getElementById('ffmwp_files_preview_wrapper');
    if (previewElement) {
        observer.observe(previewElement, { childList: true });
    }
    
    // Handle cancel button clicks
    $(document).on('click', '.ffmwp-file-remove, .ffmwp-uploadarea-cancel-btn', function() {
        $('#ffmwp_files_preview_wrapper').empty();
        $('.ffmwp-save-file-btn').hide();
        $('.ffmwp-upload-buttons').removeClass('hidden');
    });
    
    // Clear preview when new files are selected
    $('#ffmwp_choosefile').on('change', function() {
        if (this.files.length > 0) {
            $('#ffmwp_files_preview_wrapper').empty();
        }
    });
});
