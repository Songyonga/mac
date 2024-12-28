<?php
    include "head.php";
    include "db.php";

    // 데이터베이스 연결 확인
    $conn = connectDB();

    include "menu.php";


    include "dbtest.php";



    // 연결 종료
    mysqli_close($conn);
    include "tail.php";
?>