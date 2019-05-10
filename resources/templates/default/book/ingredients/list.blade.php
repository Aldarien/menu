@extends('book.layout.base')

@section('book_title')
  Ingredientes
@endsection

@section('book_content')
  <table class="ui table">
    <thead>
      <tr>
        <th>Descripci&oacute;n</th>
        <th>Tipos</th>
        <th class="right aligned">
          <a href="{{$base_url}}/book/ingredients/add">
            <i class="plus icon"></i>
          </a>
        </th>
      </tr>
    </thead>
    @if ($ingredients)
      <tbody>
        @foreach ($ingredients as $ingredient)
          <tr>
            <td>
              <a href="{{$base_url}}/book/ingredient/{{$ingredient->id}}">
                {{$ingredient->description}}
              </a>
            </td>
            <td>
              @if ($ingredient->types())
                @foreach ($ingredient->types() as $type)
                  {{$type->description}}
                @endforeach
              @endif
            </td>
            <td class="right aligned">
              <a href="{{$base_url}}/book/ingredient/{{$ingredient->id}}/edit">
                <i class="edit icon"></i>
              </a>
              <a href="{{$base_url}}/book/ingredient/{{$ingredient->id}}/remove">
                <i class="remove icon"></i>
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    @endif
  </table>
@endsection
