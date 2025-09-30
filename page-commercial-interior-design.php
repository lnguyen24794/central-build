<?php
/**
 * Template Name: commercial-interior-design Page
 *
 * @package Central_Build_Pro
 * @since 1.0.0
 */

if (!function_exists('central_build_get_cid_settings')) {
    require_once get_template_directory() . '/inc/commercial-interior-design-settings.php';
}

$cid_settings = central_build_get_cid_settings();
$hero         = $cid_settings['hero'];
$about        = $cid_settings['about'];
$strengths    = $cid_settings['strengths'];
$process      = $cid_settings['process'];
$cta_block    = $cid_settings['cta_block'];
$form_notice = central_build_form_feedback_notice('commercial_interior_design');

$projects = central_build_get_fitout_projects(9);
$projects_by_category = array();
foreach ($projects as $project) {
    $category = $project['category'] ?: __('Other', 'central-build');
    if (!isset($projects_by_category[$category])) {
        $projects_by_category[$category] = array();
    }
    $projects_by_category[$category][] = $project;
}
$categories = array_keys($projects_by_category);

get_header();
?>

<main id="primary" class="site-main">
    <section class="hero-section text-center d-flex align-items-center" id="home">
        <div class="hero-overlay"></div>
        <div class="container position-relative" data-aos="fade-up" data-aos-duration="1500">
            <h1 class="display-4 fw-normal mb-3"><?php echo esc_html($hero['title']); ?></h1>
            <p class="lead mb-4"><?php echo esc_html($hero['subtitle']); ?></p>
            <p class="mb-5"><?php echo wp_kses_post($hero['description']); ?></p>
            <?php if (!empty($hero['primary_cta']['label'])) : ?>
                <a href="<?php echo esc_url($hero['primary_cta']['url']); ?>" class="btn cta-button-primary btn-lg me-3 pulse-animation"><?php echo esc_html($hero['primary_cta']['label']); ?></a>
            <?php endif; ?>
            <?php if (!empty($hero['secondary_cta']['label'])) : ?>
                <a href="<?php echo esc_url($hero['secondary_cta']['url']); ?>" class="btn btn-outline-light btn-lg"><?php echo esc_html($hero['secondary_cta']['label']); ?></a>
            <?php endif; ?>
        </div>
    </section>

    <section id="about" class="py-5 py-md-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <h2 class="display-5 fw-normal mb-4"><?php echo esc_html($about['heading']); ?></h2>
                    <p class="lead text-primary fw-semibold"><?php echo esc_html($about['subheading']); ?></p>
                    <p><?php echo wp_kses_post($about['content']); ?></p>
                    <?php if (!empty($about['quote']['text'])) : ?>
                        <blockquote class="blockquote border-start border-3 ps-3 mt-4">
                            <p class="mb-0 fst-italic"><?php echo wp_kses_post($about['quote']['text']); ?></p>
                            <?php if (!empty($about['quote']['author'])) : ?>
                                <footer class="blockquote-footer mt-2"><?php echo esc_html($about['quote']['author']); ?></footer>
                            <?php endif; ?>
                        </blockquote>
                    <?php endif; ?>
                </div>
                <div class="col-lg-6 mt-4 mt-lg-0" data-aos="fade-left">
                    <img src="<?php echo esc_url($about['image']); ?>" class="img-fluid rounded shadow-lg" alt="<?php echo esc_attr($about['heading']); ?>">
                </div>
            </div>
        </div>
    </section>

    <?php if (!empty($strengths)) : ?>
        <section id="strengths" class="py-5 py-md-5 bg-light">
            <div class="container">
                <h2 class="text-center display-5 fw-normal mb-5" data-aos="fade-down"><?php esc_html_e('Our Competitive Strengths', 'central-build'); ?></h2>
                <div class="row g-4">
                    <?php foreach ($strengths as $index => $strength) : ?>
                        <div class="col-md-6 col-lg-3">
                            <div class="card strength-card text-center p-3 h-100" data-aos="fade-up" data-aos-delay="<?php echo esc_attr(($index + 1) * 100); ?>">
                                <div class="card-body">
                                    <i class="<?php echo esc_attr($strength['icon']); ?> fa-3x mb-3 text-primary"></i>
                                    <h5 class="card-title fw-bold"><?php echo esc_html($strength['title']); ?></h5>
                                    <p class="card-text"><?php echo wp_kses_post($strength['description']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if (!empty($process)) : ?>
        <section id="process" class="py-5 py-md-5">
            <div class="container">
                <h2 class="text-center display-5 fw-normal mb-5" data-aos="fade-down"><?php esc_html_e('Our Seamless 4-Step Process', 'central-build'); ?></h2>
                <div class="row g-5">
                    <?php foreach ($process as $index => $step) : ?>
                        <div class="col-lg-3 text-center" data-aos="fade-right" data-aos-delay="<?php echo esc_attr(($index + 1) * 100); ?>">
                            <div class="process-icon mb-3">
                                <i class="<?php echo esc_attr($step['icon']); ?> fa-4x text-secondary"></i>
                            </div>
                            <h4 class="fw-normal text-primary"><?php echo esc_html($step['title']); ?></h4>
                            <p><?php echo wp_kses_post($step['description']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section id="portfolio" class="py-5 py-md-5 bg-dark" style="color: var(--light-text);">
        <div class="container">
            <h2 class="text-center display-5 fw-normal mb-5" data-aos="fade-up"><?php esc_html_e('Our Proven Projects', 'central-build'); ?></h2>

            <?php if (!empty($projects)) : ?>
                <ul class="nav nav-pills justify-content-center mb-4" data-aos="fade-up" data-aos-delay="200">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="pill" href="#cid-projects-all"><?php esc_html_e('All', 'central-build'); ?></a></li>
                    <?php foreach ($categories as $slug) : ?>
                        <?php $tab_id = 'cid-projects-' . sanitize_title($slug); ?>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#<?php echo esc_attr($tab_id); ?>"><?php echo esc_html($slug); ?></a></li>
                    <?php endforeach; ?>
                </ul>

                <div class="tab-content">
                    <div id="cid-projects-all" class="tab-pane fade show active">
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

                    <?php foreach ($projects_by_category as $category => $items) : ?>
                        <?php $tab_id = 'cid-projects-' . sanitize_title($category); ?>
                        <div id="<?php echo esc_attr($tab_id); ?>" class="tab-pane fade">
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

                <div class="text-center mt-5">
                    <a href="<?php echo esc_url(get_post_type_archive_link('fitout_sector')); ?>" class="btn cta-button-primary btn-lg"><?php esc_html_e('Request Full Portfolio', 'central-build'); ?></a>
                </div>
            <?php else : ?>
                <p class="text-center" data-aos="fade-up"><?php esc_html_e('No projects found at the moment. Please check back soon.', 'central-build'); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <section id="contact" class="py-5 py-md-5 bg-primary" style="color: var(--light-text);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <h2 class="display-5 fw-normal text-white mb-3"><?php echo esc_html($cta_block['heading']); ?></h2>
                    <p class="lead mb-4"><?php echo wp_kses_post($cta_block['description']); ?></p>
                    <ul class="list-unstyled">
                        <?php foreach ($cta_block['items'] as $item) : ?>
                            <li class="mb-2"><i class="<?php echo esc_attr($item['icon']); ?> me-2"></i> <?php echo esc_html($item['text']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="col-lg-6 mt-4 mt-lg-0" data-aos="fade-left">
                    <?php if ($form_notice) : ?>
                        <div class="col-12 mb-3"><?php echo $form_notice; ?></div>
                    <?php endif; ?>
                    <div class="card p-4 shadow-lg" style="color: #333;">
                        <h4 class="card-title text-center fw-bold"><?php echo esc_html($cta_block['form_title']); ?></h4>
                        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="needs-validation" novalidate>
                            <input type="hidden" name="action" value="central_build_form_submit" />
                            <input type="hidden" name="form_id" value="commercial_interior_design" />
                            <?php wp_nonce_field('central_build_form_submit', 'central_build_form_nonce'); ?>
                            <div class="mb-3">
                                <input type="text" class="form-control" name="full_name" placeholder="<?php esc_attr_e('Your Full Name', 'central-build'); ?>" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control" name="email" placeholder="<?php esc_attr_e('Your Business Email', 'central-build'); ?>" required>
                            </div>
                            <div class="mb-3">
                                <input type="tel" class="form-control" name="phone" placeholder="<?php esc_attr_e('Phone Number', 'central-build'); ?>">
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" name="message" rows="3" placeholder="<?php esc_attr_e('Tell us about your project (Type of space, size, requirements)', 'central-build'); ?>"></textarea>
                            </div>
                            <button type="submit" class="btn cta-button-primary w-100 btn-lg"><?php echo esc_html($cta_block['button_label']); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>