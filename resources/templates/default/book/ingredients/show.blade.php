@extends('book.layout.base')

@section('book_title')
  <div class="ui two column grid">
    <div class="row">
      <div class="column">
        Ingrediente - {{$ingredient->description}}
        <a href="{{$base_url}}/book/ingredients">
          <i class="tiny level up icon"></i>
        </a>
      </div>
      <div class="right aligned column">
        <a href="{{$base_url}}/book/ingredient/{{$ingredient->id}}/edit">
          <i class="tiny edit icon"></i>
        </a>
      </div>
    </div>
  </div>
@endsection

@section('book_content')
  <table class="ui table">
    <thead>
      <tr>
        <th>Tipos</th>
      </tr>
    </thead>
    @if ($ingredient->types())
      <tbody>
        @foreach ($ingredient->types() as $type)
          <tr>
            <td>{{$type->description}}</td>
          </tr>
        @endforeach
      </tbody>
    @endif
  </table>
  <table class="ui table">
    <thead>
      <tr>
        <th>Recetas</th>
      </tr>
    </thead>
    @if ($ingredient->recipes())
      <tbody>
        @foreach ($ingredient->recipes() as $recipe)
          <tr>
            <td>
              <a href="{{$base_url}}/book/recipe/{{$recipe->id}}">
                {{$recipe->title}}
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    @endif
  </table>
@endsection
