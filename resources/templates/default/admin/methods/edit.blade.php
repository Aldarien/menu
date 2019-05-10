@extends('admin.layout.edit')

<?php $list = 'methods' ?>

@section('title')
  M&eacute;todo - {{$methods->description}}
@endsection

<?php $link = 'method/' . $methods->id ?>

@section('fields')
  @include('layout.form.input', ['label' => 'Descripción', 'name' => 'description', 'value' => $methods->description])
  <div class="field">
    <label>&iquest;Donde?</label>
    <div class="ui selection dropdown" id="vessel">
      <input type="hidden" name="vessel_id" />
      <i class="dropdown icon"></i>
      <div class="default text">Elemento</div>
      <div class="menu"></div>
    </div>
  </div>
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
      $('#vessel').dropdown('set selected', '{{$method->vessel_id}}')
    })
  })
  </script>
@endpush
