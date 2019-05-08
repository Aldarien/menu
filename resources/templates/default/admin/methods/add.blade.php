@extends('admin.layout.base')

@section('admin_content')
  <h1>Agregar M&eacute;todo <a href="{{$base_url}}/admin/methods"><i class="small level up icon"></i></a></h1>
  <form class="ui form" method="post" action="{{$base_url}}/admin/methods/add">
    <div class="field">
      <label>Descripci&oacute;n</label>
      <input type="text" name="description" />
    </div>
    <div class="field">
      <label>&iquest;Donde?</label>
      <div class="ui selection dropdown" id="vessel">
        <input type="hidden" name="vessel" />
        <i class="dropdown icon"></i>
        <div class="default text">Envase</div>
        <div class="menu"></div>
      </div>
    </div>
    <button class="ui button">Agregar</button>
  </form>
@endsection

@push('scripts')
  <script type="text/javascript">
  $(document).ready(function() {
    $.getJSON('{{$base_url}}/api/vessels', function(data) {
      var vessels = []
      $.each(data.vessels, function(i, el) {
        vessels.push({value: el.id, description: el.description, name: el.description})
      })
      $('#vessel').dropdown('change values', vessels)
    })
  })
  </script>
@endpush
