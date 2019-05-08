@extends('admin.layout.base')

@section('admin_title')
  Recetas
@endsection

@section('admin_content')
  <table class="ui table">
    <thead>
      <tr>
        <th>T&iacute;tulo</th>
        <th>Categor&iacute;a</th>
        <th class="right aligned">
          <a href="{{$base_url}}/admin/recipes/add"><i class="plus icon"></i></a>
        </tr>
      </tr>
    </thead>
    <tbody>
      @foreach ($recipes as $recipe)
        <tr>
          <td><a href="{{$base_url}}/admin/recipe/{{$recipe->id}}">{{$recipe->title}}</a></td>
          <td>
            @if ($recipe->categories())
              <div class="ui grid">
                <div class="row">
                  @foreach ($recipe->categories('description') as $category)
                    <div class="column">
                      <a href="{{$base_url}}/admin/recipecategory/{{$category->id}}">
                        {{ucwords($category->description)}}
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
