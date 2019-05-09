<a href="{{$base_url}}/book/recipe/{{$recipe->id}}">
  <div class="ui card">
    <div class="content">
      {{$recipe->title}}
      <div class="meta">
        @foreach ($recipe->categories() as $category)
          {{$category->description}}
        @endforeach
      </div>
    </div>
    @if ($recipe->image != '')
      <div class="image">
        <img src="{{$base_url}}/images/{{$recipe->image}}" title="{{$recipe->description}}" />
      </div>
    @endif
    <div class="content">
      <div class="description">
        <div class="ui bulleted list">
          @foreach ($recipe->ingredients() as $ingredient)
            <div class="item">{{$ingredient->amount}} {{$ingredient->unit($recipe)->abreviation}}. de {{$ingredient->description}}</div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</a>
