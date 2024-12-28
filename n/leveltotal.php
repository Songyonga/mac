<?php
// 데이터베이스 연결
$host = 'localhost';
$dbname = 'user_system'; // 데이터베이스 이름
$user = 'yong'; // 데이터베이스 사용자 이름
$pass = '1111'; // 데이터베이스 비밀번호

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// 입력된 한자 검증 처리
$result = [];
$levelCounts = [];
$rawInput = ""; // 초기화
$uniqueHanjaCount = 0; // 고유 한자 수 계산

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inputHanja'])) {
    // 입력값 가져오기 및 공백 제거
    $rawInput = $_POST['inputHanja'];
    $cleanedInput = preg_replace('/\s+/', '', $rawInput); // 공백, 줄바꿈 제거

    // 한자를 배열로 분리 후 중복 제거
    $inputHanja = array_unique(preg_split('//u', $cleanedInput, -1, PREG_SPLIT_NO_EMPTY));
    $uniqueHanjaCount = count($inputHanja); // 고유 한자 수 계산

    foreach ($inputHanja as $hanja) {
        $stmt = $pdo->prepare("SELECT title FROM hanzadata WHERE content LIKE :hanja");
        $stmt->execute(['hanja' => '%' . $hanja . '%']);
        $levels = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if ($levels) {
            $result[] = [
                "hanja" => $hanja,
                "level" => implode(', ', $levels)
            ]; // 결과를 배열에 저장

            foreach ($levels as $level) {
                if (!isset($levelCounts[$level])) {
                    $levelCounts[$level] = 0;
                }
                $levelCounts[$level]++;
            }
        } else {
            $result[] = [
                "hanja" => $hanja,
                "level" => "해당 급수 없음"
            ];
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
    <!-- 상단 로고 텍스트 -->
    <div class="mb-4" style="position: absolute; top: 10px; right: 10px; font-size: 12px; color: #555;">
        <a href="index.php" style="text-decoration: none; color: inherit;">
            <span style="text-color: #007bff; text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;font-weight: bold; font-size: 18px;">한문학</span><span style="text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;">의 <span style="text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;">모든 것</span>
        </a>
    </div>
    <div class="row">
        <!-- 왼쪽 입력 칸 -->
        <div class="col-md-6">
            <div class="p-4 border bg-light">
                <h3 class="text-center">한자 입력</h3>
                <form method="POST">
                    <textarea name="inputHanja" rows="10" class="form-control mb-3" placeholder="여기에 한자를 입력하세요..."><?= htmlspecialchars($rawInput) ?></textarea>
                    <button type="submit" class="btn btn-primary w-100">검증</button>
                </form>
            </div>
        </div>

        <!-- 오른쪽 결과 칸 -->
        <div class="col-md-6">
            <div class="p-4 border bg-light">
                <h3 class="text-center">결과</h3>
                <div class="form-control mb-3" style="height: 300px; overflow-y: auto; background-color: #f8f9fa;">
                <?php if (!empty($result)) { ?>
                    <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50%;">한자</th>
                                <th style="width: 50%;">급수</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result as $row) { ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['hanja']) ?></td>
                                    <td><?= htmlspecialchars(trim($row['level'], ',')) ?></td> <!-- 쉼표 제거 -->
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    결과가 여기에 표시됩니다.
                <?php } ?>

                </div>
                <div class="text-center">
                    <?php if (!empty($levelCounts)) { ?>
                        <p><strong>급수별 요약:</strong></p>
                        <?php foreach ($levelCounts as $level => $count) { ?>
                            <?= htmlspecialchars($level) ?>: <strong><?= $count ?></strong>개, 
                        <?php } ?>
                        <p class="mt-2">총 고유 한자 수: <strong><?= $uniqueHanjaCount ?></strong>개</p>
                    <?php } else { ?>
                        급수별 요약 결과가 없습니다.
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
