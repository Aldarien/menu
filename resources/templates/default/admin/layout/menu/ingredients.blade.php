<div class="ui dropdown item" data-menu="ingredients">
  Ingredientes
  <i class="dropdown icon"></i>
  <div class="menu">
    @include('admin.layout.menu.ingredienttypes')
    <a class="item" href="{{$base_url}}/admin/ingredients">Listado</a>
    <a class="item" href="{{$base_url}}/admin/ingredients/add"><i class="plus icon"></i> Agregar</a>
  </div>
</div>
