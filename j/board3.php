<?php
session_start();
include('head.php');
include('menu.php');

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

// 공유된 게시글 삭제 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_shared'])) {
    $delete_index = (int)$_POST['delete_shared'];
    try {
        $stmt = $pdo->prepare("DELETE FROM hanzadata2 WHERE id = :id");
        $stmt->execute(['id' => $delete_index]);
    } catch (PDOException $e) {
        die("삭제 오류: " . $e->getMessage());
    }
}

// 공유된 게시글 추가 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['title']) && !empty($_POST['content']) && !empty($_POST['category'])) {
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);
    $category = htmlspecialchars($_POST['category']);
    $author = "직접 작성"; // 기본 작성자

    try {
        $stmt = $pdo->prepare("INSERT INTO hanzadata2 (title, author, content, category) VALUES (:title, :author, :content, :category)");
        $stmt->execute(['title' => $title, 'author' => $author, 'content' => $content, 'category' => $category]);
    } catch (PDOException $e) {
        die("저장 오류: " . $e->getMessage());
    }
}

// 검색어 처리
$search_keyword = $_POST['search'] ?? '';
$query = "SELECT * FROM hanzadata2 WHERE (title LIKE :search OR content LIKE :search) ORDER BY created_at DESC";
$stmt = $pdo->prepare($query);
$stmt->execute(['search' => '%' . $search_keyword . '%']);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 카테고리 이름 매칭 배열
$category_names = [
    '1' => '한시',
    '2' => '산문',
    '3' => '기타'
];
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">責善堂</h2>

            <!-- 상단 로고 텍스트 -->
            <div class="mb-4" style="position: absolute; top: 10px; right: 10px; font-size: 12px; color: #555;">
                <a href="index.php" style="text-decoration: none; color: inherit;">
                    <span style="text-color: #007bff; text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;font-weight: bold; font-size: 18px;">한문학</span><span style="text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;">의 <span style="text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;">모든 것</span>
                </a>
            </div>
    

    <!-- 검색 기능 -->
    <form method="POST" class="d-flex mb-3">
        <input class="form-control me-2" type="search" name="search" placeholder="검색어를 입력하세요..." aria-label="Search" value="<?php echo htmlspecialchars($search_keyword); ?>" style="width: auto; padding: 5px 15px;">
        <button class="btn btn-outline-success" type="submit">검색</button>
    </form>

    <!-- 게시판 테이블 -->
    <table class="table table-hover mt-3">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>제목</th>
                <th>작성자</th>
                <th>내용</th>
                <th>분류</th>
                <th>날짜</th>
                <th>작업</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($posts) > 0): ?>
                <?php foreach ($posts as $post): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($post['id']); ?></td>
                        <td><?php echo htmlspecialchars($post['title']); ?></td>
                        <td><?php echo htmlspecialchars($post['author']); ?></td>
                        <td><?php echo htmlspecialchars($post['content']); ?></td>
                        <td><?php echo htmlspecialchars($category_names[$post['category']] ?? $post['category']); ?></td>
                        <td><?php echo htmlspecialchars($post['created_at']); ?></td>
                        <td>
                            <form method="POST" style="display: inline;" onsubmit="return confirm('정말 삭제하시겠습니까?');">
                                <input type="hidden" name="delete_shared" value="<?php echo $post['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">삭제</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">검색된 게시글이 없습니다.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- 기록 추가 버튼 -->
    <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#addPostModal">기록 추가</button>

    <!-- 모달 -->
    <div class="modal fade" id="addPostModal" tabindex="-1" aria-labelledby="addPostModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPostModalLabel">새 기록 추가</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">제목</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="제목을 입력하세요" required>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">내용</label>
                            <textarea class="form-control" id="content" name="content" placeholder="내용을 입력하세요" rows="5" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">카테고리</label>
                            <select id="category" name="category" class="form-control">
                                <option value="1">한시</option>
                                <option value="2">산문</option>
                                <option value="3">기타</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">추가</button>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
