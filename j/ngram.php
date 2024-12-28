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
    .result-container { max-height: 400px; overflow-y: auto; border: 1px solid #ccc; padding: 10px; border-radius: 5px; }
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

      // 한자 빈도수 계산
      $hanzi_frequency = array_count_values($matches[0]);
      arsort($hanzi_frequency); // 빈도수로 내림차순 정렬

      // 고유한 한자 추출
      $unique_hanzi = array_keys($hanzi_frequency);
      $hanzi_count = count($unique_hanzi);

      echo "<div class='mt-4'>";
      echo "<h4 class='text-success'>논어의 한자는 총 <strong>$hanzi_count</strong>개의 한자로 이루어져 있습니다.</h4>";

      // 빈도수 Top 10 출력
      echo "<h5 class='text-primary mt-4'>한자 사용 빈도 Top 10</h5>";
      echo "<ul>";
      $top_count = 0;
      foreach ($hanzi_frequency as $hanzi => $count) {
          echo "<li>" . (++$top_count) . ". '" . htmlspecialchars($hanzi) . "'가 <strong>$count</strong>번 사용되었습니다.</li>";
          if ($top_count == 10) break;
      }
      echo "</ul>";

      // 모든 고유 한자 출력 (스크롤 가능)
      echo "<div class='result-container'><table class='table table-bordered'>";
      echo "<thead><tr><th>#</th><th>한자</th></tr></thead>";
      echo "<tbody>";

      foreach ($unique_hanzi as $index => $hanzi) {
          echo "<tr><td>" . ($index + 1) . "</td><td>" . htmlspecialchars($hanzi) . "</td></tr>";
      }

      echo "</tbody></table></div>";
      echo "</div>";
  }
  ?>
</div>
</body>
</html>
