<!-- custom3.php -->

<?php
session_start(); // 세션 시작

// 게시글 삭제 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_index'])) {
    // 삭제할 게시글 인덱스를 가져와 세션에서 해당 게시글을 삭제
    $delete_index = $_POST['delete_index'];
    if (isset($_SESSION['posts'][$delete_index])) {
        // 해당 인덱스의 게시글 삭제
        unset($_SESSION['posts'][$delete_index]);
        // 배열 재정렬 (인덱스 유지)
        $_SESSION['posts'] = array_values($_SESSION['posts']);
    }
}

// 게시글 추가 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title']) && isset($_POST['content']) && !isset($_POST['delete_index'])) {
    // 세션에 저장할 게시글 초기화 (세션에 저장된 값이 없으면 빈 배열로 초기화)
    if (!isset($_SESSION['posts'])) {
        $_SESSION['posts'] = [];
    }

    // 새로운 게시글을 세션에 추가
    $_SESSION['posts'][] = [
        'title' => $_POST['title'],
        'content' => $_POST['content']
    ];
}
?>

<?php include('head.php'); ?>

<body>
  <div class="container mt-5">
    <h2 class="text-center mb-4">내 기록함</h2>
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
          <th scope="col">#</th>
          <th scope="col">제목</th>
          <th scope="col">내용</th>
          <th scope="col">작업</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (isset($_SESSION['posts']) && count($_SESSION['posts']) > 0) {
            foreach ($_SESSION['posts'] as $index => $post) {
                echo "<tr>
                        <th scope='row'>".($index + 1)."</th>
                        <td>{$post['title']}</td>
                        <td>{$post['content']}</td>
                        <td>
                          <form method='POST' style='display:inline;'>
                            <input type='hidden' name='delete_index' value='{$index}'>
                            <button type='submit' class='btn btn-danger btn-sm'>삭제</button>
                          </form>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>저장된 기록이 없습니다.</td></tr>";
        }
        ?>
      </tbody>
    </table>

    <!-- 페이지네이션 (선택 사항) -->
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

    <!-- 내 기록함 추가 버튼 (파란색) -->
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">내 기록함 추가</button>

    <!-- 모달 (팝업창) -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form method="POST">
            <div class="modal-header">
              <h5 class="modal-title" id="myModalLabel">제목 입력</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>제목을 입력하세요.</p>
              <!-- 제목 입력칸 -->
              <input type="text" class="form-control mb-3" name="title" placeholder="제목을 입력하세요..." required>
              <!-- 내용 입력칸 -->
              <textarea class="form-control" name="content" placeholder="내용을 입력하세요..." rows="5" required></textarea>
            </div>
            <div class="modal-footer">
              <!-- 확인 버튼 -->
              <button type="submit" class="btn btn-primary">확인</button>
            </div>
          </form>
        </div>
      </div>
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
