## Clockin Working Time Manager

Basic application, made with [Lumen Framework](http://lumen.laravel.com/), to store and organize the worked time in a month.
It calculates the time worked above or under the estimated time based on users' arrivals and leavings from work.

## Requirements
- Composer
- Bower
- MongoDB
- Git (seriously?)

## Getting Started
##### Download and install 
```bash
$ git clone https://github.com/Alexandreh/clockin.git
$ cd clockin
$ composer install
$ bower install
```

##### Setup environment
```bash
$ cp .env.example .env
$ vim .env
```

##### Run Server
```bash
$ php artisan serve
```

### License

The Clockin App is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
