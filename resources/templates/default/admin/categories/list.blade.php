@extends('admin.layout.base')

@section('admin_content')
  <h1>Categor&iacute;as de Recetas</h1>
  <table class="ui table">
    <thead>
      <tr>
        <th>Descripci&oacute;n</th>
        <th class="right aligned">
          <a href="{{$base_url}}/admin/categories/add"><i class="plus icon"></i></a>
        </tr>
      </tr>
    </thead>
    <tbody>
      @foreach ($categories as $category)
        <tr>
          <td><a href="{{$base_url}}/admin/categories/{{$category->id}}">{{ucwords($category->description)}}</a></td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
