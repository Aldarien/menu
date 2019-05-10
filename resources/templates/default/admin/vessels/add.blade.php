@extends('admin.layout.add')

<?php $list = 'vessels' ?>

@section('title')
  Elemento
@endsection

@section('fields')
  @include('layout.form.input', ['label' => 'Descripción', 'name' => 'description'])
@endsection
