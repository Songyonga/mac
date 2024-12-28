<!-- custom2.php -->

<?php include('head.php'); ?>

<body>
  <div class="container mt-5">
    <!-- 상단 로고 텍스트 -->
    <div class="mb-4" style="position: absolute; top: 10px; left: 10px; font-size: 12px; color: #555;">
      <a href="test.php" style="text-decoration: none; color: inherit;">
        <span style="color: #007bff; text-decoration: underline; font-weight: bold; font-size: 18px;">한문학</span>
        <span style="text-decoration: underline; color: #007bff;">의 모든 것</span>
      </a>
    </div>

    <div class="row mt-5 justify-content-center">
      <!-- 왼쪽 컨테이너 -->
      <div class="col-md-6">
        <div class="p-4 border bg-light">
          <h3 class="text-center">텍스트 입력 및 기능 선택</h3>
          <!-- 글 입력 영역 -->
          <textarea id="textInput" class="form-control mb-3" rows="15" placeholder="여기에 글을 입력하세요..."></textarea>
          <!-- 검색어 입력 -->
          <input type="text" id="searchTerm" class="form-control mb-3" placeholder="찾고 싶은 글자 입력" />
          <!-- 드롭다운 메뉴 -->
          <select id="functionOption" class="form-select mb-3">
            <option value="extractWords">단어 추출</option>
            <option value="highlightWord">단어 강조</option>
            <option value="extractSentences">문장 추출</option>
          </select>
          <!-- 실행 버튼 -->
          <button class="btn btn-primary w-100" onclick="processText()">실행</button>
        </div>
      </div>

      <!-- 오른쪽 컨테이너 -->
      <div class="col-md-6">
        <div class="p-4 border bg-light">
          <h3 class="text-center">결과</h3>
          <!-- 결과 표시 영역 -->
          <div id="textResult" class="form-control mb-3" style="height: 375px; overflow-y: auto; white-space: pre-wrap; background-color: #f8f9fa;"></div>
        </div>
      </div>
    </div>

    <!-- 메시지 표시 영역 -->
    <div class="row mt-4 justify-content-center">
      <div class="col-md-12 text-center">
        <p id="message" class="text-danger"></p>
      </div>
    </div>
  </div>

  <!-- 하단 언더바 -->
  <footer class="mt-4" style="background-color: #e0e0e0; padding: 5px 0; position: fixed; bottom: 0; width: 100%;">
    <div class="text-center">
      <p class="mb-0"><캡스톤디자인></p>
    </div>
  </footer>

  <script>
  function processText() {
    var inputText = document.getElementById('textInput').value;
    var searchTerm = document.getElementById('searchTerm').value;
    var functionOption = document.getElementById('functionOption').value;
    var resultText = "";

    if (!searchTerm.trim()) {
      // 검색어가 비어 있을 경우
      document.getElementById('message').textContent = "검색어를 입력해주세요.";
      document.getElementById('message').className = "text-danger";
      return;
    }

    if (functionOption === "extractWords") {
      // 단어 추출 기능: 검색어가 포함된 단어만 추출
      var words = inputText.split(/[\s.,;!?。]/); // 단어 구분 (공백 및 구두점 기준)
      resultText = words
        .filter(function (word) {
          return word.includes(searchTerm);
        })
        .map(function (word) {
          // 찾은 검색어를 파란색으로 강조
          return word.replace(
            new RegExp(searchTerm, "g"),
            `<span style="color: blue;">${searchTerm}</span>`
          );
        })
        .join(" "); // 단어를 공백으로 구분
      document.getElementById('textResult').innerHTML = resultText; // 결과를 HTML로 설정
    } else if (functionOption === "highlightWord") {
      // 단어 강조 기능: 검색어를 파란색으로 표시
      resultText = inputText.replace(
        new RegExp(searchTerm, "g"),
        `<span style="color: blue;">${searchTerm}</span>`
      );
      document.getElementById('textResult').innerHTML = resultText; // 결과를 HTML로 설정
    } else if (functionOption === "extractSentences") {
      // 문장 추출 기능: 검색어가 포함된 문장을 필터링
      var sentences = inputText.split(/(?<=[.?!。])/); // 문장 구분 (구두점 기준)
      resultText = sentences
        .filter(function (sentence) {
          return sentence.includes(searchTerm);
        })
        .map(function (sentence) {
          // 검색어를 파란색으로 강조
          return sentence.replace(
            new RegExp(searchTerm, "g"),
            `<span style="color: blue;">${searchTerm}</span>`
          );
        })
        .join("<br>"); // 문장 구분을 줄바꿈으로 설정
      document.getElementById('textResult').innerHTML = resultText; // 결과를 HTML로 설정
    }

    // 메시지 표시
    var messageElement = document.getElementById('message');
    if (resultText.trim() === "") {
      messageElement.textContent = "검색어와 일치하는 데이터가 없습니다.";
      messageElement.className = "text-danger";
    } else {
      messageElement.textContent = "작업이 완료되었습니다.";
      messageElement.className = "text-success";
    }
  }
</script>


</body>
</html>
