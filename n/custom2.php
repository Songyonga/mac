<!DOCTYPE html>
<html lang="ko">
<head>
  <title>정규식 검사 및 맵핑</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <style>
        /* 기본 스타일 */
        .container {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            padding: 20px;
        }
        .container > div {
            flex: 1;
            margin: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
            background-color: #f8f9fa;
        }
        #textResult, #mappedResult {
            height: 200px;
            overflow-y: auto;
            white-space: pre-wrap;
            background-color: #fff;
        }
        textarea {
            width: 100%;
            height: 150px;
            resize: none;
        }
    </style>

    <div class="container">
        <!-- 작성칸 -->
        <div id="container1">
            <h3 class="text-center">작성칸</h3>
            <textarea id="textInput" placeholder="여기에 텍스트를 작성하세요"></textarea>
            <button class="btn btn-primary w-100 mt-2" onclick="processText()">검사 및 맵핑</button>
        </div>

        <!-- 정규식 범위를 벗어난 한자 -->
        <div id="container2">
            <h3 class="text-center">정규식 범위를 벗어난 한자</h3>
            <div id="textResult" class="p-2 border"></div>
        </div>

        <!-- 맵핑된 결과 -->
        <div id="container3">
            <h3 class="text-center">맵핑된 결과</h3>
            <div id="mappedResult" class="p-2 border"></div>
        </div>
    </div>

    <script>
    function processText() {
        const inputText = document.getElementById("textInput").value.trim();

        // 기본 정규식 [一-龥]
        const regexHanjaRange = /[一-龥]/;

        // 확장 한자 범위 정의
        const extendedHanjaRanges = /[\u3400-\u4DBF\u4E00-\u9FFF\uF900-\uFAFF\u20000-\u2A6DF\u2A700-\u2B73F\u2B740-\u2B81F\u2B820-\u2CEAF\u2CEB0-\u2EBEF\u30000-\u3134F\u2F800-\u2FA1F]/;

         // 맵핑 데이터
         const hanziMapping = {
            "樂": "樂", // 예시 맵핑 추가
            "復": "復",
            "參": "參",
            "豈": "豈",
            "魯": "魯",
            "見": "見",
            "龜": "龜",
            "更": "更"
        };

        let extendedChars = []; // 확장 한자 범위에 해당하는 글자 저장
        let mappedText = ""; // 최종 결과 텍스트 (맵핑 포함)

        // 1. 정규식 범위를 벗어난 한자 찾기
        inputText.split("").forEach((char) => {
            if (!regexHanjaRange.test(char) && extendedHanjaRanges.test(char)) {
                extendedChars.push(char); // 확장 한자 범위에 해당하는 글자 저장
            }
        });

        // 2. 맵핑 결과 생성
        mappedText = inputText.split("").map((char) => {
            return hanziMapping[char] || char; // 맵핑된 경우 교체, 그렇지 않으면 원문 유지
        }).join("");

        // 3. 정규식 범위를 벗어난 한자 출력 (컨테이너2)
        const resultDiv = document.getElementById("textResult");
        if (extendedChars.length > 0) {
            resultDiv.textContent = "정규식 범위를 벗어난 한자: " + [...new Set(extendedChars)].join(", ");
        } else {
            resultDiv.textContent = "정규식 범위를 벗어난 한자가 없습니다.";
        }

        // 4. 맵핑된 결과 출력 (컨테이너3)
        document.getElementById("mappedResult").textContent = mappedText;

        console.log("입력 텍스트:", inputText);
        console.log("맵핑 결과 텍스트:", mappedText);
        console.log("정규식 범위를 벗어난 한자:", extendedChars);
    }
    </script>
</body>
</html>
