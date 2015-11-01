@extends('layouts.master')

@section('title')
  Track your working time
@stop

@section('header')
  <div class="col-sm-12">
    <p class="title">ClockIn.</p>
  </div>
@stop

@section('content')
  <div class="col-sm-12">
    @if (session('message'))
      <div class="alert alert-{{ $message['type'] }} alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        {{ $message['text'] }}
      </div>
    @endif
    <table class="table out-table">
      @forelse ($months as $monthName => $monthWorkdays)
        <tr>
          <td>
            <table class="table days-table">
              <tr class="month-title">
                <th colspan="100" align="center">{{ $monthName }}</th>
              </tr>
              <tr class="days-table-header">
                <td>date</td>
                <td>arrival #1</td>
                <td>leaving #1</td>
                <td>arrival #2</td>
                <td>leaving #2</td>
                <td>arrival #3</td>
                <td>leaving #3</td>
                <td>balance</td>
                <td>&nbsp;</td>
              </tr>
              @foreach ($monthWorkdays as $workday)
                <tr item-id="{!! $workday->id !!}">
                  <td>{!! empty($workday->date) ? '<i class="oi oi-warning"></i>' : $workday->date->format('d/m/Y') !!}</td>
                  <td>@formatTime($workday->arrival1)</td>
                  <td>@formatTime($workday->leaving1)</td>
                  <td>@formatTime($workday->arrival2)</td>
                  <td>@formatTime($workday->leaving2)</td>
                  <td>@formatTime($workday->arrival3)</td>
                  <td>@formatTime($workday->leaving3)</td>
                  <td>
                    @if ($workday->balance->sign == '-')
                      <span class="negative-balance">&#45;@formatTime($workday->balance->value)</span>
                    @elseif ($workday->balance->sign == '+')
                      <span class="positive-balance">&#43;@formatTime($workday->balance->value)</span>
                    @else
                      <span class="">@formatTime($workday->balance->value)</span>
                    @endif
                  </td>
                  <td>
                    <button title="delete item"
                            meta-route="{!! route('workday.destroy', ['id'=>$workday->id]) !!}"
                            class="btn btn-danger-outline btn-sm delete-item">
                      <span class="oi oi-trash"></span>
                    </button>
                  </td>
                </tr>
              @endforeach
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Total:</td>
                <td>
                  @formatTime($monthlyBalances[$monthName])
                </td>
                <td>&nbsp;</td>
              </tr>
            </table>
          </td>
        </tr>
      @empty
        <tr>
          <td>
            <table class="table days-table">
              <tr class="days-table-header">
                <td>date</td>
                <td>arrival #1</td>
                <td>leaving #1</td>
                <td>arrival #2</td>
                <td>leaving #2</td>
                <td>arrival #3</td>
                <td>leaving #3</td>
                <td>balance</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td colspan="100" align="center">No data has been registered yet. You can start now by inserting them right below.</td>
              </tr>
            </table>
          </td>
        </tr>
      @endforelse
    </table>
  </div>
@stop

@section('scripts')
  <!-- jQuery UI 1.11.4 -->
  <script type="text/javascript" src="{{ url('/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
  <!-- jQuery UI 1.11.4 Languages -->
  <script type="text/javascript" src="{{ url('/bower_components/jquery-ui/ui/i18n/datepicker-pt-BR.js') }}"></script>
  <!-- jQuery Mask Plugin 1.13.4 -->
  <script type="text/javascript" src="{{ url('/bower_components/jquery-mask-plugin/dist/jquery.mask.min.js') }}"></script>
  <!-- jQuery Cookie Plugin 1.4.1 -->
  <script type="text/javascript" src="{{ url('/bower_components/jquery.cookie/jquery.cookie.js') }}"></script>
  <!-- Moment.js 2.10.6 -->
  <script type="text/javascript" src="{{ url('/bower_components/moment/min/moment.min.js') }}"></script>
  <!-- Page Scripts -->
  <script type="text/javascript" src="{{ url('assets/js/pages/main.js') }}"></script>
@stop

@section('footer')
  <br />
  <br />
  <div id="fixed-register-form">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <form action="{{ route('workday.store') }}"
                method="post"
                id="workday-registration">
            <table class="table">
              <tbody>
              <tr>
                <td>
                  <div class="profile">
                    <ul class="nav navbar-nav">
                      <li class="dropdown">
                        <a href="#"
                           class="dropdown-toggle dropup-toggle"
                           data-toggle="dropdown"
                           role="button"
                           aria-haspopup="true"
                           aria-expanded="false">
                          <img src="{{ url('assets/img/profile/batman.jpg') }}"
                               alt=""
                               class="img-circle img-responsive">
                        </a>
                        <ul class="dropdown-menu dropup-menu">
                          <li class="dropdown-item">
                            <a href="{{ url('/logout') }}">&nbsp;&nbsp;Logout</a>
                          </li>
                        </ul>
                      </li>
                    </ul>
                  </div>
                </td>
                <td>
                  <div class="form-group">
                    <input type="text"
                           name="date"
                           id="date"
                           class="form-control"
                           maxlength="10"
                           placeholder="Data">
                  </div>
                </td>
                <td>
                  <div class="form-group">
                    <input type="text"
                           name="in1"
                           id="in1"
                           class="form-control"
                           maxlength="5"
                           placeholder="Arrival #1">
                  </div>
                </td>
                <td>
                  <div class="form-group">
                    <input type="text"
                           name="out1"
                           id="out1"
                           class="form-control"
                           maxlength="5"
                           placeholder="Leaving #1">
                  </div>
                </td>
                <td>
                  <div class="form-group">
                    <input type="text"
                           name="in2"
                           id="in2"
                           class="form-control"
                           maxlength="5"
                           placeholder="Arrival #2">
                  </div>
                </td>
                <td>
                  <div class="form-group">
                    <input type="text"
                           name="out2"
                           id="out2"
                           class="form-control"
                           maxlength="5"
                           placeholder="Leaving #2">
                  </div>
                </td>
                <td>
                  <div class="form-group">
                    <input type="text"
                           name="in3"
                           id="in3"
                           class="form-control"
                           maxlength="5"
                           placeholder="Arrival #3">
                  </div>
                </td>
                <td>
                  <div class="form-group">
                    <input type="text"
                           name="out3"
                           id="out3"
                           class="form-control"
                           maxlength="5"
                           placeholder="Leaving #3">
                  </div>
                </td>
                <td>
                  <div id="current-worktime">00:00</div>
                </td>
                <td>
                  <button class="btn btn-primary-outline" type="submit">Save</button>
                </td>
              </tr>
              </tbody>
            </table>
          </form>
        </div>
      </div>
    </div>
  </div>
@stop
