@extends('planner.layout.base')

@section('planner_title')
  Men&uacute; del Mes - {{ucfirst($date->isoFormat('MMMM'))}}
  <a href="{{$base_url}}/planner/year/{{$date->format('Y-m-d')}}">
    {{$date->format('Y')}}
  </a>
@endsection

@section('planner_content')
  <div class="ui eight columns internally celled grid">
    <div class="row">
      <div class="column"></div>
      <?php $ds = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'] ?>
      @foreach ($ds as $i => $d)
        <div class="center aligned column ui sub header">
          {{$d}}
        </div>
      @endforeach
    </div>
    <div class="row">
      <div class="center aligned column">
        <a href="{{$base_url}}/planner/week/{{$date->format('Y-m-d')}}">
          <i class="calendar alternate outline icon"></i>
        </a>
      </div>
      <?php $first_week_day = $date->copy()->format('N') - 1 ?>
      @for ($d = 0; $d < $first_week_day + $date->copy()->endOfMonth()->format('d'); $d ++)
        @if ($d % 7 == 0 and $d > 0)
        </div>
        <div class="row">
          <div class="center aligned column">
            <a href="{{$base_url}}/planner/week/{{$date->copy()->addDays($d - $first_week_day)->format('Y-m-d')}}">
              <i class="calendar alternate outline icon"></i>
            </a>
          </div>
        @endif
        <div class="center aligned column">
          @if ($d >= $first_week_day)
            <a href="{{$base_url}}/planner/day/{{$date->copy()->addDays($d - $first_week_day)->format('Y-m-d')}}">
              {{$d - $first_week_day + 1}}
            </a>
          @endif
        </div>
      @endfor
    </div>
  </div>
@endsection
