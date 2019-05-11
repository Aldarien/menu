@extends('book.layout.base')

@section('book_title')
  Agregar Ingrediente
  <a href="{{$base_url}}/book/ingredients">
    <i class="small level up icon"></i>
  </a>
@endsection

@section('book_content')
  <form class="ui form" method="post" action="{{$base_url}}/book/ingredients/add">
    @include('layout.form.input', ['label' => 'Descripción', 'name' => 'description'])
    <div class="inline field">
      <label>Tipos</label>
      <div class="ui multiple selection dropdown" id="types">
        <input type="hidden" name="types" />
        <i class="dropdown icon"></i>
        <div class="default text">Tipos</div>
        <div class="menu"></div>
      </div>
    </div>
    <button class="ui button">Agregar</button>
  </form>
@endsection

@push('scripts')
  <script type="text/javascript">
  $('#types').dropdown()
  $(document).ready(function() {
    $.getJSON('{{$base_url}}/api/ingredienttypes', function(data) {
      var types = []
      $.each(data.ingredienttypes, function(i, el) {
        types.push({value: el.id, name: el.description, description: el.description})
      })
      $('#types').dropdown('change values', types)
    })
  })
  </script>
@endpush
