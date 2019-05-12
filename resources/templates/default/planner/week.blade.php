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
  <div class="ui right floated sub header">
    <a href="{{$base_url}}/planner/ingredients/{{$week_start->format('Y-m-d')}}/week">
      <i class="tasks icon"></i>
    </a>
  </div>
@endsection

@section('planner_content')
  <div class="ui seven columns internally celled grid">
    <div class="row">
      <?php $ds = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'] ?>
      @foreach ($ds as $i => $d)
        <div class="centered column ui header">
          <a href="{{$base_url}}/planner/day/{{$week_start->copy()->addDays($i)->format('Y-m-d')}}">
            {{$d}}
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
          @foreach ($times as $time)
            <div class="ui sub header">
              {{$time->description}}
            </div>
            @if (isset($days[$i][$time->id]))
              <?php $recipe = $days[$i][$time->id]->recipe() ?>
              @include('planner.week_recipe_card')
            @else
              <div class="ui message">
                No hay.
              </div>
            @endif
          @endforeach
        </div>
      @endforeach
    </div>
  </div>
@endsection

@push('scripts')
  <script type="text/javascript">
  $(document).ready(function() {
    $('.refresh').css('cursor', 'pointer').click(function(e) {
      e.preventDefault()
      var card = $(this).parent().parent().parent()
      var date = $(this).attr('data-date')
      var time = $(this).attr('data-time')
      $.post('{{$base_url}}/api/recipes/random', {date: date, time: time}, function(data) {
        $(card).find('.title').html(data.recipe.title)
        $(card).find('.categories').html(data.recipe.categories.map(x => x.description).join(', '))
        $(card).find('.feeds').html('Rinde ' + data.recipe.feeds + ' personas')
      }, 'json')
    })
  })
  </script>
@endpush
