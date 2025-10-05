<?php
/**
 * The front page template file
 *
 * This is the template that displays the front page.
 *
 * @package Central_Build_Pro
 * @since 1.0.0
 */

get_header(); ?>
<style>
    /* Custom CSS: Integrated Advantage Style (Inherited) */
    :root {
        --primary-color: #FB7F28; /* Deep Navy/Charcoal */
        --accent-color:rgb(221, 165, 25);  /* Metallic Bronze/Gold */
        --light-bg: #F4F7F9;
        --dark-text: #212529;
        --light-text: #FFFFFF;
        
        /* Service Specific Colors */
        --cyan-coordination: #00BCD4;
        --yellow-stripout: #FFC300;
        --red-maintenance: #E53935;
    }
    
    /* Hero Section */
    .hero-section {
        /* ... (CSS giữ nguyên) ... */
        height: 95vh;
        background-color: var(--primary-color);
        color: var(--light-text);
        display: flex;
        align-items: center;
        background-image: url('path/to/high-impact-construction-video-cover.jpg');
        background-size: cover;
        position: relative;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(26, 46, 68, 0.75);
    }
    
    .cta-button-gold {
        background-color: var(--accent-color);
        border: 2px solid var(--accent-color);
        color: var(--dark-text);
        font-weight: 700;
        padding: 15px 40px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(184, 134, 11, 0.4);
    }
    .cta-button-gold:hover {
        background-color: #9d7009;
        border-color: #9d7009;
        color: var(--light-text);
    }

    /* Value Proposition Boxes */
    .value-box {
        padding: 30px;
        background-color: var(--light-text);
        border-top: 5px solid var(--primary-color);
        height: 100%;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        transition: border-color 0.3s ease;
    }
    .value-box:hover {
        border-top-color: var(--accent-color);
    }
    .value-icon {
        color: var(--accent-color);
        font-size: 3rem;
    }
    
    /* Services Overview Tiles */
    .service-tile {
        position: relative;
        height: 350px;
        overflow: hidden;
        text-align: center;
        color: var(--light-text);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        transition: transform 0.3s ease;
    }
    .service-tile:hover {
        transform: translateY(-5px);
    }
    .tile-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        transition: background-color 0.3s ease;
    }
    .service-tile:hover .tile-overlay {
        background-color: rgba(0, 0, 0, 0.7);
    }
    .tile-content {
        position: relative;
        z-index: 10;
    }
    .tile-icon {
        font-size: 3.5rem;
        margin-bottom: 15px;
    }
    .tile-fitout { background-color: var(--primary-color); }
    .tile-coordination { background-color: #1A3E4E; border: 5px solid var(--cyan-coordination); }
    .tile-stripout { background-color: #44371A; border: 5px solid var(--yellow-stripout); }
    .tile-maintenance { background-color: #441A1A; border: 5px solid var(--red-maintenance); }
    
    /* Project Card */
    .project-card {
        border: none;
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    .project-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15)!important;
    }
    .project-img {
        height: 220px;
        object-fit: cover;
    }

    /* Testimonial Section */
    .testimonial-block {
        background-color: var(--primary-color);
        color: var(--light-text);
        padding: 40px;
        border-radius: 8px;
        height: 100%;
        position: relative;
    }
    .quote-icon {
        color: var(--accent-color);
        font-size: 2.5rem;
        opacity: 0.5;
        position: absolute;
        top: 15px;
        left: 20px;
    }

    /* FAQ Section */
    .accordion-button:not(.collapsed) {
        color: var(--light-text);
        background-color: var(--primary-color);
        box-shadow: none;
    }
    .accordion-button {
        font-weight: bold;
    }
    .accordion-body {
        background-color: var(--light-bg);
    }

    /* Integrated Advantage Section & Trust Signals (CSS giữ nguyên) */
    .integrated-section { background-color: var(--light-bg); }
    .integrated-panel.cb-model { background-color: var(--primary-color); color: var(--light-text); }
    .integrated-panel.traditional-model { background-color: var(--light-text); color: var(--dark-text); border: 1px solid #ddd; }
    .metric-number { font-size: 2.5rem; font-weight: 900; color: var(--accent-color); }
    .metric-box { border: 1px solid var(--accent-color); }

</style>

<main id="primary" class="site-main">
    
    <?php
        // Hero/Start Section
        if (get_option('central_build_show_hero_section', true)) :
            loadView(get_template_directory() . '/template-parts/components/start-section.php');
        endif;
    ?>

    <?php
        loadView(get_template_directory() . '/template-parts/components/about-us-section.php');
    ?>

    <?php
        // Trust Process Section
        if (get_option('central_build_show_trust_section', true)) :
            loadView(get_template_directory() . '/template-parts/components/trust-section.php');
        endif;
    ?>

    <?php
    // Featured Projects Section
    if (get_option('central_build_show_projects_section', true)) :
        loadView(get_template_directory() . '/template-parts/components/featured-projects-section.php');
    endif;
    ?>

    
    <?php
    // About/Aware Section
    if (get_option('central_build_show_about_section', true)) :
        loadView(get_template_directory() . '/template-parts/components/aware-section.php');
    endif;
    ?>



    <?php
    // Partners Section
    if (get_option('central_build_show_partners_section', true)) :
        loadView(get_template_directory() . '/template-parts/components/partners-section.php');
    endif;
    ?>

    <?php
    // Testimonials Section
    if (get_option('central_build_show_testimonials_section', true)) :
        loadView(get_template_directory() . '/template-parts/components/testimonials-section.php');
    endif;
    ?>

    <?php
    // Commercial Fitout Sectors Section
    if (get_option('central_build_show_commercial_section', true)) :
        loadView(get_template_directory() . '/template-parts/components/commercial-section.php');
    endif;
    ?>

    <?php
    // CTA/Checkout Section
    loadView(get_template_directory() . '/template-parts/components/fitout-sector-section.php');
    ?>

    <?php
    // Cta Section
    loadView(get_template_directory() . '/template-parts/components/cta-section.php');
    ?>

    <?php
    // FAQ Section
    loadView(get_template_directory() . '/template-parts/components/faq-section.php');
    ?>
    
   <section id="contact" class="py-5 py-md-5" style="background-color: var(--light-bg);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                    <h2 class="display-5 fw-bolder mb-3" style="color: var(--primary-color);">READY TO EXPERIENCE THE <span style="color: var(--accent-color);">INTEGRATED ADVANTAGE?</span></h2>
                    <p class="lead mb-4 fw-light">Stop settling for fragmented service. Partner with Central Build for guaranteed control and transparent results on your next commercial project.</p>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="card p-4 shadow-lg">
                        <h4 class="card-title text-center fw-bold" style="color: var(--primary-color);">Project Kick-off Form (Fast Response)</h4>
                        <form>
                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="Your Full Name" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control" placeholder="Work Email" required>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <select class="form-select" required>
                                        <option selected disabled>Project Type*</option>
                                        <option>Commercial Fitout</option>
                                        <option>Commercial Stripout</option>
                                        <option>Services Coordination</option>
                                        <option>Maintenance Contract</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Estimated Size (m²)" required>
                                </div>
                            </div>
                            <button type="submit" class="btn cta-button-gold w-100 btn-lg">REQUEST A CONSULTATION</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </main>
<?php
get_footer();
?>