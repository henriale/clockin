<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Log in - ClockIn</title>

    <!-- Raleway font -->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Raleway" />
    <!-- Lato font -->
    <link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
    <!-- Normalize.css v3.0.3 -->
    <link href="{{ url('/bower_components/normalize-css/normalize.css') }}" rel="stylesheet" type="text/css" />
    <!-- Bootstrap 4.0-alpha -->
    <link href="{{ url('/bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Open Iconic -->
    <link href="{{ url('/bower_components/open-iconic/font/css/open-iconic-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Custom jQuery UI theme 1.11.4 -->
    <link href="{{ url('assets/css/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/jquery-ui/jquery-ui.theme.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Custom CSS -->
    <link href="{{ url('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/auth.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <p class="title">
                    ClockIn.
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <form class="form-signin" method="post" action="{{ url('login') }}">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    
                    <label for="inputEmail" class="sr-only">Email address</label>
                    <input type="email" name="email" class="form-control" placeholder="Email address" required="" autofocus="">
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password" required="">
                    
                    <button class="btn btn-lg btn-primary-outline btn-block" type="submit">Login</button>
                    <a class="btn btn-lg btn-secondary-outline btn-block" href="{{ url('/signup') }}" role="button">Sign Up</a>
                </form>
            </div><!-- .col-sm-12 -->
        </div><!-- .row -->
    </div><!-- .container -->
</body>

<footer class="scripts">
    <!-- Angular 1.4.7 -->
    <script type="text/javascript" src="{{ url('/bower_components/angular/angular.min.js') }}"></script>
    <!-- jQuery 2.1.4 -->
    <script type="text/javascript" src="{{ url('/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 4.0-alpha -->
    <script type="text/javascript" src="{{ url('/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- isJs 0.7.4 -->
    <script type="text/javascript" src="{{ url('/bower_components/is_js/is.min.js') }}"></script>
    
    <!-- Page Scripts -->
    <script type="text/javascript" src="{{ url('app/app.module.js') }}"></script>
</footer>
</html>