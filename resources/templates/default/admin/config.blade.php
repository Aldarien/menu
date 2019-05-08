@extends('admin.layout.base')

@section('admin_content')
  <h1>Configuraci&oacute;n B&aacute;sica</h1>
  <hr />
  <form class="ui form" method="post" action="{{$base_url}}/admin/config">
    <h3>General</h3>
    <div class="inline field">
      <label>Zona Horaria</label>
      <div class="ui selection dropdown">
        <input type="hidden" name="timezone" />
        <i class="dropdown icon"></i>
        <div class="default text">{{$config->get('app.timezone')}}</div>
        <div class="menu">
          @foreach ($timezones as $timezone)
            <div class="item" data-value="{{$timezone}}">{{$timezone}}</div>
          @endforeach
        </div>
      </div>
    </div>
    <div class="inline field">
      <label>D&iacute;as</label>
      <input type="number" name="days"
      @if ($config->get('app.days'))
        value={{$config->get('app.days')}}
      @endif
      />
    </div>

    <hr />
    <h3>Base de Datos</h3>
    <div class="inline field">
      <label>Host</label>
      <input type="text" name="db.host" value="{{$config->get('databases.default.host')}}" />
    </div>
    <div class="inline field">
      <label>Puerto</label>
      <input type="text" name="db.port" placeholder="3306"
      @if ($config->get('databases.default.port'))
        value="{{$config->get('databases.default.port')}}"
      @endif
      />
    </div>
    <div class="inline field">
      <label>Nombre</label>
      <input type="text" name="db.name" value="{{$config->get('databases.default.name')}}" />
    </div>
    <div class="field">
      <label>Usuario</label>
      <div class="fields">
        <div class="three wide field">
          <input type="text" name="db.user.name" placeholder="Nombre" value="{{$config->get('databases.default.user.name')}}" />
        </div>
        <div class="three wide field">
          <input type="password" name="db.user.pass" placeholder="Password" value="{{$config->get('databases.default.user.password')}}" />
        </div>
      </div>
    </div>
    <button class="ui button">Guardar</button>
  </form>
@endsection

@push('scripts')
  <script type="text/javascript">
  $('.form .selection').dropdown()
  </script>
@endpush
