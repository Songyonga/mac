<?php
// MySQL 연결 설정
$servername = "localhost";
$username = "yong";
$password = "1111";
$dbname = "user_system";

// CSV 파일 설정
$csvFileName = "hanzadata.csv";

// MySQL 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("MySQL 연결 실패: " . $conn->connect_error);
}

// hanzadata 테이블에서 데이터 가져오기
$sql = "SELECT title, content FROM hanzadata";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // CSV 파일 생성 및 열기
    $csvFile = fopen($csvFileName, "w");
    
    // CSV 헤더 작성
    fputcsv($csvFile, ["타이틀", "한자"]);
    
    // 데이터 처리
    while ($row = $result->fetch_assoc()) {
        $title = $row['title']; // 제목
        $content = $row['content']; // 한자 내용

        // 한글자씩 분리
        $characters = preg_split('//u', $content, -1, PREG_SPLIT_NO_EMPTY);

        // 한 글자씩 CSV에 저장
        foreach ($characters as $char) {
            fputcsv($csvFile, [$title, $char]);
        }
    }
    
    // CSV 파일 닫기
    fclose($csvFile);
    echo "CSV 파일 생성 완료: $csvFileName";
} else {
    echo "데이터가 없습니다.";
}

// MySQL 연결 닫기
$conn->close();
?>
