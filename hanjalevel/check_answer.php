<?php
session_start();
if (!isset($_SESSION['correct_answer'])) {
    die("정답 데이터가 없습니다. 다시 시도하세요.");
}

$user_input = isset($_POST['user_input']) ? trim($_POST['user_input']) : '';
$correct_answer = $_SESSION['correct_answer'];

// 띄어쓰기 제거
$user_input = str_replace(' ', '', $user_input);
$correct_answer = str_replace(' ', '', $correct_answer);

// 문자열 유사도 계산 (PHP로 구현)
function calculate_similarity($input, $correct) {
    similar_text($input, $correct, $percent);
    return $percent;
}

$similarity = calculate_similarity($user_input, $correct_answer);

// 유사도 기준 70%
$is_correct = $similarity >= 70;

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>결과</title>
</head>
<body>
    <h1>결과</h1>
    <?php if ($is_correct): ?>
        <p>정답입니다! 🎉</p>
    <?php else: ?>
        <p>오답입니다. 정답은: <?php echo $_SESSION['correct_answer']; ?> 입니다.</p>
    <?php endif; ?>
    <a href="index.php">다음 문제 풀기</a>
</body>
</html>
