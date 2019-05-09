@extends('book.layout.base')

@section('book_title')
  Agregar - Categor&iacute;a a Receta
  <a href="{{$base_url}}/book/recipe/{{$recipe->id}}">
    {{$recipe->title}}
  </a>
@endsection

@section('book_content')
  <form class="ui form" method="post" action="{{$base_url}}/book/recipe/{{$recipe->id}}/categories/add">
    <div class="field">
      <label>Descripci&oacute;n</label>
      <div class="ui multiple selection dropdown">
        <input type="hidden" name="categories" />
        <i class="dropdown icon"></i>
        <div class="default text">Categor&iacute;a</div>
        <div class="menu">
          @foreach ($categories as $category)
            <div class="item" data-value="{{$category->id}}">{{$category->description}}</div>
          @endforeach
        </div>
      </div>
    </div>
    <button class="ui button">Agregar</button>
  </form>
@endsection

@push('scripts')
  <script type="text/javascript">
  $('.ui.selection.dropdown').dropdown()
  var selected = [
    @foreach ($recipe->categories() as $category)
    '{{$category->id}}',
    @endforeach
  ]
  $('.ui.selection.dropdown').dropdown('set selected', selected)
  </script>
@endpush
