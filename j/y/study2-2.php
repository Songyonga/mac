<?php include('head.php'); ?>

<body>
  <div class="container mt-5 text-center">
    <!-- 머릿글 -->
    <h1 class="mb-4">사자성어 퀴즈</h1>
    <p class="mb-4">성어에 일맞는 뜻을 고르세요</p>
      <!-- 상단 로고 텍스트 (진한 글씨 및 파란색 밑줄) -->
      <div class="mb-4" style="position: absolute; top: 10px; left: 10px; font-size: 12px; color: #555;">
            <a href="test.php" style="text-decoration: none; color: inherit;">
            <span style="text-color: #007bff; text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;font-weight: bold; font-size: 18px;">한문학</span><span style="text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;">의 <span style="text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;">모든 것</span>
            </a>
        </div>
    <!-- 사자성어 문제 -->
    <div class="quiz-container mx-auto" style="max-width: 600px;">
      <h2 class="mb-3">輾轉反側</h2>
      <p class="mb-3">바로바로 O X 결과를 한자 위에 표시!</p>
      
      <!-- 답변 선택지 -->
      <div class="text-start">
        <button class="btn btn-outline-dark w-100 mb-3">서로 속마음을 털어놓고 친하게 사귐</button>
        <button class="btn btn-outline-dark w-100 mb-3">출세하여 고향에 돌아옴을 이르는 말</button>
        <button class="btn btn-outline-dark w-100 mb-3">누워서 몸을 이리저리 뒤척이며 잠을 이루지 못함</button>
      </div>

      <!-- 패스 버튼 -->
      <div class="text-end mt-3">
        <button class="btn btn-outline-secondary">PASS >></button>
      </div>
    </div>

    <!-- 하단에 문제 번호 -->
    <div class="mt-4">
      <p class="text-end">사자성어 다섯개씩. <br> 1 / 5</p>
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
