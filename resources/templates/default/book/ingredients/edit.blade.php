@extends('book.layout.base')

@section('book_title')
  Editar Ingrediente -
  <a href="{{$base_url}}/book/ingredient/{{$ingredient->id}}">
    {{$ingredient->description}}
    <i class="icons">
      <i class="icon"></i>
      <i class="bottom right corner level up icon"></i>
    </i>
  </a>
@endsection

@section('book_content')
  <form class="ui form" method="post" action="{{$base_url}}/book/ingredient/{{$ingredient->id}}/edit">
    @include('layout.form.input', ['label' => 'Descripción', 'name' => 'description', 'value' => $ingredient->description])
    <div class="inline field">
      <label>Tipos</label>
      <div class="ui multiple selection dropdown" id="types">
        <input type="hidden" name="types" />
        <i class="dropdown icon"></i>
        <div class="default text">Tipos</div>
        <div class="menu"></div>
      </div>
    </div>
    <button class="ui button">Editar</button>
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
      @if ($ingredient->types())
        var selected = []
        @foreach ($ingredient->types() as $type)
        selected.push('{{$type->id}}')
        @endforeach
        $('#types').dropdown('set selected', selected)
      @endif
    })
  })
  </script>
@endpush
