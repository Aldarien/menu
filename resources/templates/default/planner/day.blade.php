@extends('planner.layout.base')

@section('planner_title')
  Men&uacute; del D&iacute;a
@endsection

@section('planner_content')
  <h2>{{$date->format('d/m')}}</h2>
  @include('planner.recipe_card')
@endsection
