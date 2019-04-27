@extends('admin.layout.base')

@section('admin_content')
  <h1>Agregar Tipo a Ingrediente - <a href="{{$base_url}}/admin/ingredient/{{$ingredient->id}}">{{ucwords($ingredient->description)}}</a></h1>
  <form class="ui form" action="{{$base_url}}/admin/ingredient/{{$ingredient->id}}/types/add" method="post">
    <div class="field">
      <label>Tipos</label>
      <select multiple="" name="types[]" class="ui dropdown">
        @foreach ($types as $type)
          <option value="{{$type->id}}">{{ucwords($type->description)}}</option>
        @endforeach
      </select>
    </div>
    <button class="ui button" type="submit">Agregar</button>
  </form>
@endsection

@push('scripts')
  <script type="text/javascript">
  $('.form .dropdown').dropdown()
  </script>
@endpush
