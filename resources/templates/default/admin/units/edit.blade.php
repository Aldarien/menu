@extends('admin.layout.edit')

<?php $list = 'units' ?>

@section('title')
  Elemento - {{$unit->description}}
@endsection

<?php $link = 'unit/' . $unit->id ?>

@section('fields')
  @include('layout.form.input', ['label' => 'Descripción', 'name' => 'description', 'value' => $unit->description])
  @include('layout.form.input', ['label' => 'Abreviación', 'name' => 'abreviation', 'value' => $unit->abreviation])
@endsection
