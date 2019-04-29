@extends('admin.layout.base')

@section('admin_content')
  <h1>
    <div class="ui grid">
      <div class="two columns row">
        <div class="column">Ingrediente - {{ucwords($ingredient->description)}} <a href="{{$base_url}}/admin/ingredients"><i class="small level up icon"></i></a></div>
        <div class="right aligned column">
          <a href="{{$base_url}}/admin/ingredient/{{$ingredient->id}}/edit"><i class="small edit icon"></i></a>
          <a href="{{$base_url}}/admin/ingredient/{{$ingredient->id}}/remove"><i class="small remove icon"></i></a>
        </div>
      </div>
    </div>
  </h1>
  <table class="ui table">
    <thead>
      <tr>
        <th>Tipos</th>
        <th class="right aligned">
          <a href="{{$base_url}}/admin/ingredient/{{$ingredient->id}}/types/add">
            <i class="plus icon"></i>
          </a>
        </th>
      </tr>
    </thead>
    @if ($ingredient->types())
      <tbody>
        @foreach ($ingredient->types() as $type)
          <tr>
            <td>
              <a href="{{$base_url}}/admin/ingredienttype/{{$type->id}}">
                {{ucwords($type->description)}}
              </a>
            </td>
            <td class="right aligned">
              <a href="{{$base_url}}/admin/ingredient/{{$ingredient->id}}/type/{{$type->id}}/remove">
                <i class="remove icon"></i>
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    @endif
  </table>
@endsection
