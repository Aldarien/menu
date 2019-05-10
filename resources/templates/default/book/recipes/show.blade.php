@extends('book.layout.base')

@section('book_title')
  <div class="ui grid">
    <div class="two columns row">
      <div class="column">Receta - {{$recipe->title}} <a href="{{$base_url}}/book/recipes"><i class="small level up icon"></i></a></div>
      <div class="right aligned column">
        <a href="{{$base_url}}/book/recipe/{{$recipe->id}}/edit"><i class="small edit icon"></i></a>
        <a href="{{$base_url}}/book/recipe/{{$recipe->id}}/remove"><i class="small remove icon"></i></a>
      </div>
    </div>
  </div>
@endsection

@section('book_content')
  <table class="ui table">
    <thead>
      <tr>
        <th>Categor&iacute;as</th>
        <th class="right aligned">
          <a href="{{$base_url}}/book/recipe/{{$recipe->id}}/categories/add">
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
              {{ucwords($category->description)}}
            </td>
            <td class="right aligned">
              <a href="{{$base_url}}/book/recipe/{{$recipe->id}}/category/{{$category->id}}/remove">
                <i class="remove icon"></i>
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    @endif
  </table>
  <div class="ui message">
    Alimenta a {{$recipe->feeds()}} personas
  </div>
  <table class="ui collapsing table">
    <thead>
      <tr>
        <th>Ingredientes</th>
      </tr>
    </thead>
    @if ($recipe->ingredients())
      <tbody>
        @foreach ($recipe->ingredients() as $ingredient)
          <tr>
            <td>
              <i class="mini circle icon"></i> {{$ingredient->amount($recipe)}} {{$ingredient->unit($recipe)->abreviation}}. de
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
          <a href="{{$base_url}}/book/recipe/{{$recipe->id}}/steps/add">
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
              {{$step->method()->description}}
              @if ($step->ingredients())
                @foreach ($step->ingredients() as $ingredient)
                  {{$ingredient->amount($recipe)}} {{$ingredient->unit($recipe)->abreviation}} de {{$ingredient->description}}
                @endforeach
              @endif
              en {{$step->method()->vessel()->description}}
            </td>
            <td class="right aligned">
              <a href="{{$base_url}}/book/recipe/{{$recipe->id}}/step/{{$step->id}}/remove">
                <i class="remove icon"></i>
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    @endif
  </table>
@endsection
