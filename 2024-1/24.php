<?php
  session_save_path("sess");
  session_start();

  $id = $_POST["id"];
  $pass = $_POST["pass"];

    echo "id = $id, pass = $pass<br>";

    if($id == "test" and $pass== "1234")
    {
        $_SESSION["sinoid"] = $id;
        $_SESSION["sinoname"] = "홍길동";
        $memo = "홍길동님 반갑습니다.";
    }else
    if($id == "admin" and $pass== "1234")
    {
        $_SESSION["sinoid"] = $id;
        $_SESSION["sinoname"] = "관리자";
        $memo = "관리자님 반갑습니다.";
    }else
    {
        $memo="아이디와 비밀번호를 확인하세요";
    }

    echo "
    <script>
        alert('$memo');
        location.href='23login.php';
    </script>
        ";

?>