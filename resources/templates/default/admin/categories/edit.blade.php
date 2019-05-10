@extends('admin.layout.edit')

<?php $list = 'categories' ?>

@section('title')
  Categor&iacute;a - {{$category->description}}
@endsection

<?php $link = 'category/' . $category->id ?>

@section('fields')
  @include('layout.form.input', ['label' => 'Descripción', 'name' => 'description', 'value' => $category->description])
@endsection
