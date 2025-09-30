<?php
/**
 * Template Name: Services Coordination Page
 *
 * @package Central_Build_Pro
 * @since 1.0.0
 */

if (!function_exists('central_build_get_sc_settings')) {
    require_once get_template_directory() . '/inc/services-coordination-settings.php';
}

$settings = central_build_get_sc_settings();
$hero     = $settings['hero'];
$problems = $settings['problems'];
$methodology = $settings['methodology'];
$bim      = $settings['bim'];
$metrics  = $settings['metrics'];
$contact  = $settings['contact'];
$show_projects = $settings['show_projects'];
$form_notice = central_build_form_feedback_notice('services_coordination');

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
    /* Hero Section */
    .hero-section {
        height: 90vh;
        background-color: var(--primary-color);
        color: var(--light-text);
        display: flex;
        align-items: center;
    }

    /* Problem Box Styling */
    .problem-box {
        border-left: 5px solid var(--warning-color);
        padding: 20px;
        background-color: var(--light-bg);
        height: 100%;
        transition: transform 0.3s ease;
    }
    .problem-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    /* Triple Check Steps */
    .check-step {
        padding: 20px;
        background-color: var(--light-bg);
        border-radius: 8px;
        border-bottom: 4px solid var(--accent-color);
    }

    /* Metrics Styling */
    .metric-box {
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 8px;
        background-color: var(--light-text);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    .metric-number {
        font-size: 2.5rem;
        font-weight: 900;
        color: var(--accent-color);
    }
    
    /* BIM Section */
    .bim-image-placeholder {
        height: 400px;
        background-color: #eee;
        /* Placeholder for complex BIM diagram */
        background-image: url("path/to/bim-clash-detection-diagram.jpg"); 
        background-size: cover;
        border-radius: 8px;
    }
</style>

<main id="primary" class="site-main">
    <section class="hero-section" id="home">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center" data-aos="fade-up" data-aos-duration="1200">
                    <?php if (!empty($hero['badge'])) : ?>
                        <p class="text-uppercase fw-normal mb-2 text-white" ><?php echo esc_html($hero['badge']); ?></p>
                    <?php endif; ?>
                    <h1 class="display-3 fw-bolder mb-3"><?php echo wp_kses_post($hero['title']); ?></h1>
                    <p class="lead mb-4 opacity-75"><?php echo wp_kses_post($hero['description']); ?></p>
                    <?php if (!empty($hero['cta']['label'])) : ?>
                        <a href="<?php echo esc_url($hero['cta']['url']); ?>" class="btn hero-button-2 w-50 btn-lg pulse-animation"><?php echo esc_html($hero['cta']['label']); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <?php if (!empty($problems)) : ?>
        <section id="problems" class="py-5 py-md-5">
            <div class="container">
                <h2 class="text-center display-6 fw-normal mb-5" data-aos="fade-down"><?php esc_html_e('The High Cost of Uncoordinated Builds', 'central-build'); ?></h2>
                <div class="row g-4">
                    <?php foreach ($problems as $index => $problem) : ?>
                        <div class="col-md-4">
                            <div class="problem-box" data-aos="fade-up" data-aos-delay="<?php echo esc_attr(($index + 1) * 100); ?>">
                                <i class="<?php echo esc_attr($problem['icon']); ?> fa-3x mb-3" style="color: var(--warning-color); "></i>
                                <h4 class="fw-bold" style="color: var(--primary-color); "><?php echo esc_html($problem['title']); ?></h4>
                                <p class="mb-0"><?php echo wp_kses_post($problem['description']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if (!empty($methodology)) : ?>
        <section id="methodology" class="py-5 py-md-5 bg-light">
            <div class="container">
                <h2 class="text-center display-6 fw-normal mb-5" data-aos="fade-down"><?php esc_html_e('Our Methodology: The Triple Check Control', 'central-build'); ?></h2>
                <div class="row g-4 text-center">
                    <?php foreach ($methodology as $index => $step) : ?>
                        <div class="col-md-4" data-aos="fade-right" data-aos-delay="<?php echo esc_attr(($index + 1) * 100); ?>">
                            <div class="check-step">
                                <?php if (!empty($step['step'])) : ?>
                                    <h1 class="display-3 fw-bolder mb-2 text-primary" ><?php echo esc_html($step['step']); ?></h1>
                                <?php endif; ?>
                                <i class="<?php echo esc_attr($step['icon']); ?> fa-3x mb-3" style="color: var(--primary-color); "></i>
                                <h4 class="fw-bold"><?php echo esc_html($step['title']); ?></h4>
                                <p><?php echo wp_kses_post($step['description']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section id="bim" class="py-5 py-md-5 bg-dark" style="color: var(--light-text);">
        <div class="container">
            <h2 class="text-center display-6 fw-normal mb-5" data-aos="fade-down"><?php echo esc_html($bim['title']); ?></h2>
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                    <?php if (!empty($bim['image'])) : ?>
                        <div class="shadow-lg" style="height: 100%; min-height: 320px; background: url('<?php echo esc_url($bim['image']); ?>') center/cover no-repeat; border-radius: 12px;"></div>
                    <?php endif; ?>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <p class="lead fw-bold text-white" ><?php echo esc_html($bim['subtitle']); ?></p>
                    <p><?php echo wp_kses_post($bim['description']); ?></p>
                    <?php if (!empty($bim['accordion'])) : ?>
                        <div class="accordion accordion-flush mt-4" id="bimAccordion">
                            <?php foreach ($bim['accordion'] as $i => $item) :
                                $collapse_id = 'collapse-bim-' . $i; ?>
                                <div class="accordion-item" style="background-color: #333; color: var(--light-text); border: none;">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button fw-normal collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo esc_attr($collapse_id); ?>" style="background-color: var(--primary-color); color: var(--light-text); ">
                                            <?php echo esc_html($item['heading']); ?>
                                        </button>
                                    </h2>
                                    <div id="<?php echo esc_attr($collapse_id); ?>" class="accordion-collapse collapse" data-bs-parent="#bimAccordion">
                                        <div class="accordion-body"><?php echo wp_kses_post($item['body']); ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <?php if (!empty($metrics)) : ?>
        <section id="metrics" class="py-5 py-md-5">
            <div class="container">
                <h2 class="text-center display-6 fw-normal mb-5" data-aos="fade-down"><?php esc_html_e('Measurable Value: Project KPIs', 'central-build'); ?></h2>
                <div class="row g-4 text-center">
                    <?php foreach ($metrics as $index => $metric) : ?>
                        <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?php echo esc_attr(($index + 1) * 100); ?>">
                            <div class="metric-box">
                                <div class="metric-number display-4 text-primary" data-count="<?php echo esc_attr($metric['number']); ?>"><?php echo esc_html($metric['number']); ?><?php echo esc_html($metric['suffix']); ?></div>
                                <p class="lead fw-normal mb-0"><?php echo esc_html($metric['label']); ?></p>
                                <p class="small text-muted"><?php echo wp_kses_post($metric['description']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($show_projects && !empty($projects)) : ?>
        <section id="portfolio" class="py-5 py-md-5 bg-dark" style="color: var(--light-text);">
            <div class="container">
                <h2 class="text-center display-5 fw-normal mb-5" data-aos="fade-up"><?php esc_html_e('Our Proven Projects', 'central-build'); ?></h2>
                <ul class="nav nav-pills justify-content-center mb-4" data-aos="fade-up" data-aos-delay="200">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="pill" href="#sc-projects-all"><?php esc_html_e('All', 'central-build'); ?></a></li>
                    <?php foreach ($categories as $category) :
                        $tab = 'sc-projects-' . sanitize_title($category); ?>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#<?php echo esc_attr($tab); ?>"><?php echo esc_html($category); ?></a></li>
                    <?php endforeach; ?>
                </ul>
                <div class="tab-content">
                    <div id="sc-projects-all" class="tab-pane fade show active">
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
                        $tab = 'sc-projects-' . sanitize_title($category); ?>
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

    <section id="contact" class="py-5 py-md-5" style="background-color: var(--primary-color); color: var(--light-text);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7" data-aos="fade-right">
                    <h2 class="display-5 fw-bolder mb-3 text-white" ><?php echo wp_kses_post($contact['heading']); ?></h2>
                    <p class="lead mb-4 fw-light"><?php echo wp_kses_post($contact['description']); ?></p>
                    <?php if (!empty($contact['contact_line'])) : ?>
                        <p class="fw-bold text-white" ><i class="fas fa-phone-alt me-2"></i> <?php echo esc_html($contact['contact_line']); ?></p>
                    <?php endif; ?>
                </div>
                <div class="col-lg-5 mt-4 mt-lg-0" data-aos="fade-left">
                    <?php if ($form_notice) : ?>
                        <div class="mb-3"><?php echo $form_notice; ?></div>
                    <?php endif; ?>
                    <div class="card p-4 shadow-lg">
                        <h4 class="card-title text-center fw-bold" style="color: var(--primary-color); "><?php echo esc_html($contact['form_title']); ?></h4>
                        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" novalidate>
                            <input type="hidden" name="action" value="central_build_form_submit" />
                            <input type="hidden" name="form_id" value="services_coordination" />
                            <?php wp_nonce_field('central_build_form_submit', 'central_build_form_nonce'); ?>
                            <div class="mb-3">
                                <input type="text" class="form-control" name="full_name" placeholder="<?php esc_attr_e('Your Name', 'central-build'); ?>" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control" name="email" placeholder="<?php esc_attr_e('Work Email', 'central-build'); ?>" required>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" name="message" rows="3" placeholder="<?php esc_attr_e('Briefly describe your coordination challenge...', 'central-build'); ?>"></textarea>
                            </div>
                            <button type="submit" class="btn hero-button-2 w-100 btn-lg"><?php echo esc_html($contact['button_label']); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script>
    (function(){
        const metrics = document.querySelectorAll('.metric-number[data-count]');
        metrics.forEach(counter => {
            const target = +counter.dataset.count;
            if (!target) { return; }
            const speed = 200;
            const format = counter.textContent.trim().endsWith('%');
            const updateCount = () => {
                const current = parseInt(counter.textContent, 10) || 0;
                const increment = Math.max(1, Math.ceil(target / speed));
                if (current < target) {
                    counter.textContent = current + increment;
                    requestAnimationFrame(updateCount);
                } else {
                    counter.textContent = target;
                }
                if (format && !counter.textContent.endsWith('%')) {
                    counter.textContent += '%';
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