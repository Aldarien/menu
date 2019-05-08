@extends('admin.layout.base')

@section('admin_content')
  <h1>Agregar Ingrediente - <a href="{{$base_url}}/admin/ingredienttype/{{$type->id}}">{{ucwords($type->description)}}</a></h1>
  <form class="ui form" action="{{$base_url}}/admin/ingredienttype/{{$type->id}}/ingredients/add" method="post">
    <div class="field">
      <label>Ingredientes</label>
      <div class="ui multiple selection dropdown">
        <input type="hidden" name="ingredients" />
        <i class="dropdown icon"></i>
        <div class="default text">Ingredientes</div>
        <div class="menu">
          @foreach ($ingredients as $ingredient)
            <div class="item" data-value="{{$ingredient->id}}">{{ucwords($ingredient->description)}}</div>
          @endforeach
        </div>
      </div>
    </div>
    <button class="ui button" type="submit">Agregar</button>
  </form>
@endsection

@push('scripts')
  <script type="text/javascript">
  $('.form .multiple.dropdown').dropdown('set selected', [
    @foreach ($ingredients as $ingredient)
      @if ($ingredient->hasType($type->id))
        '{{$ingredient->id}}',
      @endif
    @endforeach
  ])
  </script>
@endpush
