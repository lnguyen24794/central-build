/**
 * Central Build Pro Admin JavaScript
 */
jQuery(document).ready(function($) {
    
    // Image upload functionality
    $(document).on('click', '.upload-image-button', function(e) {
        e.preventDefault();
        
        var button = $(this);
        var inputField = button.prev('input.image-upload-field');
        var previewContainer = button.siblings('.central-build-image-preview-container');
        
        // Create the media frame
        var frame = wp.media({
            title: 'Select Image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        });
        
        // When an image is selected in the media frame
        frame.on('select', function() {
            var attachment = frame.state().get('selection').first().toJSON();
            
            // Set the input field value
            inputField.val(attachment.url);
            
            // Update or create preview
            var existingPreview = button.siblings('.central-build-image-preview');
            if (existingPreview.length) {
                existingPreview.attr('src', attachment.url);
            } else {
                button.after('<br><img src="' + attachment.url + '" class="central-build-image-preview" alt="Preview" />');
            }
        });
        
        // Open the media frame
        frame.open();
    });
    
    // Remove image functionality
    $('.central-build-remove-image').on('click', function(e) {
        e.preventDefault();
        
        var button = $(this);
        var inputField = button.siblings('input');
        var previewContainer = button.siblings('.central-build-image-preview-container');
        
        // Clear the input field
        inputField.val('');
        
        // Clear the preview
        if (previewContainer.length) {
            previewContainer.empty();
        }
    });
    
    // Tab switching functionality
    $('.nav-tab').on('click', function(e) {
        e.preventDefault();
        
        var tab = $(this);
        var tabUrl = tab.attr('href');
        
        // Update URL without page reload
        if (history.pushState) {
            history.pushState(null, null, tabUrl);
        }
        
        // Update active tab
        $('.nav-tab').removeClass('nav-tab-active');
        tab.addClass('nav-tab-active');
        
        // Show/hide tab content would be handled by PHP
        // For now, just redirect to the tab
        window.location.href = tabUrl;
    });
    
    // Form validation
    $(document).on('submit', 'form', function(e) {
        var form = $(this);
        var hasErrors = false;
        
        // Check required fields
        form.find('input[required], textarea[required], select[required]').each(function() {
            var field = $(this);
            if (!field.val().trim()) {
                field.addClass('error');
                hasErrors = true;
            } else {
                field.removeClass('error');
            }
        });
        
        // Check URL fields
        form.find('input[type="url"]').each(function() {
            var field = $(this);
            var url = field.val().trim();
            
            if (url && !isValidUrl(url)) {
                field.addClass('error');
                hasErrors = true;
            } else {
                field.removeClass('error');
            }
        });
        
        if (hasErrors) {
            e.preventDefault();
            alert('Please check the highlighted fields and correct any errors.');
        }
    });
    
    // URL validation helper
    function isValidUrl(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    }
    
    // Auto-save functionality (optional)
    var autoSaveTimer;
    $(document).on('change', 'input, textarea, select', function() {
        clearTimeout(autoSaveTimer);
        autoSaveTimer = setTimeout(function() {
            // Auto-save logic could be implemented here
            console.log('Auto-save triggered');
        }, 2000);
    });
    
    // Collapsible sections
    $('.central-build-field-group h4').on('click', function() {
        var header = $(this);
        var content = header.siblings();
        
        content.slideToggle();
        header.toggleClass('collapsed');
    });
    
    // Color picker initialization (if needed)
    if ($.fn.wpColorPicker) {
        $('.color-picker').wpColorPicker();
    }
    
    // Sortable functionality for repeatable fields
    if ($.fn.sortable) {
        $('.repeatable-fields').sortable({
            handle: '.field-header',
            placeholder: 'sort-placeholder',
            update: function(event, ui) {
                var container = $(this);
                // Update field numbers and indices after sorting
                updateFieldNumbers(container);
                updateFieldIndices(container);
            }
        });
    }
    
    // Add/Remove repeatable fields
    $(document).on('click', '.add-field', function(e) {
        e.preventDefault();
        
        var button = $(this);
        var targetContainer = button.data('target');
        var templateId = button.data('template');
        var container = $('#' + targetContainer);
        var template = $('#' + templateId).html();
        var index = container.children('.repeatable-item').length;
        
        // Replace placeholders with actual index
        template = template.replace(/\{INDEX\}/g, index);
        
        // Add the new field
        container.append(template);
        
        // Update field numbers
        updateFieldNumbers(container);
    });
    
    $(document).on('click', '.remove-field', function(e) {
        e.preventDefault();
        
        var button = $(this);
        var fieldGroup = button.closest('.repeatable-item');
        var container = fieldGroup.parent();
        
        if (confirm('Are you sure you want to remove this field?')) {
            fieldGroup.remove();
            // Update field numbers and indices
            updateFieldNumbers(container);
            updateFieldIndices(container);
        }
    });
    
    // Function to update field numbers in headers
    function updateFieldNumbers(container) {
        container.children('.repeatable-item').each(function(index) {
            var fieldGroup = $(this);
            var header = fieldGroup.find('.field-header h4');
            var currentText = header.text();
            var baseText = currentText.replace(/\d+/, '').trim();
            header.text(baseText + ' ' + (index + 1));
        });
    }
    
    // Function to update field indices in form names
    function updateFieldIndices(container) {
        container.children('.repeatable-item').each(function(index) {
            var fieldGroup = $(this);
            fieldGroup.attr('data-index', index);
            
            // Update all input and textarea names
            fieldGroup.find('input, textarea, select').each(function() {
                var field = $(this);
                var name = field.attr('name');
                if (name) {
                    // Replace the index in square brackets
                    var newName = name.replace(/\[\d+\]/, '[' + index + ']');
                    field.attr('name', newName);
                }
            });
        });
    }
    
    // Preview functionality
    $('.preview-button').on('click', function(e) {
        e.preventDefault();
        
        var button = $(this);
        var previewUrl = button.data('preview-url');
        
        if (previewUrl) {
            window.open(previewUrl, '_blank');
        }
    });
    
    // Reset to defaults
    $('.reset-defaults').on('click', function(e) {
        e.preventDefault();
        
        if (confirm('Are you sure you want to reset all settings to their default values? This action cannot be undone.')) {
            var form = $(this).closest('form');
            
            // Reset form fields to their default values
            form.find('input, textarea, select').each(function() {
                var field = $(this);
                var defaultValue = field.data('default');
                
                if (defaultValue !== undefined) {
                    field.val(defaultValue);
                }
            });
            
            // Clear image previews
            form.find('.central-build-image-preview-container').empty();
            
            alert('Settings have been reset to default values. Don\'t forget to save your changes.');
        }
    });
    
    // Import/Export functionality
    $(document).on('click', '.export-settings', function(e) {
        e.preventDefault();
        
        // Collect all form data
        var formData = {};
        $('input, textarea, select').each(function() {
            var field = $(this);
            var name = field.attr('name');
            
            if (name) {
                formData[name] = field.val();
            }
        });
        
        // Create downloadable JSON file
        var dataStr = JSON.stringify(formData, null, 2);
        var dataBlob = new Blob([dataStr], {type: 'application/json'});
        var url = URL.createObjectURL(dataBlob);
        
        var link = document.createElement('a');
        link.href = url;
        link.download = 'central-build-settings.json';
        link.click();
        
        URL.revokeObjectURL(url);
    });
    
    $(document).on('change', '.import-settings', function(e) {
        var file = e.target.files[0];
        
        if (file) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                try {
                    var settings = JSON.parse(e.target.result);
                    
                    // Apply imported settings
                    Object.keys(settings).forEach(function(key) {
                        var field = $('[name="' + key + '"]');
                        if (field.length) {
                            field.val(settings[key]);
                        }
                    });
                    
                    alert('Settings imported successfully! Don\'t forget to save your changes.');
                } catch (error) {
                    alert('Error importing settings: Invalid file format.');
                }
            };
            
            reader.readAsText(file);
        }
    });
    
    // Help tooltips
    $('.help-tooltip').on('mouseenter', function() {
        var tooltip = $(this);
        var helpText = tooltip.data('help');
        
        if (helpText) {
            $('<div class="tooltip-popup">' + helpText + '</div>')
                .appendTo('body')
                .css({
                    position: 'absolute',
                    top: tooltip.offset().top - 30,
                    left: tooltip.offset().left,
                    background: '#333',
                    color: '#fff',
                    padding: '5px 10px',
                    borderRadius: '3px',
                    fontSize: '12px',
                    zIndex: 9999
                });
        }
    }).on('mouseleave', function() {
        $('.tooltip-popup').remove();
    });
    
    // Live preview updates (if preview iframe exists)
    if ($('#theme-preview').length) {
        $(document).on('change', 'input, textarea, select', function() {
            var field = $(this);
            var name = field.attr('name');
            var value = field.val();
            
            // Send update to preview iframe
            var previewFrame = document.getElementById('theme-preview');
            if (previewFrame && previewFrame.contentWindow) {
                previewFrame.contentWindow.postMessage({
                    action: 'update_setting',
                    setting: name,
                    value: value
                }, '*');
            }
        });
    }
    
    // Bulk actions
    $('.bulk-action-select').on('change', function() {
        var select = $(this);
        var action = select.val();
        var checkboxes = $('.bulk-checkbox:checked');
        
        if (action && checkboxes.length > 0) {
            if (confirm('Apply "' + action + '" to ' + checkboxes.length + ' selected items?')) {
                // Perform bulk action
                checkboxes.each(function() {
                    var checkbox = $(this);
                    var fieldGroup = checkbox.closest('.field-group');
                    
                    switch (action) {
                        case 'show':
                            fieldGroup.find('.visibility-toggle').prop('checked', true);
                            break;
                        case 'hide':
                            fieldGroup.find('.visibility-toggle').prop('checked', false);
                            break;
                        case 'delete':
                            fieldGroup.remove();
                            break;
                    }
                });
            }
        }
        
        select.val('');
    });
    
    // Select all/none functionality
    $('.select-all').on('click', function(e) {
        e.preventDefault();
        $('.bulk-checkbox').prop('checked', true);
    });
    
    $('.select-none').on('click', function(e) {
        e.preventDefault();
        $('.bulk-checkbox').prop('checked', false);
    });
    
});
