@extends('admin.layout.base')

@section('admin_title')
  Envases
@endsection

@section('admin_content')
  <table class="ui table">
    <thead>
      <tr>
        <th>Descripci&oacute;n</th>
        <th class="right aligned">
          <a href="{{$base_url}}/admin/vessels/add"><i class="plus icon"></i></a>
        </tr>
      </tr>
    </thead>
    <tbody>
      @foreach ($vessels as $vessel)
        <tr>
          <td><a href="{{$base_url}}/admin/vessel/{{$vessel->id}}">{{$vessel->description}}</a></td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
