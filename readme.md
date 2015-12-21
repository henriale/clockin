## Clockin Working Time Manager

[![Join the chat at https://gitter.im/Alexandreh/clockin](https://badges.gitter.im/Alexandreh/clockin.svg)](https://gitter.im/Alexandreh/clockin?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

Basic application, made with [Lumen Framework](http://lumen.laravel.com/), to store and organize the worked time in a month.
It calculates the time worked above or under the estimated time based on users' arrivals and leavings from work.

## Requirements
- [Composer](https://getcomposer.org)
- [Bower](http://bower.io)

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
# then, fill out your environment information
$ vim .env
```

##### Build up database
```bash
$ php artisan migrate
$ php artisan db:seed
```

##### Run Server
```bash
$ php artisan serve
```

## API
The Clockin API is based on [Limoncello Shot](https://github.com/neomerx/limoncello-shot) which implements [jsonAPI](http://jsonapi.org). As you run the server, the API will be working. Just make sure you have set everything up at the `.env` file.
##### Authentication
It uses the basic authentication. So, just use `email` as `username` and `password` as `password`.

### License

The Clockin App is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
