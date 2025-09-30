<?php
/**
 * Template Name: commercial-stripout Page
 *
 * @package Central_Build_Pro
 * @since 1.0.0
 */

if (!function_exists('central_build_get_cs_settings')) {
    require_once get_template_directory() . '/inc/commercial-stripout-settings.php';
}

$settings = central_build_get_cs_settings();
$hero     = $settings['hero'];
$promise  = $settings['promise'];
$safety   = $settings['safety'];
$technical = $settings['technical'];
$scale    = $settings['scale'];
$contact  = $settings['contact'];
$show_projects = $settings['show_projects'];
$form_notice = central_build_form_feedback_notice('commercial_stripout');

$projects = $show_projects ? central_build_get_fitout_projects(9) : array();
$projects_by_category = array();
if (!empty($projects)) {
    foreach ($projects as $project) {
        $category = $project['category'] ?: __('Other', 'central-build');
        $projects_by_category[$category][] = $project;
    }
}
$categories = array_keys($projects_by_category);

get_header();
?>

<style>
    .hero-section {
        min-height: 90vh;
        color: var(--light-text);
        display: flex;
        align-items: center;
    }
    .promise-box {
        border-top: 5px solid var(--accent-color);
        padding: 25px;
        background-color: var(--light-text);
        height: 100%;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: transform 0.3s ease;
    }
    .promise-box:hover { transform: translateY(-5px); }
    .safety-step {
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 8px;
        background-color: var(--light-text);
        height: 100%;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
    .safety-icon { color: var(--accent-color); font-size: 2.5rem; }
    .technical-card { border-left: 5px solid var(--primary-color); border-radius: 0; }
    .final-cta-jumbotron { background-color: var(--accent-color); color: var(--dark-text); padding: 60px 0; }
</style>
<main id="primary" class="site-main">
    <section class="hero-section" id="home">
        <div class="container position-relative" data-aos="fade-up" data-aos-duration="1200">
            <h1 class="display-3 fw-bolder mb-3"><?php echo wp_kses_post($hero['title']); ?></h1>
            <p class="lead mb-4 fw-bold" style="color: var(--accent-color); "><?php echo esc_html($hero['subtitle']); ?></p>
            <p class="mb-5 fs-5 opacity-75"><?php echo wp_kses_post($hero['description']); ?></p>
            <?php if (!empty($hero['cta']['label'])) : ?>
                <a href="<?php echo esc_url($hero['cta']['url']); ?>" class="btn hero-button-2 w-50 btn-lg pulse-animation"><?php echo esc_html($hero['cta']['label']); ?></a>
            <?php endif; ?>
        </div>
    </section>

    <?php if (!empty($promise)) : ?>
        <section id="promise" class="py-5 py-md-5 bg-light">
            <div class="container">
                <h2 class="text-center display-6 fw-normal mb-5" data-aos="fade-down"><?php esc_html_e("Our Core Promise: The 3 P's of Deconstruction", 'central-build'); ?></h2>
                <div class="row g-4">
                    <?php foreach ($promise as $index => $item) : ?>
                        <div class="col-md-4">
                            <div class="promise-box" data-aos="fade-up" data-aos-delay="<?php echo esc_attr(($index + 1) * 100); ?>">
                                <i class="<?php echo esc_attr($item['icon']); ?> fa-3x mb-3" style="color: var(--primary-color); "></i>
                                <h4 class="fw-bold" style="color: var(--primary-color); "><?php echo esc_html($item['title']); ?></h4>
                                <?php if (!empty($item['subtitle'])) : ?>
                                    <p class="lead small fw-bold"><?php echo esc_html($item['subtitle']); ?></p>
                                <?php endif; ?>
                                <p><?php echo wp_kses_post($item['description']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if (!empty($safety)) : ?>
        <section id="safety" class="py-5 py-md-5">
            <div class="container">
                <h2 class="text-center display-6 fw-normal mb-5" data-aos="fade-down"><?php esc_html_e('Our Priority: A Zero-Harm Workplace.', 'central-build'); ?></h2>
                <div class="row g-4 text-center">
                    <?php foreach ($safety as $index => $step) : ?>
                        <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?php echo esc_attr(($index + 1) * 100); ?>">
                            <div class="safety-step">
                                <i class="<?php echo esc_attr($step['icon']); ?> safety-icon mb-3"></i>
                                <h4 class="fw-bold" style="color: var(--primary-color); "><?php echo esc_html($step['title']); ?></h4>
                                <p><?php echo wp_kses_post($step['description']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section id="technical" class="py-5 py-md-5 bg-dark" style="color: var(--light-text);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                    <h2 class="display-6 fw-normal mb-4" style="color: var(--accent-color); "><?php echo esc_html($technical['heading']); ?></h2>
                    <p class="lead"><?php echo wp_kses_post($technical['introduction']); ?></p>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <?php foreach ($technical['cards'] as $card) : ?>
                        <div class="card p-4 mb-3 technical-card">
                            <h4 class="fw-bold" style="color: var(--primary-color); "><?php echo esc_html($card['title']); ?></h4>
                            <p class="mb-0 text-dark"><?php echo wp_kses_post($card['description']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <section id="scale" class="py-5 py-md-5 bg-light">
        <div class="container">
            <h2 class="text-center display-6 fw-normal mb-5" data-aos="fade-down"><?php echo esc_html($scale['heading']); ?></h2>
            <div class="row g-4 align-items-center">
                <div class="col-lg-8" data-aos="fade-right">
                    <div class="row g-2">
                        <?php foreach ($scale['images'] as $image) : ?>
                            <div class="col-4"><img src="<?php echo esc_url($image); ?>" class="img-fluid rounded shadow-sm" alt="" loading="lazy"></div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-lg-4" data-aos="fade-left">
                    <p class="lead fw-normal mt-4 mt-lg-0" style="color: var(--primary-color); "><?php echo esc_html($scale['subtitle']); ?></p>
                    <p><?php echo wp_kses_post($scale['description']); ?></p>
                    <?php if (!empty($scale['cta_label'])) : ?>
                        <a href="<?php echo esc_url($scale['cta_url']); ?>" class="btn btn-outline-dark fw-normal mt-3"><?php echo esc_html($scale['cta_label']); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <?php if ($show_projects && !empty($projects)) : ?>
        <section id="portfolio" class="py-5 py-md-5 bg-dark" style="color: var(--light-text);">
            <div class="container">
                <h2 class="text-center display-5 fw-normal mb-5" data-aos="fade-up"><?php esc_html_e('Our Proven Projects', 'central-build'); ?></h2>
                <ul class="nav nav-pills justify-content-center mb-4" data-aos="fade-up" data-aos-delay="200">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="pill" href="#cs-projects-all"><?php esc_html_e('All', 'central-build'); ?></a></li>
                    <?php foreach ($categories as $category) :
                        $tab = 'cs-projects-' . sanitize_title($category); ?>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#<?php echo esc_attr($tab); ?>"><?php echo esc_html($category); ?></a></li>
                    <?php endforeach; ?>
                </ul>
                <div class="tab-content">
                    <div id="cs-projects-all" class="tab-pane fade show active">
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
                        $tab = 'cs-projects-' . sanitize_title($category); ?>
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
            <div class="row align-items-center">
                <div class="col-lg-7" data-aos="fade-right">
                    <h2 class="display-5 fw-bolder mb-3 text-white"><?php echo wp_kses_post($contact['title']); ?></h2>
                    <p class="lead mb-4 fw-bold text-white"><?php echo wp_kses_post($contact['description']); ?></p>
                    <?php if (!empty($contact['contact_line'])) : ?>
                        <p class="fw-bold text-white"><?php echo esc_html($contact['contact_line']); ?></p>
                    <?php endif; ?>
                </div>
                <div class="col-lg-5 mt-4 mt-lg-0" data-aos="fade-left">
                    <?php if ($form_notice) : ?>
                        <div class="col-12 mb-3"><?php echo $form_notice; ?></div>
                    <?php endif; ?>
                    <div class="card p-4 shadow-lg">
                        <h4 class="card-title text-center fw-bold" style="color: var(--primary-color); "><?php echo esc_html($contact['form_title']); ?></h4>
                        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="needs-validation" novalidate>
                            <input type="hidden" name="action" value="central_build_form_submit" />
                            <input type="hidden" name="form_id" value="commercial_stripout" />
                            <?php wp_nonce_field('central_build_form_submit', 'central_build_form_nonce'); ?>
                            <div class="mb-3">
                                <input type="text" class="form-control" name="full_name" placeholder="<?php esc_attr_e('Your Name', 'central-build'); ?>" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control" name="email" placeholder="<?php esc_attr_e('Work Email', 'central-build'); ?>" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control" name="project_size" placeholder="<?php esc_attr_e('Project Size (m²)', 'central-build'); ?>">
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" name="message" rows="3" placeholder="<?php esc_attr_e('Additional project details', 'central-build'); ?>"></textarea>
                            </div>
                            <button type="submit" class="btn btn-dark w-100 btn-lg fw-bold" style="background-color: var(--primary-color); "><?php echo esc_html($contact['button_label']); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    (function(){
        const counters = document.querySelectorAll('.stat-number[data-count]');
        counters.forEach(counter => {
            const target = +counter.dataset.count;
            if (!target) { return; }
            const speed = 200;
            const updateCount = () => {
                const count = parseInt(counter.textContent, 10) || 0;
                const inc = Math.max(1, Math.ceil(target / speed));
                if (count < target) {
                    counter.textContent = count + inc;
                    requestAnimationFrame(updateCount);
                } else {
                    counter.textContent = target;
                }
            };
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        updateCount();
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });
            observer.observe(counter);
        });
    })();
</script>

<?php get_footer(); ?>