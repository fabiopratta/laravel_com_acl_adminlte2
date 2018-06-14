
## INSTALL

git clone https://github.com/fabiopratta/laravel_com_acl_adminlte2

and run composer install

after run

php artisan migrate

and 

php artisan db:seed

and for use API run

php artisan passport:install this is example return:

Client ID: 2 -> copy the client id 2 
Client Secret: gmyvudbudzlT6DMjOOyAjzxwgX7kH6co3uCz3Zrp

and modify file app/Http/Controllers/API/RegisterController.php
and replace the 'client_secret' => 'YOUCLIENTSECRET',

 
## User for example database

user: dev@dev.com.br
password: 123456




