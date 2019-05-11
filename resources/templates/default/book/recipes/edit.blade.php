@extends('book.layout.base')

@section('book_title')
  Editar Receta -
  <a href="{{$base_url}}/book/recipe/{{$recipe->id}}">{{$recipe->title}}</a>
@endsection

@section('book_content')
  <form class="ui form" method="post" action="{{$base_url}}/book/recipe/{{$recipe->id}}/edit">
    @include('layout.form.input', ['label' => 'Título', 'name' => 'title', 'value' => $recipe->title])
    <div class="inline field">
      <label>Categor&iacute;as</label>
      <div class="ui multiple selection dropdown" id="categories">
        <input type="hidden" name="categories" />
        <i class="dropdown icon"></i>
        <div class="default text">Categor&iacute;as</div>
        <div class="menu">
        </div>
      </div>
    </div>
    @include('layout.form.input', ['label' => 'Alimenta a', 'name' => 'feeds', 'value' => $recipe->feeds])
    @include('layout.form.input', ['label' => '[Imagen]', 'name' => 'image', 'value' => $recipe->image])
    <button class="ui button">Editar</button>
  </form>
@endsection

@push('scripts')
  <script type="text/javascript">
  $('#categories').dropdown()
  $(document).ready(function() {
    $.getJSON('{{$base_url}}/api/categories', function(data) {
      var info = {values: []}
      $.each(data.categories, function(i, el) {
        info.values.push({value: el.id, text: el.description, name: el.description})
      })
      $('#categories').dropdown('change values', info.values)
      @if ($recipe->categories())
        var selected = []
        @foreach ($recipe->categories() as $category)
          selected.push('{{$category->id}}')
        @endforeach
        $('#categories').dropdown('set selected', selected)
      @endif
    })
  })
  </script>
@endpush
