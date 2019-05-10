<div class="ui menu">
  <a class="item" href="{{$base_url}}">Inicio</a>
  <a class="item" href="{{$base_url}}/book">Libro de Recetas</a>
  <div class="right menu">
    <a class="item" href="{{$base_url}}/config">
      <i class="wrench icon"></i>
    </a>
  </div>
</div>

@push('scripts')
  <script type="text/javascript">
  $('.menu .dropdown').dropdown()
  </script>
@endpush
