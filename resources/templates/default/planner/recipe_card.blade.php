<a href="{{$base_url}}/book/recipe/{{$recipe->id}}">
  <div class="ui card">
    <div class="content">
      <div class="header">
        <span class="title">{{$recipe->title}}</span>
        <div class="float right meta">
          <i class="tiny sync icon" data-time="{{$time->id}}" date="{{$date->format('Y-m-d')}}"></i>
        </div>
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

@push('scripts')
  <script type="text/javascript">
  $(document).ready(function() {
    $('.refresh').css('cursor', 'pointer').click(function(e) {
      e.preventDefault()
      var card = $(this).parent().parent().parent()
      console.debug(card)
      return
      var date = $(this).attr('data-date')
      $.post('{{$base_url}}/api/recipes/random', {date: date}, function(data) {
        $(card).find('.title').html(data.recipe.title)
        $(card).find('.categories').html(data.recipe.categories.map(x => x.description).join(', '))
        $(card).find('.feeds').html('Rinde ' + data.recipe.feeds + ' personas')
        $(card).find('.ingredients').html('')
        $.getJSON('{{$base_url}}/api/recipe/' + data.recipe.id + '/ingredients', function(data2) {
          if (data2.ingredients) {
            var list = $('<div></div>').attr('class', 'ui bulleted list')
            $.each(data2.ingredients, function(i, el) {
              list.append(
                $('<div></div>').attr('class', 'item').html(el.amount.toFixed(1) + ' ' + el.unit.abreviation + '. de ' + el.description)
              )
            })
            $(card).find('.ingredients').append(
              $('<div></div>').attr('class', 'description').append(list)
            )
          }
        })
      }, 'json')
    })
  })
  </script>
@endpush
