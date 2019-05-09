<div class="ui menu">
  <a class="item" href="{{$base_url}}">Inicio</a>
  <a class="item" href="{{$base_url}}/book">Libro de Recetas</a>
</div>

@push('scripts')
  <script type="text/javascript">
  $('.menu .dropdown').dropdown()
  </script>
@endpush
