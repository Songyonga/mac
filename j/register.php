
<?php
// 데이터베이스 연결
$host = 'localhost';
$dbname = 'user_system';
$user = 'yong'; // 기본 사용자
$pass = '1111'; // 비밀번호가 없으면 빈 문자열
 
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// 회원가입 처리
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // 비밀번호 암호화

    if (!empty($username) && !empty($password)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $stmt->execute(['username' => $username, 'password' => $hashed_password]);
            $message = "회원가입이 완료되었습니다. <a href='login.php' class='text-primary'>로그인하기</a>";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $message = "이미 존재하는 사용자입니다.";
            } else {
                $message = "오류 발생: " . htmlspecialchars($e->getMessage());
            }
        }
    } else {
        $message = "모든 필드를 입력해주세요.";
    }
}
?>
        <!-- 상단 로고 텍스트 -->
        <div class="mb-4" style="position: absolute; top: 10px; right: 10px; font-size: 12px; color: #555;">
      <a href="index.php" style="text-decoration: none; color: inherit;">
        <span style="text-color: #007bff; text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;font-weight: bold; font-size: 18px;">한문학</span><span style="text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;">의 <span style="text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;">모든 것</span>
      </a>
        </div>          
        <!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원가입</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .menu-container {
            position: fixed; /* 고정 위치 */
            top: 10px; /* 상단 여백 */
            left: 10px; /* 오른쪽 여백 */
            z-index: 1050; /* 우선순위 높게 설정 */
        }
        .register-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- 메뉴 고정 -->
    <div class="menu-container">
        <?php include('menu.php'); ?>
    </div>

    <div class="register-container">
        <h2 class="text-center text-primary">회원가입</h2>
        
        <?php if (!empty($message)): ?>
            <div class="alert alert-info text-center">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">아이디</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="아이디를 입력하세요" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">비밀번호</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="비밀번호를 입력하세요" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">회원가입</button>
        </form>
        
        <div class="text-center mt-3">
            <a href="login.php" class="text-secondary">이미 계정이 있으신가요? 로그인하기</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>