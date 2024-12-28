//2-1 단계 csv파일 데이터베이스에 저장//
<?php

      include('head.php');
      include('db.php');  

// 데이터베이스 연결
$conn = connectDB();  // 여기서 connectDB() 함수를 호출하여 $conn 변수를 초기화합니다.

// CSV 파일 경로 설정 (로컬 경로를 실제 파일 경로로 수정)
$csvFile = 'hanzi_tone.csv';

if(file_exists($csvFile))
    echo "exist<br>";
else
    echo "no file<br>";

// CSV 파일 열기 및 데이터 저장
if (($handle = fopen($csvFile, "r")) !== FALSE) {
    fgetcsv($handle); // 첫 줄(헤더) 건너뛰기

    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $hanzi = trim($data[0]);   // 첫 번째 열: 한자
        $tone = trim($data[1]);    // 두 번째 열: 평측 정보

        // `hanzi_tone` 테이블에 데이터 삽입 (중복 한자일 경우 덮어쓰기)
        $stmt = $conn->prepare("INSERT INTO hanzi_tone (hanzi, tone) VALUES (?, ?) ON DUPLICATE KEY UPDATE tone = ?");
        $stmt->bind_param("sss", $hanzi, $tone, $tone);
        $stmt->execute();
    }
    fclose($handle);
    echo "CSV 데이터를 성공적으로 가져왔습니다.";
} else {
    echo "CSV 파일을 열 수 없습니다.";
}

// 연결 종료
$conn->close();
?>
