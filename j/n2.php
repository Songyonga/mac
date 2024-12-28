<!DOCTYPE html>
<html lang="ko">
<head>
  <title>논어 한자 분석</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    .container { margin-top: 20px; }
    textarea { width: 100%; height: 150px; }
    .result-container { max-height: 400px; overflow-y: auto; }
  </style>
</head>
<body>
<div class="container">
  <h2 class="text-center">논어 한자 분석</h2>
  <form method="post" action="">
    <div class="mb-3">
      <label for="hanziData" class="form-label">데이터 입력</label>
      <textarea id="hanziData" name="hanziData" placeholder="분석할 데이터를 입력하세요."><?php echo isset($_POST['hanziData']) ? htmlspecialchars($_POST['hanziData']) : ''; ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">분석하기</button>
  </form>

  <?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hanziData'])) {
    // 입력 데이터
    $data = $_POST['hanziData'];

    // 한자 추출
    preg_match_all('/[\x{4E00}-\x{9FFF}]/u', $data, $matches);

    // 고유한 한자와 빈도 계산
    $hanzi_counts = array_count_values($matches[0]);

    // 제외할 한자 목록
    $excluded_hanzi = ['子', '曰'];

    // 제외할 한자 필터링
    foreach ($excluded_hanzi as $exclude) {
        unset($hanzi_counts[$exclude]);
    }

    // 빈도수 기준으로 정렬
    arsort($hanzi_counts);

    // 고유한 한자 수
    $unique_hanzi_count = count(array_keys($hanzi_counts)); // 고유한 한자 개수 계산

    // 총 한자 수 출력
    echo "<h5 class='text-primary'>논어의 한자는 총 $unique_hanzi_count개의 한자로 이루어져 있습니다.</h5>";

    // 100번 이상 사용된 한자 표시
    echo "<h5 class='text-primary'>100번 이상 사용된 한자 (상위 10칸, 스크롤 가능)</h5>";
    echo "<div class='result-container' style='overflow-x: auto;'>";
    echo "<table class='table table-bordered'>";
    echo "<thead><tr>";
    for ($i = 1; $i <= 10; $i++) {
        echo "<th>칸 $i</th>";
    }
    echo "</tr></thead><tbody><tr>";

    $displayed = 0; // 표시된 한자 수
    foreach ($hanzi_counts as $hanzi => $count) {
        if ($count < 100) continue; // 100번 미만은 표시하지 않음
        echo "<td><strong>$hanzi</strong>: $count번</td>";
        $displayed++;
        if ($displayed % 10 === 0) {
            echo "</tr><tr>"; // 10칸씩 표시 후 줄바꿈
        }
    }

    echo "</tr></tbody></table></div>";

    // 모든 한자 출력 (스크롤 가능한 테이블)
    echo "<div class='result-container' style='max-height: 400px; overflow-y: auto;'>";
    echo "<table class='table table-bordered'>";
    echo "<thead><tr><th>#</th><th>한자</th><th>빈도수</th></tr></thead>";
    echo "<tbody>";

    // 모든 한자 출력
    $index = 1;
    foreach ($hanzi_counts as $hanzi => $count) {
        echo "<tr><td>$index</td><td>" . htmlspecialchars($hanzi) . "</td><td>$count</td></tr>";
        $index++;
    }

    echo "</tbody></table></div>";
}
?>


</div>
</body>
</html>
