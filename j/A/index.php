<!DOCTYPE html>
<html lang="ko">
<head>
    <title>문화콘텐츠 실습</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="homestyle.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <!-- 상단 네비게이션 바 -->
    <div class="navbar-container">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="menuDropdown" aria-expanded="false" onclick="toggleDropdown()">메뉴</button>
            <ul class="dropdown-menu" aria-labelledby="menuDropdown">
                <!-- 내 정보 -->
                <li><a href="mypage.php" class="dropdown-item">내 정보</a></li>
                <hr>
                <!-- 고전DB -->
                <li class="dropdown-item">
                    <a href="javascript:void(0);" onclick="toggleMenu('dbMenu')">고전DB</a>
                    <ul id="dbMenu" class="submenu">
                        <li><a href="https://db.itkc.or.kr" target="_blank">한국고전종합DB</a></li>
                        <li><a href="http://db.cyberseodang.or.kr/front/main/main.do" target="_blank">동양고전DB</a></li>
                        <li><a href="https://db.history.go.kr" target="_blank">한국사데이터베이스</a></li>
                    </ul>
                </li>
                <!-- 커스텀DB -->
                <li class="dropdown-item">
                    <a href="javascript:void(0);" onclick="toggleMenu('customDBMenu')">나만의 커스텀DB</a>
                    <ul id="customDBMenu" class="submenu">
                        <li><a href="custom1.php">커스텀DB추출</a></li>
                        <li><a href="custom3.php">내 기록함</a></li>
                    </ul>
                </li>
                <!-- 게시판 -->
                <li class="dropdown-item">
                    <a href="javascript:void(0);" onclick="toggleMenu('boardMenu')">게시판</a>
                    <ul id="boardMenu" class="submenu">
                        <li><a href="board1.php">자유게시판</a></li>
                        <li><a href="board2.php">질문게시판</a></li>
                        <li><a href="board3.php">책선당</a></li>
                    </ul>
                </li>
                <!-- 사자성어 -->
                <li class="dropdown-item">
                    <a href="javascript:void(0);" onclick="toggleMenu('idiomMenu')">사자성어</a>
                    <ul id="idiomMenu" class="submenu">
                        <li><a href="study1.php">오늘의 사자성어</a></li>
                        <li><a href="study2.php">사자성어 퀴즈</a></li>
                        <li><a href="study3.php">내 점수</a></li>
                    </ul>
                </li>
                <!-- 학교 홈페이지 -->
                <li class="dropdown-item">
                    <a href="javascript:void(0);" onclick="toggleMenu('schoolMenu')">학교 홈페이지</a>
                    <ul id="schoolMenu" class="submenu">
                        <li><a href="https://human.cnu.ac.kr/human/graduate/chinese.do" target="_blank">충남대학교 한문학과</a></li>
                        <li><a href="school1.php">기타 한문학과</a></li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="auth-buttons">
            <a href="login.php" class="btn btn-outline-primary">로그인</a>
        </div>
    </div>

    <!-- 홈페이지 로고 -->
    <div class="logo-container">
        <img src="homelogo.jpeg" alt="홈페이지 로고">
    </div>

    <script>
        function toggleDropdown() {
            const dropdownMenu = document.querySelector('.dropdown-menu');
            dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
        }

        function toggleMenu(menuId) {
            const menu = document.getElementById(menuId);
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        }
    </script>
</body>
</html>
