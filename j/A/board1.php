<?php
session_start();
include('head.php');

// 기본 게시글 데이터
$default_posts = [
  ['title' => '첫번째 글', 'author' => '홍길동', 'content' => '이것은 첫번째 게시글입니다.', 'date' => '2024-10-20'],
  ['title' => '두번째 글', 'author' => '이몽룡', 'content' => '두번째 게시글입니다.', 'date' => '2024-10-19'],
];

// 세션 초기화
if (!isset($_SESSION['posts']) || !is_array($_SESSION['posts'])) {
  $_SESSION['posts'] = [];
}

// 삭제 요청 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_index'])) {
  $delete_index = (int)$_POST['delete_index'];
  if (isset($_SESSION['posts'][$delete_index])) {
    unset($_SESSION['posts'][$delete_index]);
    $_SESSION['posts'] = array_values($_SESSION['posts']); // 인덱스 재정렬
  }
}

// 모든 게시글 병합
$all_posts = array_merge($default_posts, $_SESSION['posts']);
?>

<body>
  <div class="container mt-5">
    <h2 class="text-center mb-4">자유게시판</h2>

    <!-- 상단 로고 텍스트 -->
    <div class="mb-4" style="position: absolute; top: 10px; left: 10px; font-size: 12px; color: #555;">
      <a href="index.php" style="text-decoration: none; color: inherit;">
        <span style="color: #007bff; text-decoration: underline; font-weight: bold; font-size: 18px;">한문학</span>
        <span style="text-decoration: underline;">의 모든 것</span>
      </a>
    </div>  

    <!-- 게시판 테이블 -->
    <table class="table table-hover">
      <thead class="table-dark">
        <tr>
          <th style="width: 5%;">#</th>
          <th style="width: 20%;">제목</th>
          <th style="width: 10%;">작성자</th>
          <th style="width: 40%;">내용</th>
          <th style="width: 15%;">날짜</th>
          <th style="width: 10%;">관리</th> <!-- 삭제 버튼 열 추가 -->
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($all_posts as $index => $post) {
          // 기본값 설정 및 출력
          $title = htmlspecialchars($post['title'] ?? '제목 없음');
          $author = htmlspecialchars($post['author'] ?? '익명');
          $content = htmlspecialchars($post['content'] ?? '내용 없음');
          $date = htmlspecialchars($post['date'] ?? '날짜 없음');

          // 삭제 버튼 (세션에 있는 게시글만 삭제 가능)
          $delete_button = isset($_SESSION['posts'][$index - count($default_posts)]) ?
            "<form method='POST' style='display:inline;'>
              <input type='hidden' name='delete_index' value='" . ($index - count($default_posts)) . "'>
              <button type='submit' class='btn btn-danger btn-sm'>삭제</button>
            </form>"
            : '';

          echo "<tr>
                  <td>" . ($index + 1) . "</td>
                  <td>{$title}</td>
                  <td>{$author}</td>
                  <td>{$content}</td>
                  <td>{$date}</td>
                  <td>{$delete_button}</td>
                </tr>";
        }
        ?>
      </tbody>
    </table>

    <!-- 페이지네이션 -->
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center">
        <li class="page-item disabled">
          <a class="page-link" href="#" tabindex="-1">이전</a>
        </li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
          <a class="page-link" href="#">다음</a>
        </li>
      </ul>
    </nav>

    <!-- 글쓰기 버튼과 검색 -->
    <div class="d-flex justify-content-between">
      <!-- 글쓰기 버튼 -->
      <a href="write.php" class="btn btn-secondary" style="height: auto; width: auto; padding: 5px 15px;">글쓰기</a>

      <!-- 검색 기능 -->
      <form class="d-flex" method="GET" action="board1.php" style="width: auto;">
        <input class="form-control me-2" type="search" name="search" placeholder="검색어를 입력하세요..." aria-label="Search" style="width: auto; padding: 5px 15px;">
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

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
