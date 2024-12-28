<?php include('menu.php'); ?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <title>논어 한자 분석</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
      
  <!-- 상단 로고 텍스트 -->
      <div class="mb-4" style="position: absolute; top: 10px; right: 10px; font-size: 12px; color: #555;">
        <a href="index.php" style="text-decoration: none; color: inherit;">
            <span style="text-color: #007bff; text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;font-weight: bold; font-size: 18px;">한문학</span><span style="text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;">의 <span style="text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;">모든 것</span>
        </a>
    </div>

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
    ini_set('memory_limit', '512M');
    ini_set('max_execution_time', '300');

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hanziData'])) {
        // 입력 데이터
        $data = $_POST['hanziData'];

        // 한자 추출
        preg_match_all('/[\x{4E00}-\x{9FFF}]/u', $data, $matches);
        $hanzi_array = $matches[0]; // 모든 한자를 배열로 저장

        // 4-그램 생성
        $quadgrams = [];
        $hanzi_list = array_values($matches[0]); // 한자 배열 정렬 및 인덱스 재정렬

        for ($i = 0; $i < count($hanzi_list) - 3; $i++) {
            $quadgrams[] = $hanzi_list[$i] . $hanzi_list[$i + 1] . $hanzi_list[$i + 2] . $hanzi_list[$i + 3];
        }

        // 4-그램의 빈도 계산
        $quadgram_counts = array_count_values($quadgrams);
        arsort($quadgram_counts); // 빈도수 기준 내림차순 정렬

        // 고유한 4-그램 개수 출력
        $unique_quadgram_count = count($quadgram_counts);
        echo "<h5 class='text-primary'>논어의 고유 4-그램은 총 $unique_quadgram_count 개입니다.</h5>";

        // 상위 10개의 4-그램 출력
        echo "<h5 class='text-primary'>상위 10개의 4-그램 빈도수</h5>";
        echo "<ul>";
        foreach (array_slice($quadgram_counts, 0, 10) as $quadgram => $count) {
            echo "<li>$quadgram: $count 번</li>";
        }
        echo "</ul>";

        // 모든 네 글자 조합 출력 (스크롤 가능한 테이블)
        echo "<div class='result-container'>";
        echo "<table class='table table-bordered'>";
        echo "<thead><tr><th>#</th><th>네 글자</th><th>빈도수</th></tr></thead>";
        echo "<tbody>";

        // 네 글자 조합 출력
        $index = 1;
        foreach ($quadgram_counts as $quadgram => $count) {
            echo "<tr><td>$index</td><td>" . htmlspecialchars($quadgram) . "</td><td>$count</td></tr>";
            $index++;
        }

        echo "</tbody></table></div>";
    }
?>




</div>
</body>
</html>
