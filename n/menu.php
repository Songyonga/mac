<div class="navbar-container">
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="menuDropdown" aria-expanded="false" onclick="toggleDropdown()">메뉴</button>
        
        <ul class="dropdown-menu" aria-labelledby="menuDropdown">
            <!-- 커스텀DB -->
            <li class="dropdown-item">
                <a href="javascript:void(0);" onclick="toggleMenu('customDBMenu')">나만의 커스텀DB</a>
                <ul id="customDBMenu" class="submenu">
                    <li><a href="custom1.php">커스텀DB추출</a></li>
                    <li><a href="level.php">한자급수검증</a></li>
                    <li><a href="ngram.php">Ngram 분석기</a></li>
                    <li><a href="n2.php">Ngram 분석기-1</a></li>
                    <li><a href="n3.php">Ngram 분석기-2</a></li>
                    <li><a href="n4.php">Ngram 분석기-3</a></li>
                    <li><a href="n5.php">Ngram 분석기-4</a></li>
                    <li><a href="ngram2.php">Ngram 분석기 모두</a></li>
                    <li><a href="custom3.php">내 기록함</a></li>
                    <li><a href="index.php?cmd=analysis">분석</a></li>
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
