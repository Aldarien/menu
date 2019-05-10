@extends('admin.layout.base')

@section('admin_title')
  Agregar
  @yield('title')
  <a href="{{$base_url}}/admin/{{$list}}"><i class="small level up icon"></i></a>
@endsection

@section('admin_content')
  <form class="ui form" method="post" action="{{$base_url}}/admin/{{$list}}/add">
    @yield('fields')
    <button class="ui button">Agregar</button>
  </form>
@endsection
