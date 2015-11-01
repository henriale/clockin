@extends('layouts.master')

@section('title')
  Log In
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
@stop

@section('scripts')
  <!-- Angular 1.4.7 -->
  <script type="text/javascript" src="{{ url('/bower_components/angular/angular.min.js') }}"></script>
  <!-- Page Scripts -->
  <script type="text/javascript" src="{{ url('app/app.module.js') }}"></script>
@stop
