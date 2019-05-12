<div class="inline field">
  <label>{{$label}}</label>
  <input type="text" name="{{$name}}"
  @if (isset($id))
    id="{{$id}}"
  @endif
  @if (isset($value))
    value="{{$value}}"
  @endif
  />
</div>
