@extends('admin.layout.base')

@section('admin_content')
  <h1>M&eacute;todos</h1>
  <table class="ui table">
    <thead>
      <tr>
        <th>Descripci&oacute;n</th>
        <th>Envase</th>
        <th class="right aligned">
          <a href="{{$base_url}}/admin/methods/add"><i class="plus icon"></i></a>
        </tr>
      </tr>
    </thead>
    <tbody>
      @foreach ($methods as $method)
        <tr>
          <td><a href="{{$base_url}}/admin/method/{{$method->id}}">{{$method->description}}</a></td>
          <td><a href="{{$base_url}}/admin/vessel/{{$method->vessel()->id}}">{{$method->vessel()->description}}</a></td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
