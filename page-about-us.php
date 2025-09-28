<?php
/**
 * Template Name: About Us Page
 * 
 * @package Central_Build_Pro
 * @since 1.0.0
 */

get_header();

// Get contact settings with fallbacks
$contact_hero_title = get_option('central_build_contact_hero_title', 'let\'s work <span>together</span>');
$contact_hero_description = get_option('central_build_contact_hero_description', 'Reach out to Central Build to start your journey. Whether you\'re looking for a bespoke design, a seamless build, or expert advice, we\'re here to help make your vision a reality. Let\'s create something exceptional together.');

$contact_email = get_option('central_build_contact_email', 'info@centralbuild.au');
$contact_phone = get_option('central_build_contact_phone', 'tel:0123456789');
$contact_phone_display = get_option('central_build_contact_phone_display', '0123 456 789');

$contact_facebook = get_option('central_build_contact_facebook', 'https://www.facebook.com/p/ENP-Fitouts-100079118888496/');
$contact_instagram = get_option('central_build_contact_instagram', 'https://www.instagram.com/enpfitouts');
$contact_linkedin = get_option('central_build_contact_linkedin', 'https://in.linkedin.com/');

$contact_form_title = get_option('central_build_contact_form_title', 'We\'re here to help');
$contact_form_description = get_option('central_build_contact_form_description', 'Tell us about your project & goals!');
$contact_form_redirect = get_option('central_build_contact_form_redirect', '/thank-you');

$contact_office_image = get_option('central_build_contact_office_image', 'https://static1.squarespace.com/static/6176ce05013c5128c1ff5aa8/6194da83ea54f441cdb5a7de/64d3736437d050544f081ff3/1707218367383/Construction-recruitment+-+dayin+the+life.jpg?format=1500w');
$contact_office_title = get_option('central_build_contact_office_title', 'Visit Our Offices');
$contact_office_description = get_option('central_build_contact_office_description', 'Central Build is your trusted partner for exceptional commercial fitouts. Visit us to discuss your project and explore our tailored solutions.');
$contact_office_location = get_option('central_build_contact_office_location', 'Office in Brisbane');
$contact_office_country = get_option('central_build_contact_office_country', 'Australia');
?>

<div class="contact-three">
    <!-- Hero Section -->
    <section class="hero-section text-center d-flex align-items-center">
    <div class="container">
    <h1 class="fw-bold display-4">We Are Central Build</h1>
    <p class="lead w-75 mx-auto">
    A specialized commercial contractor delivering outstanding results in interior fit-outs. Precision, efficiency, and excellence are at the heart of everything we do.
    </p>
    </div>
    </section>


    <!-- Mission & Vision -->
    <section class="py-5">
    <div class="container text-center">
    <h2 class="fw-bold text-uppercase text-primary mb-4">Mission & Vision</h2>
    <div class="row g-4">
    <div class="col-md-6">
    <div class="p-4 shadow-sm rounded bg-light h-100">
    <i class="bi bi-bullseye fs-2 text-primary mb-3"></i>
    <h5 class="fw-bold">Our Mission</h5>
    <p class="text-muted">To deliver exceptional commercial construction services with precision, safety, and quality while building trust and long-term relationships with our clients.</p>
    </div>
    </div>
    <div class="col-md-6">
    <div class="p-4 shadow-sm rounded bg-light h-100">
    <i class="bi bi-eye fs-2 text-primary mb-3"></i>
    <h5 class="fw-bold">Our Vision</h5>
    <p class="text-muted">To become a leading commercial contractor recognized for innovation, sustainability, and creating inspiring spaces that add lasting value.</p>
    </div>
    </div>
    </div>
    </div>
    </section>


    <!-- Core Values -->
    <section class="py-5 bg-light">
    <div class="container text-center mb-5">
    <h2 class="fw-bold text-uppercase text-primary">Our Core Values</h2>
    </div>
    <div class="container">
    <div class="row g-4 text-center">
    <div class="col-md-3">
    <i class="bi bi-shield-check fs-1 text-primary mb-2"></i>
    <h6 class="fw-bold">Integrity</h6>
    </div>
    <div class="col-md-3">
    <i class="bi bi-lightbulb-fill fs-1 text-primary mb-2"></i>
    <h6 class="fw-bold">Innovation</h6>
    </div>
    <div class="col-md-3">
    <i class="bi bi-tree-fill fs-1 text-primary mb-2"></i>
    <h6 class="fw-bold">Sustainability</h6>
    </div>
    <div class="col-md-3">
    <i class="bi bi-people-fill fs-1 text-primary mb-2"></i>
    <h6 class="fw-bold">Client-Centric</h6>
    </div>
    </div>
    </div>
    </section>


    <!-- About Philosophy -->
    <section class="py-5">
    <div class="container">
    <div class="row align-items-center g-5">
    <div class="col-md-6">
    <img src="https://images.unsplash.com/photo-1556761175-4b46a572b786" class="img-fluid rounded shadow" alt="About Us">
    </div>
    <div class="col-md-6">
    <h2 class="fw-bold text-primary mb-3">Who We Are</h2>
    <p class="text-muted mb-4">
    Central Build is formed by a dedicated team of professionals, bringing together passion and expertise to deliver commercial projects with the highest standards of design, safety, and quality control.
    </p>
    <p class="text-muted">
    Our commitment to fulfilling promises and nurturing trust forms the cornerstone of our philosophy. True reputation is built not by chance, but through unwavering attention to detail, where every element contributes to lasting value.
    </p>
    </div>
    </div>
    </section>

    <!-- Services -->
<section class="py-5">
<div class="container text-center mb-5">
<h2 class="fw-bold text-uppercase text-primary">Our Services</h2>
<p class="text-muted">Comprehensive commercial solutions tailored to your needs.</p>
</div>
<div class="container">
<div class="row g-4">
<div class="col-md-4">
<div class="service-box card h-100 shadow-sm border-0 p-4 text-center">
<i class="bi bi-palette-fill fs-2 text-primary mb-3"></i>
<h5 class="fw-bold"><a href="/interior-design-construction">Interior Design & Construction</a></h5>
</div>
</div>
<div class="col-md-4">
<div class="service-box card h-100 shadow-sm border-0 p-4 text-center">
<i class="bi bi-building fs-2 text-primary mb-3"></i>
<h5 class="fw-bold"><a href="/commercial-fitouts">Commercial Fitouts</a></h5>
</div>
</div>
<div class="col-md-4">
<div class="service-box card h-100 shadow-sm border-0 p-4 text-center">
<i class="bi bi-diagram-3-fill fs-2 text-primary mb-3"></i>
<h5 class="fw-bold"><a href="/services-coordination">Services Coordination</a></h5>
</div>
</div>
<div class="col-md-6">
<div class="service-box card h-100 shadow-sm border-0 p-4 text-center">
<i class="bi bi-trash2-fill fs-2 text-primary mb-3"></i>
<h5 class="fw-bold"><a href="/commercial-stripout">Commercial Stripout</a></h5>
</div>
</div>
<div class="col-md-6">
<div class="service-box card h-100 shadow-sm border-0 p-4 text-center">
<i class="bi bi-tools fs-2 text-primary mb-3"></i>
<h5 class="fw-bold"><a href="/repairs-and-maintenance">Repairs & Maintenance</a></h5>
</div>
</div>
</div>
</div>
</section>

</div>

<?php get_footer(); ?>