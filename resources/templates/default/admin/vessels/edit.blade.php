@extends('admin.layout.edit')

<?php $list = 'vessels' ?>

@section('title')
  Elemento - {{$vessel->description}}
@endsection

<?php $link = 'vessel/' . $vessel->id ?>

@section('fields')
  @include('layout.form.input', ['label' => 'Descripción', 'name' => 'description', 'value' => $vessel->description])
@endsection
