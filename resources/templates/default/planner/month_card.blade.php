<div class="ui card">
  <div class="content">
    <div class="center aligned header">
      <a href="{{$base_url}}/planner/month/{{$month->format('Y-m-d')}}">
        {{ucfirst($month->isoFormat('MMMM'))}}
      </a>
    </div>
    <div class="ui sub header">
      <div class="ui seven columns grid">
        <div class="row">
          <?php $ds = ['Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá', 'Do'] ?>
          @foreach ($ds as $i => $d)
            <div class="centered column">
              {{$d}}
            </div>
          @endforeach
        </div>
      </div>
    </div>
    <div class="ui seven columns grid">
      <div class="row">
        <?php $first_week_day = $month->copy()->format('N') - 1 ?>
        @for ($d = 0; $d < $first_week_day + $month->copy()->endOfMonth()->format('d'); $d ++)
          @if ($d % 7 == 0 and $d > 0)
          </div>
          <div class="row">
          @endif
          <div class="center aligned column">
            @if ($d >= $first_week_day)
              <a href="{{$base_url}}/planner/day/{{$month->copy()->addDays($d - $first_week_day)->format('Y-m-d')}}">
                {{$d - $first_week_day + 1}}
              </a>
            @endif
          </div>
        @endfor
      </div>
    </div>
  </div>
</div>
