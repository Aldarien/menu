@extends('book.layout.base')

@section('book_title')
  Recetas
@endsection

@section('book_content')
  <table class="ui table">
    <thead>
      <tr>
        <th>T&iacute;tulo</th>
        <th>Categor&iacute;a</th>
        <th class="right aligned">
          <a href="{{$base_url}}/book/recipes/add"><i class="plus icon"></i></a>
        </tr>
      </tr>
    </thead>
    <tbody>
      @foreach ($recipes as $recipe)
        <tr>
          <td><a href="{{$base_url}}/book/recipe/{{$recipe->id}}">{{$recipe->title}}</a></td>
          <td>
            @if ($recipe->categories())
              <div class="ui grid">
                <div class="row">
                  @foreach ($recipe->categories('description') as $category)
                    <div class="column">
                      {{ucwords($category->description)}}
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
