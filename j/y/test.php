<!-- index.php -->
<?php include('head.php'); ?>

<body>
  <!-- 상단 네비게이션 바 -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      
    
      <!-- 왼쪽 드롭박스 메뉴 -->
      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="menuDropdown" aria-expanded="false" onclick="toggleDropdown()">메뉴</button>
        <!-- 드롭다운 메뉴 (큰 메뉴와 소메뉴) -->
        <ul class="dropdown-menu" aria-labelledby="menuDropdown">
          <!-- 내정보 (맨 위에 작게 표시) -->
          <li class="user-info">
            <img src="https://via.placeholder.com/20" alt="사용자 아이콘">
            <a href="mypage.php" class="text-dark">내정보</a>
          </li>
          <hr>
          <!-- 고전DB (소메뉴는 기본적으로 숨겨짐) -->
          <li class="dropdown-item">
            <span onclick="toggleMenu('dbMenu')">고전DB</span>
            <ul id="dbMenu" class="submenu">
              <li><a href="https://db.itkc.or.kr" target="_blank">한국고전종합DB</a></li>
              <li><a href="http://db.cyberseodang.or.kr/front/main/main.do" target="_blank">동양고전DB</a></li>
              <li><a href="https://db.history.go.kr" target="_blank">한국사데이터베이스</a></li>
            </ul>
          </li>

          <!-- 나만의 커스텀DB -->
          <li class="dropdown-item">
            <span onclick="toggleMenu('customDBMenu')">나만의 커스텀DB</span>
            <ul id="customDBMenu" class="submenu">
              <li><a href="custom1.php">한자추출</a></li>
              <li><a href="custom2.php">한자번역추출</a></li>
              <li><a href="custom3.php">내 기록함</a></li>
            </ul>
          </li>

          <!-- 게시판 -->
          <li class="dropdown-item">
            <span onclick="toggleMenu('boardMenu')">게시판</span>
            <ul id="boardMenu" class="submenu">
              <li><a href="board1.php">자유게시판</a></li>
              <li><a href="board2.php">질문게시판</a></li>
            </ul>
          </li>
          
          <!-- 사자성어 대메뉴 추가 -->
          <li class="dropdown-item">
            <span onclick="toggleMenu('idiomMenu')">사자성어</span>
            <ul id="idiomMenu" class="submenu">
              <li><a href="study1.php">오늘의 사자성어</a></li>
              <li><a href="study2.php">사자성어 퀴즈</a></li>
              <li><a href="study3.php">내 점수</a></li>
            </ul>
          </li>

          <!-- 학교 홈페이지 -->
          <li class="dropdown-item">
            <span onclick="toggleMenu('schoolMenu')">학교 홈페이지</span>
            <ul id="schoolMenu" class="submenu">
              <li><a href="https://human.cnu.ac.kr/human/graduate/chinese.do" target="_blank">충남대학교 한문학과</a></li>
              <li><a href="school1.php">기타 한문학과</a></li>
            </ul>
          </li>
        </ul>
      </div>
      <!-- 로그인 버튼과 챗봇 버튼 오른쪽 상단에 고정 -->
      <div class="d-flex ms-auto align-items-center">
        <a href="login.php" class="btn btn-outline-primary me-2">로그인</a> <!-- 로그인 버튼 -->
        <a href="chatbot.php" class="btn btn-outline-primary">챗봇</a> <!-- 챗봇 버튼 -->
      </div>
    </div>
  </nav>

  <!-- 중앙 메인 영역 -->
  <div class="container mt-5 center-container">
    <h1>한문학의 모든 것</h1>

    <!-- 검색창 -->
    <form class="d-flex justify-content-center mt-3 search-form" method="GET" action="#">
      <input class="form-control me-2" type="search" placeholder="검색어를 입력하세요..." aria-label="Search">
      <button class="btn btn-outline-success" type="submit">
        <i class="fas fa-search"></i> <!-- 돋보기 아이콘 -->
      </button>
    </form>

    <div class="row justify-content-between mt-5">
    <!-- 인기 게시글 (왼쪽) -->
    <div class="col-md-6">
      <!-- 타이틀과 + 버튼을 나란히 배치 -->
      <div class="d-flex justify-content-between align-items-center">
        <h4>인기 게시글</h4>
        <a href="board1.php" class="btn btn-outline-primary btn-sm">+</a> <!-- 게시판 이동 버튼 -->
      </div>
      <div class="p-3 border bg-light">
        <ul>
          <li>학이시습지 불역열호</li>
          <li>하필왈리 역유인의이의</li>
          <li>등등등</li>
          <li>게시글 4</li>
          <li>게시글 5</li>
        </ul>
      </div>
    </div>

    <!-- 오늘의 사자성어 (오른쪽) -->
    <div class="col-md-6">
      <!-- 타이틀과 + 버튼을 나란히 배치 -->
      <div class="d-flex justify-content-between align-items-center">
        <h4>오늘의 사자성어</h4>
        <a href="study1.php" class="btn btn-outline-primary btn-sm">+</a> <!-- 더 보기 버튼 -->
      </div>
      <div class="p-3 border bg-light">
        <p class="fs-1">學而時習</p>
        <p>배우고 때로 익힌다는 뜻으로 배운 것을 복습하고 연습하면 그 참 뜻을 알게 됨</p>
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
    // 드롭다운 열고 닫기
    function toggleDropdown() {
      var dropdownMenu = document.querySelector('.dropdown-menu');
      if (dropdownMenu.style.display === 'block') {
        dropdownMenu.style.display = 'none';
      } else {
        dropdownMenu.style.display = 'block';
      }
    }

    // 하위 메뉴 열고 닫기
    function toggleMenu(menuId) {
      var menu = document.getElementById(menuId);
      menu.classList.toggle('show');
    }
  </script>
</body>
</html>
