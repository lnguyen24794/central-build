<?php
/**
 * Template Name: Contact Page
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
    <section class="contact-three-hero-section">
        <div class="w-layout-blockcontainer container-one w-container">
            <div class="w-layout-hflex contact-three-flex-block">
                <div class="contact-three-details-left contact-three-details-right">
                    <div
                        data-w-id="597b1aec-e5e4-5eff-75f2-81d170096b95"
                        class="w-layout-hflex contact-three-heading-wrap"
                        style="opacity: 1; transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg, 0deg); transform-style: preserve-3d;"
                    >
                        <div class="tag-wrap tag-type-four"><div class="tag dark-tab">Contacts</div></div>
                        <h1 class="text-white margin-none contact-three-hero-heading"><?php echo wp_kses($contact_hero_title, array('span' => array())); ?></h1>
                    </div>
                    <p class="text-light-grey">
                        <?php echo esc_html($contact_hero_description); ?>
                    </p>
                    <div class="w-layout-hflex contact-three-contact-main-wrap margin-top-thirty">
                        <div class="w-layout-vflex conatct-three-mail-wrap">
                            <img src="https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f57d53_icon%20(27).svg" loading="lazy" width="42" height="29" alt="" />
                            <div class="text-white margin-top-fifteen">Email Us:</div>
                            <a href="mailto:<?php echo esc_attr($contact_email); ?>" class="heading-six margin-none text-white text-lowarcase contact"><?php echo esc_html($contact_email); ?></a>
                        </div>
                        <div class="w-layout-vflex contact-three-call-wrap">
                            <img src="https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f57d56_Group.svg" loading="lazy" width="29" height="29" alt="" />
                            <div class="text-white margin-top-fifteen">Let's Talk:</div>
                            <a href="<?php echo esc_attr($contact_phone); ?>" class="heading-six margin-none text-white contact"><?php echo esc_html($contact_phone_display); ?></a>
                        </div>
                    </div>
                    <div class="w-layout-vflex contact-three-social-media-main-wrap">
                        <div class="text-white">Follow us:</div>
                        <div class="w-layout-hflex contact-three-social-media-link-wrap">
                            <?php if ($contact_facebook) : ?>
                            <a href="<?php echo esc_url($contact_facebook); ?>" target="_blank" class="contact-three-social-media-link w-inline-block">
                                <img src="https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f57d41_Social%20Media%20Icon%20(2).svg" loading="lazy" width="10" height="18" alt="Facebook Icon" />
                            </a>
                            <?php endif; ?>
                            
                            <?php if ($contact_instagram) : ?>
                            <a href="<?php echo esc_url($contact_instagram); ?>" target="_blank" class="contact-three-social-media-link w-inline-block">
                                <img src="https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f57b95_Instagram-Icon.webp" loading="lazy" width="18" height="18" alt="Instagram Icon" />
                            </a>
                            <?php endif; ?>
                            
                            <?php if ($contact_linkedin) : ?>
                            <a href="<?php echo esc_url($contact_linkedin); ?>" target="_blank" class="contact-three-social-media-link w-inline-block">
                                <img src="https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f57d3f_Social%20Media%20Icon%20(1).svg" loading="lazy" width="18" height="18" alt="LinkedIn Icon" />
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div
                    data-w-id="597b1aec-e5e4-5eff-75f2-81d170096bc7"
                    class="contact-three-form-block"
                    style="opacity: 1; transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg, 0deg); transform-style: preserve-3d;"
                >
                    <h2 class="margin-top-zero margin-bottom-twenty"><?php echo esc_html($contact_form_title); ?></h2>
                    <p class="margin-bottom-thirty-two"><?php echo esc_html($contact_form_description); ?></p>
                    <div class="w-form">
                        <form
                            id="email-form-3"
                            name="email-form-3"
                            data-name="Email Form 3"
                            redirect="<?php echo esc_attr($contact_form_redirect); ?>"
                            data-redirect="<?php echo esc_attr($contact_form_redirect); ?>"
                            method="get"
                            class="form"
                            data-wf-page-id="66f1ffecdef9310969f57a14"
                            data-wf-element-id="597b1aec-e5e4-5eff-75f2-81d170096bcd"
                            aria-label="Email Form 3"
                            data-hs-cf-bound="true"
                        >
                            <input class="contact-three-name-field w-input" maxlength="256" name="name-3" data-name="Name 3" placeholder="Name" type="text" id="Contact-Three-Name" required="" />
                            <input class="contact-three-name-field w-input" maxlength="256" name="email-3" data-name="Email 3" placeholder="Email" type="email" id="email-3" required="" />
                            <input class="contact-three-name-field w-input" maxlength="256" name="Number" data-name="Number" placeholder="Phone" type="text" id="Number" required="" />
                            <input class="contact-three-name-field w-input" maxlength="256" name="Project" data-name="Project" placeholder="Project" type="text" id="Project" />
                            <input class="contact-three-name-field w-input" maxlength="256" name="Commence-Date" data-name="Commence Date" placeholder="Commence Date + Finish Date" type="text" id="Commence-Date" />
                            <input class="contact-three-name-field w-input" maxlength="256" name="Test" data-name="Test" placeholder="7+2=?" type="number" id="Test" required="" />
                            <textarea id="field-6" name="field-6" maxlength="5000" data-name="Field 6" placeholder="Message" class="contact-three-name-field contact-three-textarea w-input"></textarea>
                            <input type="submit" data-wait="Please wait..." class="contact-one-form-submit-button contact-three-form w-button" value="enquire now" />
                        </form>
                        <div class="w-form-done" tabindex="-1" role="region" aria-label="Email Form 3 success"><div class="text-block-3">Thank you! Your submission has been received!</div></div>
                        <div class="w-form-fail" tabindex="-1" role="region" aria-label="Email Form 3 failure"><div>Oops! Something went wrong while submitting the form.</div></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="contact-three-slider-section">
        <div class="w-layout-blockcontainer container-one about-two-hero-container w-container">
            <div
                data-delay="3000"
                data-animation="cross"
                class="contact-three-slider w-slider"
                data-autoplay="true"
                data-easing="ease"
                data-hide-arrows="false"
                data-disable-swipe="false"
                data-autoplay-limit="0"
                data-nav-spacing="3"
                data-duration="1100"
                data-infinite="true"
                role="region"
                aria-label="carousel"
            >
                <div class="w-slider-mask" id="w-slider-mask-0">
                    <div data-w-id="d59e0206-fed2-94be-a8fa-59a18d95fc13" class="w-slide" aria-label="1 of 1" role="group" style="transition: all; transform: translateX(0px); opacity: 1;">
                        <div class="w-layout-hflex contact-three-slider-main-wrap">
                            <div class="contact-three-details-left-flex">
                                <img
                                    src="<?php echo esc_url($contact_office_image); ?>"
                                    sizes="(max-width: 767px) 100vw, 590px"
                                    alt="<?php echo esc_attr($contact_office_title); ?>"
                                    class="image-height-auto resoponsive-width-hunderd"
                                    style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg, 0deg); transform-style: preserve-3d;"
                                />
                            </div>
                            <div class="w-layout-vflex contact-three-slider-contain-wrap">
                                <img src="https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f57d42_Contact%20Three%20Slider%20Icon.svg" loading="lazy" width="45" height="45" alt="Contact Three Slider Icon" />
                                <div class="overflow-none">
                                    <h2 class="margin-top-thirty" style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg, 0deg); transform-style: preserve-3d; opacity: 1;">
                                        <?php echo esc_html($contact_office_title); ?>
                                    </h2>
                                </div>
                                <div class="overflow-none">
                                    <p class="margin-top-ten" style="opacity: 1; transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg, 0deg); transform-style: preserve-3d;">
                                        <?php echo esc_html($contact_office_description); ?>
                                    </p>
                                </div>
                                <div class="contact-three-slider-line"></div>
                                <div class="overflow-none">
                                    <div class="heading-four" style="opacity: 1; transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg, 0deg); transform-style: preserve-3d;">
                                        <?php echo esc_html($contact_office_location); ?>
                                    </div>
                                </div>
                                <div class="overflow-none">
                                    <div class="heading-five margin-top-twenty" style="opacity: 1; transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg, 0deg); transform-style: preserve-3d;">
                                        <?php echo esc_html($contact_office_country); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div aria-live="off" aria-atomic="true" class="w-slider-aria-label" data-wf-ignore=""></div>
                </div>
            </div>
        </div>
        <div class="contact-three-slider-background"></div>
    </section>

</div>

<?php get_footer(); ?>