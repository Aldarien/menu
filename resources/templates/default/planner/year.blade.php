@extends('planner.layout.base')

@section('planner_title')
  Men&uacute; del A&ntilde;o - {{$date->format('Y')}}
@endsection

@section('planner_content')
  <div class="ui three columns grid">
    <div class="row">
      @for ($m = 0; $m < 12; $m ++)
        @if ($m % 3 == 0 and $m > 0)
          </div>
          <div class="row">
        @endif
        <div class="column">
          <?php $month = $date->copy()->addMonths($m) ?>
          @include('planner.month_card')
          
        </div>
      @endfor
    </div>
  </div>
@endsection
