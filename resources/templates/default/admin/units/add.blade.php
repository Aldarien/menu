@extends('admin.layout.add')

<?php $list = 'units' ?>

@section('title')
  Unidad
@endsection

@section('fields')
  @include('layout.form.input', ['label' => 'Descripción', 'name' => 'description'])
  @include('layout.form.input', ['label' => 'Abreviación', 'name' => 'abreviation'])
@endsection
