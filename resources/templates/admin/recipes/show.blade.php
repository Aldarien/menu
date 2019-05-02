@extends('admin.layout.base')

@section('admin_content')
  <h1>
    <div class="ui grid">
      <div class="two columns row">
        <div class="column">Receta - {{$recipe->title}} <a href="{{$base_url}}/admin/recipes"><i class="small level up icon"></i></a></div>
        <div class="right aligned column">
          <a href="{{$base_url}}/admin/recipe/{{$recipe->id}}/edit"><i class="small edit icon"></i></a>
          <a href="{{$base_url}}/admin/recipe/{{$recipe->id}}/remove"><i class="small remove icon"></i></a>
        </div>
      </div>
    </div>
  </h1>
  <table class="ui table">
    <thead>
      <tr>
        <th>Categor&iacute;as</th>
        <th class="right aligned">
          <a href="{{$base_url}}/admin/recipe/{{$recipe->id}}/categories/add">
            <i class="plus icon"></i>
          </a>
        </th>
      </tr>
    </thead>
    @if ($recipe->categories())
      <tbody>
        @foreach ($recipe->categories('description') as $category)
          <tr>
            <td>
              <a href="{{$base_url}}/admin/recipecategory/{{$category->id}}">
                {{ucwords($category->description)}}
              </a>
            </td>
            <td class="right aligned">
              <a href="{{$base_url}}/admin/recipe/{{$recipe->id}}/category/{{$category->id}}/remove">
                <i class="remove icon"></i>
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    @endif
  </table>
  <table class="ui table">
    <thead>
      <tr>
        <th colspan="3">Ingredientes</th>
      </tr>
    </thead>
    @if ($recipe->ingredients())
      <tbody>
        @foreach ($recipe->ingredients() as $ingredient)
          <tr>
            <td>{{$ingredient->amount}}</td>
            <td>{{$ingredient->unit($recipe)->description}}</td>
            <td>
              {{ucwords($ingredient->description)}}
            </td>
          </tr>
        @endforeach
      </tbody>
    @endif
  </table>
  <table class="ui table">
    <thead>
      <tr>
        <th>Pasos</th>
        <th></th>
        <th class="right aligned">
          <a href="{{$base_url}}/admin/recipe/{{$recipe->id}}/steps/add">
            <i class="plus icon"></i>
          </a>
        </th>
      </tr>
    </thead>
    @if ($recipe->steps())
      <tbody>
        @foreach ($recipe->steps() as $step)
          <tr>
            <td>{{$step->order($recipe)}}</td>
            <td>
              {{$step->method}}
              <table class="ui table">
                <thead>
                  <tr>
                    <th>Cantidad</th>
                    <th>Ingrediente</th>
                  </tr>
                </thead>
                @if ($step->ingredients())
                  <tbody>
                  </tbody>
                @endif
              </table>
            </td>
            <td class="right aligned">
              <a href="{{$base_url}}/admin/recipe/{{$recipe->id}}/step/{{$step->id}}/remove">
                <i class="remove icon"></i>
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    @endif
  </table>
@endsection
