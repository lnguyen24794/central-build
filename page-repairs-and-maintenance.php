<?php
/**
 * Template Name: Repairs and Maintenance Page
 *
 * @package Central_Build_Pro
 * @since 1.0.0
 */

if (!function_exists('central_build_get_rm_settings')) {
    require_once get_template_directory() . '/inc/repairs-maintenance-settings.php';
}

$settings   = central_build_get_rm_settings();
$hero       = $settings['hero'];
$guarantee  = $settings['guarantee'];
$expertise  = $settings['expertise'];
$model      = $settings['model'];
$partnership = $settings['partnership'];
$contact    = $settings['contact'];
$show_projects = $settings['show_projects'];
$form_notice = central_build_form_feedback_notice('repairs_maintenance');

$projects = $show_projects ? central_build_get_fitout_projects(9) : array();
$projects_by_category = array();
if (!empty($projects)) {
    foreach ($projects as $project) {
        $category = $project['category'] ?: __('Other', 'central-build');
        $projects_by_category[$category][] = $project;
    }
}
$categories = array_keys($projects_by_category);

global $central_build_inline_styles;
$central_build_inline_styles = $central_build_inline_styles ?? array();
$central_build_inline_styles['repairs-maintenance'] = array(
    '.rm-hero-section::after' => array('content' => '""', 'position' => 'absolute', 'inset' => '0', 'background' => 'linear-gradient(to bottom right, rgba(18,38,55,.82), rgba(18,38,55,.55))'),
);

get_header();
?>

<style>
    .hero-section {
        min-height: 90vh;
        color: var(--light-text);
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }
    .hero-section > .container { position: relative; z-index: 2; }
    .cta-button-emergency {
        background-color: var(--emergency-color);
        border: 2px solid var(--emergency-color);
        color: var(--light-text);
        font-weight: 700;
        padding: 15px 40px;
        transition: all 0.3s ease;
        box-shadow: 0 5px 20px rgba(229, 57, 53, 0.3);
        animation: pulse-red 2s infinite;
    }
    .cta-button-emergency:hover {
        background-color: #c4312e;
        border-color: #c4312e;
        color: var(--light-text);
    }
    @keyframes pulse-red {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); box-shadow: 0 0 0 0 rgba(229, 57, 53, 0.35); }
        100% { transform: scale(1); box-shadow: 0 0 0 12px rgba(229, 57, 53, 0); }
    }
    .guarantee-box {
        border: 1px solid rgba(0,0,0,0.08);
        padding: 30px 20px;
        background-color: var(--light-text);
        height: 100%;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: transform 0.3s ease, border-color 0.3s ease;
    }
    .guarantee-box:hover { transform: translateY(-6px); border-color: var(--accent-color); }
    .guarantee-icon { color: var(--primary-color); font-size: 3rem; }
    .expertise-tile {
        background-color: var(--light-bg);
        padding: 20px;
        border-left: 4px solid var(--accent-color);
        transition: transform 0.3s ease, background-color 0.3s ease;
    }
    .expertise-tile:hover { background-color: #e8ebed; transform: translateY(-4px); }
    .partnership-section { background: linear-gradient(120deg, rgba(28,49,68,0.95), rgba(28,49,68,0.75)); color: var(--light-text); }
    .final-cta-jumbotron { background-color: var(--accent-color); color: var(--light-text); padding: 60px 0; }
    .final-cta-jumbotron .card { background-color: var(--light-text); }
</style>
<main id="primary" class="site-main">
    <section class="hero-section" id="home">
        <div class="container position-relative" data-aos="fade-up" data-aos-duration="1200">
            <h1 class="display-3 fw-bolder mb-3"><?php echo wp_kses_post($hero['title']); ?></h1>
            <p class="lead mb-4 fw-bold" style="color: var(--accent-color); "><?php echo esc_html($hero['subtitle']); ?></p>
            <p class="mb-5 fs-5 opacity-75"><?php echo wp_kses_post($hero['description']); ?></p>
            <div class="">
                <?php if (!empty($hero['primary_cta']['label'])) : ?>
                    <a href="<?php echo esc_url($hero['primary_cta']['url']); ?>" class="d-inline-block mr-3 btn cta-button-emergency btn-lg"> <?php echo esc_html($hero['primary_cta']['label']); ?></a>
                <?php endif; ?>
                <?php if (!empty($hero['secondary_cta']['label'])) : ?>
                    <a href="<?php echo esc_url($hero['secondary_cta']['url']); ?>" class="ml-3 d-inline-block btn btn-outline-light btn-lg" style="padding: .85rem 1rem; margin-left: 50px;"><?php echo esc_html($hero['secondary_cta']['label']); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php if (!empty($guarantee)) : ?>
        <section id="guarantee" class="py-5 py-md-5">
            <div class="container">
                <h2 class="text-center display-6 fw-normal mb-5" data-aos="fade-down"><?php esc_html_e('The Central Build Service Guarantee', 'central-build'); ?></h2>
                <div class="row g-4">
                    <?php foreach ($guarantee as $index => $item) : ?>
                        <div class="col-md-4">
                            <div class="guarantee-box text-center" data-aos="fade-up" data-aos-delay="<?php echo esc_attr(($index + 1) * 100); ?>">
                                <i class="<?php echo esc_attr($item['icon']); ?> guarantee-icon mb-3"></i>
                                <h4 class="fw-bold" style="color: var(--primary-color); "><?php echo esc_html($item['title']); ?></h4>
                                <?php if (!empty($item['tagline'])) : ?>
                                    <p class="lead small fw-bold" style="color: var(--accent-color); "><?php echo esc_html($item['tagline']); ?></p>
                                <?php endif; ?>
                                <p><?php echo wp_kses_post($item['description']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if (!empty($expertise)) : ?>
        <section id="expertise" class="py-5 py-md-5 bg-light">
            <div class="container">
                <h2 class="text-center display-6 fw-normal mb-5" data-aos="fade-down"><?php esc_html_e('Specialised Commercial Repairs & Maintenance', 'central-build'); ?></h2>
                <div class="row g-4">
                    <?php foreach ($expertise as $index => $tile) : ?>
                        <div class="col-lg-3 col-md-6">
                            <div class="expertise-tile" data-aos="fade-up" data-aos-delay="<?php echo esc_attr(($index + 1) * 100); ?>">
                                <i class="<?php echo esc_attr($tile['icon']); ?> fa-2x mb-2" style="color: var(--accent-color); "></i>
                                <h5 class="fw-bold"><?php echo esc_html($tile['title']); ?></h5>
                                <p class="small mb-0"><?php echo wp_kses_post($tile['description']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if (!empty($model)) : ?>
        <section id="model" class="py-5 py-md-5">
            <div class="container">
                <h2 class="text-center display-6 fw-normal mb-5" data-aos="fade-down"><?php esc_html_e('Our 4-Step Rapid Response Model', 'central-build'); ?></h2>
                <div class="row text-center g-5">
                    <?php foreach ($model as $index => $step) : ?>
                        <div class="col-lg-3" data-aos="fade-up" data-aos-delay="<?php echo esc_attr(($index + 1) * 100); ?>">
                            <i class="<?php echo esc_attr($step['icon']); ?> fa-4x mb-3" style="color: var(--accent-color); "></i>
                            <h4 class="fw-bold" style="color: var(--primary-color); "><?php echo esc_html($step['title']); ?></h4>
                            <p class="small"><?php echo wp_kses_post($step['description']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section id="partnership" class="py-5 py-md-5 partnership-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                    <h2 class="display-6 fw-normal mb-4" style="color: var(--accent-color); "><?php echo esc_html($partnership['heading']); ?></h2>
                    <p class="lead"><?php echo wp_kses_post($partnership['description']); ?></p>
                    <?php if (!empty($partnership['cta_label'])) : ?>
                        <a href="<?php echo esc_url($partnership['cta_url']); ?>" class="btn cta-button-emergency mt-3"><?php echo esc_html($partnership['cta_label']); ?></a>
                    <?php endif; ?>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <ul class="list-unstyled mt-4">
                        <?php foreach ($partnership['items'] as $item) : ?>
                            <li class="d-flex mb-3">
                                <i class="<?php echo esc_attr($item['icon']); ?> fa-2x me-3" style="color: var(--accent-color); "></i>
                                <div>
                                    <h5 class="fw-bold"> <?php echo esc_html($item['title']); ?></h5>
                                    <p class="small opacity-75 mb-0"> <?php echo wp_kses_post($item['description']); ?></p>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <?php if ($show_projects && !empty($projects)) : ?>
        <section id="projects" class="py-5 py-md-5 bg-dark" style="color: var(--light-text);">
            <div class="container">
                <h2 class="text-center display-5 fw-normal mb-5" data-aos="fade-up"><?php esc_html_e('Our Proven Projects', 'central-build'); ?></h2>
                <ul class="nav nav-pills justify-content-center mb-4" data-aos="fade-up" data-aos-delay="200">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="pill" href="#rm-projects-all"><?php esc_html_e('All', 'central-build'); ?></a></li>
                    <?php foreach ($categories as $category) :
                        $tab = 'rm-projects-' . sanitize_title($category); ?>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#<?php echo esc_attr($tab); ?>"><?php echo esc_html($category); ?></a></li>
                    <?php endforeach; ?>
                </ul>
                <div class="tab-content">
                    <div id="rm-projects-all" class="tab-pane fade show active">
                        <div class="row g-4">
                            <?php foreach ($projects as $project) : ?>
                                <div class="col-md-6 col-lg-4" data-aos="zoom-in">
                                    <div class="portfolio-item">
                                        <img src="<?php echo esc_url($project['image']); ?>" class="img-fluid rounded" alt="<?php echo esc_attr($project['alt']); ?>">
                                        <div class="overlay-text p-3">
                                            <h5 class="fw-bold"><?php echo esc_html($project['title']); ?></h5>
                                            <?php if ($project['category']) : ?>
                                                <p><?php printf(esc_html__('Sector: %s', 'central-build'), esc_html($project['category'])); ?></p>
                                            <?php endif; ?>
                                            <a href="<?php echo esc_url($project['url']); ?>" class="stretched-link" aria-label="<?php echo esc_attr($project['title']); ?>"></a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php foreach ($projects_by_category as $category => $items) :
                        $tab = 'rm-projects-' . sanitize_title($category); ?>
                        <div id="<?php echo esc_attr($tab); ?>" class="tab-pane fade">
                            <div class="row g-4">
                                <?php foreach ($items as $project) : ?>
                                    <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="100">
                                        <div class="portfolio-item">
                                            <img src="<?php echo esc_url($project['image']); ?>" class="img-fluid rounded" alt="<?php echo esc_attr($project['alt']); ?>">
                                            <div class="overlay-text p-3">
                                                <h5 class="fw-bold"><?php echo esc_html($project['title']); ?></h5>
                                                <a href="<?php echo esc_url($project['url']); ?>" class="stretched-link" aria-label="<?php echo esc_attr($project['title']); ?>"></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section id="contact" class="final-cta-jumbotron">
        <div class="container">
            <div class="row alignớm-center">
                <div class="col-lg-7" data-aos="fade-right">
                    <h2 class="display-5 fw-bolder mb-3" style="color: var(--light-text); "><?php echo wp_kses_post($contact['heading']); ?></h2>
                    <p class="lead mb-4 fw-bold text-white"><?php echo wp_kses_post($contact['description']); ?></p>
                    <?php if (!empty($contact['contact_line'])) : ?>
                        <p class="fw-bold text-white"><?php echo esc_html($contact['contact_line']); ?></p>
                    <?php endif; ?>
                </div>
                <div class="col-lg-5 mt-4 mt-lg-0" data-aos="fade-left">
                    <div class="card p-4 shadow-lg">
                        <?php if ($form_notice) : ?>
                            <div class="mb-4"><?php echo $form_notice; ?></div>
                        <?php endif; ?>
                        <h4 class="card-title text-center fw-bold" style="color: var(--primary-color); "><?php echo esc_html($contact['form_title']); ?></h4>
                        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" novalidate>
                            <input type="hidden" name="action" value="central_build_form_submit" />
                            <input type="hidden" name="form_id" value="repairs_maintenance" />
                            <?php wp_nonce_field('central_build_form_submit', 'central_build_form_nonce'); ?>
                            <div class="mb-3">
                                <input type="text" class="form-control" name="full_name" placeholder="<?php esc_attr_e('Your Name', 'central-build'); ?>" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control" name="email" placeholder="<?php esc_attr_e('Work Email', 'central-build'); ?>" required>
                            </div>
                            <div class="mb-3">
                                <select class="form-select" name="service_type" required>
                                    <option value="" selected disabled><?php esc_html_e('Select Service Type...', 'central-build'); ?></option>
                                    <?php foreach ($contact['service_options'] as $option) : ?>
                                        <option value="<?php echo esc_attr($option); ?>"><?php echo esc_html($option); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" name="details" rows="3" placeholder="<?php esc_attr_e('Describe your issue or request', 'central-build'); ?>"></textarea>
                            </div>
                            <button type="submit" class="btn cta-button-emergency w-100 btn-lg" style="box-shadow: none;">SUBMIT REQUEST</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>