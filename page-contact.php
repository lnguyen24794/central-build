<?php
/**
 * Template Name: Contact Page
 *
 * @package Central_Build_Pro
 * @since 1.0.0
 */

if (!function_exists('central_build_get_contact_settings')) {
    require_once get_template_directory() . '/inc/contact-settings.php';
}

$contact_settings = central_build_get_contact_settings();

$hero        = $contact_settings['hero'];
$contact_info = $contact_settings['contact_info'];
$channels    = $contact_settings['channels'];
$form        = $contact_settings['form'];
$checklist   = $contact_settings['checklist'];
$office      = $contact_settings['office'];
$form_notice = central_build_form_feedback_notice('contact_page');

get_header();
?>
 <style>
    /* Contact Option Blocks */
    .option-block {
        padding: 30px;
        background-color: var(--light-text);
        border-top: 5px solid var(--primary-color);
        height: 100%;
        transition: transform 0.3s ease;
    }
    .option-block:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    .option-icon {
        font-size: 3rem;
        margin-bottom: 15px;
    }

    .option-block.accent { border-top-color: var(--accent-color); }
    .option-block.emergency { border-top-color: var(--emergency-color); }
    .option-block.primary { border-top-color: var(--primary-color); }

    .cta-button-gold {
        background-color: var(--accent-color);
        color: var(--dark-text);
        border: 2px solid var(--accent-color);
        font-weight: 700;
        transition: all 0.3s ease;
    }
    .cta-button-gold:hover {
        background-color: #9d7009;
        color: var(--light-text);
        border-color: #9d7009;
    }

    .checklist-item {
        font-size: 1.1rem;
        line-height: 1.6;
        color: var(--primary-color);
    }
    .checklist-icon {
        color: var(--accent-color);
        margin-right: 10px;
    }
</style>
<main id="primary" class="site-main">
    <!-- Hero Section -->
    <section class="hero-section text-center d-flex align-items-center">
        <div class="container position-relative" data-aos="fade-up" data-aos-duration="1200">
            <h1 class="display-3 fw-bolder mb-2"><?php echo wp_kses_post($hero['title']); ?></h1>
            <p class="lead mb-0 fs-5 opacity-90"><?php echo wp_kses_post($hero['description']); ?></p>
        </div>
    </section>

    <section id="options" class="py-5 py-md-5 bg-light">
        <div class="container">
            <h2 class="text-center display-6 fw-normal mb-5" data-aos="fade-down"><?php esc_html_e('Choose Your Contact Channel', 'central-build'); ?></h2>
            <div class="row g-4">
                <?php foreach ($channels as $index => $channel) :
                    $style = in_array($channel['style'], array('accent', 'emergency', 'primary'), true) ? $channel['style'] : 'primary';
                    $icon  = $channel['icon'] ?: 'fas fa-headset';
                    ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="option-block <?php echo esc_attr($style); ?> <?php echo $style === 'emergency' ? 'text-center' : ''; ?>" data-aos="fade-up" data-aos-delay="<?php echo esc_attr(($index + 1) * 100); ?>">
                            <i class="option-icon <?php echo esc_attr($icon); ?>"></i>
                            <h4 class="fw-bold" style="color: var(--primary-color); "><?php echo esc_html($channel['title']); ?></h4>
                            <?php if ($channel['description']) : ?>
                                <p class="small text-muted"><?php echo wp_kses_post($channel['description']); ?></p>
                            <?php endif; ?>
                            <?php if ($channel['highlight']) : ?>
                                <p class="fw-bold <?php echo esc_attr($style === 'emergency' ? 'emergency-number pulse-animation' : ''); ?>"><?php echo esc_html($channel['highlight']); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($channel['secondary'])) : ?>
                                <p class="small fw-bold"><?php echo esc_html($channel['secondary']); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($channel['cta']['label'])) :
                                $cta_url = $channel['cta']['url'];
                                $cta_label = $channel['cta']['label'];
                                $cta_type = $channel['cta']['type'];
                                ?>
                                <a href="<?php echo $cta_url ? esc_url($cta_url) : '#'; ?>" class="btn btn-sm fw-bold <?php echo esc_attr($style === 'emergency' ? 'btn-danger' : 'btn-outline-dark'); ?>" <?php echo $cta_url ? '' : 'aria-disabled="true"'; ?>>
                                    <?php echo esc_html($cta_label); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="form" class="py-5 py-md-5">
        <div class="container">
            <h2 class="text-center display-6 fw-normal mb-5" data-aos="fade-down"><?php echo esc_html($form['title']); ?></h2>
            <div class="row g-5">
                <div class="col-lg-8 order-lg-1" data-aos="fade-right">
                    <?php if ($form_notice) : ?>
                        <div class="mb-4"><?php echo $form_notice; ?></div>
                    <?php endif; ?>
                    <form class="p-4 border rounded shadow-sm" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" novalidate>
                        <input type="hidden" name="action" value="central_build_form_submit" />
                        <input type="hidden" name="form_id" value="contact_page" />
                        <?php wp_nonce_field('central_build_form_submit', 'central_build_form_nonce'); ?>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="cb-contact-name" class="form-label fw-bold"><?php esc_html_e('Your Full Name*', 'central-build'); ?></label>
                                <input type="text" class="form-control" id="cb-contact-name" name="full_name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="cb-contact-company" class="form-label fw-bold"><?php esc_html_e('Company Name*', 'central-build'); ?></label>
                                <input type="text" class="form-control" id="cb-contact-company" name="company" required>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="cb-contact-email" class="form-label fw-bold"><?php esc_html_e('Work Email*', 'central-build'); ?></label>
                                <input type="email" class="form-control" id="cb-contact-email" name="email" required>
                            </div>
                            <div class="col-md-6">
                                <label for="cb-contact-phone" class="form-label fw-bold"><?php esc_html_e('Phone Number', 'central-build'); ?></label>
                                <input type="tel" class="form-control" id="cb-contact-phone" name="phone">
                            </div>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="cb-contact-type" class="form-label fw-bold"><?php esc_html_e('Project Type*', 'central-build'); ?></label>
                                <select class="form-select" id="cb-contact-type" name="project_type" required>
                                    <option selected disabled value=""><?php esc_html_e('Select Service…', 'central-build'); ?></option>
                                    <option value="commercial_fitout"><?php esc_html_e('Commercial Fit-out', 'central-build'); ?></option>
                                    <option value="commercial_stripout"><?php esc_html_e('Commercial Stripout', 'central-build'); ?></option>
                                    <option value="services_coordination"><?php esc_html_e('Services Coordination', 'central-build'); ?></option>
                                    <option value="scheduled_maintenance"><?php esc_html_e('Scheduled Maintenance Contract', 'central-build'); ?></option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="cb-contact-size" class="form-label fw-bold"><?php esc_html_e('Estimated Project Size (m²)*', 'central-build'); ?></label>
                                <input type="text" class="form-control" id="cb-contact-size" name="project_size" placeholder="e.g., 500 m²" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="cb-contact-message" class="form-label fw-bold"><?php esc_html_e('Your Message/Brief Project Description*', 'central-build'); ?></label>
                            <textarea class="form-control" id="cb-contact-message" name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn hero-button-2 btn-lg w-100"><?php esc_html_e('Submit Inquiry & Start Your Project', 'central-build'); ?></button>
                    </form>
                </div>

                <div class="col-lg-4 order-lg-2" data-aos="fade-left">
                    <div class="p-4 mb-4" style="background-color: var(--light-bg); border-left: 5px solid var(--accent-color);">
                        <h4 class="fw-normal mb-3" style="color: var(--primary-color); "><?php echo esc_html($checklist['title']); ?></h4>
                        <p class="small mb-2"><?php esc_html_e('A quick checklist to help us speed up your quote:', 'central-build'); ?></p>
                        <ul class="list-unstyled">
                            <?php foreach ($checklist['items'] as $item) : ?>
                                <li class="checklist-item"><i class="fas fa-check-circle checklist-icon"></i> <?php echo esc_html($item); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="p-4 border rounded shadow-sm">
                        <h4 class="fw-normal mb-3" style="color: var(--primary-color); "><?php echo esc_html($office['title']); ?></h4>
                        <?php foreach ($office['hours'] as $hour) : ?>
                            <p class="mb-1 fw-bold"><?php echo esc_html($hour['label']); ?></p>
                            <p class="mb-3"><?php echo esc_html($hour['value']); ?></p>
                        <?php endforeach; ?>
                        <p class="mb-1 fw-bold" style="color: var(--emergency-color); "><?php echo esc_html($office['description']); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="location" class="py-5 py-md-5 bg-light">
        <div class="container">
            <h2 class="text-center display-6 fw-normal mb-5" data-aos="fade-down"><?php echo esc_html($office['address_title']); ?></h2>
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0 text-right" data-aos="fade-right">
                    <?php foreach ($office['address_lines'] as $line) : ?>
                        <p class="lead"><?php echo esc_html($line); ?></p>
                    <?php endforeach; ?>
                    <?php if ($office['cta_url']) : ?>
                        <a href="<?php echo esc_url($office['cta_url']); ?>" target="_blank" class="btn btn-outline-dark fw-normal mt-3"><?php echo esc_html($office['cta_label']); ?> <i class="fas fa-map-marker-alt ms-2"></i></a>
                    <?php endif; ?>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div style="height: 350px; background-color: #eee; border: 1px solid #ddd; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                        <i class="fas fa-map-marked-alt fa-3x" style="color: #ccc;"></i>
                        <p class="text-muted ms-3 mb-0"><?php esc_html_e('Google Map Placeholder', 'central-build'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>