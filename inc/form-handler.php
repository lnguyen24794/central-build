<?php
if (!defined('ABSPATH')) {
    exit;
}

function central_build_register_form_submission_cpt(): void
{
    $labels = array(
        'name'               => __('Form Submissions', 'central-build'),
        'singular_name'      => __('Form Submission', 'central-build'),
        'menu_name'          => __('Form Submissions', 'central-build'),
        'name_admin_bar'     => __('Form Submission', 'central-build'),
        'add_new'            => __('Add New', 'central-build'),
        'add_new_item'       => __('Add New Submission', 'central-build'),
        'edit_item'          => __('Edit Submission', 'central-build'),
        'new_item'           => __('New Submission', 'central-build'),
        'view_item'          => __('View Submission', 'central-build'),
        'search_items'       => __('Search Submissions', 'central-build'),
        'not_found'          => __('No submissions found.', 'central-build'),
        'not_found_in_trash' => __('No submissions found in Trash.', 'central-build'),
        'all_items'          => __('All Submissions', 'central-build'),
    );

    $args = array(
        'labels'              => $labels,
        'public'              => false,
        'publicly_queryable'  => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_icon'           => 'dashicons-email-alt2',
        'query_var'           => false,
        'rewrite'             => false,
        'capability_type'     => 'post',
        'capabilities'        => array('create_posts' => false),
        'map_meta_cap'        => true,
        'has_archive'         => false,
        'hierarchical'        => false,
        'menu_position'       => 59,
        'supports'            => array('title', 'editor', 'custom-fields'),
    );

    register_post_type('cb_form_submission', $args);
}
add_action('init', 'central_build_register_form_submission_cpt');

function central_build_get_form_definitions(): array
{
    return array(
        'front_page' => array(
            'label'  => __('Front Page – Project Kick-off', 'central-build'),
            'fields' => array(
                'full_name'    => array('label' => __('Full Name', 'central-build'), 'sanitize' => 'sanitize_text_field', 'required' => true),
                'email'        => array('label' => __('Work Email', 'central-build'), 'sanitize' => 'sanitize_email', 'required' => true),
                'project_type' => array('label' => __('Project Type', 'central-build'), 'sanitize' => 'sanitize_text_field', 'required' => true),
                'project_size' => array('label' => __('Estimated Size', 'central-build'), 'sanitize' => 'sanitize_text_field', 'required' => false),
                'message'      => array('label' => __('Message', 'central-build'), 'sanitize' => 'central_build_sanitize_textarea', 'required' => false),
            ),
        ),
        'contact_page' => array(
            'label'  => __('Contact Page – Inquiry', 'central-build'),
            'fields' => array(
                'full_name'    => array('label' => __('Full Name', 'central-build'), 'sanitize' => 'sanitize_text_field', 'required' => true),
                'company'      => array('label' => __('Company', 'central-build'), 'sanitize' => 'sanitize_text_field', 'required' => true),
                'email'        => array('label' => __('Work Email', 'central-build'), 'sanitize' => 'sanitize_email', 'required' => true),
                'phone'        => array('label' => __('Phone Number', 'central-build'), 'sanitize' => 'sanitize_text_field', 'required' => false),
                'project_type' => array('label' => __('Project Type', 'central-build'), 'sanitize' => 'sanitize_text_field', 'required' => true),
                'project_size' => array('label' => __('Project Size', 'central-build'), 'sanitize' => 'sanitize_text_field', 'required' => false),
                'message'      => array('label' => __('Project Description', 'central-build'), 'sanitize' => 'central_build_sanitize_textarea', 'required' => true),
            ),
        ),
        'commercial_fitout_specialists' => array(
            'label'  => __('Commercial Fitout Specialists – CTA Form', 'central-build'),
            'fields' => array(
                'full_name' => array('label' => __('Full Name', 'central-build'), 'sanitize' => 'sanitize_text_field', 'required' => true),
                'email'     => array('label' => __('Work Email', 'central-build'), 'sanitize' => 'sanitize_email', 'required' => true),
                'phone'     => array('label' => __('Phone Number', 'central-build'), 'sanitize' => 'sanitize_text_field', 'required' => false),
            ),
        ),
        'commercial_interior_design' => array(
            'label'  => __('Commercial Interior Design – Consultation', 'central-build'),
            'fields' => array(
                'full_name' => array('label' => __('Full Name', 'central-build'), 'sanitize' => 'sanitize_text_field', 'required' => true),
                'email'     => array('label' => __('Business Email', 'central-build'), 'sanitize' => 'sanitize_email', 'required' => true),
                'phone'     => array('label' => __('Phone Number', 'central-build'), 'sanitize' => 'sanitize_text_field', 'required' => false),
                'message'   => array('label' => __('Project Details', 'central-build'), 'sanitize' => 'central_build_sanitize_textarea', 'required' => false),
            ),
        ),
        'commercial_stripout' => array(
            'label'  => __('Commercial Stripout – Quote', 'central-build'),
            'fields' => array(
                'full_name'    => array('label' => __('Full Name', 'central-build'), 'sanitize' => 'sanitize_text_field', 'required' => true),
                'email'        => array('label' => __('Work Email', 'central-build'), 'sanitize' => 'sanitize_email', 'required' => true),
                'project_size' => array('label' => __('Project Size', 'central-build'), 'sanitize' => 'sanitize_text_field', 'required' => false),
                'message'      => array('label' => __('Additional Details', 'central-build'), 'sanitize' => 'central_build_sanitize_textarea', 'required' => false),
            ),
        ),
        'repairs_maintenance' => array(
            'label'  => __('Repairs & Maintenance – Quote', 'central-build'),
            'fields' => array(
                'full_name'    => array('label' => __('Full Name', 'central-build'), 'sanitize' => 'sanitize_text_field', 'required' => true),
                'email'        => array('label' => __('Work Email', 'central-build'), 'sanitize' => 'sanitize_email', 'required' => true),
                'service_type' => array('label' => __('Service Type', 'central-build'), 'sanitize' => 'sanitize_text_field', 'required' => true),
                'details'      => array('label' => __('Additional Details', 'central-build'), 'sanitize' => 'central_build_sanitize_textarea', 'required' => false),
            ),
        ),
        'services_coordination' => array(
            'label'  => __('Services Coordination – Consultation', 'central-build'),
            'fields' => array(
                'full_name' => array('label' => __('Full Name', 'central-build'), 'sanitize' => 'sanitize_text_field', 'required' => true),
                'email'     => array('label' => __('Work Email', 'central-build'), 'sanitize' => 'sanitize_email', 'required' => true),
                'message'   => array('label' => __('Coordination Challenge', 'central-build'), 'sanitize' => 'central_build_sanitize_textarea', 'required' => false),
            ),
        ),
    );
}

function central_build_sanitize_textarea($value): string
{
    $value = is_string($value) ? wp_unslash($value) : '';
    return $value === '' ? '' : wp_kses_post($value);
}

function central_build_collect_form_data(string $form_id): array
{
    $definitions = central_build_get_form_definitions();
    if (!isset($definitions[$form_id])) {
        return array('data' => array(), 'errors' => array(__('Invalid form selection.', 'central-build')));
    }

    $fields = $definitions[$form_id]['fields'];
    $data   = array();
    $errors = array();

    foreach ($fields as $key => $config) {
        $raw = $_POST[$key] ?? '';
        if (is_array($raw)) {
            $raw = implode(', ', array_map('sanitize_text_field', wp_unslash($raw)));
        }
        $callback = $config['sanitize'] ?? 'sanitize_text_field';
        $value    = $callback === 'central_build_sanitize_textarea'
            ? central_build_sanitize_textarea($raw)
            : ($callback === 'sanitize_email'
                ? sanitize_email(wp_unslash($raw))
                : sanitize_text_field(wp_unslash($raw)));

        if (!empty($config['required']) && $value === '') {
            $errors[] = sprintf(__('The field “%s” is required.', 'central-build'), $config['label']);
        }

        $data[$key] = $value;
    }

    return array('data' => $data, 'errors' => $errors);
}

function central_build_create_submission_post(string $form_id, array $data): int
{
    $definitions = central_build_get_form_definitions();
    $label       = $definitions[$form_id]['label'] ?? ucfirst($form_id);
    $content     = '';    
    foreach ($data as $key => $value) {
        if ($value === '') {
            continue;
        }
        $field_label = $definitions[$form_id]['fields'][$key]['label'] ?? $key;
        $content    .= sprintf("%s: %s\n", $field_label, $value);
    }

    $post_id = wp_insert_post(array(
        'post_type'    => 'cb_form_submission',
        'post_status'  => 'private',
        'post_title'   => sprintf('%s – %s', $label, current_time('Y-m-d H:i:s')), 
        'post_content' => $content,
        'meta_input'   => array(
            '_cb_form_id'   => $form_id,
            '_cb_form_data' => wp_json_encode($data),
            '_cb_form_url'  => esc_url_raw(wp_get_referer()),
        ),
    ));

    return (int) $post_id;
}

function central_build_prepare_email_body(string $intro, array $data, array $fields_def, string $closing = ''): string
{
    $lines = array($intro, '');
    foreach ($data as $key => $value) {
        if ($value === '') {
            continue;
        }
        $label = $fields_def[$key]['label'] ?? $key;
        $lines[] = sprintf('%s: %s', $label, $value);
    }
    if ($closing !== '') {
        $lines[] = '';
        $lines[] = $closing;
    }
    $lines[] = '';
    $lines[] = sprintf(__('Sent from %s', 'central-build'), home_url());
    return implode("\n", $lines);
}

function central_build_send_form_emails(string $form_id, array $data): void
{
    $definitions = central_build_get_form_definitions();
    if (!isset($definitions[$form_id])) {
        return;
    }

    $fields_def = $definitions[$form_id]['fields'];
    $notifications = function_exists('central_build_get_form_notifications')
        ? central_build_get_form_notifications()
        : array();

    $site_name = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

    // Thank-you email to sender
    $user_email = $data['email'] ?? '';
    if ($user_email && is_email($user_email)) {
        $subject = sprintf(__('Thanks for contacting %s', 'central-build'), $site_name);
        $body    = central_build_prepare_email_body(
            __('We have received your message and will be in touch shortly. Here is a copy of what you sent:', 'central-build'),
            $data,
            $fields_def,
            __('If you need to reach us urgently, please call our team.', 'central-build')
        );
        wp_mail($user_email, $subject, $body);
    }

    // Notify admin recipients
    $recipients = $notifications[$form_id]['recipients'] ?? array();
    $reply_to   = $notifications[$form_id]['reply_to'] ?? '';

    if (!empty($recipients)) {
        $subject = sprintf(__('New Form Submission: %s', 'central-build'), $definitions[$form_id]['label']);
        $body    = central_build_prepare_email_body(
            __('You have received a new submission with the following details:', 'central-build'),
            $data,
            $fields_def,
            __('Please follow up promptly.', 'central-build')
        );

        $headers = array('Content-Type: text/plain; charset=UTF-8');
        if ($reply_to && is_email($reply_to)) {
            $headers[] = 'Reply-To: ' . $reply_to;
        } elseif ($user_email && is_email($user_email)) {
            $headers[] = 'Reply-To: ' . $user_email;
        }

        wp_mail($recipients, $subject, $body, $headers);
    }
}

function central_build_handle_form_submission(): void
{
    if (!isset($_POST['form_id'], $_POST['central_build_form_nonce'])) {
        wp_safe_redirect(add_query_arg(array('cb_form_status' => 'error', 'cb_form' => 'unknown'), wp_get_referer() ?: home_url('/')));
        exit;
    }

    if (!wp_verify_nonce($_POST['central_build_form_nonce'], 'central_build_form_submit')) {
        wp_safe_redirect(add_query_arg(array('cb_form_status' => 'error', 'cb_form' => 'invalid_nonce'), wp_get_referer() ?: home_url('/')));
        exit;
    }

    $form_id = sanitize_key($_POST['form_id']);
    $definitions = central_build_get_form_definitions();

    if (!isset($definitions[$form_id])) {
        wp_safe_redirect(add_query_arg(array('cb_form_status' => 'error', 'cb_form' => $form_id), wp_get_referer() ?: home_url('/')));
        exit;
    }

    $result = central_build_collect_form_data($form_id);
    $data   = $result['data'];
    $errors = $result['errors'];

    if (!empty($errors)) {
        wp_safe_redirect(add_query_arg(array(
            'cb_form_status' => 'error',
            'cb_form'        => $form_id,
            'cb_errors'      => rawurlencode(implode('|', $errors)),
        ), wp_get_referer() ?: home_url('/')));
        exit;
    }

    central_build_create_submission_post($form_id, $data);
    central_build_send_form_emails($form_id, $data);

    wp_safe_redirect(add_query_arg(array(
        'cb_form_status' => 'success',
        'cb_form'        => $form_id,
    ), wp_get_referer() ?: home_url('/')));
    exit;
}
add_action('admin_post_nopriv_central_build_form_submit', 'central_build_handle_form_submission');
add_action('admin_post_central_build_form_submit', 'central_build_handle_form_submission');

function central_build_form_submission_admin_columns(array $columns): array
{
    $columns['cb_form_type'] = __('Form', 'central-build');
    $columns['cb_form_email'] = __('Email', 'central-build');
    return $columns;
}
add_filter('manage_cb_form_submission_posts_columns', 'central_build_form_submission_admin_columns');

function central_build_form_submission_admin_column_content(string $column, int $post_id): void
{
    if ($column === 'cb_form_type') {
        $form_id = get_post_meta($post_id, '_cb_form_id', true);
        $definitions = central_build_get_form_definitions();
        echo esc_html($definitions[$form_id]['label'] ?? $form_id);
    }

    if ($column === 'cb_form_email') {
        $data = get_post_meta($post_id, '_cb_form_data', true);
        $data = is_string($data) ? json_decode($data, true) : array();
        $email = is_array($data) && isset($data['email']) ? $data['email'] : '';
        echo esc_html($email);
    }
}
add_action('manage_cb_form_submission_posts_custom_column', 'central_build_form_submission_admin_column_content', 10, 2);

function central_build_form_feedback_notice(string $form_id): string
{
    $status = isset($_GET['cb_form_status']) ? sanitize_key($_GET['cb_form_status']) : '';
    $submitted_form = isset($_GET['cb_form']) ? sanitize_key($_GET['cb_form']) : '';

    if ($status === '' || $submitted_form !== $form_id) {
        return '';
    }

    if ($status === 'success') {
        return '<div class="alert alert-success" role="alert">' . esc_html__('Thank you! We have received your message and will respond shortly.', 'central-build') . '</div>';
    }

    if ($status === 'error') {
        $error_text = __('Something went wrong. Please check your details and try again.', 'central-build');
        if (!empty($_GET['cb_errors'])) {
            $errors = explode('|', sanitize_text_field(wp_unslash($_GET['cb_errors'])));
            $error_text .= ' ' . implode(' ', array_map('esc_html', $errors));
        }
        return '<div class="alert alert-danger" role="alert">' . esc_html($error_text) . '</div>';
    }

    return '';
}
