<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
     <!-- Bootstrap 3.3.4 -->
    <link href="{{ url('/bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    @if (session('message'))
    <div class="alert alert-{!! $message['type'] !!} alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{ $message['text'] }}
    </div>
    @endif
    <form action="/" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </form>
</body>
</html>