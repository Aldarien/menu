@extends('admin.layout.base')

@section('admin_title')
  Elementos
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
    @if ($vessels)
      <tbody>
        @foreach ($vessels as $vessel)
          <tr>
            <td>{{$vessel->description}}</td>
            <td class="right aligned">
              <a href="{{$base_url}}/admin/vessel/{{$vessel->id}}/edit">
                <i class="edit icon"></i>
              </a>
              <a href="{{$base_url}}/admin/vessel/{{$vessel->id}}/remove">
                <i class="remove icon"></i>
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    @endif
  </table>
@endsection
