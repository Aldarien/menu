@extends('planner.layout.base')

@section('planner_title')
  Men&uacute; del D&iacute;a
  <a href="{{$base_url}}/planner/week/{{$date->format('Y-m-d')}}">
    <i class="small level up icon"></i>
  </a>
  <div class="sub header">
    <h2>{{$date->format('d/m/Y')}}</h2>
    <i class="small sync icon refresh" data-date="{{$date->format('Y-m-d')}}"></i>
  </div>
@endsection

@section('planner_content')
  @include('planner.recipe_card')
@endsection

@push('scripts')
  <script type="text/javascript">
  $(document).ready(function() {
    $('.refresh').css('cursor', 'pointer').click(function(e) {
      e.preventDefault()
      var card = $(this).parent().parent().next('.segment').find('.card')[0]
      var date = $(this).attr('data-date')
      $.post('{{$base_url}}/api/recipes/random', {date: date}, function(data) {
        $(card).find('.title').html(data.recipe.title)
        $(card).find('.categories').html(data.recipe.categories.map(x => x.description).join(', '))
        $(card).find('.feeds').html('Rinde ' + data.recipe.feeds + ' personas')
        $(card).find('.ingredients').html('')
        $.getJSON('{{$base_url}}/api/recipe/' + data.recipe.id + '/ingredients', function(data2) {
          if (data2.ingredients) {
            var list = $('<div></div>').attr('class', 'ui bulleted list')
            $.each(data2.ingredients, function(i, el) {
              list.append(
                $('<div></div>').attr('class', 'item').html(el.amount.toFixed(1) + ' ' + el.unit.abreviation + '. de ' + el.description)
              )
            })
            $(card).find('.ingredients').append(
              $('<div></div>').attr('class', 'description').append(list)
            )
          }
        })
      }, 'json')
    })
  })
  </script>
@endpush
