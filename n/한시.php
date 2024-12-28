<?php
session_start(); // 세션 시작

// 데이터베이스 연결
$host = 'localhost';
$dbname = 'user_system';
$user = 'yong'; // MySQL 사용자
$pass = '1111'; // MySQL 비밀번호

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// 게시글 추가 처리 (내 기록 추가 버튼 사용)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title']) && isset($_POST['content']) && isset($_POST['category'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];

    if (!empty($title) && !empty($content) && !empty($category)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO hanzadata (title, content, category) VALUES (:title, :content, :category)");
            $stmt->execute(['title' => $title, 'content' => $content, 'category' => $category]);
        } catch (PDOException $e) {
            die("데이터 저장 오류: " . $e->getMessage());
        }
    }
}

// 게시글 삭제 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_index'])) {
    $delete_index = $_POST['delete_index'];
    try {
        $stmt = $pdo->prepare("DELETE FROM hanzadata WHERE id = :id");
        $stmt->execute(['id' => $delete_index]);
    } catch (PDOException $e) {
        die("삭제 오류: " . $e->getMessage());
    }
}

// 게시글 검색 및 조회
$search_keyword = $_POST['search'] ?? '';
$selected_category = $_POST['filter_category'] ?? '';

$query = "SELECT * FROM hanzadata WHERE (title LIKE :search OR content LIKE :search)";
if (!empty($selected_category)) {
    $query .= " AND category = :category";
}
$query .= " ORDER BY created_at DESC";

$stmt = $pdo->prepare($query);
$params = [
    'search' => '%' . $search_keyword . '%',
];
if (!empty($selected_category)) {
    $params['category'] = $selected_category;
}
$stmt->execute($params);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 카테고리 이름 매핑
$category_names = [
    '1' => '한시',
    '2' => '산문',
    '3' => '기타',
];
?>

<?php include('head.php'); ?>
<?php include('menu.php'); ?>
<body>
<style>
    .content-cell {
        max-width: 300px; /* 셀의 최대 너비 */
        white-space: nowrap; /* 한 줄로 표시 */
        overflow: hidden; /* 넘친 내용 숨김 */
        text-overflow: ellipsis; /* "..."으로 표시 */
    }
</style>
<div class="container mt-5">
    <h2 class="text-center mb-4">내 기록함</h2>
    <!-- 상단 로고 텍스트 -->
    <div class="mb-4" style="position: absolute; top: 10px; right: 10px; font-size: 12px; color: #555;">
        <a href="index.php" style="text-decoration: none; color: inherit;">
            <span style="text-color: #007bff; text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;font-weight: bold; font-size: 18px;">한문학</span><span style="text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;">의 <span style="text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;">모든 것</span>
        </a>
    </div>
    <!-- 게시판 테이블 -->
    <table class="table table-hover">
        <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>제목</th>
            <th>내용</th>
            <th>분류</th>
            <th>작업</th>
        </tr>
        </thead>
        <tbody>
        <?php if (count($posts) > 0): ?>
            <?php foreach ($posts as $post): ?>
                <tr>
                    <td><?php echo htmlspecialchars($post['id']); ?></td>
                    <td>
                        <a href="view_post.php?id=<?php echo $post['id']; ?>" target="_blank">
                            <?php echo htmlspecialchars($post['title']); ?>
                        </a>
                    </td>
                    <td class="content-cell"><?php echo htmlspecialchars($post['content']); ?></td>
                    <td><?php echo htmlspecialchars($category_names[$post['category']] ?? $post['category']); ?></td>
                    <td>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="delete_index" value="<?php echo $post['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">삭제</button>
                        </form>
                        <button class="btn btn-success btn-sm" onclick="sharePost(<?php echo $post['id']; ?>)">공유하기</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center">저장된 게시글이 없습니다.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <!-- 기존 기능 유지 -->
    <script>
        function sharePost(postId) {
            if (confirm('이 게시글을 공유하시겠습니까?')) {
                fetch('board3.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id: postId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('공유가 성공적으로 완료되었습니다.');
                    } else {
                        alert('공유에 실패했습니다.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('오류가 발생했습니다.');
                });
            }
        }
    </script>

    <!-- 카테고리 선택 및 검색 기능 -->
    <form method="POST" class="d-flex align-items-center mb-3">
        <select name="filter_category" class="form-select me-2">
            <option value="" <?php echo $selected_category === '' ? 'selected' : ''; ?>>카테고리 선택</option>
            <option value="1" <?php echo $selected_category === '1' ? 'selected' : ''; ?>>한시</option>
            <option value="2" <?php echo $selected_category === '2' ? 'selected' : ''; ?>>산문</option>
            <option value="3" <?php echo $selected_category === '3' ? 'selected' : ''; ?>>기타</option>
        </select>
        <input type="text" name="search" class="form-control me-2" placeholder="검색어를 입력하세요" value="<?php echo htmlspecialchars($search_keyword); ?>">
        <button type="submit" class="btn btn-outline-success">검색</button>
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
                        <input type="text" class="form-control mb-3" name="title" placeholder="제목을 입력하세요" required>
                        <textarea class="form-control" name="content" placeholder="내용을 입력하세요" rows="5" required></textarea>
                        <label for="category" class="form-label">카테고리 선택</label>
                        <select name="category" class="form-control mb-3" required>
                            <option value="1">한시</option>
                            <option value="2">산문</option>
                            <option value="3">기타</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">저장</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


