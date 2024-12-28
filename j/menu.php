<div class="navbar-container">
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="menuDropdown" aria-expanded="false" onclick="toggleDropdown()">메뉴</button>
        
        <ul class="dropdown-menu" aria-labelledby="menuDropdown">
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

                    <li><a href="board3.php">책선당</a></li>
                </ul>
            </li>
            <!-- 사자성어 -->
            <li class="dropdown-item">
                <a href="javascript:void(0);" onclick="toggleMenu('idiomMenu')">한자게임</a>
                <ul id="idiomMenu" class="submenu">
                    <li><a href="game.php">한문타자연습</a></li>

                </ul>
            </li>
            <!-- 학교 홈페이지 -->
            <li class="dropdown-item">
                <a href="javascript:void(0);" onclick="toggleMenu('schoolMenu')">학교 홈페이지</a>
                <ul id="schoolMenu" class="submenu">
                    <li><a href="https://human.cnu.ac.kr/human/graduate/chinese.do" target="_blank">충남대학교 한문학과</a></li>
                    <li><a href="https://www.instagram.com/cnu_now/">충남대 인스타그램</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>

<!-- 스타일 추가 -->
<style>
    /* 링크 스타일 */
    .dropdown-menu a:link {
        font-size: 14px;
        text-decoration: none;
        color: #000000;
    }
    .dropdown-menu a:hover {
        font-size: 14px;
        text-decoration: none;
        color: #0000FF;
    }
    .dropdown-menu a:visited {
        font-size: 14px;
        text-decoration: none;
        color: #000000;
    }

    /* 추가적으로 다른 부분에도 동일한 스타일 적용 */
    .submenu a:link,
    .submenu a:hover,
    .submenu a:visited {
        font-size: 14px;
        text-decoration: none;
        color: #000000;
    }
</style>

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
