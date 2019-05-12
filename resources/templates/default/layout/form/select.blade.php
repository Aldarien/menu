<div class="inline field">
  <label>{{$label}}</label>
  <div class="ui
  @if (isset($multiple) and $multiple)
    multiple
  @endif
  selection dropdown"
  @if (isset($id))
    id="{{$id}}"
  @endif>
    <input type="hidden" name="{{$name}}" />
    <i class="dropdown icon"></i>
    <div class="default text">
      @if (isset($default))
        {{$default}}
      @else
        {{$label}}
      @endif
    </div>
    <div class="menu">
      @if (isset($data))
        @foreach ($data as $info)
          <?php if (!is_object($info)) $info = (object) $info ?>
          <div class="item" data-value="{{$info->value}}">{{$info->description}}</div>
        @endforeach
      @endif
    </div>
  </div>
</div>

@push('scripts')
  <script type="text/javascript">
  <?php $identifier = (isset($id)) ? '#id' : '.ui.selection.dropdown' ?>
  $('{{$identifier}}').dropdown()
  @if (isset($value))
    $('{{$identifier}}').dropdown('set selected',
    @if (is_array($value))
      ['{{implode("', '", $value)}}']
    @else
    '{{$value}}'
    @endif
  )
  @endif
  </script>
@endpush
