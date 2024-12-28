<?php
session_start();
session_destroy(); // 모든 세션 데이터 삭제
header("Location: index.php"); // 홈 화면으로 리디렉션
exit;
?>
