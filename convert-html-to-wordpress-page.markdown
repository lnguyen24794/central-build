# Hướng dẫn chuyển đổi file HTML thành WordPress Page

Dưới đây là hướng dẫn chi tiết để chuyển một trang web tĩnh từ các file HTML, CSS, JS thành một **WordPress page**, phù hợp với một senior WordPress developer. Giả định bạn đã có sẵn các file HTML, CSS, JS cho một trang cụ thể (ví dụ: trang "About" hoặc một landing page) và muốn tích hợp nó vào WordPress như một custom page template.

## 1. Phân tích và chuẩn bị
- **Mục tiêu**: Hiểu cấu trúc và nội dung của file HTML, xác định các phần động và tĩnh.
- **Công việc cần làm**:
  1. **Kiểm tra file HTML**:
     - Xem cấu trúc HTML (header, footer, content, sidebar, etc.).
     - Xác định các phần có thể tái sử dụng (header/footer) và các phần cần động hóa (nội dung, menu, widget).
  2. **Kiểm tra CSS/JS**:
     - Đảm bảo CSS được tổ chức tốt (ví dụ: có file main.css riêng hoặc inline).
     - Xác định các JS cần enqueue (menu toggle, slider, etc.).
  3. **Lập kế hoạch**:
     - Quyết định xem trang HTML sẽ được tích hợp như một **custom page template** hay một phần của theme.
     - Xác định các nội dung động (ví dụ: tiêu đề, nội dung chính) sẽ được lấy từ WordPress editor.

## 2. Thiết lập WordPress Theme
- **Mục tiêu**: Tạo hoặc chỉnh sửa theme để tích hợp trang HTML.
- **Công việc cần làm**:
  1. **Tạo hoặc sử dụng theme có sẵn**:
     - Nếu đã có theme, tích hợp vào theme hiện tại.
     - Nếu không, tạo theme mới với cấu trúc cơ bản.
  2. **Tạo custom page template**:
     - Tạo file mới, ví dụ: `page-about.php` trong thư mục theme.
     - Thêm header template với cú pháp WordPress:
       ```php
       <?php
       /*
       Template Name: About Page
       */
       get_header();
       ?>
       ```
  3. **Sao chép nội dung HTML**:
     - Copy nội dung HTML từ file gốc vào `page-about.php`, loại bỏ các phần header/footer trùng lặp (sẽ sử dụng `get_header()` và `get_footer()`).
  4. **Tích hợp CSS/JS**:
     - Đặt file CSS vào thư mục `css/` (ví dụ: `css/about.css`).
     - Đặt file JS vào thư mục `js/` (ví dụ: `js/about.js`).
     - Enqueue trong `functions.php`:
       ```php
       function enqueue_page_assets() {
           if (is_page_template('page-about.php')) {
               wp_enqueue_style('about-style', get_template_directory_uri() . '/css/about.css', [], '1.0.0');
               wp_enqueue_script('about-script', get_template_directory_uri() . '/js/about.js', ['jquery'], '1.0.0', true);
           }
       }
       add_action('wp_enqueue_scripts', 'enqueue_page_assets');
       ```

## 3. Chuyển đổi nội dung tĩnh thành nội dung động
- **Mục tiêu**: Thay thế các nội dung tĩnh trong HTML bằng các hàm WordPress để lấy dữ liệu từ admin.
- **Công việc cần làm**:
  1. **Tiêu đề và nội dung**:
     - Thay thế tiêu đề tĩnh `<h1>About Us</h1>` bằng:
       ```php
       <h1><?php the_title(); ?></h1>
       ```
     - Thay thế nội dung tĩnh `<div class="content">...</div>` bằng:
       ```php
       <div class="content"><?php the_content(); ?></div>
       ```
  2. **Menu**:
     - Thay thế menu tĩnh `<nav>...</nav>` bằng WordPress menu:
       ```php
       <?php
       wp_nav_menu([
           'theme_location' => 'primary',
           'container' => 'nav',
           'menu_class' => 'nav-menu'
       ]);
       ?>
       ```
     - Đăng ký menu trong `functions.php`:
       ```php
       function register_menus() {
           register_nav_menus([
               'primary' => __('Primary Menu', 'theme-domain'),
           ]);
       }
       add_action('init', 'register_menus');
       ```
  3. **Images**:
     - Nếu HTML có hình tĩnh, tải hình lên WordPress Media Library và sử dụng:
       ```php
       <img src="<?php echo get_template_directory_uri(); ?>/images/image.jpg" alt="Image">
       ```
     - Hoặc sử dụng custom fields (xem bước 4).
  4. **Custom Fields** (nếu cần):
     - Sử dụng plugin như ACF (Advanced Custom Fields) để thêm các trường tùy chỉnh (ví dụ: banner image, subtitle).
     - Ví dụ: Lấy banner image từ ACF:
       ```php
       <?php if (get_field('banner_image')): ?>
           <img src="<?php echo esc_url(get_field('banner_image')); ?>" alt="Banner">
       <?php endif; ?>
       ```

## 4. Responsive và Accessibility
- **Mục tiêu**: Đảm bảo trang giữ được thiết kế responsive và tuân thủ accessibility.
- **Công việc cần làm**:
  1. **Kiểm tra CSS**:
     - Đảm bảo các media queries trong file CSS gốc hoạt động tốt trên WordPress.
     - Nếu cần, chỉnh sửa trong `css/about.css` để tương thích với WordPress layout.
  2. **Accessibility**:
     - Thêm ARIA roles (ví dụ: `role="navigation"` cho menu).
     - Đảm bảo tất cả hình ảnh có `alt` text:
       ```php
       <img src="<?php echo esc_url(get_field('banner_image')); ?>" alt="<?php esc_attr_e('Banner Image', 'theme-domain'); ?>">
       ```
     - Kiểm tra keyboard navigation cho menu và button.

## 5. Tích hợp WordPress Features
- **Mục tiêu**: Tận dụng các tính năng WordPress để tăng tính tương tác.
- **Công việc cần làm**:
  1. **Header và Footer**:
     - Đảm bảo sử dụng `get_header()` và `get_footer()` để tái sử dụng header/footer từ theme.
     - Thêm `wp_head()` và `wp_footer()` trong `header.php` và `footer.php` để hỗ trợ plugin:
       ```php
       <!-- header.php -->
       <head>
           <meta charset="<?php bloginfo('charset'); ?>">
           <?php wp_head(); ?>
       </head>

       <!-- footer.php -->
       <?php wp_footer(); ?>
       ```
  2. **Widgets** (nếu có sidebar):
     - Tích hợp sidebar từ HTML vào `sidebar.php`:
       ```php
       <?php if (is_active_sidebar('about-sidebar')): ?>
           <aside>
               <?php dynamic_sidebar('about-sidebar'); ?>
           </aside>
       <?php endif; ?>
       ```
     - Đăng ký sidebar trong `functions.php`:
       ```php
       function register_sidebars() {
           register_sidebar([
               'name' => __('About Sidebar', 'theme-domain'),
               'id' => 'about-sidebar',
               'before_widget' => '<div class="widget">',
               'after_widget' => '</div>',
               'before_title' => '<h3>',
               'after_title' => '</h3>',
           ]);
       }
       add_action('widgets_init', 'register_sidebars');
       ```
  3. **Comments** (nếu cần):
     - Thêm khu vực bình luận:
       ```php
       <?php comments_template(); ?>
       ```

## 6. Kiểm tra và tối ưu hóa
- **Mục tiêu**: Đảm bảo trang hoạt động mượt mà, nhanh, và không lỗi.
- **Công việc cần làm**:
  1. **Kiểm tra tính năng**:
     - Tạo page trong WordPress admin (`Pages > Add New`), chọn template "About Page".
     - Kiểm tra nội dung, menu, và JS trên desktop/mobile.
  2. **Tối ưu hóa performance**:
     - Minify CSS/JS nếu chưa có.
     - Kiểm tra PageSpeed Insights, đảm bảo score > 90.
     - Thêm lazy loading cho images:
       ```php
       <img src="<?php echo esc_url(get_field('banner_image')); ?>" loading="lazy" alt="Banner">
       ```
  3. **Debug**:
     - Kiểm tra lỗi PHP (bật `WP_DEBUG` trong `wp-config.php`).
     - Sử dụng Theme Check plugin để validate theme.

## 7. Triển khai và kiểm tra
- **Mục tiêu**: Đưa page lên production và đảm bảo hoạt động ổn định.
- **Công việc cần làm**:
  1. **Tải theme lên WordPress**:
     - Nén thư mục theme thành file `.zip` và upload qua WordPress admin (`Appearance > Themes > Add New`).
  2. **Kiểm tra production**:
     - Kiểm tra trên server thật, đảm bảo fonts, images, và scripts tải đúng.
     - Kiểm tra tương thích với các plugin phổ biến (Yoast SEO, Contact Form 7).
  3. **Internationalization**:
     - Thêm text domain cho các chuỗi tĩnh:
       ```php
       <h2><?php esc_html_e('Welcome to About Us', 'theme-domain'); ?></h2>
       ```
     - Tạo file `.pot` trong thư mục `languages/` để hỗ trợ translation.

## Lưu ý quan trọng
- **Thời gian thực hiện**: 1-3 ngày, tùy thuộc vào độ phức tạp của HTML và yêu cầu động hóa.
- **Công cụ**:
  - Editor: VS Code.
  - Local environment: LocalWP hoặc XAMPP.
  - Version control: Git.
- **Best practices**:
  - Tuân thủ WordPress Coding Standards.
  - Sanitize/escape dữ liệu (e.g., `esc_url()`, `esc_html()`).
  - Đảm bảo theme tương thích với Gutenberg.
- **Nếu gặp vấn đề**:
  - Kiểm tra console log (browser) để debug JS.
  - Kiểm tra PHP errors trong `debug.log`.

## Ví dụ cụ thể
Giả sử file HTML gốc như sau:
```html
<!DOCTYPE html>
<html>
<head>
    <title>About Us</title>
    <link rel="stylesheet" href="css/about.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/about">About</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>About Us</h1>
        <p>This is our story.</p>
    </main>
    <script src="js/about.js"></script>
</body>
</html>
```

Sau khi chuyển đổi, `page-about.php` sẽ như sau:
```php
<?php
/*
Template Name: About Page
*/
get_header();
?>
<main>
    <h1><?php the_title(); ?></h1>
    <div class="content"><?php the_content(); ?></div>
</main>
<?php get_footer(); ?>
```

Và `functions.php` sẽ bao gồm:
```php
function enqueue_page_assets() {
    if (is_page_template('page-about.php')) {
        wp_enqueue_style('about-style', get_template_directory_uri() . '/css/about.css', [], '1.0.0');
        wp_enqueue_script('about-script', get_template_directory_uri() . '/js/about.js', ['jquery'], '1.0.0', true);
    }
}
add_action('wp_enqueue_scripts', 'enqueue_page_assets');

function register_menus() {
    register_nav_menus([
        'primary' => __('Primary Menu', 'theme-domain'),
    ]);
}
add_action('init', 'register_menus');
```