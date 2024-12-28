//2-2단계 - 한시 평측 분석 및 저장//
<?php
include('head.php');
include('db.php'); 

// 한자-평측 데이터를 `hanzi_tone` 테이블에서 불러오기
function loadHanziToneDataFromDB($conn) {
    $hanzi_tone = [];
    $query = "SELECT hanzi, tone FROM hanzi_tone";
    $result = $conn->query($query);

    while ($row = $result->fetch_assoc()) {
        $hanzi_tone[trim($row['hanzi'])] = trim($row['tone']); // 한자와 평측 정보 저장
    }

    return $hanzi_tone;
}

// 평측 분석 수행 함수
function analyzeTone($poem, $hanzi_tone_data) {
    $hanja_only = preg_replace('/[^\p{Han}]/u', '', $poem); // 한자만 추출
    $line_length = (mb_strlen($hanja_only) % 5 == 0) ? 5 : 7; // 5자 또는 7자로 나누기 결정
    $hanzi_lines = [];
    $tone_lines = [];

    // 각 한자에 대해 평측 정보 매칭 및 줄 단위로 나누기
    for ($i = 0; $i < mb_strlen($hanja_only); $i += $line_length) {
        $line = mb_substr($hanja_only, $i, $line_length, 'UTF-8');
        $hanzi_lines[] = $line;

        $tone_line = "";
        foreach (mb_str_split($line) as $hanzi) {
            $tone_line .= isset($hanzi_tone_data[$hanzi]) ? $hanzi_tone_data[$hanzi] : "정보 없음";
            $tone_line .= " ";
        }
        $tone_lines[] = trim($tone_line);
    }

    // 각 줄을 개행으로 구분하여 반환
    $formatted_hanzi = implode("\n", $hanzi_lines);
    $formatted_tones = implode("\n", $tone_lines);

    return [$formatted_hanzi, $formatted_tones];
}

  // POST 요청 처리
  $formatted_hanzi = $formatted_tones = "";
  $message = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["poem_content"])) {
      $conn = connectDB(); // 데이터베이스 연결 설정
      $hanzi_tone_data = loadHanziToneDataFromDB($conn);

      $poem_content = $_POST["poem_content"];
      list($formatted_hanzi, $formatted_tones) = analyzeTone($poem_content, $hanzi_tone_data);

      // 중복 확인 쿼리: 동일한 hanzi와 tone 데이터가 있는지 확인
      $sql_check = "SELECT * FROM poam2 WHERE hanzi = '$formatted_hanzi' AND tone = '$formatted_tones'";
      $result = $conn->query($sql_check);

      if ($result->num_rows > 0) {
          // 중복된 내용이 존재하는 경우 메시지 출력
          $message = "<p class='text-center text-warning mt-3'>이미 동일한 내용이 저장되어 있습니다.</p>";
      } else {
          // 중복이 없을 때만 데이터 삽입 쿼리 실행
          $sql_insert = "INSERT INTO poam2 (hanzi, tone) VALUES ('$formatted_hanzi', '$formatted_tones')";

          if ($conn->query($sql_insert) === TRUE) {
              $message = "<p class='text-center text-success mt-3'>저장완료</p>";
          } else {
              $message = "<p class='text-center text-danger mt-3'>저장 중 오류가 발생했습니다: " . $conn->error . "</p>";
          }
      }

      $conn->close();
  }

?>

<body>
  <div class="container mt-5">
    <div class="row mt-5 justify-content-center">
      <div class="col-md-6">
        <div class="p-4 border bg-light">
          <h3 class="text-center">한시 작성</h3>
          <form method="POST">
            <textarea name="poem_content" class="form-control mb-3" rows="15" placeholder="여기에 한시를 작성하세요..."></textarea>
            <button type="submit" class="btn btn-primary w-100">추출</button>
          </form>
        </div>
      </div>
    </div>

    <div class="row mt-4 justify-content-center">
      <div class="col-md-6">
        <div class="p-4 border bg-light">
          <h4 class="text-center">추출 결과</h4>
          <?php if ($formatted_hanzi && $formatted_tones): ?>
            <pre><strong>한자:</strong><br><?php echo htmlspecialchars($formatted_hanzi); ?></pre>
            <pre><strong>평측:</strong><br><?php echo htmlspecialchars($formatted_tones); ?></pre>
          <?php else: ?>
            <p>여기에 한시 분석 결과가 표시됩니다.</p>
          <?php endif; ?>

          <!-- 저장 완료 메시지 표시 -->
          <?php if ($message): ?>
            <?php echo $message; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
