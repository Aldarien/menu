@extends('admin.layout.base')

@section('admin_content')
  <h1>Agregar Paso - <a href="{{$base_url}}/book/recipe/{{$recipe->id}}">{{$recipe->title}}</a></h1>
  <form class="ui form" method="post" action="{{$base_url}}/book/recipe/{{$recipe->id}}/steps/add">
    <div class="field">
      <label>M&eacute;todo</label>
      <div class="ui selection dropdown" id="method">
        <input type="hidden" name="method" />
        <i class="dropdown icon"></i>
        <div class="default text">M&eacute;todo</div>
        <div class="menu"></div>
      </div>
    </div>
    <input type="hidden" name="ingredients" value="" />
    <table class="ui table" id="ingredients">
      <thead>
        <tr>
          <th colspan="3">Ingredientes</th>
          <th class="right aligned"><i class="plus icon" id="add_ingredient"></i></th>
        </tr>
        <tr>
          <th>Nombre</th>
          <th>Cantidad</th>
          <th>Unidad</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
    <button class="ui button">Agregar</button>
  </form>
@endsection

@push('scripts')
  <script type="text/javascript">
  var active_ingredients = []
  var ingredients = []
  var units = []
  function addIngredient() {
    var i = active_ingredients[active_ingredients.length - 1] + 1
    if (active_ingredients.length == 0) {
      i = 1
    }
    $('#ingredients tbody').append(
      $('<tr></tr>').attr('data-idx', i).append(
        $('<td></td>').append(
          $('<div></div>').attr('class', 'ui selection dropdown').attr('id', 'ingredient' + i).append(
            $('<input />').attr('type', 'hidden').attr('name', 'ingredient' + i)
          ).append(
            $('<i></i>').attr('class', 'dropdown icon')
          ).append(
            $('<div></div>').attr('class', 'default text').html('Ingrediente')
          ).append(
            $('<div></div>').attr('class', 'menu')
          )
        )
      ).append(
        $('<td></td>').append(
          $('<input />').attr('type', 'text').attr('name', 'amount' + i)
        )
      ).append(
        $('<td></td>').append(
          $('<div></div>').attr('class', 'ui selection dropdown').attr('id', 'unit' + i).append(
            $('<input />').attr('type', 'hidden').attr('name', 'unit' + i)
          ).append(
            $('<i></i>').attr('class', 'dropdown icon')
          ).append(
            $('<div></div>').attr('class', 'default text').html('Unidad')
          ).append(
            $('<div></div>').attr('class', 'menu')
          )
        )
      ).append(
        $('<td></td>').append(
          $('<i></i>').attr('class', 'minus icon').css('cursor', 'pointer').click(function() {
            removeIngredient($(this).parent().parent())
          })
        )
      )
    )
    $('#ingredient' + i).dropdown('change values', ingredients)
    $('#unit' + i).dropdown('change values', units)
    active_ingredients.push(i)
    $("input[name='ingredients']").val(active_ingredients)
  }
  function removeIngredient(tr) {
    var idx = parseInt(tr.attr('data-idx'))
    var i = active_ingredients.indexOf(idx)
    if (i == -1) {
      return
    }
    active_ingredients.splice(i, 1)
    $("input[name='ingredients']").val(active_ingredients)
    tr.remove()
  }
  $(document).ready(function() {
    $.getJSON('{{$base_url}}/api/methods', function(data) {
      var methods = []
      $.each(data.methods, function(i, el) {
        methods.push({value: el.id, description: el.description, name: el.description})
      })
      $('#method').dropdown('change values', methods)
    })
    $.getJSON('{{$base_url}}/api/ingredients', function(data) {
      $.each(data.ingredients, function(i, el) {
        var desc = el.description.replace(/\b[a-z]/g, function(letter) {
          return letter.toUpperCase()
        })
        ingredients.push({value: el.id, description: desc, name: desc})
      })
    })
    $.getJSON('{{$base_url}}/api/units', function(data) {
      $.each(data.units, function(i, el) {
        units.push({value: el.id, description: el.abreviation, name: el.abreviation})
      })
    })
    $('#add_ingredient').css('cursor', 'pointer').click(function() {
      addIngredient()
    })
  })
  </script>
@endpush
