@extends('layout.base')

@section('content')
  <div class="ui striped list">
  @foreach ($types as $type)
    <div class="item">{{$type->description}}</div>
  @endforeach
  </div>
@endsection
