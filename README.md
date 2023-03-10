<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Blog Apps

This project about Blog Apps with Multiple Roles. There was 3 roles in the default. Admin can manage/CRUD all users and posts data. Manager can manage/CRUD all posts data. And Normal User can only manage/CRUD his/her posts.

### Tech stacks

- PHP (Laravel 10)
- Sanctum (for Authentication and Authorization)
- MySQL Database

### Database Design
![Database Design](https://github.com/salimarizi/blog-apps/blob/main/public/Database.png?raw=true)


### How to Run

There are two was to run this application. Feel free to choose the way to run this app.

### Run with Docker
1. After clone the apps, you can simply type `docker-compose up -d` and wait till all the process done.
2. After installation is done, you can go to browser and go to http://localhost:8000 and you will see the app is running

### Run manually
1. After clone the apps, install all the necessary libraries by running `composer install` on terminal
2. Set the environment variable by editing `.env` file (if there is no `.env` file, please run `cp .env.example .env`)
3. Then for migrate the database migration, type `php artisan migrate`
4. The last step is simply run `php artisan serve` to serve the application

(Optional) for running the test cases we can setup the test environment by using this steps:

1. Create test database by running `touch database/test.sqlite`
2. Copy the .env to .env.testing and set the database to be using the test database.
3. After that, we can run those test cases by typing `php artisan test`

### Endpoints

1. Authentication
   * `[POST] /api/register` (Register User)
   * `[POST] /api/login` (Login User)

2. Roles
   * `[GET] /api/roles` (Get All Roles)
   * `[GET] /api/roles/:id` (Get Selected Role by ID)

3. Users
   * `[GET] /api/users/` (Get All Users)
   * `[GET] /api/users/:id` (Get Selected User by ID)
   * `[POST] /api/users` (Store User)
   * `[PATCH] /api/users/:id` (Update User)
   * `[DELETE] /api/users/:id` (Delete User)

4. Posts
   * `[GET] /api/posts/` (Get All Posts)
   * `[GET] /api/posts/:id` (Get Selected Post by ID)
   * `[POST] /api/posts` (Store Post)
   * `[PATCH] /api/posts/:id` (Update Post)
   * `[DELETE] /api/posts/:id` (Delete Post)

More info about Project APIs can be view by visiting this [Postman Documentation](https://documenter.getpostman.com/view/2470070/2s93CHtuaN)

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
