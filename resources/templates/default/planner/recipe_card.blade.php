<a href="{{$base_url}}/book/recipe/{{$recipe->id}}">
  <div class="ui card">
    <div class="content">
      <span class="title">{{$recipe->title}}</span>
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
    <div class="image">
      @if ($recipe->image != '')
        <img src="{{$base_url}}/images/{{$recipe->image}}" title="{{$recipe->description}}" />
      @endif
    </div>
    <div class="content ingredients">
      @if ($recipe->ingredients())
          <div class="description">
            <div class="ui bulleted list">
              @foreach ($recipe->ingredients() as $ingredient)
                <div class="item">{{$ingredient->amount($recipe)}} {{$ingredient->unit($recipe)->abreviation}}. de {{$ingredient->description}}</div>
              @endforeach
            </div>
          </div>
      @endif
    </div>
  </div>
</a>
