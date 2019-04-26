@extends('layout.base')

@section('content')
  <ul>
  @foreach ($types as $type)
    <li>{{$type->description}}</li>
  @endforeach
  </ul>
@endsection
