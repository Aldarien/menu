@extends('planner.layout.base')

@section('planner_title')
  Men&uacute; de la Semana {{$week_start->format('W')}} -
  <a href="{{$base_url}}/planner/month/{{$week_start->format('Y-m-d')}}">
    {{ucfirst($week_start->isoFormat('MMMM'))}}
    <i class="icons">
      <i class="icon"></i>
      <i class="bottom right corner level up icon"></i>
    </i>
  </i>
  <a href="{{$base_url}}/planner/year/{{$week_start->format('Y-m-d')}}">
    {{$week_start->format('Y')}}
    <i class="icons">
      <i class="icon"></i>
      <i class="bottom right corner level up icon"></i>
    </i>
  </a>
@endsection

@section('planner_content')
  <div class="ui seven columns internally celled grid">
    <div class="row">
      <?php $ds = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'] ?>
      @foreach ($ds as $i => $d)
        <div class="centered column ui header">
          <a href="{{$base_url}}/planner/day/{{$week_start->copy()->addDays($i)->format('Y-m-d')}}">
            {{$d}}
            <i class="tiny sync icon refresh" data-n="{{$i}}" data-date="{{$week_start->copy()->addDays($i)->format('Y-m-d')}}"></i>
            <div class="sub header">
              {{$week_start->copy()->addDays($i)->format('d/m')}}
            </div>
          </a>
        </div>
      @endforeach
    </div>
    <div class="row">
      @foreach ($ds as $i => $d)
        <div class="centered column">
          @if (is_array($days))
            <?php $found = false ?>
            @foreach ($days as $day)
              @if ($day->date() == $week_start->copy()->addDays($i))
                <?php $found = true; $recipe = $day->recipe() ?>
                @include('planner.recipe_card')
              @endif
            @endforeach
            @if (!$found)
              <?php $recipe = $random_recipes[$i] ?>
              @include('planner.recipe_card')
            @endif
          @else
            <?php $recipe = $random_recipes[$i] ?>
            @include('planner.recipe_card')
          @endif
        </div>
      @endforeach
    </div>
  </div>
@endsection

@push('scripts')
  <script type="text/javascript">
  $(document).ready(function() {
    $('.refresh').click(function(e) {
      e.preventDefault()
      var n = parseInt($(this).attr('data-n'))
      var card = $(this).parent().parent().parent().next('.row').find('.card')[n]
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
