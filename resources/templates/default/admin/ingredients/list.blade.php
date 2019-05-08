@extends('admin.layout.base')

@section('admin_content')
  <h1>Ingredientes</h1>
  <table class="ui table">
    <thead>
      <tr>
        <th>Descripci&oacute;n</th>
        <th><a href="{{$base_url}}/admin/ingredienttypes">Tipos</a></th>
        <th class="right aligned">
          <a href="{{$base_url}}/admin/ingredients/add"><i class="plus icon"></i></a>
        </tr>
      </tr>
    </thead>
    <tbody>
      @foreach ($ingredients as $ingredient)
        <tr>
          <td><a href="{{$base_url}}/admin/ingredient/{{$ingredient->id}}">{{ucwords($ingredient->description)}}</a></td>
          <td>
            @if ($ingredient->types())
              <div class="ui grid">
                <div class="row">
                  @foreach ($ingredient->types('description') as $type)
                    <div class="column">
                      <a href="{{$base_url}}/admin/ingredienttype/{{$type->id}}">
                        {{ucwords($type->description)}}
                      </a>
                    </div>
                  @endforeach
                </div>
              </div>
            @endif
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
