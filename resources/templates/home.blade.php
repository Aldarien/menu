@extends('layout.base')

@section('content')
  <table class="ui table">
    <thead>
      <tr>
        <th>Tipos de Ingredientes</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($types as $type)
        <tr>
          <td>{{ucwords($type->description)}}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
