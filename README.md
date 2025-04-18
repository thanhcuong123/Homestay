
## Nhánh

Chọn nhánh master để clone code.

link git: 
https://github.com/thanhcuong123/Homestay/tree/master 

## Cơ sở dữ liệu: XAMPP

Dùng MySQL để lưu dữ liệu.

Dự án có bao gồm tệp CSDL: ql_homestay

Giải nén và import CSDL.

## Các bước thực hiện để chạy hệ thống
- Sau khi clone code về, chạy lệnh tải composer (nếu chưa có) 

composer install

- Sao chép .env và key 

cp .env.example .env

php artisan key:generate

- Mở file .env cấu hình cơ sỡ dữ liệu

DB_CONNECTION=mysql 

DB_HOST=127.0.0.1

DB_PORT=3306

DB_DATABASE=ql_homestay

DB_USERNAME=root

DB_PASSWORD=

- Chạy lệnh để add hình 

php artisan storage:link

- Chạy lệnh migrate

php artisan migrate

- Chạy dự án 

php artisan serve 

