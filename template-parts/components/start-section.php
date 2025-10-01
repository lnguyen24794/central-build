<!-- Hero/Start Section -->
<section class="about-two-hero-section" data-aos="fade-up" data-aos-duration="900">
    <div class="w-layout-blockcontainer container-one about-two-hero-container w-container">
        <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
            <h1 class="display-3 fw-bolder mb-3">COMMERCIAL CONSTRUCTION. <br> <span style="color: var(--accent-color);">RELIABILITY ENGINEERED.</span></h1>
            <p class="lead mb-4 fw-bold" style="color: var(--accent-color);">We are Central Build: The Vertically Integrated Partner.</p>
            <p class="mb-5 fs-5 opacity-85 col-lg-8 text-white">Eliminate risk, cut coordination delays, and guarantee compliance with a single, accountable in-house team managing your entire project lifecycle.</p>
            <a href="#contact" class="btn cta-button-gold btn-lg shadow-lg" data-aos="zoom-in" data-aos-delay="150">START YOUR PROJECT CONSULTATION</a>
        </div>
    </div>
    <div class="about-two-hero-overlay" data-aos="fade-in" data-aos-delay="50"></div>
</section>

<?php
$form_id = 'front_page';
$notice = central_build_form_feedback_notice($form_id);
?>
<section class="start-form-section py-5" data-aos="fade-up" data-aos-delay="200">
    <div class="container">
        <?php if ($notice) : ?>
            <div class="row justify-content-center mb-4">
                <div class="col-lg-8"><?php echo $notice; ?></div>
            </div>
        <?php endif; ?>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="card shadow-lg p-4 border-0" data-aos="fade-up" data-aos-delay="250" novalidate>
                    <input type="hidden" name="action" value="central_build_form_submit" />
                    <input type="hidden" name="form_id" value="<?php echo esc_attr($form_id); ?>" />
                    <?php wp_nonce_field('central_build_form_submit', 'central_build_form_nonce'); ?>
                    <div class="mb-3">
                        <label class="form-label fw-bold" for="cb-start-full-name"><?php esc_html_e('Full Name', 'central-build'); ?></label>
                        <input type="text" class="form-control" id="cb-start-full-name" name="full_name" placeholder="<?php esc_attr_e('Your Full Name', 'central-build'); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold" for="cb-start-email"><?php esc_html_e('Work Email', 'central-build'); ?></label>
                        <input type="email" class="form-control" id="cb-start-email" name="email" placeholder="<?php esc_attr_e('Work Email', 'central-build'); ?>" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold" for="cb-start-project-type"><?php esc_html_e('Project Type', 'central-build'); ?></label>
                            <select class="form-select" id="cb-start-project-type" name="project_type" required>
                                <option value="" selected disabled><?php esc_html_e('Select a Project Type', 'central-build'); ?></option>
                                <option value="commercial_fitout"><?php esc_html_e('Commercial Fitout', 'central-build'); ?></option>
                                <option value="commercial_stripout"><?php esc_html_e('Commercial Stripout', 'central-build'); ?></option>
                                <option value="services_coordination"><?php esc_html_e('Services Coordination', 'central-build'); ?></option>
                                <option value="maintenance_contract"><?php esc_html_e('Maintenance Contract', 'central-build'); ?></option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold" for="cb-start-project-size"><?php esc_html_e('Estimated Size (m²)', 'central-build'); ?></label>
                            <input type="text" class="form-control" id="cb-start-project-size" name="project_size" placeholder="<?php esc_attr_e('e.g., 500 m²', 'central-build'); ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold" for="cb-start-message"><?php esc_html_e('Project Details', 'central-build'); ?></label>
                        <textarea class="form-control" id="cb-start-message" name="message" rows="4" placeholder="<?php esc_attr_e('Tell us about your project', 'central-build'); ?>"></textarea>
                    </div>
                    <button type="submit" class="btn cta-button-gold w-100 btn-lg" data-aos="zoom-in" data-aos-delay="300"><?php esc_html_e('Request a Consultation', 'central-build'); ?></button>
                </form>
            </div>
        </div>
    </div>
</section>