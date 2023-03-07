# MASA EPR
* Laravel Version 5.4
* Bootrtrap 3
* Javascript, Jquery, Vue JS

#### Requirement
1. PHP 7.2
2. PostgreeSQL 12.8
3. Composer

#### Instalasi
1. `git clone git@gitlab.com:programmer-berkatsoft/cv-masa/erp.git` ke branch development
2. `$ cd erp`
3. `$ composer install`
4. `$ cp .env.example .env` dan sesuaikan konfigurasi database
5. Import database dari link [berikut](https://analisberkatsoft.atlassian.net/jira/software/c/projects/CM/boards/1/backlog?issueLimit=100) 
6. `$ php artisan key:generate`
7. `$ php artisan migrate`
8. `$ php artisan serve`

### User login
Role : Superadmin <br>
username : admindev@mail.com <br>
password : berkatsoft123 <br>

