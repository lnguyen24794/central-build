<?php
/**
 * Template Name: Contact Page
 * 
 * @package Central_Build_Pro
 * @since 1.0.0
 */

get_header(); ?>

<div class="contact-three">
    <section class="contact-three-hero-section">
        <div class="w-layout-blockcontainer container-one w-container">
            <div class="w-layout-hflex contact-three-flex-block">
                <div class="contact-three-details-left contact-three-details-right">
                    <div data-w-id="597b1aec-e5e4-5eff-75f2-81d170096b95" class="w-layout-hflex contact-three-heading-wrap">
                        <div class="tag-wrap tag-type-four">
                            <div class="tag dark-tab">Contacts</div>
                        </div>
                        <h1 class="text-white margin-none contact-three-hero-heading">
                            <?php 
                            if (have_posts()) : 
                                while (have_posts()) : the_post();
                                    if (get_the_title()) {
                                        the_title();
                                    } else {
                                        echo 'let\'s work <span>together</span>';
                                    }
                                endwhile;
                            else :
                                echo 'let\'s work <span>together</span>';
                            endif;
                            ?>
                        </h1>
                    </div>
                    <p class="text-light-grey">
                        <?php 
                        if (have_posts()) : 
                            while (have_posts()) : the_post();
                                if (get_the_content()) {
                                    the_content();
                                } else {
                                    echo 'Reach out to Central Build Pro to start your journey. Whether you\'re looking for a bespoke design, a seamless build, or expert advice, we\'re here to help make your vision a reality. Let\'s create something exceptional together.';
                                }
                            endwhile;
                        else :
                            echo 'Reach out to Central Build Pro to start your journey. Whether you\'re looking for a bespoke design, a seamless build, or expert advice, we\'re here to help make your vision a reality. Let\'s create something exceptional together.';
                        endif;
                        ?>
                    </p>
                    
                    <div class="w-layout-hflex contact-three-contact-main-wrap margin-top-thirty">
                        <div class="w-layout-vflex conatct-three-mail-wrap">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57d53_icon%20%2827%29.svg" loading="lazy" width="42" height="29" alt="">
                            <div class="text-white margin-top-fifteen">Email Us:</div>
                            <a href="mailto:<?php echo get_theme_mod('contact_email', 'info@centralbuild.com'); ?>" class="heading-six margin-none text-white text-lowarcase contact">
                                <?php echo get_theme_mod('contact_email', 'info@centralbuild.com'); ?>
                            </a>
                        </div>
                        <div class="w-layout-vflex contact-three-call-wrap">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57d56_Group.svg" loading="lazy" width="29" height="29" alt="">
                            <div class="text-white margin-top-fifteen">Let's Talk:</div>
                            <a href="tel:<?php echo get_theme_mod('contact_phone', '+61431465090'); ?>" class="heading-six margin-none text-white contact">
                                <?php echo get_theme_mod('contact_phone', '+61 431 465 090'); ?>
                            </a>
                        </div>
                    </div>
                    
                    <div class="w-layout-vflex contact-three-social-media-main-wrap">
                        <div class="text-white">Follow us:</div>
                        <div class="w-layout-hflex contact-three-social-media-link-wrap">
                            <?php if (get_theme_mod('facebook_url')) : ?>
                            <a href="<?php echo esc_url(get_theme_mod('facebook_url')); ?>" target="_blank" class="contact-three-social-media-link w-inline-block">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57d41_Social%20Media%20Icon%20%282%29.svg" loading="lazy" width="10" height="18" alt="Facebook">
                            </a>
                            <?php endif; ?>
                            
                            <?php if (get_theme_mod('instagram_url')) : ?>
                            <a href="<?php echo esc_url(get_theme_mod('instagram_url')); ?>" target="_blank" class="contact-three-social-media-link w-inline-block">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57b95_Instagram-Icon.webp" loading="lazy" width="18" height="18" alt="Instagram">
                            </a>
                            <?php endif; ?>
                            
                            <?php if (get_theme_mod('linkedin_url')) : ?>
                            <a href="<?php echo esc_url(get_theme_mod('linkedin_url')); ?>" target="_blank" class="contact-three-social-media-link w-inline-block">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57d3f_Social%20Media%20Icon%20%281%29.svg" loading="lazy" width="18" height="18" alt="LinkedIn">
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div data-w-id="597b1aec-e5e4-5eff-75f2-81d170096bc7" class="contact-three-form-block">
                    <h2 class="margin-top-zero margin-bottom-twenty">We're here to help</h2>
                    <p class="margin-bottom-thirty-two">Tell us about your project & goals!</p>
                    
                    <div class="w-form">
                        <form id="contact-form" name="contact-form" method="post" class="form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                            <?php wp_nonce_field('contact_form_nonce', 'contact_nonce'); ?>
                            <input type="hidden" name="action" value="submit_contact_form">
                            
                            <input class="contact-three-name-field w-input" maxlength="256" name="contact_name" placeholder="Name" type="text" required="">
                            <input class="contact-three-name-field w-input" maxlength="256" name="contact_email" placeholder="Email" type="email" required="">
                            <input class="contact-three-name-field w-input" maxlength="256" name="contact_phone" placeholder="Phone" type="text" required="">
                            <input class="contact-three-name-field w-input" maxlength="256" name="contact_project" placeholder="Project" type="text">
                            <input class="contact-three-name-field w-input" maxlength="256" name="contact_dates" placeholder="Commence Date + Finish Date" type="text">
                            <input class="contact-three-name-field w-input" maxlength="256" name="contact_math" placeholder="7+2=?" type="number" required="">
                            <textarea name="contact_message" maxlength="5000" placeholder="Message" class="contact-three-name-field contact-three-textarea w-input"></textarea>
                            
                            <input type="submit" class="contact-one-form-submit-button contact-three-form w-button" value="enquire now">
                        </form>
                        
                        <div class="w-form-done" style="display: none;">
                            <div class="text-block-3">Thank you! Your submission has been received!</div>
                        </div>
                        <div class="w-form-fail" style="display: none;">
                            <div>Oops! Something went wrong while submitting the form.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="contact-three-slider-section">
        <div class="w-layout-blockcontainer container-one about-two-hero-container w-container">
            <div data-delay="3000" data-animation="cross" class="contact-three-slider w-slider" data-autoplay="true" data-easing="ease" data-hide-arrows="false" data-disable-swipe="false" data-autoplay-limit="0" data-nav-spacing="3" data-duration="1100" data-infinite="true">
                <div class="w-slider-mask">
                    <div data-w-id="d59e0206-fed2-94be-a8fa-59a18d95fc13" class="w-slide">
                        <div class="w-layout-hflex contact-three-slider-main-wrap">
                            <div class="contact-three-details-left-flex">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/674f93236bf6f3bf70603016_ENP05610%20%28Large%29.jpg" 
                                     sizes="(max-width: 767px) 100vw, 590px" width="590" height="689" 
                                     alt="Central Build Pro team member working onsite during commercial fitout project" 
                                     srcset="<?php echo get_template_directory_uri(); ?>/images/674f93236bf6f3bf70603016_ENP05610%20%28Large%29-p-500.jpg 500w, <?php echo get_template_directory_uri(); ?>/images/674f93236bf6f3bf70603016_ENP05610%20%28Large%29-p-800.jpg 800w, <?php echo get_template_directory_uri(); ?>/images/674f93236bf6f3bf70603016_ENP05610%20%28Large%29.jpg 1080w" 
                                     class="image-height-auto resoponsive-width-hunderd">
                            </div>
                            <div class="w-layout-vflex contact-three-slider-contain-wrap">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57d42_Contact%20Three%20Slider%20Icon.svg" loading="lazy" width="45" height="45" alt="Contact Three Slider Icon">
                                <div class="overflow-none">
                                    <h2 class="margin-top-thirty">Visit Our Offices</h2>
                                </div>
                                <div class="overflow-none">
                                    <p class="margin-top-ten">Central Build Pro is your trusted partner for exceptional commercial fitouts. Visit us to discuss your project and explore our tailored solutions.</p>
                                </div>
                                <div class="contact-three-slider-line"></div>
                                <div class="overflow-none">
                                    <div class="heading-four">Office in Brisbane</div>
                                </div>
                                <div class="overflow-none">
                                    <div class="heading-five margin-top-twenty">
                                        <?php echo get_theme_mod('office_address', 'Unit 4/126-130 Compton Rd, Woodridge QLD 4114, Australia'); ?>
                                    </div>
                                </div>
                                <div class="overflow-none">
                                    <p class="margin-top-twenty-five">Come explore our showroom and see our craftsmanship in action! Discover our range of materials and witness our in-house operations. Experience the quality and innovation that sets Central Build Pro apart.</p>
                                </div>
                                <div class="contact-three-slider-line"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="contact-three-slider-left-arrow w-slider-arrow-left">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57d44_Slider%20Arrow%20%281%29.svg" loading="lazy" width="8" height="14" alt="Slider Arrow">
                </div>
                <div class="contact-three-slider-right-arrow w-slider-arrow-right">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57d43_Slider%20Arrow%20%282%29.svg" loading="lazy" width="8" height="14" alt="Slider Arrow">
                </div>
                <div class="display-none w-slider-nav w-round w-num"></div>
            </div>
        </div>
        <div class="contact-three-slider-background"></div>
    </section>
</div>

<?php get_footer(); ?>