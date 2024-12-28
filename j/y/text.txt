<!-- custom1.php -->

<?php include('head.php'); ?>

<body>
  <div class="container mt-5">
    <!-- 상단 로고 텍스트 (진한 글씨 및 파란색 밑줄) -->
    <div class="mb-4" style="position: absolute; top: 10px; left: 10px; font-size: 12px; color: #555;">
     <a href="test.php" style="text-decoration: none; color: inherit;">
      <span style="text-color: #007bff; text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;font-weight: bold; font-size: 18px;">한문학</span><span style="text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;">의 <span style="text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;">모든 것</span>
        </a>
    </div>

    <div class="row mt-5 justify-content-center">
      <!-- 왼쪽 컨테이너 (한자추출) -->
      <div class="col-md-6">
        <div class="p-4 border bg-light">
          <h3 class="text-center">한자추출</h3>
          <!-- 글 입력 영역 -->
          <textarea id="hanjaInput" class="form-control mb-3" rows="15" placeholder="여기에 글을 입력하세요..."></textarea>
          <!-- 추출 버튼 -->
          <button class="btn btn-primary w-100" onclick="extractText()">추출</button>
        </div>
      </div>

      <!-- 오른쪽 컨테이너 (결과) -->
      <div class="col-md-6">
        <div class="p-4 border bg-light">
          <h3 class="text-center">결과</h3>
          <!-- 결과 표시 영역 -->
          <textarea id="hanjaResult" class="form-control mb-3" rows="15" placeholder="결과가 여기에 표시됩니다..." readonly></textarea>
          <!-- 내 기록함 추가 버튼 (파란색) -->
          <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#myModal">내 기록함 추가</button>
        </div>
      </div>
    </div>
  </div>

  <!-- 하단 언더바 -->
  <footer class="mt-4" style="background-color: #e0e0e0; padding: 5px 0; position: fixed; bottom: 0; width: 100%;">
    <div class="text-center">
      <p class="mb-0"><캡스톤디자인></p>
    </div>
  </footer>

  <!-- 모달 (제목 입력 팝업창) -->
  <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="POST" action="custom3.php">
          <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">제목 입력</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>제목을 입력하세요.</p>
            <!-- 제목 입력칸 -->
            <input type="text" id="recordTitle" name="title" class="form-control mb-3" placeholder="제목을 입력하세요..." required>
            <!-- 내용 전달 (hidden) -->
            <input type="hidden" id="recordContent" name="content">
          </div>
          <div class="modal-footer">
            <!-- 확인 버튼 -->
            <button type="submit" class="btn btn-primary" onclick="addContentToRecord()">확인</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    function extractText() {
      var inputText = document.getElementById('hanjaInput').value;
      document.getElementById('hanjaResult').value = inputText;
    }

    function addContentToRecord() {
      var resultContent = document.getElementById('hanjaResult').value;
      document.getElementById('recordContent').value = resultContent;  // 기록함에 추가될 내용
    }
  </script>
</body>
</html>
