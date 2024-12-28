<?php
  session_save_path("sess");
  session_start();

  session_destroy();
 
    echo "
    <script>
        alert('로그아웃되었습니다.');
        location.href='23login.php';
    </script>
        ";

?>