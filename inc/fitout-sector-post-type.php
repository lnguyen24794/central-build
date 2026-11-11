<?php
/**
 * Fitout Sector Custom Post Type
 *
 * @package Central_Build_Pro
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Fitout Sector Custom Post Type
 */
function central_build_register_fitout_sector_post_type()
{
    $labels = array(
        'name'                  => _x('Projects', 'Post Type General Name', 'central-build'),
        'singular_name'         => _x('Project', 'Post Type Singular Name', 'central-build'),
        'menu_name'             => __('Projects', 'central-build'),
        'name_admin_bar'        => __('Project', 'central-build'),
        'archives'              => __('Project Archives', 'central-build'),
        'attributes'            => __('Project Attributes', 'central-build'),
        'parent_item_colon'     => __('Parent Project:', 'central-build'),
        'all_items'             => __('All Projects', 'central-build'),
        'add_new_item'          => __('Add New Project', 'central-build'),
        'add_new'               => __('Add New', 'central-build'),
        'new_item'              => __('New Project', 'central-build'),
        'edit_item'             => __('Edit Project', 'central-build'),
        'update_item'           => __('Update Project', 'central-build'),
        'view_item'             => __('View Project', 'central-build'),
        'view_items'            => __('View Projects', 'central-build'),
        'search_items'          => __('Search Project', 'central-build'),
        'not_found'             => __('Not found', 'central-build'),
        'not_found_in_trash'    => __('Not found in Trash', 'central-build'),
        'featured_image'        => __('Featured Image', 'central-build'),
        'set_featured_image'    => __('Set featured image', 'central-build'),
        'remove_featured_image' => __('Remove featured image', 'central-build'),
        'use_featured_image'    => __('Use as featured image', 'central-build'),
        'insert_into_item'      => __('Insert into project', 'central-build'),
        'uploaded_to_this_item' => __('Uploaded to this project', 'central-build'),
        'items_list'            => __('Fitout sectors list', 'central-build'),
        'items_list_navigation' => __('Fitout sectors list navigation', 'central-build'),
        'filter_items_list'     => __('Filter projects list', 'central-build'),
    );

    $args = array(
        'label'                 => __('Project', 'central-build'),
        'description'           => __('Fitout sector projects and case studies', 'central-build'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions'),
        'taxonomies'            => array('fitout_category'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-building',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rewrite'               => array(
            'slug'                  => 'projects',
            'with_front'            => false,
            'pages'                 => true,
            'feeds'                 => true,
        ),
    );

    register_post_type('fitout_sector', $args);
}
add_action('init', 'central_build_register_fitout_sector_post_type', 0);

/**
 * Register Fitout Category Taxonomy
 */
function central_build_register_fitout_category_taxonomy()
{
    $labels = array(
        'name'                       => _x('Project Categories', 'Taxonomy General Name', 'central-build'),
        'singular_name'              => _x('Project Category', 'Taxonomy Singular Name', 'central-build'),
        'menu_name'                  => __('Project Categories', 'central-build'),
        'all_items'                  => __('All Categories', 'central-build'),
        'parent_item'                => __('Parent Category', 'central-build'),
        'parent_item_colon'          => __('Parent Category:', 'central-build'),
        'new_item_name'              => __('New Category Name', 'central-build'),
        'add_new_item'               => __('Add New Category', 'central-build'),
        'edit_item'                  => __('Edit Category', 'central-build'),
        'update_item'                => __('Update Category', 'central-build'),
        'view_item'                  => __('View Category', 'central-build'),
        'separate_items_with_commas' => __('Separate categories with commas', 'central-build'),
        'add_or_remove_items'        => __('Add or remove categories', 'central-build'),
        'choose_from_most_used'      => __('Choose from the most used', 'central-build'),
        'popular_items'              => __('Popular Categories', 'central-build'),
        'search_items'               => __('Search Categories', 'central-build'),
        'not_found'                  => __('Not Found', 'central-build'),
        'no_terms'                   => __('No categories', 'central-build'),
        'items_list'                 => __('Categories list', 'central-build'),
        'items_list_navigation'      => __('Categories list navigation', 'central-build'),
    );

    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
        'rewrite'                    => array(
            'slug'                       => 'fitout-sectors',
            'with_front'                 => false,
            'hierarchical'               => true,
        ),
    );

    register_taxonomy('fitout_category', array('fitout_sector'), $args);
}
add_action('init', 'central_build_register_fitout_category_taxonomy', 0);

/**
 * Add custom meta boxes for fitout sector
 */
function central_build_add_fitout_sector_meta_boxes()
{
    add_meta_box(
        'fitout_sector_details',
        __('Project Details', 'central-build'),
        'central_build_fitout_sector_details_callback',
        'fitout_sector',
        'normal',
        'high'
    );

    add_meta_box(
        'fitout_sector_gallery',
        __('Project Gallery', 'central-build'),
        'central_build_fitout_sector_gallery_callback',
        'fitout_sector',
        'normal',
        'high'
    );

    add_meta_box(
        'fitout_sector_quote',
        __('Project Quote', 'central-build'),
        'central_build_fitout_sector_quote_callback',
        'fitout_sector',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'central_build_add_fitout_sector_meta_boxes');

/**
 * Project Details Meta Box Callback
 */
function central_build_fitout_sector_details_callback($post)
{
    // Add nonce for security
    wp_nonce_field('central_build_fitout_sector_meta', 'central_build_fitout_sector_nonce');

    // Get current values
    $client = get_post_meta($post->ID, '_fitout_client', true);
    $location = get_post_meta($post->ID, '_fitout_location', true);
    $sqm = get_post_meta($post->ID, '_fitout_sqm', true);
    $created_date = get_post_meta($post->ID, '_fitout_created_date', true);
    $hero_image = get_post_meta($post->ID, '_fitout_hero_image', true);
    $about_image = get_post_meta($post->ID, '_fitout_about_image', true);
    $key_elements = get_post_meta($post->ID, '_fitout_key_elements', true);
    $about_project = get_post_meta($post->ID, '_fitout_about_project', true);
    $cta_text = get_post_meta($post->ID, '_fitout_cta_text', true);
    $final_result = get_post_meta($post->ID, '_fitout_final_result', true);

    ?>
    <table class="form-table">
        <tr>
            <th><label for="fitout_client"><?php _e('Client', 'central-build'); ?></label></th>
            <td><input type="text" id="fitout_client" name="fitout_client" value="<?php echo esc_attr($client); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="fitout_location"><?php _e('Location', 'central-build'); ?></label></th>
            <td><input type="text" id="fitout_location" name="fitout_location" value="<?php echo esc_attr($location); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="fitout_sqm"><?php _e('Size (m²)', 'central-build'); ?></label></th>
            <td><input type="text" id="fitout_sqm" name="fitout_sqm" value="<?php echo esc_attr($sqm); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="fitout_created_date"><?php _e('Completion date', 'central-build'); ?></label></th>
            <td><input type="date" id="fitout_created_date" name="fitout_created_date" value="<?php echo esc_attr($created_date); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="fitout_hero_image"><?php _e('Main photo', 'central-build'); ?></label></th>
            <td>
                <?php central_build_project_image_picker('fitout_hero_image', $hero_image); ?>
                <p class="description"><?php _e('Shown behind the project name at the top of the page and next to the project details. If empty, the Featured image is used.', 'central-build'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="fitout_about_image"><?php _e('"About the project" photo', 'central-build'); ?></label></th>
            <td>
                <?php central_build_project_image_picker('fitout_about_image', $about_image); ?>
                <p class="description"><?php _e('Shown next to the "About the project" text.', 'central-build'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="fitout_about_project"><?php _e('About the Project', 'central-build'); ?></label></th>
            <td>
                <textarea id="fitout_about_project" name="fitout_about_project" rows="8" cols="50" class="large-text"><?php echo esc_textarea($about_project); ?></textarea>
                <p class="description"><?php _e('Shown under the heading "About the project". Press Enter for a new line.', 'central-build'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="fitout_key_elements"><?php _e('Key Elements', 'central-build'); ?></label></th>
            <td>
                <textarea id="fitout_key_elements" name="fitout_key_elements" rows="8" cols="50" class="large-text"><?php echo esc_textarea($key_elements); ?></textarea>
                <p class="description"><?php _e('One item per line. Each line becomes a bullet point under "Key Elements".', 'central-build'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="fitout_cta_text"><?php _e('Call-to-action line', 'central-build'); ?></label></th>
            <td>
                <textarea id="fitout_cta_text" name="fitout_cta_text" rows="3" cols="50" class="large-text"><?php echo esc_textarea($cta_text); ?></textarea>
                <p class="description"><?php _e('The short invitation near the bottom of the page, e.g. "Planning a fitout project? Let\'s talk."', 'central-build'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="fitout_final_result"><?php _e('Final result', 'central-build'); ?></label></th>
            <td>
                <textarea id="fitout_final_result" name="fitout_final_result" rows="5" cols="50" class="large-text"><?php echo esc_textarea($final_result); ?></textarea>
                <p class="description"><?php _e('A sentence or two about the finished result, shown near the photo gallery.', 'central-build'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Project Gallery Meta Box Callback
 */
function central_build_fitout_sector_gallery_callback($post)
{
    $gallery_images = get_post_meta($post->ID, '_fitout_gallery_images', true);
    if (!is_array($gallery_images)) {
        $gallery_images = array();
    }

    ?>
    <p class="description" style="margin-top:0"><?php _e('These photos are shown in the gallery at the bottom of the project page, in this order. Drag a photo to move it.', 'central-build'); ?></p>
    <ul id="cb-project-gallery" class="cb-project-gallery">
        <?php foreach ($gallery_images as $image_url) : if (!$image_url) { continue; } ?>
            <li>
                <img src="<?php echo esc_url($image_url); ?>" alt="" />
                <input type="hidden" name="fitout_gallery_images[]" value="<?php echo esc_url($image_url); ?>" />
                <button type="button" class="cb-project-gallery__remove" title="<?php esc_attr_e('Remove this photo', 'central-build'); ?>">&times;</button>
            </li>
        <?php endforeach; ?>
    </ul>
    <input type="hidden" name="fitout_gallery_images_present" value="1" />
    <p><button type="button" class="button button-primary" id="cb-project-gallery-add"><?php _e('+ Add photos', 'central-build'); ?></button></p>
    <?php
}

/**
 * Project Quote Meta Box Callback
 */
function central_build_fitout_sector_quote_callback($post)
{
    $quote_text = get_post_meta($post->ID, '_fitout_quote_text', true);
    $quote_author = get_post_meta($post->ID, '_fitout_quote_author', true);
    $quote_position = get_post_meta($post->ID, '_fitout_quote_position', true);

    ?>
    <table class="form-table">
        <tr>
            <th><label for="fitout_quote_text"><?php _e('Quote Text', 'central-build'); ?></label></th>
            <td>
                <textarea id="fitout_quote_text" name="fitout_quote_text" rows="4" cols="50" class="large-text"><?php echo esc_textarea($quote_text); ?></textarea>
                <p class="description"><?php _e('The quote only appears on the website when "Quote by (name)" is filled in too.', 'central-build'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="fitout_quote_author"><?php _e('Quote by (name)', 'central-build'); ?></label></th>
            <td><input type="text" id="fitout_quote_author" name="fitout_quote_author" value="<?php echo esc_attr($quote_author); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="fitout_quote_position"><?php _e('Their role or company', 'central-build'); ?></label></th>
            <td><input type="text" id="fitout_quote_position" name="fitout_quote_position" value="<?php echo esc_attr($quote_position); ?>" class="regular-text" /></td>
        </tr>
    </table>
    <?php
}

/**
 * Save fitout sector meta data
 */
function central_build_save_fitout_sector_meta($post_id)
{
    // Check if nonce is valid
    if (!isset($_POST['central_build_fitout_sector_nonce']) || !wp_verify_nonce($_POST['central_build_fitout_sector_nonce'], 'central_build_fitout_sector_meta')) {
        return;
    }

    // Check if user has permission to edit post
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Check if not an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Save project details
    $fields = array(
        'fitout_client' => '_fitout_client',
        'fitout_location' => '_fitout_location',
        'fitout_sqm' => '_fitout_sqm',
        'fitout_created_date' => '_fitout_created_date',
        'fitout_hero_image' => '_fitout_hero_image',
        'fitout_about_image' => '_fitout_about_image',
        'fitout_about_project' => '_fitout_about_project',
        'fitout_key_elements' => '_fitout_key_elements',
        'fitout_cta_text' => '_fitout_cta_text',
        'fitout_final_result' => '_fitout_final_result',
        'fitout_quote_text' => '_fitout_quote_text',
        'fitout_quote_author' => '_fitout_quote_author',
        'fitout_quote_position' => '_fitout_quote_position',
    );

    foreach ($fields as $field => $meta_key) {
        if (isset($_POST[$field])) {
            if (in_array($field, array('fitout_hero_image', 'fitout_about_image'))) {
                update_post_meta($post_id, $meta_key, esc_url_raw($_POST[$field]));
            } elseif (in_array($field, array('fitout_about_project', 'fitout_key_elements', 'fitout_cta_text', 'fitout_final_result', 'fitout_quote_text'))) {
                update_post_meta($post_id, $meta_key, wp_kses_post($_POST[$field]));
            } else {
                update_post_meta($post_id, $meta_key, wp_kses_post($_POST[$field]));
            }
        }
    }

    // Save gallery images
    if (isset($_POST['fitout_gallery_images'])) {
        $gallery_images = array_values(array_filter(array_map('esc_url_raw', wp_unslash((array) $_POST['fitout_gallery_images']))));
        update_post_meta($post_id, '_fitout_gallery_images', $gallery_images);
    } elseif (isset($_POST['fitout_gallery_images_present'])) {
        // Every photo was removed.
        update_post_meta($post_id, '_fitout_gallery_images', array());
    }
}

/**
 * Image picker used in the Project Details box (stores the image address, as before).
 */
function central_build_project_image_picker(string $name, $value): void
{
    $value = (string) $value;
    ?>
    <div class="cb-project-image<?php echo $value ? ' has-image' : ''; ?>">
        <div class="cb-project-image__preview"><?php if ($value) : ?><img src="<?php echo esc_url($value); ?>" alt="" /><?php else : ?><span><?php esc_html_e('No photo', 'central-build'); ?></span><?php endif; ?></div>
        <input type="hidden" id="<?php echo esc_attr($name); ?>" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_url($value); ?>" />
        <button type="button" class="button button-primary cb-project-image__choose"><?php echo $value ? esc_html__('Change photo', 'central-build') : esc_html__('Choose photo', 'central-build'); ?></button>
        <button type="button" class="button-link cb-project-image__remove"><?php esc_html_e('Remove', 'central-build'); ?></button>
    </div>
    <?php
}

/**
 * Scripts & styles for the project edit screen: photo pickers and the gallery.
 */
function central_build_project_editor_assets(): void
{
    $screen = get_current_screen();
    if (!$screen || $screen->post_type !== 'fitout_sector' || $screen->base !== 'post') {
        return;
    }
    wp_enqueue_media();
    wp_enqueue_script('jquery-ui-sortable');
    add_action('admin_footer', 'central_build_project_editor_footer');
}
add_action('admin_enqueue_scripts', 'central_build_project_editor_assets');

function central_build_project_editor_footer(): void
{
    ?>
    <style>
        .cb-project-image { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
        .cb-project-image__preview { width: 160px; height: 100px; border: 1px solid #dcdcde; border-radius: 6px; background: #f6f7f7; display: grid; place-items: center; overflow: hidden; }
        .cb-project-image__preview img { width: 100%; height: 100%; object-fit: cover; }
        .cb-project-image__preview span { color: #8c8f94; font-size: 12px; }
        .cb-project-image:not(.has-image) .cb-project-image__remove { display: none; }
        .cb-project-image__remove, .cb-project-gallery__remove { color: #b32d2e !important; }
        .cb-project-gallery { display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 10px; margin: 10px 0; }
        .cb-project-gallery li { position: relative; margin: 0; border: 1px solid #dcdcde; border-radius: 6px; overflow: hidden; height: 100px; cursor: move; background: #f6f7f7; }
        .cb-project-gallery li img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .cb-project-gallery__remove { position: absolute; top: 4px; right: 4px; width: 26px; height: 26px; border-radius: 50%; border: 0; background: rgba(255,255,255,.92); font-size: 18px; line-height: 24px; cursor: pointer; box-shadow: 0 1px 3px rgba(0,0,0,.3); }
        .cb-project-gallery-placeholder { border: 2px dashed #fb7f28 !important; background: #fff7f1 !important; }
        #external_featured_image { display: none; }
    </style>
    <script>
    jQuery(function ($) {
        function pick(multiple, done) {
            var frame = wp.media({ title: multiple ? 'Choose photos' : 'Choose a photo', button: { text: multiple ? 'Add these photos' : 'Use this photo' }, library: { type: 'image' }, multiple: multiple ? 'add' : false });
            frame.on('select', function () {
                done(frame.state().get('selection').toJSON().map(function (a) {
                    return (a.sizes && a.sizes.large) ? (a.width > 2560 ? a.sizes.large.url : a.url) : a.url;
                }));
            });
            frame.open();
        }
        $(document).on('click', '.cb-project-image__choose', function () {
            var $box = $(this).closest('.cb-project-image');
            pick(false, function (urls) {
                $box.find('input').val(urls[0]);
                $box.find('.cb-project-image__preview').html('<img src="' + urls[0] + '" alt="">');
                $box.addClass('has-image').find('.cb-project-image__choose').text('Change photo');
            });
        });
        $(document).on('click', '.cb-project-image__remove', function () {
            var $box = $(this).closest('.cb-project-image');
            $box.find('input').val('');
            $box.find('.cb-project-image__preview').html('<span>No photo</span>');
            $box.removeClass('has-image').find('.cb-project-image__choose').text('Choose photo');
        });
        var $gallery = $('#cb-project-gallery');
        $gallery.sortable({ placeholder: 'cb-project-gallery-placeholder', tolerance: 'pointer' });
        $('#cb-project-gallery-add').on('click', function () {
            pick(true, function (urls) {
                urls.forEach(function (url) {
                    var $li = $('<li><img alt=""><input type="hidden" name="fitout_gallery_images[]"><button type="button" class="cb-project-gallery__remove" title="Remove this photo">&times;</button></li>');
                    $li.find('img').attr('src', url);
                    $li.find('input').val(url);
                    $gallery.append($li);
                });
            });
        });
        $gallery.on('click', '.cb-project-gallery__remove', function () {
            if (window.confirm('Remove this photo from the gallery?')) { $(this).closest('li').remove(); }
        });
    });
    </script>
    <?php
}
add_action('save_post', 'central_build_save_fitout_sector_meta');

/**
 * Add custom columns to fitout sector admin list
 */
function central_build_fitout_sector_columns($columns)
{
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['fitout_client'] = __('Client', 'central-build');
    $new_columns['fitout_location'] = __('Location', 'central-build');
    $new_columns['fitout_category'] = __('Category', 'central-build');
    $new_columns['date'] = $columns['date'];

    return $new_columns;
}
add_filter('manage_fitout_sector_posts_columns', 'central_build_fitout_sector_columns');

/**
 * Display custom column content
 */
function central_build_fitout_sector_column_content($column, $post_id)
{
    switch ($column) {
        case 'fitout_client':
            $client = get_post_meta($post_id, '_fitout_client', true);
            echo $client ? esc_html($client) : '—';
            break;
        case 'fitout_location':
            $location = get_post_meta($post_id, '_fitout_location', true);
            echo $location ? esc_html($location) : '—';
            break;
        case 'fitout_category':
            $terms = get_the_terms($post_id, 'fitout_category');
            if ($terms && !is_wp_error($terms)) {
                $term_names = array();
                foreach ($terms as $term) {
                    $term_names[] = $term->name;
                }
                echo implode(', ', $term_names);
            } else {
                echo '—';
            }
            break;
    }
}
add_action('manage_fitout_sector_posts_custom_column', 'central_build_fitout_sector_column_content', 10, 2);

/**
 * Make custom columns sortable
 */
function central_build_fitout_sector_sortable_columns($columns)
{
    $columns['fitout_client'] = 'fitout_client';
    $columns['fitout_location'] = 'fitout_location';
    return $columns;
}
add_filter('manage_edit-fitout_sector_sortable_columns', 'central_build_fitout_sector_sortable_columns');

/**
 * Handle sorting for custom columns
 */
function central_build_fitout_sector_orderby($query)
{
    if (!is_admin()) {
        return;
    }

    $orderby = $query->get('orderby');

    if ('fitout_client' == $orderby) {
        $query->set('meta_key', '_fitout_client');
        $query->set('orderby', 'meta_value');
    } elseif ('fitout_location' == $orderby) {
        $query->set('meta_key', '_fitout_location');
        $query->set('orderby', 'meta_value');
    }
}
add_action('pre_get_posts', 'central_build_fitout_sector_orderby');

/**
 * Add custom fields to fitout category taxonomy
 */
function central_build_add_fitout_category_fields()
{
    ?>
    <div class="form-field">
        <label for="category_hero_image"><?php _e('Main photo', 'central-build'); ?></label>
        <input type="text" name="category_hero_image" id="category_hero_image" value="" />
        <p class="description"><?php _e('Enter the URL for the hero section background image', 'central-build'); ?></p>
    </div>
    
    <div class="form-field">
        <label for="category_icon"><?php _e('Category Icon URL', 'central-build'); ?></label>
        <input type="text" name="category_icon" id="category_icon" value="" />
        <p class="description"><?php _e('Enter the URL for the category icon', 'central-build'); ?></p>
    </div>
    
    <div class="form-field">
        <label for="category_description_custom"><?php _e('Custom Description', 'central-build'); ?></label>
        <textarea name="category_description_custom" id="category_description_custom" rows="5" cols="50"></textarea>
        <p class="description"><?php _e('Custom description for the category archive page (optional)', 'central-build'); ?></p>
    </div>
    <?php
}
add_action('fitout_category_add_form_fields', 'central_build_add_fitout_category_fields');

/**
 * Edit custom fields for fitout category taxonomy
 */
function central_build_edit_fitout_category_fields($term)
{
    $hero_image = get_term_meta($term->term_id, 'category_hero_image', true);
    $icon = get_term_meta($term->term_id, 'category_icon', true);
    $custom_description = get_term_meta($term->term_id, 'category_description_custom', true);
    ?>
    <tr class="form-field">
        <th scope="row"><label for="category_hero_image"><?php _e('Main photo', 'central-build'); ?></label></th>
        <td>
            <input type="text" name="category_hero_image" id="category_hero_image" value="<?php echo esc_url($hero_image); ?>" class="regular-text" />
            <p class="description"><?php _e('Enter the URL for the hero section background image', 'central-build'); ?></p>
        </td>
    </tr>
    
    <tr class="form-field">
        <th scope="row"><label for="category_icon"><?php _e('Category Icon URL', 'central-build'); ?></label></th>
        <td>
            <input type="text" name="category_icon" id="category_icon" value="<?php echo esc_url($icon); ?>" class="regular-text" />
            <p class="description"><?php _e('Enter the URL for the category icon', 'central-build'); ?></p>
        </td>
    </tr>
    
    <tr class="form-field">
        <th scope="row"><label for="category_description_custom"><?php _e('Custom Description', 'central-build'); ?></label></th>
        <td>
            <textarea name="category_description_custom" id="category_description_custom" rows="5" cols="50" class="large-text"><?php echo esc_textarea($custom_description); ?></textarea>
            <p class="description"><?php _e('Custom description for the category archive page (optional)', 'central-build'); ?></p>
        </td>
    </tr>
    <?php
}
add_action('fitout_category_edit_form_fields', 'central_build_edit_fitout_category_fields');

/**
 * Save custom fields for fitout category taxonomy
 */
function central_build_save_fitout_category_fields($term_id)
{
    if (isset($_POST['category_hero_image'])) {
        update_term_meta($term_id, 'category_hero_image', esc_url_raw($_POST['category_hero_image']));
    }

    if (isset($_POST['category_icon'])) {
        update_term_meta($term_id, 'category_icon', esc_url_raw($_POST['category_icon']));
    }

    if (isset($_POST['category_description_custom'])) {
        update_term_meta($term_id, 'category_description_custom', wp_kses_post($_POST['category_description_custom']));
    }
}
add_action('created_fitout_category', 'central_build_save_fitout_category_fields');
add_action('edited_fitout_category', 'central_build_save_fitout_category_fields');

/**
 * Add custom columns to fitout category admin list
 */
function central_build_fitout_category_columns($columns)
{
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['name'] = $columns['name'];
    $new_columns['hero_image'] = __('Hero Image', 'central-build');
    $new_columns['icon'] = __('Icon', 'central-build');
    $new_columns['description'] = $columns['description'];
    $new_columns['slug'] = $columns['slug'];
    $new_columns['posts'] = $columns['posts'];

    return $new_columns;
}
add_filter('manage_edit-fitout_category_columns', 'central_build_fitout_category_columns');

/**
 * Display custom column content for fitout category
 */
function central_build_fitout_category_column_content($content, $column_name, $term_id)
{
    switch ($column_name) {
        case 'hero_image':
            $hero_image = get_term_meta($term_id, 'category_hero_image', true);
            if ($hero_image) {
                echo '<img src="' . esc_url($hero_image) . '" style="width: 50px; height: 30px; object-fit: cover;" />';
            } else {
                echo '—';
            }
            break;
        case 'icon':
            $icon = get_term_meta($term_id, 'category_icon', true);
            if ($icon) {
                echo '<img src="' . esc_url($icon) . '" style="width: 30px; height: 30px;" />';
            } else {
                echo '—';
            }
            break;
    }
    return $content;
}
add_filter('manage_fitout_category_custom_column', 'central_build_fitout_category_column_content', 10, 3);

/**
 * Flush rewrite rules on activation
 */
function central_build_fitout_sector_flush_rewrites()
{
    central_build_register_fitout_sector_post_type();
    central_build_register_fitout_category_taxonomy();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'central_build_fitout_sector_flush_rewrites');
