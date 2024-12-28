<?php
session_start(); // 세션 시작

// 데이터베이스 연결 설정
$host = 'localhost';
$dbname = 'user_system';
$user = 'yong'; // MySQL 사용자
$pass = '1111'; // MySQL 비밀번호

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// 로그인 처리
$error_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? ''; // 'username' 필드 사용
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // 세션에 로그인 정보 저장
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;

            header("Location: index.php"); // 홈 화면으로 리디렉션
            exit;
        } else {
            $error_message = '아이디 또는 비밀번호가 잘못되었습니다.';
        }
    } else {
        $error_message = '모든 필드를 입력해주세요.';
    }
}
?>

<?php include('head.php'); ?>

<link href="loginstyle.css" rel="stylesheet">

<body>
    <!-- 드롭메뉴 -->
    <div class="menu-container">
        <?php include('menu.php'); ?>
    </div>

    <!-- 상단 로고 텍스트 -->
    <div class="mb-4" style="position: absolute; top: 10px; right: 10px; font-size: 12px; color: #555;">
        <a href="index.php" style="text-decoration: none; color: inherit;">
            <span style="color: #007bff; text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px; font-weight: bold; font-size: 18px;">한문학</span>
            <span style="text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;">의 <span style="text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;">모든 것</span>
        </a>
    </div>

    <!-- 로그인 컨테이너 -->
    <div class="login-container">
        <h2 class="text-center">로그인</h2>
        
        <!-- 오류 메시지 -->
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?php echo htmlspecialchars($error_message); ?>
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
            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe">
                <label class="form-check-label" for="rememberMe">로그인 상태 유지</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">로그인</button>
        </form>

        <div class="login-options">
            <a href="register.php">회원가입</a>
            <a href="#">아이디/비밀번호 찾기</a>
        </div>

        <div class="divider">또는</div>

        <div class="social-login-container">
            <div class="social-btn">
                <a href="#" class="btn btn-kakao">카카오</a>
                <a href="#" class="btn btn-google">구글</a>
                <a href="#" class="btn btn-naver">네이버</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
