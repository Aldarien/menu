@extends('admin.layout.edit')

<?php $list = 'ingredienttypes' ?>

@section('title')
  Tipo de Ingrediente - {{$ingredienttype->description}}
@endsection

<?php $link = 'ingredienttype/' . $ingredienttype->id ?>

@section('fields')
  @include('layout.form.input', ['label' => 'Descripción', 'name' => 'description', 'value' => $ingredienttype->description])
@endsection
