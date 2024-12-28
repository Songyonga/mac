<?php
session_start();

// 게시글 데이터 저장 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $content = trim($_POST['content']);

    // 기본 유효성 검사
    if (empty($title) || empty($author) || empty($content)) {
        $error_message = "모든 필드를 입력해주세요.";
    } else {
        // 세션에 게시글 데이터 저장
        if (!isset($_SESSION['posts'])) {
            $_SESSION['posts'] = [];
        }
        $_SESSION['posts'][] = [
            'title' => htmlspecialchars($title),
            'author' => htmlspecialchars($author),
            'content' => htmlspecialchars($content),
            'date' => date('Y-m-d'),
        ];

        // 작성 완료 후 게시판으로 리다이렉트
        header('Location: board1.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>글쓰기</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">게시글 작성</h2>

    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="write.php">
        <div class="mb-3">
            <label for="title" class="form-label">제목</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="제목을 입력하세요">
        </div>
        <div class="mb-3">
            <label for="author" class="form-label">작성자</label>
            <input type="text" class="form-control" id="author" name="author" placeholder="작성자를 입력하세요">
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">내용</label>
            <textarea class="form-control" id="content" name="content" rows="5" placeholder="내용을 입력하세요"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">작성하기</button>
        <a href="board1.php" class="btn btn-secondary">취소</a>
    </form>
</div>

<footer class="mt-4" style="background-color: #e0e0e0; padding: 5px 0; position: fixed; bottom: 0; width: 100%;">
    <div class="text-center">
        <p class="mb-0"><캡스톤디자인></p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
