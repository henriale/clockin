@extends('layouts.master')

@section('ng-app', 'app')

@section('title')
  Sign Up
@stop

@section('styles')
  <link href="{{ url('assets/css/auth.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('header')
  <div class="col-sm-12">
    <a href="{{ url('/') }}" style="text-decoration:none;"><p class="title">ClockIn.</p></a>
  </div>
@stop

@section('content')
  <div class="col-sm-12" ng-controller="SignupController">
    <form name="formSignup" class="form-signup" method="post" action="{{ url('signup') }}" novalidate>
      <input type="hidden" name="_token" value="{!! csrf_token() !!}">

      <label for="email" class="sr-only">Email address</label>
      <input ng-model="email" required
             type="email"
             name="email"
             class="form-control"
             placeholder="Email address">

      <label for="password" class="sr-only">Password</label>
      <input ng-minlength="6" ng-change="passCheck()" ng-model="password" required
             type="password"
             name="password"
             class="form-control"
             placeholder="Password">

      <label for="repeatPassword" class="sr-only">Repeat password</label>
      <input ng-model="passwordConfirmation" ng-change="passCheck()" required
             type="password"
             name="passwordConfirmation"
             class="form-control"
             placeholder="Repeat password">
      <br />

      <div ng-show="!is.empty(formSignup.$error) && formSignup.$dirty && formSignup.$invalid"
           class="alert alert-danger alert-dismissible fade in"
           role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
        <ul>
          <li ng-show="formSignup.email.$invalid">
            <strong>Email</strong> must be valid.
          </li>
          <li ng-show="formSignup.password.$error.required">
            <strong>Password</strong> must be provided.
          </li>
          <li ng-show="formSignup.password.$error.minlength">
            <strong>Password</strong> must have 6 characters, at least.
          </li>
          <li ng-show="formSignup.passwordConfirmation.$error.passCheck">
            <strong>Password confirmation</strong> must be the same as password.
          </li>
        </ul>
      </div>
      <br />

      <button type="submit" class="btn btn-lg btn-secondary-outline btn-block"
              ng-class="{disabled: formSignup.$invalid, 'btn-success-outline':formSignup.$valid}"
              ng-disabled="formSignup.$invalid"
              ng-click="formSignup.$valid && register()">
          Sign up!
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
