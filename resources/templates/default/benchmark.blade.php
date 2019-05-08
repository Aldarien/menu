<br />
<div class="ui container">
  <div class="benchmark ui info message">
    <i class="close icon"></i>
    <div class="header">Benchmark Time</div>
    <div class="content">
      {{$time}}
    </div>
  </div>
</div>

<script type="text/javascript">
  $('.benchmark .close').click(function() {
    $(this).parent().transition('fade')
  })
</script>
