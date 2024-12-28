<?php include('head.php'); ?>
<div class="menu-container" style="position: absolute; top: 0; left: 0; z-index: 1000; width: auto;">
    <?php include('menu.php'); ?>
</div>

<body class="d-flex justify-content-center align-items-center vh-100">
    <!-- 상단 로고 텍스트 (진한 글씨 및 파란색 밑줄) -->
    <div class="mb-4" style="position: absolute; top: 10px; right: 10px; font-size: 12px; color: #555;">
        <a href="index.php" style="text-decoration: none; color: inherit;">
            <span style="color: #007bff; text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px; font-weight: bold; font-size: 18px;">한문학</span>
            <span style="text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;">의 <span style="text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;">모든 것</span>
        </a>
    </div>

    <div class="container text-center">
        <div class="row">
            <div class="col">
                <h1 id="title">學而時習之不亦說乎</h1> <!-- 한자 제목 -->
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p id="quote">배우고 때때로 그것을 익히면 또한 기쁘지 아니한가</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <input type="text" id="input" class="form-control" placeholder="여기에 입력 시작" />
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <button class="btn btn-primary btn-sm" id="start-button">시작하다</button>
                <button class="btn btn-success btn-sm" id="check-button">확인</button> <!-- 확인 버튼 추가 -->
            </div>
        </div>
        <div class="row mt-3">
            <div class="col" id="result"></div>
        </div>
        <div class="row mt-2">
            <div class="col" id="wpm"></div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
