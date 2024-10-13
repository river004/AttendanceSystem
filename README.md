# Atte
人事評価のため作られた勤怠管理システムです。
## 環境構築

Dockerビルド

1.　`git clone https://github.com/river004/AttendanceSystem` </br>
2.  `docker-compose up -d —build`

＊ MySQLは、OSによって起動しない場合があるのでそれぞれのPCに合わせて docker-compose.yml ファイルを編集してください。

Laravel環境構築

1.  `docker-compose exec php bash`
2.  `composer install`
3.  `cp .env.example .env` 
4. .envの環境変数を変更
``` text
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```
6.  `php artisan key:generate`
7.  `php artisan migrate`
8.  `php artisan db:seed`

## 使用技術

- PHP8.3.0
- Laravel8.83.27
- MySQL8.0.26
- nginx1.21.1

## URL
- 開発環境：http://localhost/
- phpMyAdmin：http://localhost:8080/
