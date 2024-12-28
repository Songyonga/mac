<?php include('menu.php'); ?>
<?php
// 데이터베이스 연결 설정
$host = 'localhost';
$dbname = 'user_system';
$user = 'yong';
$pass = '1111';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// 게시글 조회
$postId = $_GET['id'] ?? null;

if ($postId) {
    $stmt = $pdo->prepare("SELECT * FROM hanzadata WHERE id = :id");
    $stmt->execute(['id' => $postId]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$post) {
        die("게시글을 찾을 수 없습니다.");
    }
} else {
    die("잘못된 요청입니다.");
}

// 게시글 수정 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $category = $_POST['category'] ?? '';

    if (!empty($title) && !empty($content) && !empty($category)) {
        try {
            $stmt = $pdo->prepare("UPDATE hanzadata SET title = :title, content = :content, category = :category WHERE id = :id");
            $stmt->execute([
                'title' => $title,
                'content' => $content,
                'category' => $category,
                'id' => $postId
            ]);

            // 수정 완료 메시지
            echo "<script>alert('게시글이 성공적으로 수정되었습니다.');</script>";

            // 수정된 내용 다시 조회
            $stmt = $pdo->prepare("SELECT * FROM hanzadata WHERE id = :id");
            $stmt->execute(['id' => $postId]);
            $post = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("수정 오류: " . $e->getMessage());
        }
    } else {
        echo "<script>alert('모든 필드를 입력해주세요.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- 상단 로고 텍스트 -->
        <div class="mb-4" style="position: absolute; top: 10px; right: 10px; font-size: 12px; color: #555;">
            <a href="index.php" style="text-decoration: none; color: inherit;">
                <span style="text-color: #007bff; text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;font-weight: bold; font-size: 18px;">한문학</span><span style="text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;">의 <span style="text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;">모든 것</span>
            </a>
         </div>
    <style>
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .content-box {
            max-height: 300px; /* 최대 높이 */
            overflow-y: auto; /* 세로 스크롤 */
            padding: 10px;
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="text-center">게시글 보기 및 수정</h2>

    <!-- 게시글 표시 -->
    <form method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">제목</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" maxlength="30" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">내용</label>
            <div class="content-box">
                <textarea class="form-control" id="content" name="content" rows="10" required><?php echo htmlspecialchars($post['content']); ?></textarea>
            </div>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">분류</label>
            <select id="category" name="category" class="form-select" required>
                <option value="1" <?php echo $post['category'] == '1' ? 'selected' : ''; ?>>한시</option>
                <option value="2" <?php echo $post['category'] == '2' ? 'selected' : ''; ?>>산문</option>
                <option value="3" <?php echo $post['category'] == '3' ? 'selected' : ''; ?>>기타</option>
            </select>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">수정</button>
            <a href="custom3.php" class="btn btn-secondary">뒤로가기</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
