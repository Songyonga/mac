<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lotto Number Generator</title>
    <!-- 부트스트랩 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    // 로또 번호 생성 함수
    function generateLottoNumbers() {
        // 1부터 45까지의 범위에서 6개의 랜덤한 번호를 선택
        $numbers = range(1, 45);
        shuffle($numbers);
        $lottoNumbers = array_slice($numbers, 0, 6);
        
        // 번호를 오름차순으로 정렬
        sort($lottoNumbers);

        // 10 미만의 숫자는 2자리로 표시 (예: 03, 09)
        $formattedNumbers = array_map(function($num) {
            return str_pad($num, 2, '0', STR_PAD_LEFT);
        }, $lottoNumbers);

        return $formattedNumbers;
    }

    // 로또 번호를 생성
    $lottoNumbers = generateLottoNumbers();
    ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header text-center">
                        <h3>Lotto Numbers</h3>
                    </div>
                    <div class="card-body text-center">
                        <h4>
                            <?php
                            // PHP에서 생성한 로또 번호를 출력
                            foreach ($lottoNumbers as $number) {
                                echo "<span class='badge bg-primary p-2 mx-1'>$number</span>";
                            }
                            ?>
                        </h4>
                        <!-- 로또 번호 새로 생성 버튼 -->
                        <form method="POST">
                            <button type="submit" class="btn btn-primary mt-3">새 번호 생성</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 부트스트랩 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
