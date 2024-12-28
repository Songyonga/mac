<?php 
include ('head.php');
?>

<body>
  <div class="container mt-5">
    <div class="row mt-5 justify-content-center">
      <div class="col-md-6">
        <div class="p-4 border bg-light">
          <h3 class="text-center">한시 및 평측 입력</h3>
          <form method="POST" action="">
            <textarea name="poem_content" class="form-control mb-3" rows="8" placeholder="여기에 한시와 평측을 작성하세요..."></textarea>
            <button type="submit" class="btn btn-primary w-100">검사</button>
          </form>
        </div>
      </div>
    </div>

    <div class="row mt-4 justify-content-center">
      <div class="col-md-6">
        <div class="p-4 border bg-light">
          <h4 class="text-center">검사 결과</h4>

          <?php 
          // 사용자 입력을 필터링하여 '평'과 '측'만 추출하는 함수
          function filterInputTones($input) {
              $lines = explode("\n", trim($input)); // 각 줄을 나눔
              $filtered_lines = [];

              foreach ($lines as $line) {
                  $filtered_line = preg_replace('/[^평측]/u', '', $line); // '평'과 '측'만 남김
                  if (!empty($filtered_line)) {
                      $filtered_lines[] = mb_str_split($filtered_line); // 각 글자를 배열로 저장
                  }
              }

              return $filtered_lines; // 각 줄이 분리된 배열 반환
          }

          if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["poem_content"])) {
              $input_content = $_POST["poem_content"];
              $filtered_tones = filterInputTones($input_content);

              // 패턴 정의 (5언 절구 예시)
              $expected_pattern = [
                  ["평", "평", "측", "측", "평"],
                  ["측", "평", "평", "평", "측"],
                  ["측", "측", "평", "평", "측"],
                  ["평", "평", "평", "측", "평"]
              ];

              $total_matches = 0;
              $total_elements = 0;
              $highlighted_output = ""; // 틀린 부분을 강조할 문자열

              // 입력된 한자와 평측을 분석하여 패턴과 비교
              for ($i = 0; $i < count($filtered_tones) && $i < count($expected_pattern); $i++) {
                  $user_tones = $filtered_tones[$i];
                  $pattern_tones = $expected_pattern[$i];
                  $line_result = "";

                  // 일치하는 평측 개수 계산 및 색상 지정
                  foreach ($user_tones as $j => $tone) {
                      if ($j < count($pattern_tones) && $tone == $pattern_tones[$j]) {
                          $line_result .= "<span style='color: black;'>$tone</span> "; // 기본색 또는 검은색
                          $total_matches++;
                      } else {
                          $line_result .= "<span style='color: red;'>$tone</span> "; // 틀린 부분은 빨간색
                      }
                      $total_elements++;
                  }
                  $highlighted_output .= trim($line_result) . "<br>";
              }

              // 일치율 계산
              $accuracy = ($total_matches / $total_elements) * 100;
              $result = $accuracy >= 80 ? "합격" : "불합격";
              
              // 결과 색상 적용 (합격은 파란색, 불합격은 빨간색)
              echo "<p><strong>일치율:</strong> {$accuracy}%</p>";
              if ($result === "합격") {
                  echo "<p><strong>결과:</strong> <span style='color: blue; font-weight: bold;'>{$result}</span></p>";
              } else {
                  echo "<p><strong>결과:</strong> <span style='color: red; font-weight: bold;'>{$result}</span></p>";
              }
              
              // 틀린 부분을 강조한 결과 출력
              echo "<h5 class='text-center'>입력한 평측 검사 결과:</h5>";
              echo "<p class='text-center'>{$highlighted_output}</p>";
          } else {
              echo "<p>결과가 여기에 표시됩니다.</p>";
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
