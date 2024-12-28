<?php
// 데이터베이스 정보 설정 및 연결 함수 정의
    $dbHost = "localhost"; 
    $dbName = "user_system"; // 사용할 데이터베이스 이름
    $dbUser = "yong"; // MySQL 사용자 이름
    $dbPass = "1111"; // MySQL 비밀번호

    function connectDB() {
        global $dbHost, $dbName, $dbUser, $dbPass;
        $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
?>