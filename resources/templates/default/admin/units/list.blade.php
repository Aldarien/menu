@extends('admin.layout.base')

@section('admin_title')
  Unidades
@endsection

@section('admin_content')
  <table class="ui table">
    <thead>
      <tr>
        <th>Descripci&oacute;n</th>
        <th>Abreviaci&oacute;n</th>
        <th class="right aligned">
          <a href="{{$base_url}}/admin/units/add"><i class="plus icon"></i></a>
        </tr>
      </tr>
    </thead>
    @if ($units)
      <tbody>
        @foreach ($units as $unit)
          <tr>
            <td>{{$unit->description}}</td>
            <td>{{$unit->abreviation}}</td>
            <td class="right aligned">
              <a href="{{$base_url}}/admin/unit/{{$unit->id}}/edit">
                <i class="edit icon"></i>
              </a>
              <a href="{{$base_url}}/admin/unit/{{$unit->id}}/remove">
                <i class="remove icon"></i>
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    @endif
  </table>
@endsection
