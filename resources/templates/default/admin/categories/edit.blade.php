@extends('admin.layout.edit')

<?php $list = 'categories' ?>

@section('title')
  Categor&iacute;a - {{$category->description}}
@endsection

<?php $link = 'category/' . $category->id ?>

@section('fields')
  @include('layout.form.input', ['label' => 'Descripción', 'name' => 'description', 'value' => $category->description])
  @include('layout.form.select', ['label' => 'Período', 'name' => 'times', 'multiple' => true, 'id' => 'times'])
@endsection

@push('scripts')
  <script type="text/javascript">
  $(document).ready(function() {
    $.getJSON('{{$base_url}}/api/times', function(data) {
      var times = []
      $.each(data.times, function(i, el) {
        times.push({value: el.id, description: el.description, name: el.description})
      })
      $('#times').dropdown('change values', times)
      @if ($category->times())
        $('#times').dropdown('set selected', ['{!!implode("', '", array_map(function($item) {
          return $item->id;
        }, $category->times()))!!}'])
      @endif
    })
  })
  </script>
@endpush
