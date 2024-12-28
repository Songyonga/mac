<?php
// 데이터베이스 연결
$host = 'localhost';
$dbname = 'user_system'; // 데이터베이스 이름
$user = 'yong'; // 데이터베이스 사용자 이름
$pass = '1111';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// 입력된 한자 검증 처리
$result = [];
$rawInput = ""; // 초기화
$notFoundHanja = []; // '없음'으로 표시된 한자를 저장

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inputHanja'])) {
    // 입력값 가져오기 및 공백 제거
    $rawInput = $_POST['inputHanja'];
    $cleanedInput = preg_replace('/\s+/', '', $rawInput); // 공백, 줄바꿈 제거

    // 한자를 배열로 분리 (입력 순서를 유지)
    $inputHanja = preg_split('//u', $cleanedInput, -1, PREG_SPLIT_NO_EMPTY);

    foreach ($inputHanja as $hanja) {
        // han_levels 테이블에서 hanja 열을 기준으로 조회
        $stmt = $pdo->prepare("SELECT level, total FROM han_levels WHERE hanja = :hanja");
        $stmt->execute(['hanja' => $hanja]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC); // 결과를 연관 배열로 가져옴

        if ($row) {
            $result[] = [
                'hanja' => $hanja,
                'level' => $row['level'],
                'total' => $row['total'] // 총획 추가
            ];
        } else {
            $result[] = [
                'hanja' => $hanja,
                'level' => '없음',
                'total' => '없음' // 총획이 없으면 "없음"으로 표시
            ];
            $notFoundHanja[] = $hanja; // '없음'인 한자를 저장
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>한자 급수 검증</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <!-- 입력 및 결과 영역 -->
    <div class="row">
        <!-- 입력 칸 -->
        <div class="col-md-6">
            <div class="p-4 border bg-light">
                <h3 class="text-center">한자 입력</h3>
                <form method="POST">
                    <textarea name="inputHanja" rows="10" class="form-control mb-3" placeholder="여기에 한자를 입력하세요..."><?= htmlspecialchars($rawInput) ?></textarea>
                    <button type="submit" class="btn btn-primary w-100">검증</button>
                </form>
            </div>
        </div>

        <!-- 결과 출력 -->
        <div class="col-md-6">
            <div class="p-4 border bg-light">
                <h3 class="text-center">결과</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>한자</th>
                            <th>급수</th>
                            <th>총획</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($result)): ?>
                            <?php foreach ($result as $row): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['hanja']) ?></td>
                                    <td><?= htmlspecialchars($row['level']) ?></td>
                                    <td><?= htmlspecialchars($row['total']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">결과가 없습니다.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- '없음'으로 표시된 한자 나열 -->
    <div class="mt-4">
        <h4 class="text-center">'없음'으로 표시된 한자</h4>
        <div class="p-3 border bg-light" style="height: 150px; overflow-y: auto; white-space: pre-wrap;">
            <?php
            if (!empty($notFoundHanja)) {
                echo implode(', ', $notFoundHanja); // '없음'인 한자를 쉼표로 구분하여 출력
            } else {
                echo "모든 한자가 데이터베이스에 있습니다.";
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>
