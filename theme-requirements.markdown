# Specification for Developing a Complete WordPress Theme: Central build Pro

## 1. Giới thiệu
- **Tên theme**: Central Build Pro
- **Mô tả**: Theme dành cho công ty chia sẻ các dự án công ty và thông tin công ty. Tập trung vào readability, tốc độ tải trang cao, và tích hợp social media. Theme hỗ trợ các loại post như bài viết chuẩn, gallery, video embed, và quote.
- **Mục tiêu**:
  - Cung cấp giao diện sạch sẽ, minimalist với tùy chỉnh dễ dàng qua WordPress Customizer.
  - Hỗ trợ SEO cơ bản và mobile-first design.
  - Phiên bản: 1.0.0
- **Đối tượng người dùng**: Cá nhân, freelancer, không yêu cầu kiến thức lập trình cao để sử dụng.

## 2. Yêu cầu Kỹ Thuật
- **WordPress version**: Tương thích với WordPress 6.0 trở lên (kiểm tra với phiên bản mới nhất, hiện tại 6.6+).
- **PHP version**: PHP 8 trở lên (khuyến nghị 8.0+ cho performance).
- **Dependencies**:
  - Không phụ thuộc vào plugin bên ngoài, nhưng khuyến nghị sử dụng với Gutenberg (block editor).
  - Nếu cần, tích hợp CSS framework như Bootstrap CSS (compiled) hoặc pure CSS để giữ lightweight.
- **Browser support**: Chrome, Firefox, Safari, Edge (phiên bản mới nhất), và responsive trên mobile (iOS/Android).
- **Performance goals**: PageSpeed Insights score > 90/100 cho desktop và mobile.

## 3. Cấu Trúc File
Theme được tổ chức theo cấu trúc chuẩn của WordPress. Các file chính bao gồm:

| File/Folder          | Mô tả                                                                 |
|----------------------|-----------------------------------------------------------------------|
| **style.css**       | File chính định nghĩa theme (theme name, author, version, description). Bao gồm CSS cơ bản cho layout. |
| **functions.php**   | Đăng ký scripts, styles, menus, sidebars, theme supports (e.g., post thumbnails, custom logo). |
| **index.php**       | Template chính cho homepage (hiển thị list bài viết). |
| **single.php**      | Template cho single post (bài viết chi tiết). |
| **page.php**        | Template cho static pages (e.g., About, Contact). |
| **archive.php**     | Template cho archive (category, tag, date-based). |
| **search.php**      | Template cho kết quả tìm kiếm. |
| **404.php**         | Trang lỗi 404. |
| **header.php**      | Phần header (logo, menu, search bar). |
| **footer.php**      | Phần footer (copyright, social links). |
| **sidebar.php**     | Sidebar cho widgets. |
| **comments.php**    | Template cho comments section. |
| **inc/**            | Folder cho các file include (e.g., customizer.php, enqueue.php). |
| **template-parts/** | Folder cho reusable parts (e.g., content-post.php, content-page.php). |
| **js/**             | Folder cho JavaScript (e.g., main.js cho menu toggle, lazy loading). |
| **css/**            | Folder cho additional CSS (e.g., responsive.css). |
| **images/**         | Folder cho theme assets (e.g., default thumbnail). |
| **languages/**      | Folder cho translation files (.pot, .po, .mo). |
| **readme.txt**      | File mô tả theme, license (GPLv2+), changelog. |
| **screenshot.png**  | Hình ảnh preview theme (880x660 pixels). |

- **Tổng file dự kiến**: Khoảng 20-30 file, giữ theme lightweight (< 500KB zipped).

## 4. Tính Năng Chính
- **Homepage**: Slider hoặc featured posts ở đầu, theo sau là grid/list bài viết mới nhất. Hỗ trợ pagination.
- **Post Formats**: Hỗ trợ standard, image, gallery, video, quote (sử dụng `add_theme_support('post-formats')`).
- **Custom Widgets**:
  - Recent Posts with thumbnails.
  - Social Media Links.
  - Author Bio.
- **Menus**: Primary menu (header), Secondary menu (footer). Sử dụng `wp_nav_menu()`.
- **Search Functionality**: Tích hợp search form với AJAX nếu có thể (sử dụng JS).
- **Comments System**: Hỗ trợ threaded comments, avatar, moderation.
- **Pagination**: Sử dụng `the_posts_pagination()` cho navigation.
- **Custom Post Types (Optional)**: Thêm CPT cho "Portfolio" nếu cần mở rộng.
- **Shortcodes**: Tạo shortcodes đơn giản như `[gallery]` hoặc `[button]`.

## 5. Thiết Kế và UX
- **Layout**:
  - 2-column (content + sidebar) cho desktop, stack thành 1-column cho mobile.
  - Width: Max 1200px centered.
- **Color Scheme**: Minimalist – Primary: #333 (text), Accent: #007BFF (links/buttons), Background: #FFFFFF.
- **Typography**: Google Fonts (e.g., Open Sans for body, Merriweather for headings). Font sizes: Body 16px, H1 32px.
- **Responsive Design**: Sử dụng media queries (`@media`) để hỗ trợ màn hình < 768px (mobile), 768-1024px (tablet).
- **Accessibility**:
  - ARIA roles cho navigation.
  - Alt text cho images.
  - Keyboard navigation.
- **Animations**: Subtle CSS transitions cho hover effects (e.g., button scale).

## 6. Tích Hợp
- **WordPress Customizer**:
  - Sections: Site Identity (logo, title), Colors (primary/accent), Layout (sidebar position).
  - Sử dụng `add_theme_support('custom-logo', 'custom-background')`.
- **Theme Supports**:
  - `add_theme_support('title-tag', 'automatic