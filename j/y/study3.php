<?php include('head.php'); ?>

<body>
  <div class="container mt-5 text-center">
    <!-- 점수 및 누적점수 표시 -->
    <h1>80점</h1>
    <p>누적점수: 200점</p>
       <!-- 상단 로고 텍스트 (진한 글씨 및 파란색 밑줄) -->
       <div class="mb-4" style="position: absolute; top: 10px; left: 10px; font-size: 12px; color: #555;">
            <a href="test.php" style="text-decoration: none; color: inherit;">
            <span style="text-color: #007bff; text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;font-weight: bold; font-size: 18px;">한문학</span><span style="text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;">의 <span style="text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;">모든 것</span>
            </a>
        </div>    

    <!-- 성어 목록 및 스크랩 버튼 -->
    <div class="quiz-container mx-auto" style="max-width: 800px;">
      <table class="table table-borderless">
        <tbody>
          <tr>
            <td><strong>肝膽相照</strong></td>
            <td>서로 마음을~</td>
            <td><input type="checkbox" aria-label="스크랩"></td>
          </tr>
          <tr>
            <td><strong>輾轉反側</strong></td>
            <td>잠을 이루지 X</td>
            <td><input type="checkbox" aria-label="스크랩"></td>
          </tr>
          <tr>
            <td><strong style="color: red;">錦衣還鄕</strong></td>
            <td>출세하여 고향에~</td>
            <td><input type="checkbox" aria-label="스크랩"></td>
          </tr>
          <tr>
            <td><strong>塞翁之馬</strong></td>
            <td>인생이야~</td>
            <td><input type="checkbox" aria-label="스크랩"></td>
          </tr>
          <tr>
            <td><strong>書耕夜讀</strong></td>
            <td>낮에는 농사~</td>
            <td><input type="checkbox" aria-label="스크랩"></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- 하단 언더바 -->
  <footer class="mt-4" style="background-color: #e0e0e0; padding: 10px 0; position: fixed; bottom: 0; width: 100%;">
    <div class="text-center">
      <p class="mb-0">© 캡스톤디자인</p>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
