<?php
// 데이터베이스 연결
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

// 데이터 삽입 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['data'])) {
    $rawData = $_POST['data'];
    $lines = explode("\n", $rawData); // 줄바꿈 기준으로 데이터 분리

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO han_levels (hanja, level) VALUES (:hanja, :level)");
        foreach ($lines as $line) {
            $columns = preg_split('/\s+/', trim($line)); // 공백으로 데이터 분리
            if (count($columns) === 2) {
                $stmt->execute([
                    ':hanja' => $columns[1], // 한자
                    ':level' => $columns[0]  // 급수
                ]);
            }
        }

        $pdo->commit();
        echo "데이터가 성공적으로 저장되었습니다!";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "데이터 저장 중 오류가 발생했습니다: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>한자 데이터 입력</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">한자 데이터 입력</h2>
    <form method="POST" class="mt-4">
        <div class="mb-3">
            <textarea name="data" rows="15" class="form-control" placeholder="급수\t한자&#10;7급\t家&#10;7급\t歌"></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-100">데이터 저장</button>
    </form>
</div>
</body>
</html>
