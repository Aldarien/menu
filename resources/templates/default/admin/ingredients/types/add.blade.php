@extends('admin.layout.base')

@section('admin_content')
  <h1>Agregar Tipo a Ingrediente - <a href="{{$base_url}}/admin/ingredient/{{$ingredient->id}}">{{ucwords($ingredient->description)}}</a></h1>
  <form class="ui form" action="{{$base_url}}/admin/ingredient/{{$ingredient->id}}/types/add" method="post">
    <div class="field">
      <label>Tipos</label>
      <div class="ui multiple selection dropdown">
        <input type="hidden" name="types" />
        <i class="dropdown icon"></i>
        <div class="default text">Ingredientes</div>
        <div class="menu">
          @foreach ($types as $type)
            <div class="item" data-value="{{$type->id}}">{{ucwords($type->description)}}</div>
          @endforeach
        </div>
      </div>
    </div>
    <button class="ui button" type="submit">Agregar</button>
  </form>
@endsection

@push('scripts')
  <script type="text/javascript">
  $('.form .dropdown').dropdown('set selected', [
    @foreach ($types as $type)
      @if ($type->hasIngredient($ingredient->id))
        '{{$type->id}}',
      @endif
    @endforeach
  ])
  </script>
@endpush
