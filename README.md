# Air Work
Software for work, task management, team collaboration, process display, Agile board.Base on Laravel.<br/>
办公软件：任务管理，团队协作，流程展示，敏捷看板。

## DEMO
<!-- [DEMO site（data won't save for long）](http://ec2-18-166-11-79.ap-east-1.compute.amazonaws.com/login "Air Work (data won't save for long)") -->
![image](https://github.com/BourneSuper/air-work/blob/master/README.gif)

## Requirement
- php >= 7.2.5
- composer
- npm

## Install
1. download
```shell
$ git clone https://github.com/BourneSuper/air-work.git
```
2. install dependency
```shell
$ cd air-work
$ composer install
$ npm install
```
3. config application
```shell
$ cp .env.example .env
#change database configure here.
$ vim .env 
```
4. generate laravel key
```shell
$ php artisan key:generate
```
5. migrate and seed
```shell
$ php artisan migrate
$ php artisan db:seed
```
Now you get some defalut data. <br/>
E-mail account: zhangsan@zhangsan.com <br/>
passwor: zhangsan

6. config your nginx
config your nginx and php-fpm by following their manual. It's just standard configuration.
```shell
    location ~ \.php$ {
        #root           html;
        root            /usr/share/nginx/html/air-work/public;
        fastcgi_index   index.php;
        fastcgi_pass    127.0.0.1:9000;
        include         fastcgi_params;
        fastcgi_param   SCRIPT_FILENAME    $document_root$fastcgi_script_name;
        fastcgi_param   SCRIPT_NAME        $fastcgi_script_name;
    }
```
7. open your brower and try it



