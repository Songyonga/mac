<!DOCTYPE html>
<html lang="ko">
<head>
  <title>Bootstrap 5 Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <link href="style.css" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col colLine">
                HTML 영역
                <?php 
                    // 주석(프로그램)

                    $age = 13;
                    echo "age = $age<br>";
                    $age = $age + 5;
                    $age++;
                    echo "age = $age<br>";

                    if($age > 10)
                    {
                        echo "10살 이상<br>";
                    }else 
                    {
                        echo "유치원생<br>";
                    }

                    $a = 7 % 3;

                    echo "a = $a<br>";

                    // 반복문
                    // for(초기값; 조건; 증감)

                ?>

// 010-4567-23450101-22fjv22010-4444-2352-1222231vv
                <?php
                    for($i = 1; $i<=31; $i=$i+1)
                    {
                        echo "$i ";

                        if($i % 7 ==0)
                        {
                            echo "<br>";
                        }
                    }

                    echo "<br><br>";
                    $sum = 0;
                    for($i=1; $i<=100; $i++)
                    {
                        $sum = $sum + $i;
                    }

                    echo "sum = $sum<br>";
                ?>
            </div>
        </div>
    </div>
</body>
</html>