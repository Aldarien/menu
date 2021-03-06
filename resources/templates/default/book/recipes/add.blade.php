@extends('book.layout.base')

@section('book_title')
  Agregar - Receta
@endsection

@section('book_content')
  <form class="ui form" method="post" action="{{$base_url}}/book/recipes/add">
    @include('layout.form.input', ['label' => 'Título', 'name' => 'title'])
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
    @include('layout.form.input', ['label' => 'Alimenta a', 'name' => 'feeds'])
    @include('layout.form.input', ['label' => '[Imagen]', 'name' => 'image'])
    <button class="ui button">Agregar</button>
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
    })
  })
  </script>
@endpush
