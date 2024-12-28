<?php
    // 데이터베이스 정보 설정
    $dbHost = "localhost"; // 보통 'localhost' 또는 서버의 IP 주소
    $dbName = "culture";
    $dbUser = "culture";
    $dbPass = "1111";

    // DB 연결 함수 정의
    function connectDB() {
        global $dbHost, $dbName, $dbUser, $dbPass;

        // MySQLi 연결 시도
        $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

        // 연결 오류 확인
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // 연결 성공 시 연결 객체 반환
        return $conn;
    }

    // 함수 호출 예제 (필요한 경우 사용)
    $conn = connectDB();
    if ($conn) {
        //echo "Database connected successfully!";
    }
?>
