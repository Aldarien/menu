@extends('admin.layout.base')

@section('admin_title')
  Envase - {{$vessel->description}}
  <a href="{{$base_url}}/admin/vessels">
    <i class="small level up icon"></i>
  </a>
@endsection

@section('admin_content')
  <table class="ui table">
    <thead>
      <tr>
        <th>M&eacute;todos</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($vessel->methods() as $method)
        <tr>
          <td>
            <a href="{{$base_url}}/admin/method/{{$method->id}}">
              {{$method->description}}
            </a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
