<?php
  $csrfToken = bin2hex(random_bytes(32)); // สร้าง token สุ่ม
  $_SESSION['csrf_token'] = $csrfToken; 

?>


<script>
function jssecertkey()
{   
    var sercetkeyx
    return 'wow';
}
</script>