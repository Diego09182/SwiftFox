<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## 關於專案

一個藉由Laravel開發支援多種功能的線上社群軟體

## 安裝

git clone https://github.com/Diego09182/SwiftFox

安裝 composer

安裝所需依賴:  
`composer install`

配置環境變數:  
`cp .env.example .env`

生成應用程式密鑰:  
`php artisan key:generate`

配置資料庫:  
DB_CONNECTION=mysql  
DB_HOST=127.0.0.1  
DB_PORT=3306  
DB_DATABASE=your_database_name  
DB_USERNAME=your_database_user  
DB_PASSWORD=your_database_password  

遷移資料庫:  
`php artisan migrate`

啟動開發伺服器:  
`php artisan serve`

編譯前端資產:  
`npm install`  
`npm run build`  

## 版本

Vue         v3.5.7

Vue-router  v4.4.5

Laravel     v10.48.4

Materialize v1.0.0

jQuery      v3.7.1

## 授權條款

[MIT license](https://opensource.org/licenses/MIT).