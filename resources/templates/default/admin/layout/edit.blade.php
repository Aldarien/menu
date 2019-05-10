@extends('admin.layout.base')

@section('admin_title')
  Editar
  @yield('title')
  <a href="{{$base_url}}/admin/{{$list}}"><i class="small level up icon"></i></a>
@endsection

@section('admin_content')
  <form class="ui form" method="post" action="{{$base_url}}/admin/{{$link}}/edit">
    @yield('fields')
    <button class="ui button">Editar</button>
  </form>
@endsection
