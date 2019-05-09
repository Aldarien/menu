@extends('planner.layout.base')

@section('planner_title')
  Men&uacute; de la Semana
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
