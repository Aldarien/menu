@extends('layout.base')

@section('content')
  <div class="ui top attached segment">
    @include('book.layout.menu')
  </div>
  <h1 class="ui middle attached header">
    @yield('book_title')
  </h1>
  <div class="ui bottom attached segment">
    @yield('book_content')
  </div>
@endsection
