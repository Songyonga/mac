<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>9월 달력</title>
    <!-- 부트스트랩 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        table {
            width: 100%;
            text-align: center;
            border-collapse: collapse;
        }
        th, td {
            padding: 20px; /* 간격 설정 */
            border: 3px solid black; /* 테두리 더 굵게 설정 */
            width: 14.28%; /* 테이블 열 너비를 동일하게 설정 (7열이므로 100%/7) */
        }
        .saturday {
            color: blue;
        }
        .sunday, .holiday {
            color: red;
        }
        .bold-title {
            font-weight: bold;
            font-size: 2rem;
            text-align: center;
            margin-top: 20px;
        }
        .year-label {
            font-weight: bold;
            font-size: 0.8rem;
            text-align: left;
            margin-bottom: -10px;
        }
        .holiday-text {
            color: red;
            font-size: 0.7rem; /* 추석연휴 텍스트 크기를 더 작게 설정 */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="year-label">2024년</div> <!-- 2024년을 왼쪽 상단에 굵고 작게 표시 -->
        <h1 class="bold-title">9월</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="sunday">일</th>
                    <th>월</th>
                    <th>화</th>
                    <th>수</th>
                    <th>목</th>
                    <th>금</th>
                    <th class="saturday">토</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // 9월 1일은 일요일로 시작하므로 빈 칸이 없음
                $days_in_month = 30;  // 9월은 30일까지 있음
                $first_day_of_month = 0; // 9월 1일이 일요일이므로 인덱스 0 (0: 일요일, 6: 토요일)
                $day_counter = 1;

                // 달력 생성
                while ($day_counter <= $days_in_month) {
                    echo "<tr>";
                    for ($i = 0; $i < 7; $i++) {
                        if ($day_counter > $days_in_month) {
                            echo "<td></td>"; // 빈 칸
                        } else {
                            // 일요일
                            if ($i == 0) {
                                echo "<td class='sunday'>$day_counter</td>";
                            }
                            // 토요일
                            elseif ($i == 6) {
                                echo "<td class='saturday'>$day_counter</td>";
                            }
                            // 추석 연휴 (15~18일)
                            elseif ($day_counter >= 15 && $day_counter <= 18) {
                                if ($day_counter == 17) {
                                    // 17일은 '추석연휴' 텍스트 추가
                                    echo "<td class='holiday'>$day_counter<br><span class='holiday-text'>추석연휴</span></td>";
                                } else {
                                    echo "<td class='holiday'>$day_counter</td>";
                                }
                            }
                            // 평일
                            else {
                                echo "<td>$day_counter</td>";
                            }
                        }
                        $day_counter++;
                    }
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- 부트스트랩 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
