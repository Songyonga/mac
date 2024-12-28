<?php
session_start();
include('head.php');

// 기본 게시글 데이터
$default_posts = [
  ['title' => '세번째 글', 'author' => '성춘향', 'content' => '세번째 게시글입니다.', 'date' => '2024-10-21'],
  ['title' => '네번째 글', 'author' => '변학도', 'content' => '네번째 게시글입니다.', 'date' => '2024-10-22'],
];

// 세션 초기화
if (!isset($_SESSION['board2_posts']) || !is_array($_SESSION['board2_posts'])) {
  $_SESSION['board2_posts'] = [];
}

// 삭제 요청 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_index'])) {
  $delete_index = (int)$_POST['delete_index'];
  if (isset($_SESSION['board2_posts'][$delete_index])) {
    unset($_SESSION['board2_posts'][$delete_index]);
    $_SESSION['board2_posts'] = array_values($_SESSION['board2_posts']); // 인덱스 재정렬
  }
}

// 모든 게시글 병합
$all_posts = array_merge($default_posts, $_SESSION['board2_posts']);

// 검색 처리
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($search_query !== '') {
    $all_posts = array_filter($all_posts, function($post) use ($search_query) {
        return stripos($post['title'], $search_query) !== false ||
               stripos($post['author'], $search_query) !== false ||
               stripos($post['content'], $search_query) !== false;
    });
}

// 페이지네이션 처리
$current_page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$posts_per_page = 5;
$total_posts = count($all_posts);
$total_pages = ceil($total_posts / $posts_per_page);
$start_index = ($current_page - 1) * $posts_per_page;
$display_posts = array_slice($all_posts, $start_index, $posts_per_page);

// Pagination 버튼 생성 함수
function create_pagination_links($total_pages, $current_page) {
    $links = '';
    for ($i = 1; $i <= $total_pages; $i++) {
        $active = $i === $current_page ? 'active' : '';
        $links .= "<li class='page-item {$active}'><a class='page-link' href='?page={$i}'>{$i}</a></li>";
    }
    return $links;
}
?>

<body>
  <div class="container mt-5">
    <h2 class="text-center mb-4">질문게시판</h2>

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
          <th style="width: 10%;">관리</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($display_posts as $index => $post) {
          $title = htmlspecialchars($post['title'] ?? '제목 없음');
          $author = htmlspecialchars($post['author'] ?? '익명');
          $content = htmlspecialchars($post['content'] ?? '내용 없음');
          $date = htmlspecialchars($post['date'] ?? '날짜 없음');

          // 삭제 버튼 (세션에 있는 게시글만 삭제 가능)
          $session_index = $index + ($current_page - 1) * $posts_per_page - count($default_posts);
          $delete_button = ($session_index >= 0 && isset($_SESSION['board2_posts'][$session_index])) ?
            "<form method='POST' style='display:inline;'>
              <input type='hidden' name='delete_index' value='{$session_index}'>
              <button type='submit' class='btn btn-danger btn-sm'>삭제</button>
            </form>"
            : '';

          echo "<tr>
                  <td>" . (($current_page - 1) * $posts_per_page + $index + 1) . "</td>
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
        <?= create_pagination_links($total_pages, $current_page); ?>
      </ul>
    </nav>

    <!-- 글쓰기 버튼과 검색 -->
    <div class="d-flex justify-content-between">
      <!-- 글쓰기 버튼 -->
      <a href="write2.php" class="btn btn-secondary" style="height: auto; width: auto; padding: 5px 15px;">글쓰기</a>

      <!-- 검색 기능 -->
      <form class="d-flex" method="GET" action="board2.php" style="width: auto;">
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
