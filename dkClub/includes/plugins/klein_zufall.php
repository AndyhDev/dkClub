<?php
function plugin_klein_zufall($id){
    return "<script type='text/javascript'>
      var images = new Array('1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg', '6.jpg');
      var rotate_id = '$id';
    </script>
    <script type='text/javascript' src='js/small_random.js'></script>
    <script type='text/javascript'>
      $(document).ready(function(){
        document_ready = true;
        check_ok();
      });
    </script>
    <div class='small_slider' id='$id'>
      <div class='overlay1'>
      </div>
      <div class='overlay2'>
      </div>
      <div class='overlay3'>
      </div>
    </div>
    ";
}
?>
