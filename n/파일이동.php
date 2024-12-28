<?php
// 데이터베이스 연결 정보
$servername = "localhost";
$username = "yong";
$password = "1111";
$dbname = "user_system";

try {
    // PDO를 사용한 데이터베이스 연결
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 복사할 데이터의 조건 (title)
    $titles = ['특급', '특2급', '1급', '2급', '3급', '4급', '5급', '6급', '7급', '8급'];

    // 데이터를 hanzadata에서 가져오기
    $placeholders = str_repeat('?,', count($titles) - 1) . '?';
    $stmt = $conn->prepare("SELECT title FROM hanzadata WHERE title IN ($placeholders)");
    $stmt->execute($titles);

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($rows) {
        // haja_levels에 데이터 삽입
        $insertStmt = $conn->prepare("INSERT INTO hanja_level (level, hanja, created_at) VALUES (:level, :hanja, NOW())");

        foreach ($rows as $row) {
            // title을 `level`로 변환 (예: "1급" -> 1, "2급" -> 2)
            $level = (int) filter_var($row['title'], FILTER_SANITIZE_NUMBER_INT);
            if ($level === 0) {
                // 예외 처리: '특급', '특2급' 등의 경우 고유한 level 값을 할당
                $level = $row['title'] === '특급' ? 100 : ($row['title'] === '특2급' ? 99 : 0);
            }

            // `hanja`는 고정된 값 또는 다른 데이터를 사용할 수 있습니다.
            $hanja = '漢'; // 기본값으로 '漢'을 삽입

            $insertStmt->execute([
                ':level' => $level,
                ':hanja' => $hanja,
            ]);
        }

        echo "데이터가 성공적으로 복사되었습니다.";
    } else {
        echo "조건에 맞는 데이터가 없습니다.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// 연결 닫기
$conn = null;
?>
