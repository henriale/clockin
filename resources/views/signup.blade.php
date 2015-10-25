<!DOCTYPE html>
<html lang="en" ng-app="app">
<head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Sign Up - ClockIn</title>

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
    <link href="{{ url('assets/css/angular.css') }}" rel="stylesheet" type="text/css" />
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
            <div class="col-sm-12" ng-controller="SignupController">
                <form name="formSignup" class="form-signup" method="post" action="{{-- url('signup') --}}" novalidate>
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">

                    <label for="email" class="sr-only">Email address</label>
                    <input type="email" name="email" class="form-control" placeholder="Email address" ng-model="user.email" ng-class="" required>

                    <label for="password" class="sr-only">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password" ng-model="user.password" required ng-minlength="6">

                    <label for="repeatPassword" class="sr-only">Repeat password</label>
                    <input type="password" name="repeatPassword" class="form-control" placeholder="Repeat password" ng-model="user.passwordConfirmation" required ng-minlength="6" ng-change="passCheck()">
                    <br>

                    <button class="btn btn-lg btn-primary-outline btn-block" type="submit" ng-class="{disabled: formSignup.$invalid}" ng-click="formSignup.$valid && register()">Sign up!</button>
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