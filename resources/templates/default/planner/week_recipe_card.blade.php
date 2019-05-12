<a href="{{$base_url}}/book/recipe/{{$recipe->id}}">
  <div class="ui card">
    <div class="content">
      <span class="title">{{$recipe->title}}</span>
    </div>
    <div class="content">
      <div class="right floated meta">
        <i class="tiny sync icon refresh" data-time="{{$time->id}}" data-date="{{$days[$i][$time->id]->date()->format('Y-m-d')}}"></i>
      </div>
      <div class="meta categories">
        @if ($recipe->categories())
          {{implode(', ', array_map(function($item) {
            return $item->description;
          }, $recipe->categories()))}}
        @endif
      </div>
      <div class="meta feeds">
        Rinde {{$recipe->feeds()}} personas
      </div>
    </div>
  </div>
</a>
