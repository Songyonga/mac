document.addEventListener("DOMContentLoaded", () => {
    // 문구 배열 (한자와 번역 연결)
    const idioms = [
        { title: "學而時習之不亦說乎", meaning: "배우고 때때로 그것을 익히면 또한 기쁘지 아니한가" },
        { title: "不患人之不己知, 患不知人也", meaning: "다른 사람이 자기를 알아주지 않음을 걱정하지 말고 자기가 다른 사람을 알지 못함을 걱정하라" },
        { title: "三人行 必有我師焉 擇其善者而從之 其不善者而改之", meaning: "세 사람이 길을 가면 반드시 나의 스승이 있으니 선한 것을 골라 따르고 선하지 못한 것은 가려서 고친다" }
    ];

    // HTML 요소 참조
    const titleElement = document.getElementById("title"); // 제목(한자) 요소
    const contentElement = document.getElementById("quote"); // 내용(한글) 요소
    const input = document.getElementById("input"); // 입력 필드
    const startButton = document.getElementById("start-button"); // 시작 버튼
    const checkButton = document.getElementById("check-button"); // 확인 버튼
    const result = document.getElementById("result"); // 결과 메시지
    const wpmDisplay = document.getElementById("wpm"); // 타수 표시
    let startTime, endTime; // 타이핑 시작 및 종료 시간

    // 현재 문구 저장
    let currentIdiom = null;

    // 랜덤 문구 선택 함수
    const getRandomIdiom = () => idioms[Math.floor(Math.random() * idioms.length)];

    // 시작 버튼 클릭 이벤트
    startButton.addEventListener("click", () => {
        // 랜덤 문구 선택
        currentIdiom = getRandomIdiom();

        // 제목(한자)와 내용(한글) 업데이트
        titleElement.textContent = currentIdiom.title; // 한자 제목
        contentElement.textContent = currentIdiom.meaning; // 한글 번역

        // 입력 필드 초기화
        input.disabled = false;
        input.value = "";
        input.focus();
        result.textContent = "";
        wpmDisplay.textContent = "";

        // 타이핑 시작 시간 기록
        startTime = new Date();
    });

    // 확인 버튼 클릭 이벤트
    checkButton.addEventListener("click", () => {
        const userInput = input.value.trim(); // 입력한 내용
        const fullText = contentElement.textContent.trim(); // 한글 번역 내용

        if (userInput === fullText) {
            // 타이핑 종료 시간 기록
            endTime = new Date();
            const timeTaken = (endTime - startTime) / 1000; // 초 단위 시간 계산
            const wpm = (fullText.length / 5) * (60 / timeTaken); // WPM 계산

            // 정답 메시지와 타수 표시
            result.textContent = "정답입니다! 다음 문구로 넘어갑니다.";
            wpmDisplay.textContent = `타수: ${wpm.toFixed(2)} WPM`;

            // 다음 문구로 이동
            currentIdiom = getRandomIdiom(); // 새 문구 선택
            titleElement.textContent = currentIdiom.title; // 새 제목
            contentElement.textContent = currentIdiom.meaning; // 새 내용

            // 입력 필드 초기화
            input.value = "";
            input.focus();

            // 새로운 타이핑 시작 시간 기록
            startTime = new Date();
        } else {
            // 틀린 경우 메시지 출력
            result.textContent = "틀렸습니다. 올바르게 입력하세요.";
        }
    });
});
