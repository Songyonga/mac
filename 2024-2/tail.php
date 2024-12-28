
</div>

<div class="container-fluid footer">
    <div class="row">
        <div class="col">
            충남대학교 한문학과
        </div>
    </div>
</div>
</body>
</html>

<script>
    function adjustFooterPosition() {
        const footer = document.querySelector('.footer');
        const contentHeight = document.body.scrollHeight; // 콘텐츠 높이
        const windowHeight = window.innerHeight; // 창 높이

        // 콘텐츠 높이가 창 높이보다 작으면, footer를 아래에 고정
        if (contentHeight < windowHeight) {
            footer.style.position = 'absolute';
            footer.style.bottom = '0';
            footer.style.width = '100%';
        } else {
            footer.style.position = 'static'; // 콘텐츠가 충분히 클 때는 고정 해제
        }
    }

    // 페이지가 로드되었을 때와 창 크기가 변경될 때마다 실행
    window.onload = adjustFooterPosition;
    window.onresize = adjustFooterPosition;
</script>