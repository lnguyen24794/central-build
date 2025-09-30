<?php
/**
 * Template Name: About Us Page
 *
 * @package Central_Build_Pro
 * @since 1.0.0
 */

if (!function_exists('central_build_get_about_settings')) {
    require_once get_template_directory() . '/inc/about-settings.php';
}

$about_settings = central_build_get_about_settings();

$hero       = $about_settings['hero'];
$mission    = $about_settings['mission'];
$vision     = $about_settings['vision'];
$philosophy = $about_settings['philosophy'];
$services   = $about_settings['services'];
$cta        = $about_settings['cta'];
$right      = $about_settings['right_column'];
$team       = $about_settings['team'];

get_header();
?>

<div class="contact-three">
    <!-- Hero Section -->
    <section class="hero-section text-center d-flex align-items-center">
        <div class="container position-relative" data-aos="fade-up" data-aos-duration="1200">
            <h1 class="display-3 fw-bolder mb-3 text-white"><?php echo wp_kses_post($hero['title']); ?></h1>
            <p class="lead mb-4 fw-bold" style="color: var(--accent-color);">The Central Build Story: Reliability Engineered.</p>
            <p class="mb-0 fs-5 opacity-75"><?php echo wp_kses_post($hero['description']); ?></p>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="py-5" style="margin-top: -100px">
        <div class="container text-center">
            <div class="row g-4">
                <div class="col-md-6" data-aos="fade-right">
                    <div class="p-4 shadow-sm rounded bg-light h-100">
                        <i class="bi bi-bullseye fs-2 text-primary mb-3"></i>
                        <h5 class="fw-bold"><?php echo esc_html($mission['title']); ?></h5>
                        <p class="text-muted"><?php echo wp_kses_post($mission['text']); ?></p>
                    </div>
                </div>
                <div class="col-md-6" data-aos="fade-left">
                    <div class="p-4 shadow-sm rounded bg-light h-100">
                        <i class="bi bi-eye fs-2 text-primary mb-3"></i>
                        <h5 class="fw-bold"><?php echo esc_html($vision['title']); ?></h5>
                        <p class="text-muted"><?php echo wp_kses_post($vision['text']); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Philosophy -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-md-6" data-aos="fade-right">
                    <img src="<?php echo esc_url($philosophy['image']); ?>" class="img-fluid rounded shadow" alt="<?php echo esc_attr($philosophy['heading']); ?>">
                </div>
                <div class="col-md-6" data-aos="fade-left">
                    <h2 class="fw-normal text-primary mb-3"><?php echo esc_html($philosophy['heading']); ?></h2>
                    <?php foreach ($philosophy['paragraphs'] as $paragraph) : ?>
                        <p class="text-muted mb-4"><?php echo wp_kses_post($paragraph); ?></p>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Services -->
    <section class="py-5 bg-light">
        <div class="container text-center mb-5">
            <h2 class="fw-normal text-uppercase text-primary" data-aos="fade-up"><?php esc_html_e('Our Services', 'central-build'); ?></h2>
            <p class="text-muted" data-aos="fade-up" data-aos-delay="100"><?php esc_html_e('Comprehensive commercial solutions tailored to your needs.', 'central-build'); ?></p>
        </div>
        <div class="container">
            <div class="row g-4">
                <?php foreach ($services as $index => $service) :
                    $title = trim($service['title']);
                    $url   = trim($service['url']);
                    if ($title === '') {
                        continue;
                    }
                    $col = $index < 3 ? 'col-md-4' : 'col-md-6';
                    ?>
                    <div class="<?php echo esc_attr($col); ?> animate__animated animate__backInRight" data-aos="fade-up" data-aos-delay="200">
                        <div class="service-box card h-100 shadow-sm border-0 p-4 text-center">
                            <?php if ($url) : ?>
                                <h5 class="fw-bold"><a href="<?php echo esc_url($url); ?>"><?php echo esc_html($title); ?></a></h5>
                            <?php else : ?>
                                <h5 class="fw-bold"><?php echo esc_html($title); ?></h5>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php
    if (get_option('central_build_show_projects_section', true)) {
        loadView(get_template_directory() . '/template-parts/components/featured-projects-section.php');
    }
?>

    <!-- Our Team Slider -->
    <?php if ($team['show']) : ?>
        <section class="py-5 bg-light" data-aos="fade-up" data-aos-delay="200">
            <div class="container text-center mb-5">
                <h2 class="fw-normal text-uppercase text-primary" data-aos="fade-up"><?php esc_html_e('Our Team', 'central-build'); ?></h2>
                <p class="text-muted" data-aos="fade-up" data-aos-delay="100"><?php esc_html_e('Meet the people behind our success', 'central-build'); ?></p>
            </div>
            <div class="container">
                <div class="w-layout-blockcontainer home-three-project-container w-container">
                    <div class="fitout-carousel-container">
                        <div class="fitout-carousel-track">
                            <?php
                        $members = $team['members'];
        if (!empty($members)) {
            $all_team = array_merge($members, $members);
            foreach ($all_team as $member) {
                $name  = $member['name'] ?? '';
                $role  = $member['role'] ?? '';
                $image = $member['image'] ?? '';
                ?>
                                    <div class="fitout-project-card" data-aos="fade-up" data-aos-delay="200">
                                        <div class="project-card-two w-inline-block">
                                            <div class="project-card-2">
                                                <?php if ($image) : ?>
                                                    <img class="home-three-project-img-2"
                                                        src="<?php echo esc_url($image); ?>"
                                                        width="600"
                                                        height="800"
                                                        alt="<?php echo esc_attr($name); ?>"
                                                        loading="lazy">
                                                <?php else : ?>
                                                    <div style="width:100%;height:400px;background:#e9ecef;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#666;">
                                                        <?php esc_html_e('No Image', 'central-build'); ?>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="project-overlay"></div>
                                            </div>
                                            <div class="home-three-project-text-box">
                                                <div class="heading-four-2 text-white"><?php echo esc_html($name); ?></div>
                                                <?php if ($role) : ?>
                                                    <div class="project-category text-white" style="font-size: 14px; opacity: 0.8; margin-top: 5px;">
                                                        <?php echo esc_html($role); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
            }
        }
?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
