<?php
/**
 * Enhanced MIME type validation for WPFM
 */

if (!defined('ABSPATH')) {
    exit;
}

function wpfm_validate_file_security($file_path, $file_name) {
    // Check file extension
    $file_type = wp_check_filetype_and_ext($file_path, $file_name);
    
    if (!$file_type['ext'] || !$file_type['type']) {
        return new WP_Error('invalid_file', __('Invalid file type detected', 'wpfm'));
    }
    
    // Get actual MIME type from file content
    if (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $actual_mime = finfo_file($finfo, $file_path);
        finfo_close($finfo);
        
        // Compare declared vs actual MIME type
        if ($actual_mime && $actual_mime !== $file_type['type']) {
            return new WP_Error('mime_mismatch', __('File content does not match declared type', 'wpfm'));
        }
    }
    
    // Check for dangerous file signatures
    $handle = fopen($file_path, 'rb');
    if ($handle) {
        $header = fread($handle, 1024);
        fclose($handle);
        
        // Check for executable signatures
        $dangerous_signatures = [
            "\x4D\x5A", // PE executable
            "\x7F\x45\x4C\x46", // ELF executable
            "#!/bin/", // Shell script
            "<?php", // PHP script
            "<script", // JavaScript
        ];
        
        foreach ($dangerous_signatures as $sig) {
            if (strpos($header, $sig) === 0 || strpos($header, $sig) !== false) {
                return new WP_Error('dangerous_file', __('Potentially dangerous file detected', 'wpfm'));
            }
        }
    }
    
    return true;
}

function wpfm_get_secure_allowed_types() {
    $default_safe_types = [
        'jpg', 'jpeg', 'png', 'gif', 'webp', // Images
        'pdf', 'doc', 'docx', 'txt', 'rtf', // Documents
        'zip', 'rar', '7z', // Archives
        'mp3', 'wav', 'ogg', // Audio
        'mp4', 'avi', 'mov', 'webm' // Video
    ];
    
    $allowed_types = wpfm_get_option('_file_types');
    if (!$allowed_types) {
        return $default_safe_types;
    }
    
    $custom_types = array_map('trim', explode(',', strtolower($allowed_types)));
    
    // Filter out potentially dangerous extensions
    $dangerous_extensions = [
        'php', 'php3', 'php4', 'php5', 'phtml', 'phps',
        'js', 'html', 'htm', 'css',
        'exe', 'bat', 'cmd', 'com', 'scr',
        'sh', 'bash', 'zsh', 'fish',
        'sql', 'db', 'sqlite'
    ];
    
    return array_diff($custom_types, $dangerous_extensions);
}
