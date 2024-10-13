# Atte
人事評価のため作られた勤怠管理システムです。
## 環境構築

Dockerビルド

1.  `git clone リンク`
2.  `docker-compose up -d —build`

＊ MySQLは、OSによって起動しない場合があるのでそれぞれのPCに合わせて docker-compose.yml ファイルを編集してください。

Laravel環境構築

1.  `docker-compose exec php bash`
2.  `composer install`
3.  `cp .env.example .env` 
4.  .envの環境変数を変更
5.  `php artisan key:generate`
6.  `php artisan migrate`
7.  `php artisan db:seed`

## 使用技術

- PHP 
- Laravel 
- MySQL 

## URL
- 開発環境：http://localhost/
- phpMyAdmin：http://localhost:8080/
