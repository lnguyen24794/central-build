<!-- Partners/Clients Section -->
<section class="home-two-partners-marquee overflow-none home-two-bottom-marquee">
<?php
    $partners = central_build_get_partners();
?>
<div class="swiper-container">
  <div class="swiper-wrapper">
    <div class="swiper-slide">
        <div class="w-layout-hflex home-two-partners-marquee-main-wrap branches">
            <!-- First Row of Partners -->
            <?php foreach ($partners as $partner) : 
            ?>
            <div class="w-layout-hflex home-two-partners-marquee-box-2">
        
                <div class="home-two-partners-block-2">
                    <?php if (!empty($partner['url']) && $partner['url'] !== '#') : ?>
                        <a href="<?php echo esc_url($partner['url']); ?>" target="_blank" rel="noopener noreferrer">
                    <?php endif; ?>
                    
                    <img src="<?php echo esc_url($partner['logo']); ?>" 
                            alt="<?php echo esc_attr($partner['name'] ?? 'Partner Logo'); ?>" 
                            loading="lazy" 
                            class="logo-image">
                    
                    <?php if (!empty($partner['url']) && $partner['url'] !== '#') : ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="swiper-slide">
        <div class="w-layout-hflex home-two-partners-marquee-main-wrap branches">
            <!-- Second Row of Partners -->
            <?php foreach ($partners as $partner) : 
            ?>
            <div class="w-layout-hflex home-two-partners-marquee-box-2">
        
                <div class="home-two-partners-block-2">
                    <?php if (!empty($partner['url']) && $partner['url'] !== '#') : ?>
                        <a href="<?php echo esc_url($partner['url']); ?>" target="_blank" rel="noopener noreferrer">
                    <?php endif; ?>
                    
                    <img src="<?php echo esc_url($partner['logo']); ?>" 
                            alt="<?php echo esc_attr($partner['name'] ?? 'Partner Logo'); ?>" 
                            loading="lazy" 
                            class="logo-image">
                    
                    <?php if (!empty($partner['url']) && $partner['url'] !== '#') : ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="swiper-slide">
        <div class="w-layout-hflex home-two-partners-marquee-main-wrap branches">
            <!-- Third Row of Partners -->
            <?php foreach ($partners as $partner) : 
            ?>
            <div class="w-layout-hflex home-two-partners-marquee-box-2">
        
                <div class="home-two-partners-block-2">
                    <?php if (!empty($partner['url']) && $partner['url'] !== '#') : ?>
                        <a href="<?php echo esc_url($partner['url']); ?>" target="_blank" rel="noopener noreferrer">
                    <?php endif; ?>
                    
                    <img src="<?php echo esc_url($partner['logo']); ?>" 
                            alt="<?php echo esc_attr($partner['name'] ?? 'Partner Logo'); ?>" 
                            loading="lazy" 
                            class="logo-image">
                    
                    <?php if (!empty($partner['url']) && $partner['url'] !== '#') : ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
  </div>
</div>
</section>

<script>
    let swiper = new Swiper('.swiper-container', {
       loop: true, // Kích hoạt vòng lặp vô hạn
        autoplay: {
            delay: 0, // Chuyển động liên tục (0ms để mượt mà)
            disableOnInteraction: false, // Không dừng khi user tương tác
        },
        speed: 5000, // Tốc độ chuyển động (5 giây cho 1 slide)
        spaceBetween: 0, // Không có khoảng cách giữa các slide
    });
</script>