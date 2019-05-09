@extends('admin.layout.base')

@section('admin_title')
  M&eacute;todo - {{$method->description}}
  <a href="{{$base_url}}/admin/methods">
    <i class="small level up icon"></i>
  </a>
@endsection

@section('admin_content')
  <br />
  Envase:
  <a href="{{$base_url}}/admin/vessel/{{$method->vessel()->id}}">
    {{$method->vessel()->description}}
  </a>
@endsection
