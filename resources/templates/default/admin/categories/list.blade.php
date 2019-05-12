@extends('admin.layout.list')

@section('title')
  Categor&iacute;as de Recetas
@endsection

<?php
  $columns = ['description' => 'Descripción', 'times()' => 'Períodos'];
  $list = 'categories';
  $link = 'category';
  $items = $categories
?>
