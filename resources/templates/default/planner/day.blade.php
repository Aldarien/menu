@extends('planner.layout.base')

@section('planner_title')
  Men&uacute; del D&iacute;a
  <a href="{{$base_url}}/planner/week/{{$date->format('Y-m-d')}}">
    <i class="small level up icon"></i>
  </a>
  <div class="sub header">
    <h2>{{$date->format('d/m/Y')}}</h2>
  </div>
@endsection

@section('planner_content')
  <div class="ui grid">
    @foreach ($times as $time)
      <div class="row">
        <div class="centered column">
          <div class="ui sub header">
            {{$time->description}}
          </div>
          @if (isset($recipes[$time->id]))
            <br />
            <?php $recipe = $recipes[$time->id] ?>
            @include('planner.recipe_card')
          @else
            <div class="ui message">
              No hay recetas.
            </div>
          @endif
        </div>
      </div>
    @endforeach
  </div>
@endsection
