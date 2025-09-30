<?php
/**
 * Template Name: commercial-fitout-specialists Page
 *
 * @package Central_Build_Pro
 * @since 1.0.0
 */

if (!function_exists('central_build_get_cfs_settings')) {
    require_once get_template_directory() . '/inc/commercial-fitout-specialists-settings.php';
}

$settings    = central_build_get_cfs_settings();
$hero        = $settings['hero'];
$stats       = $settings['stats'];
$pillars     = $settings['pillars'];
$inhouse     = $settings['inhouse'];
$case_study  = $settings['case_study'];
$journey     = $settings['journey'];
$final_cta   = $settings['final_cta'];
$form_notice = central_build_form_feedback_notice('commercial_fitout_specialists');

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
<style>
    .hero-section {
        min-height: 90vh;
        background-color: var(--dark-text);
        color: var(--light-text);
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }
    .hero-section::after {
        content: "";
        position: absolute;
        inset: 0;
        background: url('<?php echo esc_url($hero['background']); ?>') center/cover no-repeat;
        opacity: .35;
        z-index: 0;
    }
    .hero-section > * { position: relative; z-index: 1; }
    .cta-button-accent {
        background-color: var(--accent-color);
        border: 2px solid var(--accent-color);
        color: var(--dark-text);
        font-weight: 700;
        padding: 12px 35px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(255, 107, 0, 0.4);
    }
    .cta-button-accent:hover {
        background-color: #e05e00;
        border-color: #e05e00;
        color: var(--light-text);
    }
    .stat-box {
        background-color: var(--primary-color);
        color: var(--light-text);
        border-radius: 10px;
        padding: 30px;
        height: 100%;
        transition: transform 0.3s ease;
    }
    .stat-box:hover { transform: translateY(-5px); background-color: #2a4968; }
    .stat-number { font-size: 3.5rem; font-weight: 900; color: white; line-height: 1; }
    .in-house-feature { background-color: var(--light-bg); border-left: 5px solid var(--accent-color); padding: 20px; transition: all 0.3s ease; height: 100%; }
    .in-house-feature:hover { background-color: #E8EDF1; }
    .process-step-icon { font-size: 2.5rem; color: var(--accent-color); }
    .final-cta-jumbotron { background-color: var(--accent-color); color: var(--dark-text); padding: 60px 0; }
</style>
<main id="primary" class="site-main">
    <section class="hero-section" id="home">
        <div class="container py-5 py-lg-6">
            <div class="row">
                <div class="col-lg-8" data-aos="fade-right">
                    <?php if (!empty($hero['badge'])) : ?>
                        <p class="text-uppercase fw-normal mb-2" style="color: var(--accent-color); "><?php echo esc_html($hero['badge']); ?></p>
                    <?php endif; ?>
                    <h1 class="display-3 fw-bolder mb-4"><?php echo wp_kses_post($hero['title']); ?></h1>
                    <p class="lead mb-4 opacity-75"><?php echo wp_kses_post($hero['description']); ?></p>
                    <?php if (!empty($hero['cta']['label'])) : ?>
                        <a href="<?php echo esc_url($hero['cta']['url']); ?>" class="btn cta-button-accent btn-lg me-3 pulse-animation"><?php echo esc_html($hero['cta']['label']); ?></a>
                    <?php endif; ?>
                    </div>
            </div>
        </div>
    </section>

    <?php if (!empty($stats)) : ?>
    <section id="stats" class="py-5 py-md-5" style="background-color: var(--light-bg);">
        <div class="container">
                <h2 class="text-center display-6 fw-normal mb-5" data-aos="fade-down"><?php esc_html_e('Driven by Data. Built on Trust.', 'central-build'); ?></h2>
            <div class="row g-4">
                    <?php foreach ($stats as $index => $stat) : ?>
                <div class="col-md-4">
                            <div class="stat-box text-center" data-aos="fade-up" data-aos-delay="<?php echo esc_attr(($index + 1) * 100); ?>">
                                <div class="d-flex align-items-center justify-content-center">
                                    <i class="<?php echo esc_attr($stat['icon']); ?> fa-3x mb-3" style="color: var(--accent-color);"></i>
                                    <div class="stat-number" data-count="<?php echo esc_attr($stat['number']); ?>">0</div>
                                    <?php if ($stat['suffix']) : ?>
                                        <span class="lead d-block fw-bold"><?php echo esc_html($stat['suffix']); ?></span>
                                    <?php endif; ?>
                    </div>
                                <p class="lead fw-normal mb-0"><?php echo esc_html($stat['label']); ?></p>
                    </div>
                </div>
                    <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if (!empty($pillars)) : ?>
    <section id="pillars" class="py-5 py-md-5">
        <div class="container">
                <h2 class="text-center display-6 fw-normal mb-5" data-aos="fade-down"><?php esc_html_e('The Three Pillars of Central Build', 'central-build'); ?></h2>
                <ul class="nav nav-tabs nav-fill mb-4" role="tablist" data-aos="fade-up">
                    <?php foreach ($pillars as $index => $pillar) :
                        $tab_id = 'cfs-pillar-' . $index; ?>
                <li class="nav-item" role="presentation">
                            <button class="nav-link <?php echo $index === 0 ? 'active' : ''; ?> fw-normal text-uppercase" data-bs-toggle="pill" data-bs-target="#<?php echo esc_attr($tab_id); ?>" type="button" role="tab">
                                <?php echo esc_html($pillar['title']); ?>
                            </button>
                </li>
                    <?php endforeach; ?>
            </ul>
                <div class="tab-content border p-4 rounded shadow-sm" data-aos="fade-up" data-aos-delay="300">
                    <?php foreach ($pillars as $index => $pillar) :
                        $tab_id = 'cfs-pillar-' . $index; ?>
                        <div class="tab-pane fade <?php echo $index === 0 ? 'show active' : ''; ?>" id="<?php echo esc_attr($tab_id); ?>" role="tabpanel">
                            <h3 class="fw-normal mb-3" style="color: var(--primary-color); "><?php echo esc_html($pillar['heading']); ?></h3>
                            <p><?php echo wp_kses_post($pillar['description']); ?></p>
                </div>
                    <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if (!empty($inhouse)) : ?>
    <section id="inhouse" class="py-5 py-md-5 bg-dark" style="color: var(--light-text);">
        <div class="container">
                <h2 class="text-center display-6 fw-normal mb-5" data-aos="fade-down"><?php esc_html_e('We Own the Process: Our In-House Teams', 'central-build'); ?></h2>
            <div class="row g-4">
                    <?php foreach ($inhouse as $index => $unit) : ?>
                        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="<?php echo esc_attr(($index + 1) * 100); ?>">
                    <div class="in-house-feature" style="background-color: #333; color: var(--light-text);">
                                <i class="<?php echo esc_attr($unit['icon']); ?> fa-2x mb-3" style="color: var(--accent-color); "></i>
                                <h4 class="fw-bold"><?php echo esc_html($unit['title']); ?></h4>
                                <p><?php echo wp_kses_post($unit['description']); ?></p>
                                <?php if ($unit['image']) : ?>
                                    <img src="<?php echo esc_url($unit['image']); ?>" class="img-fluid rounded mt-3" alt="<?php echo esc_attr($unit['title']); ?>" loading="lazy">
                                <?php endif; ?>
                    </div>
                </div>
                    <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <section id="case-study" class="py-5 py-md-5" style="background-color: var(--light-bg);">
        <div class="container">
            <h2 class="text-center display-6 fw-normal mb-5" data-aos="fade-down"><?php echo esc_html($case_study['title']); ?></h2>
            <div class="card p-4 shadow-lg border-0" data-aos="zoom-in">
                <div class="row g-0">
                    <div class="col-md-5">
                        <img src="<?php echo esc_url($case_study['image']); ?>" class="img-fluid rounded-start h-100 object-fit-cover" alt="<?php echo esc_attr($case_study['title']); ?>" loading="lazy">
                    </div>
                    <div class="col-md-7 p-4">
                        <h3 class="fw-normal mb-3" style="color: var(--primary-color); "><?php echo esc_html($case_study['challenge']); ?></h3>
                        <p class="lead"><?php echo wp_kses_post($case_study['intro']); ?></p>
                        <?php if (!empty($case_study['solutions'])) : ?>
                            <h4 class="mt-4 fw-bold"><?php esc_html_e('The Central Build Solution', 'central-build'); ?></h4>
                        <ul class="list-unstyled">
                                <?php foreach ($case_study['solutions'] as $solution) : ?>
                                    <li><i class="fas fa-check-circle me-2" style="color: var(--accent-color); "></i> <?php echo wp_kses_post($solution); ?></li>
                                <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                        <h4 class="mt-4 fw-bold"><?php echo esc_html($case_study['result_heading']); ?></h4>
                        <div class="progress mb-2" style="height: 30px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: <?php echo esc_attr($case_study['progress_value']); ?>%; background-color: var(--accent-color);" aria-valuenow="<?php echo esc_attr($case_study['progress_value']); ?>" aria-valuemin="0" aria-valuemax="100"><?php echo esc_html($case_study['progress_label']); ?></div>
                        </div>
                        <p class="text-muted fst-italic"><?php echo wp_kses_post($case_study['result_text']); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if (!empty($journey)) : ?>
    <section id="journey" class="py-5 py-md-5">
        <div class="container">
                <h2 class="text-center display-6 fw-normal mb-5" data-aos="fade-down"><?php esc_html_e('The Seamless Client Journey', 'central-build'); ?></h2>
            <div class="row g-4 text-center">
                    <?php foreach ($journey as $index => $step) : ?>
                        <div class="col-md-3" data-aos="fade-right" data-aos-delay="<?php echo esc_attr(($index + 1) * 100); ?>">
                            <i class="<?php echo esc_attr($step['icon']); ?> process-step-icon mb-3"></i>
                            <h4 class="fw-bold"><?php echo esc_html($step['title']); ?></h4>
                            <p class="small"><?php echo wp_kses_post($step['description']); ?></p>
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
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="pill" href="#cfs-projects-all"><?php esc_html_e('All', 'central-build'); ?></a></li>
                    <?php foreach ($categories as $category) :
                        $tab = 'cfs-projects-' . sanitize_title($category); ?>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#<?php echo esc_attr($tab); ?>"><?php echo esc_html($category); ?></a></li>
                    <?php endforeach; ?>
                </ul>
                <div class="tab-content">
                    <div id="cfs-projects-all" class="tab-pane fade show active">
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
                        $tab = 'cfs-projects-' . sanitize_title($category); ?>
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
                <div class="text-center mt-5">
                    <a href="<?php echo esc_url(get_post_type_archive_link('fitout_sector')); ?>" class="btn cta-button-primary btn-lg"><?php esc_html_e('Request Full Portfolio', 'central-build'); ?></a>
                </div>
            <?php else : ?>
                <p class="text-center" data-aos="fade-up"><?php esc_html_e('No fitout projects available at the moment.', 'central-build'); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <section id="contact" class="final-cta-jumbotron">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7" data-aos="fade-right">
                    <h2 class="display-5 text-white fw-bolder mb-3"><?php echo wp_kses_post($final_cta['title']); ?></h2>
                    <p class="lead mb-4 text-white fw-bold"><?php echo wp_kses_post($final_cta['description']); ?></p>
                    <?php if ($final_cta['contact']) : ?>
                        <p class="fw-bold text-white"><?php echo esc_html($final_cta['contact']); ?></p>
                    <?php endif; ?>
                </div>
                <div class="col-lg-5 mt-4 mt-lg-0" data-aos="fade-left">
                    <?php if ($form_notice) : ?>
                        <div class="col-12 mb-3"><?php echo $form_notice; ?></div>
                    <?php endif; ?>
                    <div class="card p-4 shadow-lg">
                        <h4 class="card-title text-center fw-bold" style="color: var(--primary-color); "><?php echo esc_html($final_cta['form_title']); ?></h4>
                        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="needs-validation" novalidate>
                            <input type="hidden" name="action" value="central_build_form_submit" />
                            <input type="hidden" name="form_id" value="commercial_fitout_specialists" />
                            <?php wp_nonce_field('central_build_form_submit', 'central_build_form_nonce'); ?>
                            <div class="mb-3">
                                <input type="text" class="form-control" name="full_name" placeholder="<?php esc_attr_e('Your Name', 'central-build'); ?>" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control" name="email" placeholder="<?php esc_attr_e('Work Email', 'central-build'); ?>" required>
                            </div>
                            <div class="mb-3">
                                <input type="tel" class="form-control" name="phone" placeholder="<?php esc_attr_e('Phone Number', 'central-build'); ?>">
                            </div>
                            <button type="submit" class="btn btn-dark w-100 btn-lg fw-bold" style="background-color: var(--primary-color); "><?php echo esc_html($final_cta['button_label']); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script>
    const counters = document.querySelectorAll('.stat-number[data-count]');
    counters.forEach(counter => {
        const target = +counter.dataset.count;
        if (!target) { return; }
        const speed = 200;
        const updateCount = () => {
            const count = +counter.innerText;
            const inc = Math.max(1, Math.ceil(target / speed));
            if (count < target) {
                counter.innerText = count + inc;
                requestAnimationFrame(updateCount);
            } else {
                counter.innerText = target;
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
</script>
<?php get_footer(); ?>