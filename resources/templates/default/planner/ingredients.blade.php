@extends('planner.layout.base')

@section('planner_title')
  Lista de Ingredientes -
  @switch ($period)
    @case('week')
      Semana {{$date->format('d/m')}} - {{$date->copy()->endOfWeek()->format('d/m')}} - {{$date->format('Y')}}
      @break
    @case('month')
      Mes {{ucfirst($date->isoFormat('MMMM Y'))}}
      @break;
    @case('day')
      D&iacute;a
      @break
  @endswitch
  <a href="{{$base_url}}/planner/{{$period}}/{{$date->format('Y-m-d')}}">
    <i class="small level up icon"></i>
  </a>
@endsection

@section('planner_content')
  <table class="ui collapsing table">
    <thead>
      <tr>
        <th>#</th>
        <th>Ingrediente</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($ingredients as $ingredient)
        <tr>
          <td>{{$ingredient->amount}} {{$ingredient->unit->abreviation}}.</td>
          <td>{{$ingredient->description}}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
