<?php
function plugin_klein_zufall_w($id){
    return "<script type='text/javascript'>
      function check_w_rotate(id){
        if(document_ready && img_loaded == images.length){
          rotate_start(id);
        }else{
          setTimeout('check_w_rotate(" . '"' . $id . '"' . ")', 200);
        }
      }
      $(document).ready(function(){
        check_w_rotate('$id');
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
