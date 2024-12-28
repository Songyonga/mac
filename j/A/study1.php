<?php include('head.php'); ?>

<body>
  <div class="container mt-5 text-center">
    <!-- 머릿글 -->
    <h1 class="mb-4">오늘의 사자성어</h1>
    
    <!-- 사자성어 컨테이너 -->
    <div class="p-4 border bg-light mx-auto" style="max-width: 600px;">
      <!-- 사자성어 -->
      <h2 id="idiom-title" class="fs-1 mb-4">學而時習</h2>
      <!-- 사자성어의 뜻 -->
      <p id="idiom-meaning">배우고 때로 익힌다는 뜻으로, 배운 것을 복습하고 연습하면 그 참 뜻을 알게 된다는 말입니다.</p>
    </div>
  </div>

  <!-- 하단 언더바 -->
  <footer class="mt-4" style="background-color: #e0e0e0; padding: 10px 0; position: fixed; bottom: 0; width: 100%;">
    <div class="text-center">
      <p class="mb-0">© 캡스톤디자인</p>
    </div>
  </footer>

  <!-- External JavaScript -->
  <script src="idiom.js"></script>
  <script>
    // 페이지가 로드될 때 updateIdiom 호출
    document.addEventListener("DOMContentLoaded", () => updateIdiom("idiom-title", "idiom-meaning"));
  </script>
</body>
</html>
