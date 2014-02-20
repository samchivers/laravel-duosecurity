Laravel-duosecurity
===================

An example of how to implement two factor authentication using Duo Security and Laravel. 

Once complete, a user will be asked for their username and password, which is authenticated by Laravel, then if successful, they will be shown a prompt by Duo Security which will require a second kind of authentication. If that is also authenticated, the user will be logged in by Laravel and redirected to the homepage. 

There are therefore 3 stages:
- Laravel login page
- Duo Security login page
- Authenticated homepage

##### Notes
1. [Duo Security](https://www.duosecurity.com/) is a service that offers a way to protect a site using two factor authentication. You can find their PHP code [here](https://github.com/duosecurity/duo_php) which this example repo extends in a minor way.

2. [Laravel](http://laravel.com/) is a PHP MVC framework. You can find it [here](https://github.com/laravel/laravel).

I am not affiliated in any way to either.

##### Instructions

This repo is based on a fresh version of Laravel 4, so to recreate this implementation, i would recommend you start with the same from [here](https://github.com/laravel/laravel) and follow the steps listed below. This repo is a tutorial rather than a finished product to plug in.

##### Screenshots

1. Stage One
![Stage One](http://3cb7c06ccb1e0b84a1cc-164f999ecb835605bbbe5f068924d4ed.r17.cf3.rackcdn.com/Screen Shot 2014-02-19 at 21.37.24.png)

2. Stage Two
![Stage Two](http://3cb7c06ccb1e0b84a1cc-164f999ecb835605bbbe5f068924d4ed.r17.cf3.rackcdn.com/Screen Shot 2014-02-19 at 21.37.48.png)

3. iOS Notification
![iOS Notification](http://3cb7c06ccb1e0b84a1cc-164f999ecb835605bbbe5f068924d4ed.r17.cf3.rackcdn.com/Screen Shot 2014-02-19 at 18.36.10.png)

4. Stage Three
![Stage Three](http://3cb7c06ccb1e0b84a1cc-164f999ecb835605bbbe5f068924d4ed.r17.cf3.rackcdn.com/Screen Shot 2014-02-19 at 21.39.12.png)

---

##### Steps
1. Sign up for a Duo Security account then create a new Web SDK integration. Note the following which you will require later
    - Integration key	
    - Secret key	
    - API hostname

2. Clone a new instance of Laravel

3. Run the following in Terminal `composer install`

4. Set up some kind of database (I used mySQL) and add the relevant credentials to `app/config/database.php`

5. Run the following artisan command to generate the migration for a Users table, which we will use to authenticate our user against - `php artisan migrate:make create_users_table`

6. Open `app/database/migrations/<the date you ran the command>_create_users_table.php` and add the code shown in the file of the same name from this repo which scaffolds a users table.

7. Run the following artisan command `php artisan migrate`

8. Open `app/database/seeds/DatabaseSeeder.php` and add the code shown in the file of the same name from this repo which prepares the file to add one user we can authenticate against

9. Run the following artisan command `php artisan db:seed` - If you check your DB now, there should be one user in the users table, with a username of `sam@laravelduo.co.uk`, and a password of `password` (which has been helpfully hashed by Laravel)

10. Add a new folder at `app/LaravelDuo` and add the two files from this repo from the same location, `Duo.php` (available [here](https://github.com/duosecurity/duo_php/blob/master/duo_web.php)) and `LaravelDuo.php`

11. Open `app/LaravelDuo/LaravelDuo.php` and add add the Intergration key `IKEY`, Secret Key `SKEY` and Host `HOST` values from your Duo Security account, and create an Application Key `AKEY`

12. Open `composer.json` and add `app/LaravelDuo` to the `classmap` list as shown in the `composer.json` of this repo

13. Run the following artisan command `composer dumpautoload` 

14. Open `app/routes.php`, delete the standard routing for (`'/'`) and add the following `Route::controller('/', 'HomeController');`. This will RESTfully route our various page requests through `app/controllers/HomeController.php`

15. Create `app/views/layouts/master.blade.php` and add the code shown in the file of the same name from this repo. This uses Laravel's Blade syntax and is the outer structure for every page.

16. Create `app/views/pages/login.blade.php` and `app/views/pages/duologin.blade.php` and copy the code show in the files of the same name from this repo. `login.blade.php` is the page shown initally in which we authenticate a user against the `Users` table of our database. `duologin.blade.php` is the page shown subsequently which allows authentication with Duo.

17. Create `public/assets/css/style.css` and add any styling you want, and `app/assets/js/Duo-Web-v1.bundled.min.js` (available [here](https://github.com/duosecurity/duo_php/blob/master/js/Duo-Web-v1.bundled.min.js))

18. Open `app/controllers/HomeController.php` and add the code from file of the same name from this repo.

19. Open `app/models/User.php` and add the `getIdFromEmail()` static method from the file of the same name from this repo.

20. Browse to your webroot (in my case `http://localhost:8888/LaravelDuo/public`) and enter `sam@laravelduo.co.uk` in the email field and `password` in the password field. 

21. Follow the Duo security instructions to authenticate using their service

22. Win

---

To come - a more in depth walkthrough of `HomeController.php`
