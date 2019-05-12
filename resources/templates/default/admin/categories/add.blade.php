@extends('admin.layout.add')

<?php $list = 'categories' ?>

@section('title')
  Categor&iacute;a de Receta
@endsection

@section('fields')
  @include('layout.form.input', ['label' => 'Descripción', 'name' => 'description'])
  @include('layout.form.select', ['label' => 'Período', 'name' => 'times', 'multiple' => true, 'id' => 'times'])
@endsection

@push('scripts')
  <script type="text/javascript">
  $(document).ready(function() {
    $.getJSON('{{$base_url}}/api/times', function(data) {
      var times = []
      $.each(data.times, function(i, el) {
        times.push({value: el.id, description: el.description, name: el.name})
      })
      $('#times').dropdown('change values', times)
    })
  })
  </script>
@endpush
