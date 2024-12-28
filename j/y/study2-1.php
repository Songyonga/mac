<?php include('head.php'); ?>

<body>
  <div class="container mt-5 text-center">
    <!-- 머릿글 -->
    <h1 class="mb-4">사자성어 퀴즈</h1>
    <p class="mb-4">성어에 일맞는 뜻을 이어주세요</p>
       <!-- 상단 로고 텍스트 (진한 글씨 및 파란색 밑줄) -->
       <div class="mb-4" style="position: absolute; top: 10px; left: 10px; font-size: 12px; color: #555;">
            <a href="test.php" style="text-decoration: none; color: inherit;">
            <span style="text-color: #007bff; text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;font-weight: bold; font-size: 18px;">한문학</span><span style="text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;">의 <span style="text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;">모든 것</span>
            </a>
        </div>
    <!-- 사자성어와 뜻 연결하는 퀴즈 -->
    <div class="quiz-container mx-auto" style="max-width: 800px;">
      <div class="row text-start">
        <div class="col-md-6">
          <!-- 사자성어 목록 -->
          <ul class="list-unstyled">
            <li class="mb-3"><b>肝膽相照</b></li>
            <li class="mb-3"><b>輾轉反側</b></li>
            <li class="mb-3"><b>錦衣還鄕</b></li>
            <li class="mb-3"><b>塞翁之馬</b></li>
            <li class="mb-3"><b>書耕夜讀</b></li>
          </ul>
        </div>

        <div class="col-md-6">
          <!-- 뜻 목록 -->
          <ul class="list-unstyled">
            <li class="mb-3">- 서로 속마음을 털어놓고 친하게 사귐</li>
            <li class="mb-3">- 누워서 몸을 이리저리 뒤척이며 잠을 이루지 못함</li>
            <li class="mb-3">- 출세하여 고향에 돌아옴을 이르는 말</li>
            <li class="mb-3">- 인생의 길흉화복은 늘 바뀌어 변화가 많음을 이르는 말</li>
            <li class="mb-3">- 낮에는 농사 짓고 밤에는 공부한다는 뜻, 바쁜 틈을 차여럽게 공부함</li>
          </ul>
        </div>
      </div>

      <!-- 이미지 참고하여 선 연결하는 것처럼 표현 -->
      <div class="mt-4">
        <img src="path_to_your_image/quiz_image.png" alt="성어 연결 이미지" class="img-fluid">
      </div>
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
