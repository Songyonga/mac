<?php
session_start();

// 데이터베이스 연결 설정
$host = 'localhost';
$dbname = 'user_system';
$user = 'yong';
$pass = '1111';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // 세션에 사용자 정보 저장
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;

            header("Location: index.php"); // 홈 화면으로 리디렉션
            exit;
        } else {
            echo "아이디 또는 비밀번호가 잘못되었습니다.";
        }
    } else {
        echo "모든 필드를 입력해주세요.";
    }
}
?>
