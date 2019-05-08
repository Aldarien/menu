<div class="ui item dropdown" data-menu="recipes">
  Recetas
  <i class="dropdown icon"></i>
  <div class="menu">
    @include('admin.layout.menu.categories')
    <a class="item" href="{{$base_url}}/admin/recipes">Listado</a>
    <a class="item" href="{{$base_url}}/admin/recipes/add"><i class="plus icon"></i> Agregar</a>
  </div>
</div>
