@extends('admin.layout.base')

@section('admin_title')
  Agregar - Receta
@endsection

@section('admin_content')
  <form class="ui form" method="post" action="{{$base_url}}/book/recipes/add">
    <div class="field">
      <label>T&iacute;tulo</label>
      <input type="text" name="title" />
    </div>
    <div class="field">
      <label>Categor&iacute;as</label>
      <div class="ui multiple selection dropdown" id="categories">
        <input type="hidden" name="categories" />
        <i class="dropdown icon"></i>
        <div class="default text">Categor&iacute;as</div>
        <div class="menu">
        </div>
      </div>
    </div>
    <div class="field">
      <label>[Imagen]</label>
      <input type="text" name="image" />
    </div>
    <button class="ui button">Agregar</button>
  </form>
@endsection

@push('scripts')
  <script type="text/javascript">
  $('#categories').dropdown()
  $(document).ready(function() {
    $.getJSON('{{$base_url}}/api/recipecategories', function(data) {
      var info = {values: []}
      $.each(data.categories, function(i, el) {
        info.values.push({value: el.id, text: el.description, name: el.description})
      })
      $('#categories').dropdown('change values', info.values)
    })
  })
  </script>
@endpush
