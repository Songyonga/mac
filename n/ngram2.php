<?php
ini_set('memory_limit', '-1'); // 메모리 제한 해제
ini_set('max_execution_time', '0'); // 최대 실행 시간 제한 해제

$result = [];
$total_characters = 0; // 글자 수 저장 변수

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['textData'])) {
    $data = $_POST['textData'];

    // 스페이스바와 기호를 제외한 글자 수 계산
    $total_characters = mb_strlen(preg_replace('/[^\p{L}]/u', '', $data));

    // 스페이스바 기준으로 단어 분리
    $words = explode(' ', $data);

    // n그램 저장 배열
    $ngrams = [
        1 => [],
        2 => [],
        3 => [],
        4 => []
    ];

    // 각 단어에서 n그램 생성
    foreach ($words as $word) {
        $length = mb_strlen($word);

        for ($n = 1; $n <= 4; $n++) { // 1그램부터 4그램까지
            if ($length >= $n) {
                for ($i = 0; $i <= $length - $n; $i++) {
                    $ngram = mb_substr($word, $i, $n);
                    if (isset($ngrams[$n][$ngram])) {
                        $ngrams[$n][$ngram]++;
                    } else {
                        $ngrams[$n][$ngram] = 1;
                    }
                }
            }
        }
    }

    // n그램 결과 정렬 및 준비
    foreach ($ngrams as $n => $ngram_data) {
        arsort($ngram_data); // 빈도수 기준 정렬
        $result[$n] = $ngram_data;
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>n그램 분석기</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .fixed-container {
            position: sticky;
            top: 0;
            background: #f8f9fa;
            z-index: 10;
            padding: 15px;
            border-bottom: 2px solid #ccc;
        }

        .result-container {
            max-height: 300px;
            overflow-y: auto;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
        }

        .char-count {
            font-size: 0.9em;
            color: #666;
            margin-top: 5px;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="fixed-container">
        <h2 class="text-center">n그램 분석기</h2>
        <form method="post">
            <label for="textData">텍스트 입력:</label>
            <textarea id="textData" name="textData" rows="5" class="form-control mb-3"><?php echo isset($_POST['textData']) ? htmlspecialchars($_POST['textData']) : ''; ?></textarea>
            <!-- 글자 수 표시 -->
            <p class="char-count">
                <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
                    스페이스바와 기호를 제외한 글자 수: <strong><?php echo $total_characters; ?></strong>
                <?php endif; ?>
            </p>
            <button type="submit" class="btn btn-primary">분석하기</button>
        </form>
    </div>

    <?php if (!empty($result)): ?>
        <div class="row mt-3">
            <?php foreach ($result as $n => $ngram_data): ?>
                <div class="col-md-6">
                    <h5 class="text-primary"><?php echo $n; ?>그램 결과 (총 <?php echo count($ngram_data); ?>개)</h5>
                    <div class="result-container">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th><?php echo $n; ?>그램</th>
                                <th>빈도수</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $index = 1; // 일련번호 초기화
                                foreach ($ngram_data as $gram => $count): ?>
                                    <tr>
                                        <td>#<?php echo $index; ?></td> <!-- 일련번호 -->
                                        <td><?php echo htmlspecialchars($gram); ?></td> <!-- 한자 -->
                                        <td><?php echo $count; ?></td> <!-- 빈도수 -->
                                    </tr>
                                <?php 
                                $index++; // 일련번호 증가
                                endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
