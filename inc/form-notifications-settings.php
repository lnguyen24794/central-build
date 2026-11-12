<?php
if (!defined('ABSPATH')) {
    exit;
}

function central_build_form_notifications_defaults(): array
{
    return array(
        'front_page'                    => array('recipients' => array(), 'reply_to' => ''),
        'contact_page'                  => array('recipients' => array(), 'reply_to' => ''),
        'commercial_fitout_specialists' => array('recipients' => array(), 'reply_to' => ''),
        'commercial_interior_design'    => array('recipients' => array(), 'reply_to' => ''),
        'commercial_stripout'           => array('recipients' => array(), 'reply_to' => ''),
        'repairs_maintenance'           => array('recipients' => array(), 'reply_to' => ''),
        'services_coordination'         => array('recipients' => array(), 'reply_to' => ''),
        'design_solutions'              => array('recipients' => array(), 'reply_to' => ''),
        // Every email the website sends: sender name, and the main address that receives form messages.
        'sender'                        => array('name' => 'Support-CentralBuild', 'recipient' => 'thangt@centralbuild.au'),
    );
}

function central_build_get_form_notifications(): array
{
    $defaults = central_build_form_notifications_defaults();
    $saved    = get_option('central_build_form_notifications', array());

    $settings = wp_parse_args(is_array($saved) ? $saved : array(), $defaults);

    foreach ($defaults as $key => $default) {
        if ($key === 'sender') {
            continue;
        }
        if (!isset($settings[$key]) || !is_array($settings[$key])) {
            $settings[$key] = $default;
        }
        $recipients = array();
        if (!empty($settings[$key]['recipients']) && is_array($settings[$key]['recipients'])) {
            foreach ($settings[$key]['recipients'] as $recipient) {
                $email = sanitize_email(is_string($recipient) ? $recipient : '');
                if ($email !== '') {
                    $recipients[] = $email;
                }
            }
        } elseif (!empty($settings[$key]['recipients']) && is_string($settings[$key]['recipients'])) {
            $parts = preg_split('/[,\n]+/', $settings[$key]['recipients']);
            foreach ($parts as $recipient) {
                $email = sanitize_email(trim($recipient));
                if ($email !== '') {
                    $recipients[] = $email;
                }
            }
        }
        $settings[$key]['recipients'] = $recipients;
        $settings[$key]['reply_to']   = sanitize_email($settings[$key]['reply_to'] ?? '');
    }

    $sender = is_array($settings['sender'] ?? null) ? $settings['sender'] : array();
    $settings['sender'] = array(
        'name'      => trim((string) ($sender['name'] ?? '')) !== '' ? sanitize_text_field($sender['name']) : $defaults['sender']['name'],
        'recipient' => is_email($sender['recipient'] ?? '') ? sanitize_email($sender['recipient']) : $defaults['sender']['recipient'],
    );

    return $settings;
}

function central_build_sanitize_form_notifications(array $input): array
{
    $defaults = central_build_form_notifications_defaults();
    $settings = array();

    foreach ($defaults as $key => $default) {
        if ($key === 'sender') {
            $raw = is_array($input['sender'] ?? null) ? $input['sender'] : array();
            $name = sanitize_text_field(wp_unslash((string) ($raw['name'] ?? '')));
            $to   = sanitize_email(wp_unslash((string) ($raw['recipient'] ?? '')));
            $settings['sender'] = array(
                'name'      => $name !== '' ? $name : $default['name'],
                'recipient' => is_email($to) ? $to : $default['recipient'],
            );
            continue;
        }
        $raw = $input[$key] ?? array();
        $recipients_input = '';
        if (is_array($raw) && isset($raw['recipients'])) {
            $recipients_input = $raw['recipients'];
        } elseif (is_string($raw)) {
            $recipients_input = $raw;
        }

        if (is_array($recipients_input)) {
            $recipients_input = implode("\n", $recipients_input);
        }

        $emails = array();
        foreach (preg_split('/[,\n]+/', (string) $recipients_input) as $recipient) {
            $email = sanitize_email(trim($recipient));
            if ($email !== '') {
                $emails[] = $email;
            }
        }

        $settings[$key] = array(
            'recipients' => $emails,
            'reply_to'   => sanitize_email($raw['reply_to'] ?? ''),
        );
    }

    return $settings;
}

function central_build_handle_form_notifications_submit(): void
{
    if (!isset($_POST['central_build_form_notifications_submit'])) {
        return;
    }

    check_admin_referer('central_build_form_notifications');

    $raw = isset($_POST['central_build_form_notifications']) && is_array($_POST['central_build_form_notifications'])
        ? $_POST['central_build_form_notifications']
        : array();

    $sanitized = central_build_sanitize_form_notifications($raw);

    update_option('central_build_form_notifications', $sanitized);

    add_settings_error('central_build_form_notifications', 'central_build_form_notifications_updated', __('Form notification settings saved.', 'central-build'), 'updated');
}

function central_build_form_notifications_page_render(): void
{
    central_build_handle_form_notifications_submit();

    $settings = central_build_get_form_notifications();
    $messages = get_settings_errors('central_build_form_notifications');
    $forms    = array(
        'front_page'                    => __('Front Page – Project Kick-off Form', 'central-build'),
        'contact_page'                  => __('Contact Page – Primary Inquiry Form', 'central-build'),
        'commercial_fitout_specialists' => __('Commercial Fitout Specialists – Final CTA Form', 'central-build'),
        'commercial_interior_design'    => __('Commercial Interior Design – Consultation Form', 'central-build'),
        'commercial_stripout'           => __('Commercial Stripout – Quote Request Form', 'central-build'),
        'repairs_maintenance'           => __('Repairs & Maintenance – Quote Form', 'central-build'),
        'services_coordination'         => __('Services Coordination – Consultation Form', 'central-build'),
        'design_solutions'              => __('Commercial Design and Solutions – Design Consultation Form', 'central-build'),
    );
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Form Notifications', 'central-build'); ?></h1>

        <?php if (!empty($messages)) :
            foreach ($messages as $message) :
                printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($message['type']), esc_html($message['message']));
            endforeach;
        endif; ?>

        <form method="post" action="">
            <?php wp_nonce_field('central_build_form_notifications'); ?>

            <p class="description"><?php esc_html_e('Enter one email address per line. These recipients will be notified whenever a form submission is received. Optionally specify a reply-to address for each form.', 'central-build'); ?></p>

            <table class="form-table" role="presentation">
                <tbody>
                    <?php foreach ($forms as $key => $label) :
                        $form_settings = $settings[$key];
                        ?>
                        <tr>
                            <th scope="row"><?php echo esc_html($label); ?></th>
                            <td>
                                <label for="cb-form-recipient-<?php echo esc_attr($key); ?>" class="screen-reader-text"><?php esc_html_e('Notification recipients', 'central-build'); ?></label>
                                <textarea id="cb-form-recipient-<?php echo esc_attr($key); ?>" name="central_build_form_notifications[<?php echo esc_attr($key); ?>][recipients]" rows="4" class="large-text" placeholder="<?php esc_attr_e('name@example.com', 'central-build'); ?>"><?php echo esc_textarea(implode("\n", $form_settings['recipients'])); ?></textarea>
                                <p class="description"><?php esc_html_e('One email address per line.', 'central-build'); ?></p>
                                <label for="cb-form-reply-<?php echo esc_attr($key); ?>" class="screen-reader-text"><?php esc_html_e('Reply-To address', 'central-build'); ?></label>
                                <input type="email" id="cb-form-reply-<?php echo esc_attr($key); ?>" name="central_build_form_notifications[<?php echo esc_attr($key); ?>][reply_to]" class="regular-text" value="<?php echo esc_attr($form_settings['reply_to']); ?>" placeholder="<?php esc_attr_e('Optional reply-to email', 'central-build'); ?>" />
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <p class="submit">
                <button type="submit" name="central_build_form_notifications_submit" class="button button-primary"><?php esc_html_e('Save Changes', 'central-build'); ?></button>
            </p>
        </form>
    </div>
    <?php
}

function central_build_form_notifications_menu(): void
{
    add_theme_page(
        __('Form Notifications', 'central-build'),
        __('Form Notifications', 'central-build'),
        'manage_options',
        'central-build-form-notifications',
        'central_build_form_notifications_page_render'
    );
}
add_action('admin_menu', 'central_build_form_notifications_menu');

/** Sender name and main recipient for every email the website sends (Website Content > Form emails > Sender). */
function central_build_mail_sender(): array
{
    $settings = central_build_get_form_notifications();
    return (array) $settings['sender'];
}

/**
 * All website emails go out as "Support-CentralBuild" (or the name set in Form emails).
 * GoSMTP keeps this name unless "Force From Name" is switched on in its own settings.
 */
add_filter('wp_mail_from_name', static function ($name) {
    $sender = central_build_mail_sender();
    return $sender['name'] !== '' ? $sender['name'] : $name;
}, 20);

/**
 * Sender address: when GoSMTP sends through an SMTP account that logs in with an email address
 * (for example Gmail), send from that address, which the mail server requires. GoSMTP's own
 * "Force From Email" setting still wins when it is switched on.
 */
add_filter('wp_mail_from', static function ($from) {
    if (!function_exists('is_plugin_active')) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    if (!is_plugin_active('gosmtp/gosmtp.php')) {
        return $from;
    }
    $o    = get_option('gosmtp_options');
    $m    = is_array($o['mailer'][0] ?? null) ? $o['mailer'][0] : array();
    $user = (string) ($m['smtp_username'] ?? '');
    return ($m['mail_type'] ?? '') === 'smtp' && is_email($user) ? $user : $from;
}, 20);
