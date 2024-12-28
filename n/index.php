<?php
ini_set("display_errors", 1); // 디버깅 시 활성화
error_reporting(E_ALL); // 모든 에러 보고
    include "db.php";

    $conn = connectDB();
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <title>문화콘텐츠 실습</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="homestyle.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* 배경화면 설정 
        body {
            background: url('background.png') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            font-family: 'Nanum Gothic', sans-serif;
            background-color: rgba(255, 255, 255, 0.3);
        } */

        /* 로그인 버튼을 항상 최상위로 표시 */
        .login-button {
            position: absolute; /* 위치 고정 */
            top: 10px; /* 화면 위쪽 여백 */
            right: 10px; /* 화면 오른쪽 여백 */
            z-index: 1050; /* 우선순위를 높게 설정 */
        }

        .logo-container {
            background-color: rgba(255, 255, 255, 0.8); /* 로고 배경 흰색 투명도 */
            padding: 20px;
            border-radius: 10px;
        }
    </style>
</head>
<?php
    if(!isset($_GET["cmd"]))
        $cmd = "init";
    else
        $cmd = $_GET["cmd"];
?>
<body>
    <!-- 드롭메뉴 포함 -->
    <?php include('menu.php'); ?>

    <!-- 로그인 버튼 -->
    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']): ?>
        <div class="login-button">
            <span class="me-3">환영합니다, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
            <a href="logout.php" class="btn btn-outline-danger">로그아웃</a>
        </div>
    <?php else: ?>
        <a href="login.php" class="btn btn-outline-primary login-button">로그인</a>
    <?php endif; ?>

    <div class="container mt-5 "> <div class="row"><div class="col"></div></div></div>
    <div class="container mt-5 "> 
    <?php
        include "$cmd.php";
    ?>
    </div> <!-- container -->

</body>
</html>
