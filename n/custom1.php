<?php include('head.php'); ?>
<?php include('menu.php'); ?>
<body>
    <style>
      #excludeInput {
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f8f9fa;
      }
    </style>
  <div class="container mt-5">
        <!-- 상단 로고 텍스트 -->
        <div class="mb-4" style="position: absolute; top: 10px; right: 10px; font-size: 12px; color: #555;">
      <a href="index.php" style="text-decoration: none; color: inherit;">
        <span style="text-color: #007bff; text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;font-weight: bold; font-size: 18px;">한문학</span><span style="text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;">의 <span style="text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;">모든 것</span>
      </a>
    </div>
    </div>

    <div class="row mt-5 justify-content-center">
      <!-- 왼쪽 컨테이너 -->
      <div class="col-md-6">
        <div class="p-4 border bg-light">
          <h3 class="text-center">텍스트 입력 및 기능 선택</h3>
          <!-- 글 입력 영역 -->
          <textarea id="textInput" class="form-control mb-3" rows="15" placeholder="여기에 글을 입력하세요..."></textarea>
          <!-- 검색어 입력 -->
          <input type="text" id="searchTerm" class="form-control mb-3" placeholder="찾고 싶은 글자 입력 (선택 사항)" />
          
          <!-- 드롭다운 메뉴 -->
          <select id="functionOption" class="form-select mb-3">
            <option value="hanja">한자 추출</option>
            <option value="hangul">한글 추출</option>
            <option value="number">숫자 추출</option>
            <option value="extractWords">단어 추출</option>
            <option value="highlightWord">단어 강조</option>
            <option value="extractSentences">문장 추출</option>
            <option value="excludeInput">제외할 한자</option>
            <option value="uniqueChars">고유글자로 변환</option>
            <option value="wordsplit">글자별 분리</option>
          
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
          <!-- 한자 글자 수 표시 -->
          <p id="hanziCount" class="text-center text-muted"></p>
          <!-- 기록함 추가 버튼 -->
          <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#myModal" onclick="addContentToRecord()">내 기록함 추가</button>

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

  <!-- 모달 -->
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
            <input type="text" id="recordTitle" name="title" class="form-control mb-3" placeholder="제목을 입력하세요..." required>
            <textarea id="recordContent" name="content" class="form-control mb-3" placeholder="내용을 입력하세요..." rows="5" required></textarea>
            <input type="hidden" name="category" value="3"> <!-- 카테고리를 기본값으로 설정 -->
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">확인</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <script>
 // --------------------------- 텍스트 처리 함수 ---------------------------
 function processText() {
  var inputText = document.getElementById('textInput').value;
  var searchTerm = document.getElementById('searchTerm').value;
  var functionOption = document.getElementById('functionOption').value;
  var resultText = "";

  // 입력 값이 없는 경우 경고 메시지 출력
  if (!inputText.trim()) {
    document.getElementById('message').textContent = "텍스트를 입력해주세요.";
    document.getElementById('message').className = "text-danger";
    return;
  }

  // --------------------------- 한자 추출 ---------------------------
  if (functionOption === "hanja") {
    resultText = inputText
      .replace(/[^一-龥\uF900-\uFAFF]/g, " ") // 한자만 추출
      .replace(/ +/g, " ") // 연속된 공백 제거
      .trim();

    if (searchTerm.trim()) {
      var excludeHanzi = searchTerm.split(""); // 검색어 입력 칸에서 한자 하나씩 분리
      excludeHanzi.forEach(function (hanzi) {
        resultText = resultText.replace(new RegExp(hanzi, "g"), ""); // 한자 제거
      });
    }
  }

  // --------------------------- 한글 추출 ---------------------------
  else if (functionOption === "hangul") {
    resultText = inputText.replace(/[^가-힣]/g, "");
  }

  // --------------------------- 숫자 추출 ---------------------------
  else if (functionOption === "number") {
    resultText = inputText.replace(/[^0-9]/g, "");
  }

  // --------------------------- 단어 추출 ---------------------------
  else if (functionOption === "extractWords") {
    var words = inputText.split(/[\s.,;!?。]/);
    resultText = words
      .filter(function (word) {
        return word.includes(searchTerm);
      })
      .map(function (word) {
        return word.replace(
          new RegExp(searchTerm, "g"),
          `<span style="color: blue;">${searchTerm}</span>`
        );
      })
      .join(" ");
    document.getElementById('textResult').innerHTML = resultText;
    return;
  }

  // --------------------------- 단어 강조 ---------------------------
  else if (functionOption === "highlightWord") {
    resultText = inputText.replace(
      new RegExp(searchTerm, "g"),
      `<span style="color: blue;">${searchTerm}</span>`
    );
  }

  // --------------------------- 문장 추출 ---------------------------
  else if (functionOption === "extractSentences") {
    var sentences = inputText.split(/(?<=[.?!。])/);
    resultText = sentences
      .filter(function (sentence) {
        return sentence.includes(searchTerm);
      })
      .map(function (sentence) {
        return sentence.replace(
          new RegExp(searchTerm, "g"),
          `<span style="color: blue;">${searchTerm}</span>`
        );
      })
      .join("<br>");
  }

  // --------------------------- 글자별 분리 ---------------------------
    else if (functionOption === "wordsplit") {
    // 한자, 한글, 숫자만 남기고 나머지 제거 후, 글자를 쉼표로 분리
    resultText = inputText
      .replace(/[^一-龥\uF900-\uFAFF가-힣0-9]/g, "") // 한자, 한글, 숫자만 추출
      .split("") // 글자 하나씩 나누기
      .join(","); // 쉼표로 연결
  }


  // --------------------------- 제외할 한자 제거 ---------------------------
  else if (functionOption === "excludeInput") {
    if (searchTerm.trim()) {
      resultText = inputText.replace(new RegExp(`[${searchTerm}]`, "g"), ""); // 입력된 한자 제거
    } else {
      document.getElementById('message').textContent = "제외할 한자를 입력해주세요.";
      document.getElementById('message').className = "text-danger";
      return;
    }
  }

  // --------------------------- 고유 글자로 변환 ---------------------------
  else if (functionOption === "uniqueChars") {
    resultText = Array.from(new Set(inputText.split(""))).join("");
  }

  // 결과 출력
  document.getElementById('textResult').innerHTML = resultText;

  // --------------------------- 한자 글자 수 계산 ---------------------------
  var hanziOnly = resultText.replace(/[^一-龥\uF900-\uFAFF]/g, ""); // 한자만 추출
  var hanziCount = hanziOnly.length;

  document.getElementById('hanziCount').textContent = `한자 글자 수: ${hanziCount}자`;

  var messageElement = document.getElementById('message');
  if (resultText.trim() === "") {
    messageElement.textContent = "결과가 없습니다.";
    messageElement.className = "text-danger";
  } else {
    messageElement.textContent = "작업이 완료되었습니다.";
    messageElement.className = "text-success";
  }
}

 // --------------------------- 기록함 추가 ---------------------------
  function addContentToRecord() {
    // 결과 영역의 내용을 가져오기
    var resultContent = document.getElementById('textResult').textContent; // 텍스트 내용 가져오기
    var recordContentField = document.getElementById('recordContent'); // 모달 입력 영역

    // 결과값이 비어있지 않은 경우 모달 입력 영역에 설정
    if (resultContent.trim()) {
      recordContentField.value = resultContent;
    } else {
      alert("결과값이 없습니다. 먼저 텍스트를 처리해주세요.");
    }
  }


</script>


  
</body>
</html>
