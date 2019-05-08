@extends('layout.base')

@section('content')
  @include('admin.layout.header')
  <div class="ui bottom attached segment">
    <h1 class="ui dividing header">
      @yield('admin_title')
    </h1>
    @yield('admin_content')
  </div>
@endsection
