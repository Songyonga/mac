<?php
session_start(); // 세션 시작

// 게시글 삭제 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_index'])) {
    $delete_index = $_POST['delete_index'];
    if (isset($_SESSION['posts'][$delete_index])) {
        unset($_SESSION['posts'][$delete_index]);
        $_SESSION['posts'] = array_values($_SESSION['posts']);
    }
  }

// 게시글 추가 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title']) && isset($_POST['content']) && isset($_POST['category']) && !isset($_POST['delete_index'])) {
    if (!isset($_SESSION['posts'])) {
        $_SESSION['posts'] = [];
    }

    // 새로운 게시글을 세션에 추가
    $_SESSION['posts'][] = [
        'title' => $_POST['title'],
        'content' => $_POST['content'],
        'category' => $_POST['category'] // 카테고리 추가
    ];
}

// 카테고리 이름 매칭 배열
$category_names = [
    '1' => '한시',
    '2' => '산문',
    '3' => '기타'
];

// 검색어와 카테고리 필터링 처리
$search_keyword = '';
$selected_category = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search_keyword = $_POST['search'] ?? '';
    $selected_category = $_POST['filter_category'] ?? '';
}
?>

<?php include('head.php'); ?>

<body>
  <div class="container mt-5">
    <h2 class="text-center mb-4">내 기록함</h2>

    <!-- 상단 로고 텍스트 -->
    <div class="mb-4" style="position: absolute; top: 10px; left: 10px; font-size: 12px; color: #555;">
      <a href="index.php" style="text-decoration: none; color: inherit;">
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
          <th scope="col">분류</th>
          <th scope="col">작업</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (isset($_SESSION['posts']) && count($_SESSION['posts']) > 0) {
            $filtered_posts = array_filter($_SESSION['posts'], function($post) use ($search_keyword, $selected_category) {
                $title_matches = stripos($post['title'], $search_keyword) !== false;
                $category_matches = $selected_category === '' || $post['category'] === $selected_category;
                return $title_matches && $category_matches;
            });

            if (count($filtered_posts) > 0) {
                foreach ($filtered_posts as $index => $post) {
                    $category_display = $category_names[$post['category']] ?? "기타";
                    echo "<tr>
                            <th scope='row'>".($index + 1)."</th>
                            <td>{$post['title']}</td>
                            <td class='content-cell'>{$post['content']}</td>
                            <td>{$category_display}</td>
                            <td>
                              <form method='POST' style='display:inline;'>
                                <input type='hidden' name='delete_index' value='{$index}'>
                                <button type='submit' class='btn btn-danger btn-sm'>삭제</button>
                              </form>
                              <button class='btn btn-success btn-sm' onclick='sharePost({$index})'>공유하기</button>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>검색어 또는 선택한 카테고리에 맞는 게시글이 없습니다.</td></tr>";
            }
        } else {
            echo "<tr><td colspan='5'>저장된 기록이 없습니다.</td></tr>";
        }
        ?>
      </tbody>
    </table>

    <script>
function sharePost(index) {
    const posts = <?php echo json_encode($_SESSION['posts'] ?? []); ?>;
    const post = posts[index];

    if (post) {
        if (confirm(`"${post.title}" 기록을 공유하시겠습니까?`)) {
            // 데이터를 POST 요청으로 board3.php에 전달
            fetch('board3.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(post),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('네트워크 응답이 올바르지 않습니다.');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert("공유가 성공적으로 완료되었습니다.");
                    window.location.href = 'board3.php';
                } else {
                    alert("공유에 실패했습니다. 다시 시도해주세요.");
                    window.location.href = 'errorPage.php';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('오류가 발생했습니다. 다시 시도해주세요.');
            });
        } else {
            alert("공유가 취소되었습니다.");
        }
    } else {
        alert("유효하지 않은 게시글입니다.");
    }
}
</script>





    <!-- 스타일 추가 -->
    <style>
      .content-cell {
        max-width: 150px; /* 셀의 최대 너비 설정 */
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
      }
    </style>

    <!-- 카테고리 선택 및 검색 기능 -->
    <form method="POST" class="d-flex align-items-center" style="width: auto;">
        <select id="options" name="filter_category" style="margin-right: 10px;">
          <option value="" <?php echo $selected_category === '' ? 'selected' : ''; ?>>분류 선택</option>
          <option value="1" <?php echo $selected_category === '1' ? 'selected' : ''; ?>>한시</option>
          <option value="2" <?php echo $selected_category === '2' ? 'selected' : ''; ?>>산문</option>
          <option value="3" <?php echo $selected_category === '3' ? 'selected' : ''; ?>>기타</option>
        </select>
        <input class="form-control me-2" type="search" name="search" placeholder="검색어를 입력하세요..." aria-label="Search" value="<?php echo htmlspecialchars($search_keyword); ?>" style="width: auto; padding: 5px 15px;">
        <button class="btn btn-outline-success" type="submit" style="height: auto; width: auto; padding: 5px 15px;">검색</button>
    </form>

    <!-- 내 기록함 추가 버튼 -->
    <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#myModal">내 기록함 추가</button>

    <!-- 모달 -->
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
              <input type="text" class="form-control mb-3" name="title" placeholder="제목을 입력하세요..." required>
              <textarea class="form-control" name="content" placeholder="내용을 입력하세요..." rows="5" required></textarea>
              <label for="category" class="form-label">카테고리 선택</label>
              <select id="category" name="category" class="form-control mb-3">
                <option value="">== 선택 ==</option>
                <option value="1">한시</option>
                <option value="2">산문</option>
                <option value="3">기타</option>
              </select>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">확인</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <footer class="mt-4" style="background-color: #e0e0e0; padding: 5px 0; position: fixed; bottom: 0; width: 100%;">
    <div class="text-center">
      <p class="mb-0"><캡스톤디자인></p>
    </div>
  </footer>

  <!-- JavaScript로 공유 기능 -->
  <script>
    function sharePost(index) {
        const post = <?php echo json_encode($_SESSION['posts']); ?>[index];
        const shareText = 제목: ${post.title}}