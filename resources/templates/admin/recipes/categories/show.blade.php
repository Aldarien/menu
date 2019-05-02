@extends('admin.layout.base')

@section('admin_content')
  <h1>
    <div class="ui grid">
      <div class="two columns row">
        <div class="column">Categor&iacute;a - {{ucwords($category->description)}} <a href="{{$base_url}}/admin/recipecategories"><i class="small level up icon"></i></a></div>
        <div class="right aligned column">
          <a href="{{$base_url}}/admin/recipecategory/{{$category->id}}/edit"><i class="small edit icon"></i></a>
          <a href="{{$base_url}}/admin/recipecategory/{{$category->id}}/remove"><i class="small remove icon"></i></a>
        </div>
      </div>
    </div>
  </h1>
  <table class="ui table">
    <thead>
      <tr>
        <th>Recetas</th>
        <th class="right aligned">
          <a href="{{$base_url}}/admin/recipecategory/{{$category->id}}/recipes/add">
            <i class="plus icon"></i>
          </a>
        </th>
      </tr>
    </thead>
    @if ($category->recipes())
      <tbody>
        @foreach ($category->recipes('title') as $recipe)
          <tr>
            <td>
              <a href="{{$base_url}}/admin/recipe/{{$recipe->id}}">
                {{$recipe->title}}
              </a>
            </td>
            <td class="right aligned">
              <a href="{{$base_url}}/admin/recipecategory/{{$category->id}}/recipe/{{$recipe->id}}/remove">
                <i class="remove icon"></i>
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    @endif
  </table>
@endsection
