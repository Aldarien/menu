@extends('admin.layout.add')

<?php $list = 'categories' ?>

@section('title')
  Categor&iacute;a de Receta
@endsection

@section('fields')
  @include('layout.form.input', ['label' => 'Descripción', 'name' => 'description'])
@endsection
