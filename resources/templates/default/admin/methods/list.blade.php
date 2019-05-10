@extends('admin.layout.list')

@section('title')
  M&eacute;todos
@endsection

<?php
  $columns = ['description' => 'Descripción', 'vessel()->description' => 'Elemento'];
  $list = 'methods';
  $link = 'method';
  $items = $methods
?>
