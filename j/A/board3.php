<?php
session_start();
include('head.php');

// 기존 게시글 데이터
$posts = [
    ['title' => '첫번째 글', 'author' => '홍길동', 'content' => '이것은 첫번째 게시글입니다.', 'category' => '한시', 'date' => '2024-10-20'],
    ['title' => '두번째 글', 'author' => '이몽룡', 'content' => '두번째 게시글입니다.', 'category' => '산문', 'date' => '2024-10-19'],
    ['title' => '세번째 글', 'author' => '성춘향', 'content' => '세번째 게시글입니다.', 'category' => '기타', 'date' => '2024-10-18']
];

// 카테고리 이름 매칭 배열
$category_names = [
    '1' => '한시',
    '2' => '산문',
    '3' => '기타'
];

// 세션에서 공유된 게시글 불러오기
if (!isset($_SESSION['shared_posts'])) {
    $_SESSION['shared_posts'] = [];
}

// 게시글 삭제 처리 (공유된 게시글만)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_shared'])) {
    $delete_index = (int)$_POST['delete_shared'];
    if (isset($_SESSION['shared_posts'][$delete_index])) {
        unset($_SESSION['shared_posts'][$delete_index]);
        $_SESSION['shared_posts'] = array_values($_SESSION['shared_posts']); // 인덱스 재정렬
    }
}

// 공유된 게시글 추가 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST['search']) && empty($_POST['delete_shared'])) {
    $input = json_decode(file_get_contents('php://input'), true);
    if (isset($input['title'], $input['content'], $input['category'])) {
        $_SESSION['shared_posts'][] = [
            'title' => htmlspecialchars($input['title']),
            'author' => '공유됨', // 공유된 게시글의 작성자
            'content' => htmlspecialchars($input['content']),
            'category' => htmlspecialchars($input['category']),
            'date' => date('Y-m-d'),
        ];
        echo json_encode(['success' => true]);
        exit;
    }
    echo json_encode(['success' => false]);
    exit;
}

// 검색어 처리
$search_keyword = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $search_keyword = trim($_POST['search']);
}

// 기존 데이터와 공유된 데이터 병합
$merged_posts = array_merge($posts, $_SESSION['shared_posts']);

// 검색 결과 필터링
$filtered_posts = array_filter($merged_posts, function ($post) use ($search_keyword) {
    return stripos($post['title'], $search_keyword) !== false;
});
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
    <div class="mb-4" style="position: absolute; top: 10px; left: 10px; font-size: 12px; color: #555;">
        <a href="index.php" style="text-decoration: none; color: inherit;">
            <span style="color: #007bff; text-decoration: underline; font-weight: bold; font-size: 18px;">한문학</span>
            <span style="text-decoration: underline;">의 모든 것</span>
        </a>
    </div>

    <!-- 검색 기능 -->
    <form method="POST" class="d-flex" style="width: auto;">

        <input class="form-control me-2" type="search" name="search" placeholder="검색어를 입력하세요..." aria-label="Search" value="<?php echo htmlspecialchars($search_keyword); ?>" style="width: auto; padding: 5px 15px;">
        <button class="btn btn-outline-success" type="submit" style="height: auto; width: auto; padding: 5px 15px;">검색</button>
    </form>

    <!-- 게시판 테이블 -->
    <table class="table table-hover mt-3">
        <thead class="table-dark">
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 20%;">제목</th>
                <th style="width: 10%;">작성자</th>
                <th style="width: 40%;">내용</th>
                <th style="width: 15%;">분류</th>
                <th style="width: 10%;">날짜</th>
                <th style="width: 10%;">작업</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // 검색된 게시글 표시
            if (count($filtered_posts) > 0) {
                foreach ($filtered_posts as $index => $post) {
                    // 카테고리 값 변환
                    $category_display = $category_names[$post['category']] ?? $post['category'];
                    
                    $is_shared = in_array($post, $_SESSION['shared_posts'], true); // 공유 게시글 확인
                    $delete_button = $is_shared ? 
                        "<form method='POST' style='display:inline;' onsubmit=\"return confirm('정말 삭제하시겠습니까?');\">
                            <input type='hidden' name='delete_shared' value='" . array_search($post, $_SESSION['shared_posts'], true) . "'>
                            <button type='submit' class='btn btn-danger btn-sm'>삭제</button>
                         </form>"
                        : '';

                    echo "<tr>
                            <td>" . ($index + 1) . "</td>
                            <td>{$post['title']}</td>
                            <td>{$post['author']}</td>
                            <td>{$post['content']}</td>
                            <td>{$category_display}</td>
                            <td>{$post['date']}</td>
                            <td>{$delete_button}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>검색된 결과가 없습니다.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<footer class="mt-4" style="background-color: #e0e0e0; padding: 5px 0; position: fixed; bottom: 0; width: 100%;">
    <div class="text-center">
        <p class="mb-0"><캡스톤디자인></p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
