@extends('layout.base')

@section('content')
  <div class="ui top attached segment">
    @include('planner.layout.menu')
  </div>
  <h1 class="ui middle attached header">
    @yield('planner_title')
  </h1>
  <div class="ui bottom attached segment">
    @yield('planner_content')
  </div>
@endsection
