<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <title>Menu</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" type="text/css" />
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
  @stack('styles')
</head>
<body>
  <div class="ui container">
    @include('layout.header')
    @yield('content')
  </div>
  @stack('scripts')
</body>
