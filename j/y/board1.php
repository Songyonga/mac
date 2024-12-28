<!-- board1.php -->

<?php include('head.php'); ?>

<body>
  <div class="container mt-5">
    <h2 class="text-center mb-4">자유게시판</h2>
      <!-- 상단 로고 텍스트 (진한 글씨 및 파란색 밑줄) -->
      <div class="mb-4" style="position: absolute; top: 10px; left: 10px; font-size: 12px; color: #555;">
     <a href="test.php" style="text-decoration: none; color: inherit;">
      <span style="text-color: #007bff; text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;font-weight: bold; font-size: 18px;">한문학</span><span style="text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;">의 <span style="text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;">모든 것</span>
        </a>
    </div>  
    <!-- 게시판 테이블 -->
    <table class="table table-hover">
      <thead class="table-dark">
        <tr>
            <th style="width: 5%;">#</th> <!-- 번호 열 추가 -->
            <th style="width: 20%;">제목</th>
            <th style="width: 10%;">작성자</th>
            <th style="width: 40%;">내용</th>
            <th style="width: 25%;">날짜</th>
        </tr>
      </thead>
      <tbody>
        <?php
        session_start();
        // 예시 게시글 데이터
        $posts = [
            ['title' => '첫번째 글', 'author' => '홍길동', 'content' => '이것은 첫번째 게시글입니다.', 'date' => '2024-10-20'],
            ['title' => '두번째 글', 'author' => '이몽룡', 'content' => '두번째 게시글입니다.', 'date' => '2024-10-19'],
        ];

        foreach ($posts as $index => $post) {
            echo "<tr>
                    <td>".($index + 1)."</td> <!-- 넘버링 -->
                    <td>{$post['title']}</td>
                    <td>{$post['author']}</td>
                    <td>{$post['content']}</td>
                    <td>{$post['date']}</td>
                  </tr>";
        }
        ?>
      </tbody>
    </table>

    <!-- 글쓰기 버튼 -->
    <div class="d-flex justify-content-between">
        <!-- 글쓰기 버튼 -->
        <a href="write.php" class="btn btn-secondary" style="height: auto; width: auto; padding: 5px 15px;">글쓰기</a>

        <!-- 검색 기능 -->
        <form class="d-flex" style="width: auto;">
            <input class="form-control me-2" type="search" placeholder="검색어를 입력하세요..." aria-label="Search" style="width: auto; padding: 5px 15px;">
            <button class="btn btn-outline-success" type="submit" style="height: auto; width: auto; padding: 5px 15px;">검색</button>
        </form>

    </div>
  </div>

  <!-- 하단 언더바 -->
  <footer class="mt-4" style="background-color: #e0e0e0; padding: 5px 0; position: fixed; bottom: 0; width: 100%;">
    <div class="text-center">
      <p class="mb-0"><캡스톤디자인></p>
    </div>
  </footer>

  <!-- Bootstrap JS (테이블 및 페이지네이션 관련 기능 포함) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
