<?php
    include "head.php";
    include "db.php";

    // 데이터베이스 연결 확인
    $conn = connectDB();

    include "menu.php";

    // $cmd 변수를 가져오기 (URL에서 ?cmd= 값을 확인)
    $cmd = isset($_GET["cmd"]) ? $_GET["cmd"] : '';


    if (empty($cmd)) {
        include "init.php";
    } else {
        $cmd_file = $cmd . ".php";
        if (file_exists($cmd_file)) {
            include $cmd_file;
        } else {
            echo "<div class='container'><p>파일을 찾을 수 없습니다: $cmd_file</p></div>";
        }
    }

    



    // 연결 종료
    mysqli_close($conn);
    include "tail.php";
?>
