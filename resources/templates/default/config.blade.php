@extends('layout.base')

@section('content')
  <h1 class="ui dividing header">Configuraci&oacute;n</h1>
  @if ($configs)
    <form class="ui form" method="post" action="{{$base_url}}/config">
      <input type="hidden" name="configs" value="{{count($configs)}}" />
      @foreach ($configs as $i => $config)
        <input type="hidden" name="config.{{$i}}.id" />
        <div class="inline field">
          <label>{{$config->description}}</label>
          <input type="text" name="config.{{$i}}.value" value="{{$config->value}}" />
        </div>
      @endforeach
      <button class="ui button">Guardar</button>
    </form>
  @endif
@endsection
