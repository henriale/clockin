<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Main view</title>

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
    <link href="{{ url('/css/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('/css/jquery-ui/jquery-ui.theme.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Custom CSS -->
    <link href="{{ url('/css/custom.css') }}" rel="stylesheet" type="text/css" />
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
                @if (session('message'))
                    {{ dd($message) }}
                    <div class="alert alert-{!! $message['type'] !!} alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ $message['text'] }}
                    </div>
                @endif

                <table class="table" id="timetable">
                    <tr>
                        <th>data</th>
                        <th>entrada #1</th>
                        <th>saída #1</th>
                        <th>entrada #2</th>
                        <th>saída #2</th>
                        <th>entrada #3</th>
                        <th>saída #3</th>
                        <th>Saldo</th>
                        <th>&nbsp;</th>
                    </tr>
                    @forelse($workdays as $workday)
                    <tr item-id="{{ $workday->id }}">
                        <td>{!! empty($workday->date) ? '<i class="oi oi-warning"></i>' : $workday->date !!}</td>
                        <td>@formatTime($workday->in1)</td>
                        <td>@formatTime($workday->out1)</td>
                        <td>@formatTime($workday->in2)</td>
                        <td>@formatTime($workday->out2)</td>
                        <td>@formatTime($workday->in3)</td>
                        <td>@formatTime($workday->out3)</td>
                        <td>
                            @if($workday->balance->sign == '-')
                            <span class="negative-balance">&#45;@formatTime($workday->balance->value)</span>
                            @elseif($workday->balance->sign == '+')
                            <span class="positive-balance">&#43;@formatTime($workday->balance->value)</span>
                            @else
                            <span class="">@formatTime($workday->balance)</span>
                            @endif
                        </td>
                        <td>
                            <button meta-route="{{ route('workday.destroy', ['id'=>$workday->_id]) }}" class="btn btn-danger-outline btn-sm delete-item"><span class="oi oi-trash"></span></button>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="100" align="center">Não há nenhum registro. Insira as informações abaixo para cadastrar</td>
                        </tr>
                    @endforelse
                    <form action="{{ route('workday.store') }}" method="post" id="workday-registration">
                    <tr>
                        {{--<td><input type="text" name="date" id="date" class="form-control" maxlength="10" placeholder="Data"></td>--}}
                        <td>
                            <div class="form-group">
                                <input type="text" name="date" id="date" class="form-control" maxlength="10" placeholder="Data">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input type="text" name="in1" id="in1" class="form-control" maxlength="5" placeholder="Entrada #1">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input type="text" name="out1" id="out1" class="form-control" maxlength="5" placeholder="Saída #1">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input type="text" name="in2" id="in2" class="form-control" maxlength="5" placeholder="Entrada #2">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input type="text" name="out2" id="out2" class="form-control" maxlength="5" placeholder="Saída #2">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input type="text" name="in3" id="in3" class="form-control" maxlength="5" placeholder="Entrada #3">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input type="text" name="out3" id="out3" class="form-control" maxlength="5" placeholder="Saída #3">
                            </div>
                        </td>
                        {{--<td><a href="{{ route('workday.store') }}" class="btn btn-primary-outline" role="button">Salvar</a></td>--}}
                        <td><button class="btn btn-primary-outline" type="submit">Salvar</button></td>
                        <td></td>
                    </tr>
                    </form>
                </table>
            </div><!-- .col-sm-12 -->
        </div><!-- .row -->
        <div class="row">
            <h2>Balanço mensal: {{ $month_balance }}</h2>
        </div><!-- .row -->
    </div><!-- .container -->
</body>

<footer class="scripts">
    <!-- jQuery 2.1.4 -->
    <script type="text/javascript" src="{{ url('/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 4.0-alpha -->
    <script type="text/javascript" src="{{ url('/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- isJs 0.7.4 -->
    <script type="text/javascript" src="{{ url('/bower_components/is_js/is.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script type="text/javascript" src="{{ url('/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 Languages -->
    <script type="text/javascript" src="{{ url('/bower_components/jquery-ui/ui/i18n/datepicker-pt-BR.js') }}"></script>
    <!-- jQuery Mask Plugin 1.13.4 -->
    <script type="text/javascript" src="{{ url('/bower_components/jquery-mask-plugin/dist/jquery.mask.min.js') }}"></script>
    <!-- Page Scripts -->
    <script type="text/javascript" src="{{ url('/js/main.js') }}"></script>
</footer>
</html>