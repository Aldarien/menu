@extends('admin.layout.list')

@section('title')
  Tipos de Ingredientes
@endsection

<?php
  $columns = ['description' => 'Descripción'];
  $list = 'ingredienttypes';
  $link = 'ingredienttype';
  $items = $types
?>
