<?php include('head.php'); ?>
<style>
/* 퀴즈 버튼 스타일 */
.quiz-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: white;
  border: none;
  padding: 15px 30px;
  border-radius: 50px;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
  font-size: 18px;
  text-decoration: none;
  color: black;
  transition: all 0.3s ease;
}

.quiz-btn .icon {
  margin-right: 10px;
  font-size: 1.5rem;
}

/* 버튼 호버 효과 */
.quiz-btn:hover {
  box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.15);
  transform: translateY(-3px);
}
</style>
<body>
  <div class="container mt-5 text-center">
    <!-- 머릿글 -->
    <h1 class="mb-4">사자성어 퀴즈</h1>
     <!-- 상단 로고 텍스트 (진한 글씨 및 파란색 밑줄) -->
     <div class="mb-4" style="position: absolute; top: 10px; left: 10px; font-size: 12px; color: #555;">
            <a href="test.php" style="text-decoration: none; color: inherit;">
            <span style="text-color: #007bff; text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;font-weight: bold; font-size: 18px;">한문학</span><span style="text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;">의 <span style="text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;">모든 것</span>
            </a>
        </div>

    <!-- 버튼 두 개를 중앙에 배치 -->
    <div class="d-flex justify-content-center gap-5 mt-5">
      <!-- 퀴즈 1 버튼 -->
      <a href="study2-1.php" class="btn quiz-btn">
        <span class="icon"><i class="fas fa-map-marker-alt"></i></span>
        사자성어 퀴즈1
      </a>

      <!-- 퀴즈 2 버튼 -->
      <a href="study2-2.php" class="btn quiz-btn">
        <span class="icon"><i class="fas fa-user"></i></span>
        사자성어 퀴즈2
      </a>
    </div>
  </div>

  <!-- 하단 언더바 -->
  <footer class="mt-4" style="background-color: #e0e0e0; padding: 10px 0; position: fixed; bottom: 0; width: 100%;">
    <div class="text-center">
      <p class="mb-0">© 캡스톤디자인</p>
    </div>
  </footer>

  <!-- Bootstrap JS 및 FontAwesome -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>
</html>
