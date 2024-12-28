//1단계 - 한시분류 및 저장//
<?php include('head.php');
      include('db.php');  

    // 한시 형식 분류 및 줄 맞추기 함수 (한자만 남기고 줄바꿈 추가)
    function determineFormatAndAdjustLines($poem) {
        // 1. 한글과 기타 문자를 제거하여 한자만 남기기
        $hanja_only = preg_replace('/[^\p{Han}]/u', '', $poem);

        // 2. 글자 수에 따라 5자 또는 7자로 줄 나누기
        $lines = [];
        $char_count = mb_strlen($hanja_only, 'UTF-8');

        // 글자 수로 5언 또는 7언을 구분하여 줄 나눔
        if ($char_count % 5 == 0) {
            $line_length = 5;
        } elseif ($char_count % 7 == 0) {
            $line_length = 7;
        } else {
            return ['형식 불명', $hanja_only]; // 규칙에 맞지 않는 경우 처리
        }

        // 3. 줄 단위로 저장하기 위한 줄 나누기
        for ($i = 0; $i < $char_count; $i += $line_length) {
            $lines[] = mb_substr($hanja_only, $i, $line_length, 'UTF-8');
        }

        // 한 줄씩 배열로 저장된 결과를 줄바꿈을 포함한 문자열로 변환
        $formatted_poem = implode("\n", $lines);

        // 4. 형식 분류 (5언/7언 절구 및 율시로 분류)
        $line_count = count($lines); // 줄 수
        if ($line_count == 4 && $line_length == 5) $format_type = '5언 절구';
        elseif ($line_count == 4 && $line_length == 7) $format_type = '7언 절구';
        elseif ($line_count == 8 && $line_length == 5) $format_type = '5언 율시';
        elseif ($line_count == 8 && $line_length == 7) $format_type = '7언 율시';
        else $format_type = '형식 불명';

        return [$format_type, $formatted_poem];
    }

    // POST 요청이 있을 때 한시 내용을 데이터베이스에 저장
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["poem_content"])) {
        $conn = connectDB(); // DB 연결
        $poem_content = $_POST["poem_content"];

       // 한시 형식과 줄바꿈 추가된 포맷 가져오기
      list($format_type, $formatted_poem) = determineFormatAndAdjustLines($poem_content);

      // 데이터베이스에 중복된 내용이 있는지 확인하는 쿼리
      $sql_check = "SELECT * FROM poem WHERE content = '$formatted_poem' AND format_type = '$format_type'";
      $result = $conn->query($sql_check);

      if ($result->num_rows > 0) {
          // 중복된 내용이 존재하는 경우 메시지 출력
          $message = "<p class='text-center text-warning mt-3'>이미 동일한 내용이 저장되어 있습니다.</p>";
      } else {
          // 중복이 없을 때만 데이터 삽입 쿼리 실행
          $sql_insert = "INSERT INTO poem (content, format_type) VALUES ('$formatted_poem', '$format_type')";

          if ($conn->query($sql_insert) === TRUE) {
              $message = "<p class='text-center text-success mt-3'>한시가 성공적으로 저장되었습니다! 형식: $format_type</p>";
          } else {
              $message = "<p class='text-center text-danger mt-3'>저장 중 오류가 발생했습니다: " . $conn->error . "</p>";
          }
      }

        // 연결 종료
        $conn->close();
    }
?>

<body>
  <div class="container mt-5">
    <!-- 한시 작성 컨테이너 -->
    <div class="row mt-5 justify-content-center">
      <div class="col-md-6">
        <div class="p-4 border bg-light">
          <h3 class="text-center">한시 작성</h3>
          <!-- 한시 입력 영역 -->
          <form method="POST">
            <textarea name="poem_content" class="form-control mb-3" rows="15" placeholder="여기에 한시를 작성하세요..."></textarea>
            <!-- 저장 버튼 -->
            <button type="submit" class="btn btn-primary w-100">저장</button>
          </form>
          <?php 
            // 저장 결과 메시지 출력
            if (isset($message)) {
                echo $message;
            }
          ?>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

