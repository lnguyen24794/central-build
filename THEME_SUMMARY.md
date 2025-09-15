# Central Build Pro WordPress Theme - Tóm tắt

## Tổng quan
Theme WordPress chuyên nghiệp được thiết kế cho các công ty xây dựng và fitout, dựa trên các template HTML có sẵn từ thư mục `template_pages/`.

## Cấu trúc Theme

### Files chính
- `style.css` - CSS chính và thông tin theme
- `functions.php` - Các chức năng và hooks của theme
- `index.php` - Template chính cho homepage
- `front-page.php` - Template trang chủ tùy chỉnh
- `header.php` - Header với navigation và top bar
- `footer.php` - Footer với thông tin liên hệ và social media
- `sidebar.php` - Sidebar cho widgets

### Page Templates
- `page-contact.php` - Trang liên hệ với form và thông tin văn phòng
- `page-commercial-shop-fitting.php` - Trang dịch vụ shopfitting
- `page-testimonials.php` - Trang hiển thị testimonials
- `page-our-values.php` - Trang giá trị công ty và team

### Template Parts
- `template-parts/content.php` - Template cho posts
- `template-parts/content-search.php` - Template cho kết quả tìm kiếm

### Assets
- `css/components.css` - CSS cho components và animations
- `js/main.js` - JavaScript chính với mobile menu, smooth scroll, animations
- `images/` - Thư mục chứa hình ảnh theme
- `fonts/` - Thư mục chứa fonts

## Tính năng chính

### WordPress Features
- ✅ Custom Logo support
- ✅ Custom Background support
- ✅ Post Thumbnails
- ✅ Post Formats (standard, image, gallery, video, quote)
- ✅ HTML5 support
- ✅ Responsive embeds
- ✅ Navigation menus (primary, footer)
- ✅ Widget areas (sidebar, footer)
- ✅ Translation ready

### Custom Post Types
- ✅ Portfolio - Để showcase các dự án
- ✅ Testimonials - Để hiển thị feedback khách hàng

### Customizer Options
- ✅ Site Identity (logo, colors)
- ✅ Contact Information (phone, email)
- ✅ Social Media Links (Facebook, Instagram, LinkedIn, etc.)
- ✅ Hero Section Content
- ✅ Colors (primary, accent)

### JavaScript Features
- ✅ Mobile responsive menu
- ✅ Smooth scrolling
- ✅ Scroll to top button
- ✅ Lazy loading images
- ✅ Animation on scroll
- ✅ Contact form handling
- ✅ Testimonials slider

### Performance & SEO
- ✅ Optimized CSS và JavaScript
- ✅ Lazy loading
- ✅ SEO-friendly structure
- ✅ Schema markup ready
- ✅ Fast loading
- ✅ Mobile-first responsive design

## Cách sử dụng

### 1. Cài đặt Theme
1. Upload theme vào `/wp-content/themes/`
2. Activate theme trong WordPress admin
3. Cấu hình trong Customizer

### 2. Tạo Pages
Tạo các pages sau và assign templates tương ứng:
- Contact (sử dụng template "Contact Page")
- Commercial Shop Fitting (sử dụng template "Commercial Shop Fitting")
- Testimonials (sử dụng template "Testimonials")
- Our Values (sử dụng template "Our Values")

### 3. Setup Menus
- Tạo Primary Menu trong Appearance > Menus
- Tạo Footer Menu nếu cần

### 4. Configure Widgets
- Setup sidebar widgets
- Setup footer widgets

### 5. Customizer Settings
Vào Appearance > Customize để cấu hình:
- Logo và site identity
- Colors
- Contact information
- Social media links
- Hero section content

## Custom Post Types

### Portfolio
- Thêm portfolio items trong admin
- Có thể thêm client name, project date, URL, gallery images
- Hiển thị trong archive và single pages

### Testimonials
- Thêm testimonials trong admin
- Có thể thêm author name, position, company, rating
- Hiển thị trong homepage và testimonials page

## Responsive Design
- Mobile-first approach
- Breakpoints: 480px, 768px, 992px, 1200px
- Flexible grid system
- Touch-friendly navigation

## Browser Support
- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Performance Goals
- PageSpeed Insights score > 90/100
- First Contentful Paint < 2s
- Largest Contentful Paint < 2.5s
- Cumulative Layout Shift < 0.1

## Cần bổ sung
1. **Images**: Cần thêm các hình ảnh thực tế vào thư mục `images/`
2. **Fonts**: Copy fonts từ template_pages vào thư mục `fonts/`
3. **CSS từ templates**: Tích hợp CSS từ các template HTML gốc
4. **Testing**: Test trên các devices và browsers khác nhau
5. **Content**: Thêm nội dung mẫu cho demo

## Hướng dẫn phát triển tiếp
1. Tạo child theme để customization
2. Thêm more page templates nếu cần
3. Tích hợp với plugins phổ biến (Contact Form 7, Yoast SEO, etc.)
4. Thêm more customizer options
5. Optimize performance hơn nữa

## Support
- WordPress version: 6.0+
- PHP version: 8.0+
- License: GPL v2+
