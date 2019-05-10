@extends('admin.layout.edit')

<?php $list = 'ingredienttypes' ?>

@section('title')
  Tipo de Ingrediente - {{$type->description}}
@endsection

<?php $link = 'ingredienttype/' . $type->id ?>

@section('fields')
  @include('layout.form.input', ['label' => 'Descripción', 'name' => 'description', 'value' => $type->description])
@endsection
