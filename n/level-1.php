<?php
// 데이터베이스 연결 설정
$host = 'localhost'; // 데이터베이스 호스트
$dbname = 'user_system'; // 데이터베이스 이름
$user = 'yong'; // 사용자 이름
$pass = '1111'; // 비밀번호

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// 결과 초기화
$unrecognized = []; // 인식되지 않는 한자 저장
$rawInput = ""; // 사용자 입력 초기화

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inputHanja'])) {
    // 사용자 입력값 가져오기
    $rawInput = $_POST['inputHanja'];
    $cleanedInput = preg_replace('/\s+/', '', $rawInput); // 공백 및 줄바꿈 제거
    $inputHanja = preg_split('//u', $cleanedInput, -1, PREG_SPLIT_NO_EMPTY); // 한 글자씩 분리

    // 데이터베이스에서 hanzadata의 모든 content 필드 가져오기
    $query = "SELECT content FROM hanzadata";
    $stmt = $pdo->query($query);
    $dbHanjaList = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // 데이터베이스의 모든 한자 합치기 (공백 제거 후 한 글자씩 분리)
    $dbHanja = [];
    foreach ($dbHanjaList as $content) {
        $dbHanja = array_merge($dbHanja, preg_split('//u', preg_replace('/\s+/', '', $content), -1, PREG_SPLIT_NO_EMPTY));
    }

    // 중복 제거
    $dbHanja = array_unique($dbHanja);

    // 입력된 한자와 DB 한자 비교
    foreach ($inputHanja as $hanja) {
        if (!in_array($hanja, $dbHanja)) {
            $unrecognized[] = $hanja; // DB에 없는 한자 저장
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>인식되지 않는 한자</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <!-- 입력 칸 -->
        <div class="col-md-6">
            <div class="p-4 border bg-light">
                <h3 class="text-center">한자 입력</h3>
                <form method="POST">
                    <textarea name="inputHanja" rows="10" class="form-control mb-3" placeholder="여기에 한자를 입력하세요..."><?= htmlspecialchars($rawInput) ?></textarea>
                    <button type="submit" class="btn btn-primary w-100">대조</button>
                </form>
            </div>
        </div>

        <!-- 결과 칸 -->
        <div class="col-md-6">
            <div class="p-4 border bg-light">
                <h3 class="text-center">인식되지 않는 한자</h3>
                <?php if (!empty($unrecognized)): ?>
                    <pre class="bg-light p-3 border" style="height: 300px; overflow-y: auto;"><?= implode(' ', $unrecognized) ?></pre>
                <?php else: ?>
                    <div class="text-center">모든 한자가 데이터베이스에 존재합니다.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
