@extends('layouts.master')

@section('ng-app', 'app')

@section('title')
    Recover Passowowd
@stop

@section('styles')
    <link href="{{ url('assets/css/auth.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('header')
    <div class="col-sm-12">
        <p class="title">ClockIn.</p>
    </div>
@stop

@section('content')
    <div class="col-sm-12" ng-controller="SignupController">
        <form name="formSignup" class="form-signup" method="post" action="{{ url('recover') }}" novalidate>
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">

            <label for="email" class="sr-only">Email address</label>
            <input ng-model="email" required
                   type="email"
                   name="email"
                   class="form-control"
                   placeholder="Email address">

            <button type="submit" class="btn btn-lg btn-secondary-outline btn-block"
                    ng-class="{disabled: formSignup.$invalid, 'btn-success-outline':formSignup.$valid}"
                    ng-disabled="formSignup.$invalid"
                    ng-click="formSignup.$valid && register()">
                Recover!
            </button>
        </form>
    </div>
    @stop

    @section('scripts')
            <!-- Angular 1.4.7 -->
    <script type="text/javascript" src="{{ url('/bower_components/angular/angular.min.js') }}"></script>
    <!-- Page Scripts -->
    <script type="text/javascript" src="{{ url('app/app.module.js') }}"></script>
@stop
