@if (session('messages'))
    @foreach (session('messages') as $message)
        <div class="alert alert-{!! $message['type'] !!} alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{ $message['text'] }}
        </div>
    @endforeach
@endif

@if($errors->has())
   @foreach ($errors->all() as $error)
   <div class="alert alert-error alert-dismissible" role="alert">
       <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
       {{ $error }}
   </div>
  @endforeach
@endif
