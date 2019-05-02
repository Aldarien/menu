@extends('admin.layout.base')

@section('admin_content')
  <h1>Agregar - Categor&iacute;a de Recetas</h1>
  <form class="ui form" method="post" action="{{$base_url}}/admin/recipecategories/add">
    <div class="field">
      <label>Descripci&oacute;n</label>
      <input type="text" name="description" />
    </div>
    <button class="ui button">Agregar</button>
  </form>
@endsection
