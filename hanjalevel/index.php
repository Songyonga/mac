<?php
session_start();

// 데이터베이스 연결
$servername = "localhost";
$username = "yong";
$password = "1111";
$dbname = "user_system";

$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 결과 처리 변수 초기화
$is_correct = null;
$correct_answer = $_SESSION['correct_answer'] ?? null;

// 사용자가 답을 제출한 경우 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_input'])) {
    $user_input = trim($_POST['user_input']);
    $correct_answer = $_SESSION['correct_answer'];

    // 띄어쓰기 제거
    $user_input = str_replace(' ', '', $user_input);
    $correct_answer = str_replace(' ', '', $correct_answer);

    // 문자열 유사도 계산
    similar_text($user_input, $correct_answer, $percent);
    $is_correct = $percent >= 70;
}

// 새로운 문제 로드
$sql = "SELECT hanja, CONCAT(mean, ' ', sound) AS answer FROM han_level2 ORDER BY RAND() LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hanja = $row['hanja'];
    $answer = $row['answer'];
    // 세션에 정답 저장
    $_SESSION['correct_answer'] = $answer;
} else {
    die("데이터가 없습니다.");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>한자 퀴즈</title>
</head>
<body>
    <h1>한자 퀴즈</h1>
    <?php if ($is_correct !== null): ?>
        <div>
            <?php if ($is_correct): ?>
                <p>정답입니다! 🎉</p>
            <?php else: ?>
                <p>오답입니다. 정답은: <?php echo htmlspecialchars($correct_answer); ?> 입니다.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <p>다음 한자의 뜻과 음을 입력하세요:</p>
    <h2><?php echo htmlspecialchars($hanja); ?></h2>
    <form action="index.php" method="POST">
        <input type="text" name="user_input" placeholder="답변을 입력하세요" autocomplete="off" required>
        <button type="submit">제출</button>
    </form>
</body>
</html>
