@if (session('messages'))
  @foreach (session('messages') as $message)
    <div class="alert alert-{!! $message['type'] !!} alert-dismissible fade in" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
      </button>
      {{ $message['text'] }}
    </div>
  @endforeach
@endif

@if($errors->has())
  @foreach ($errors->all() as $error)
    <div class="alert alert-error alert-dismissible fade in" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
      </button>
      {{ $error }}
    </div>
  @endforeach
@endif
