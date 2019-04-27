@extends('admin.layout.base')

@section('admin_content')
  <h1>Ingredientes</h1>
  <table class="ui table">
    <thead>
      <tr>
        <th>Descripci&oacute;n</th>
        <th>Tipos</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($ingredients as $ingredient)
        <tr>
          <td><a href="{{$base_url}}/admin/ingredient/{{$ingredient->id}}">{{ucwords($ingredient->description)}}</a></td>
          <td>
            @if ($ingredient->types())
              {{implode(', ', $ingredient->types('description'))}}
            @endif
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
