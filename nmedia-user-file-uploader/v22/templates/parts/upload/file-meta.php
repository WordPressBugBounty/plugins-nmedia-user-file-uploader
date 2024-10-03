<?php
/**
 * File Meta Fields
 * Showing File details after file selected (not uploaded yet)
 */

if( ! defined('ABSPATH' ) ){ exit; } 
?>

<script type="text/html" id="tmpl-ffmwp-file-meta-text">
    <div class="ffmwp-form-group-inline">
    <label for="{{data.meta.data_name}}" class="ffmwp-label">{{data.meta.title}}</label>
    <input type="text"
           id="{{data.meta.data_name}}"
           name="uploaded_files[{{data.file_id}}][file_meta][{{data.meta.data_name}}]" 
           class="{{data.meta.class}} ffmwp-text" 
           placeholder="{{data.meta.placeholder}}" 
           value="{{data.meta.default_value}}"
           required/>
    </div>
</script>

<script type="text/html" id="tmpl-ffmwp-file-meta-date">
<div class="ffmwp-form-group-inline">
    <label for="{{data.meta.data_name}}" class="ffmwp-label">{{data.meta.title}}</label>
    <input type="date"
           id="{{data.meta.data_name}}"
           name="uploaded_files[{{data.file_id}}][file_meta][{{data.meta.data_name}}]" 
           class="{{data.meta.class}} ffmwp-meta-date-field" 
           placeholder="{{data.meta.placeholder}}" 
           value="{{data.meta.default_value}}"
           required/>
</div>
</script>

<script type="text/html" id="tmpl-ffmwp-file-meta-select">
<div class="ffmwp-form-group-inline">
    <label for="{{data.meta.data_name}}" class="ffmwp-label">{{data.meta.title}}</label>
    <select 
            name="uploaded_files[{{data.file_id}}][file_meta][{{data.meta.data_name}}]"
            id="{{data.meta.data_name}}"
            class="ffmwp-meta-select-field ffmwp-select"
            required>{{data.meta.title}}
    		<# _.forEach( data.meta.options, function ( option ) {
    			var selected = '';
    			if(option == data.default_value){
    				selected = 'selected';
    		}#>
    			<option {{selected}} value="{{option}}">{{option}}</option>
    		<# }) #>
    </select>
</div>
</script>

<script type="text/html" id="tmpl-ffmwp-file-meta-checkbox">
<div class="ffmwp-form-group-inline">
    <label class="ffmwp-label">{{data.meta.title}}</label>
    <# _.forEach( data.meta.options, function ( option ) { #>
    <label class="ffmwp-checkbox-inline">
        <input type="checkbox"
               name="uploaded_files[{{data.file_id}}][file_meta][{{data.meta.data_name}}][]" 
               class="{{data.meta.class}}"  
               value="{{option}}"
               required/>
        {{option}}
    </label>
    <# }) #>
</div>
</script>

<script type="text/html" id="tmpl-ffmwp-file-meta-radio">
<div class="ffmwp-form-group-inline">
    <label class="ffmwp-label">{{data.meta.title}}</label>
    <# _.forEach( data.meta.options, function ( option ) { #>
    <label>    
        <input type="radio"
               name="uploaded_files[{{data.file_id}}][file_meta][{{data.meta.data_name}}]" 
               class="{{data.meta.class}}"  
               value="{{option.default_value}}"
               required/>
        {{option}}
    </label>
    <# }) #>
</div>
</script>

<script type="text/html" id="tmpl-ffmwp-file-meta-number">
    <div class="ffmwp-form-group-inline">
    <label for="{{data.meta.data_name}}" class="ffmwp-label">{{data.meta.title}}</label>
    <input type="number"
           id="{{data.meta.data_name}}"
           name="uploaded_files[{{data.file_id}}][file_meta][{{data.meta.data_name}}]" 
           class="{{data.meta.class}} ffmwp-meta-number-field" 
           placeholder="{{data.meta.placeholder}}" 
           value="{{data.meta.default_value}}"
           max="{{data.max_values}}"
           min="{{data.min_values}}"
           required/>
    </div>
</script>

<script type="text/html" id="tmpl-ffmwp-file-meta-color">
    <div class="ffmwp-form-group-inline">
    <label for="{{data.meta.data_name}}" class="ffmwp-label">{{data.meta.title}}</label>
    <input type="color"
           id="{{data.meta.data_name}}"
           name="uploaded_files[{{data.file_id}}][file_meta][{{data.meta.data_name}}]" 
           class="{{data.meta.class}}" 
           value="{{data.meta.default_value}}"
           required/>
    </div>
</script>

<script type="text/html" id="tmpl-ffmwp-file-meta-email">
    <div class="ffmwp-form-group-inline">
    <label for="{{data.meta.data_name}}" class="ffmwp-label">{{data.meta.title}}</label>
    <input type="email"
           id="{{data.meta.data_name}}"
           name="uploaded_files[{{data.file_id}}][file_meta][{{data.meta.data_name}}]" 
           class="{{data.meta.class}} ffmwp-meta-email-field" 
           placeholder="{{data.meta.placeholder}}" 
           value="{{data.meta.default_value}}"
           required/>
    </div>
</script>

<script type="text/html" id="tmpl-ffmwp-file-meta-url">
    <div class="ffmwp-form-group-inline">
    <label for="{{data.meta.data_name}}" class="ffmwp-label">{{data.meta.title}}</label>
    <input type="url"
           id="{{data.meta.data_name}}"
           name="uploaded_files[{{data.file_id}}][file_meta][{{data.meta.data_name}}]" 
           class="{{data.meta.class}} ffmwp-meta-url-field" 
           placeholder="{{data.meta.placeholder}}" 
           value="{{data.meta.default_value}}"
           required/>
    </div>
</script>

<script type="text/html" id="tmpl-ffmwp-file-meta-textarea">
    <div class="ffmwp-form-group-inline">
    <label for="{{data.meta.data_name}}" class="ffmwp-label">{{data.meta.title}}</label>
    <textarea
           id="{{data.meta.data_name}}"
           name="uploaded_files[{{data.file_id}}][file_meta][{{data.meta.data_name}}]" 
           class="{{data.meta.class}} ffmwp-meta-textarea-field" 
           placeholder="{{data.meta.placeholder}}"
           value="{{data.meta.default_value}}"
           required></textarea>
    </div>
</script>