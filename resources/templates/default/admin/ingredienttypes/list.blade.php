@extends('admin.layout.base')

@section('admin_content')
  <h1>Tipos de Ingredientes</h1>
  <table class="ui table">
    <thead>
      <tr>
        <th>Descripci&oacute;n</th>
        <th>Ingredientes</th>
        <th class="right aligned">
          <a href="{{$base_url}}/admin/ingredienttypes/add"><i class="plus icon"></i></a>
        </tr>
      </tr>
    </thead>
    <tbody>
      @foreach ($types as $type)
        <tr>
          <td><a href="{{$base_url}}/admin/ingredienttype/{{$type->id}}">{{ucwords($type->description)}}</a></td>
          <td>
            @if ($type->ingredients())
              <div class="ui grid">
                <div class="row">
                  @foreach ($type->ingredients('description') as $ingredient)
                    <div class="column">
                      {{ucwords($ingredient->description)}}
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
