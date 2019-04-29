@extends('admin.layout.base')

@section('admin_content')
  <h1>
    <div class="ui grid">
      <div class="two columns row">
        <div class="column">
          Tipo de Ingrediente - {{ucwords($type->description)}}
          <a href="{{$base_url}}/admin/ingredienttypes"><i class="small level up alternate icon"></i></a>
        </div>
        <div class="right aligned column">
          <a href="{{$base_url}}/admin/ingredienttype/{{$type->id}}/edit"><i class="small edit icon"></i></a>
          <a href="{{$base_url}}/admin/ingredienttype/{{$type->id}}/remove"><i class="small remove icon"></i></a>
        </div>
      </div>
    </div>
  </h1>
  <table class="ui table">
    <thead>
      <tr>
        <th>Ingredientes</th>
        <th class="right aligned">
          <a href="{{$base_url}}/admin/ingredienttype/{{$type->id}}/ingredients/add">
            <i class="plus icon"></i>
          </a>
        </th>
      </tr>
    </thead>
    @if ($type->ingredients())
      <tbody>
        @foreach ($type->ingredients() as $ingredient)
          <tr>
            <td>
              <a href="{{$base_url}}/admin/ingredient/{{$ingredient->id}}">
                {{ucwords($ingredient->description)}}
              </a>
            </td>
            <td class="right aligned">
              <a href="{{$base_url}}/admin/ingredienttype/{{$type->id}}/ingredient/{{$ingredient->id}}/remove">
                <i class="remove icon"></i>
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    @endif
  </table>
@endsection
