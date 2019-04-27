@extends('admin.layout.base')

@section('admin_content')
  <h1>Ingrediente <a href="{{$base_url}}/admin/ingredients"><i class="small level up icon"></i></a></h1>
  <div class="ui grid">
    <div class="row">
      <div class="right aligned column">
        <a href="{{$base_url}}/admin/ingredient/{{$ingredient->id}}/edit"><i class="edit icon"></i></a>
        <a href="{{$base_url}}/admin/ingredient/{{$ingredient->id}}/remove"><i class="remove icon"></i></a>
      </div>
    </div>
    <div class="row">
      <div class="two wide column"><strong>Descripci&oacute;n</strong></div>
      <div class="three wide column">{{ucwords($ingredient->description)}}</div>
    </div>
    <div class="row">
      <div class="two wide column"><strong>Tipos</strong></div>
      <div class="fourteen wide column">
        <div class="right aligned column"><a href="{{$base_url}}/admin/ingredient/{{$ingredient->id}}/types/add"><i class="add icon"></i></a></div>
        <div class="ui list">
          @foreach ($ingredient->types() as $type)
            <a class="item" href="{{$base_url}}/admin/ingredienttype/{{$type->id}}">{{ucwords($type->description)}}</a>
          @endforeach
        </div>
      </div>
    </div>
  </div>
@endsection
