## VietnamHouse Project - Laravel 5.2

### Image Resource
- Sử dụng thư viện này để cắt ảnh nhá https://github.com/Folkloreatelier/laravel-image

### Building Assets
- Yêu cầu cài NodeJS
- Cài GULP: `npm install --global gulp`
- Cài Laravel Elixir: `npm install --no-bin-links`
- Sử dụng SCSS để viết stylesheet
- Build CSS chạy lệnh: `gulp` hoặc `gulp --production` để build và minify
- Chạy lệnh: `gulp watch` để Gulp tự động build ra CSS khi SCSS có thay đổi

### How To Deploy
- Dùng lệnh: `php artisan deploy` -> lệnh này sẽ sync code lên gitlab và deploy code lên web demo

### Cập nhật Cấu trúc File Resources
- CSS:
    - Chứa CSS từ github hoặc các nguồn khác.
- SCSS:
    - app.scss: File SCSS chính combine các CSS từ vendor và các CSS thành phần.
    - common.scss: Định nghĩa các CSS được dùng global trong project.
    - fonts.scss: Khai báo font.
    - mixin.scss: Extends SCSS -> cái này là Helper thôi.
    - variable.scss: Chứa các biến mã màu, fonts, etc.
    - (Mọi người nhớ Log vào README nếu tạo mới file để mọi người tiện theo dõi nha)
- JS:
    - Thư mục vendor/: Chứa JS từ github hoặc các nguồn khác.

# vnh renew 2018/06/21
- Install:
    - Run:
        - 'composer install'
        - 'composer update'
- Setup:
    - Test
