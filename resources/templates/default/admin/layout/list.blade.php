@extends('admin.layout.base')

@section('admin_title')
  @yield('title')
@endsection

@section('admin_content')
  <table class="ui table">
    <thead>
      <tr>
        @foreach ($columns as $column)
          <th>{{$column}}</th>
        @endforeach
        <th class="right aligned">
          <a href="{{$base_url}}/admin/{{$list}}/add"><i class="plus icon"></i></a>
        </tr>
      </tr>
    </thead>
    @if ($items)
      <tbody>
        @foreach ($items as $item)
          <tr>
            @foreach ($columns as $col => $name)
              <td>
                  <?php
                  if (strpos($col, '(') !== false):
                  $str = "\$val = \$item->$col;";
                  eval($str);
                  ?>
                  @if (is_array($val))
                    {{implode(', ', array_map(function($item) {
                      return $item->description;
                    }, $val))}}
                  @else
                    {{$val}}
                  @endif
                @else
                  {{$item->$col}}
                @endif
              </td>
            @endforeach
            <td class="right aligned">
              <a href="{{$base_url}}/admin/{{$link}}/{{$item->id}}/edit">
                <i class="edit icon"></i>
              </a>
              <a href="{{$base_url}}/admin/{{$link}}/{{$item->id}}/remove">
                <i class="remove icon"></i>
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    @endif
  </table>
  @yield('data')
@endsection
