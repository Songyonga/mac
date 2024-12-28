<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap 5 Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <link rel="stylesheet" href="style.css">

</head>
<body>
<div class="container">
    <div class="row">
        <div class="col colLine">프로그래밍(변수)<br>
            <?php 

                $name = "홍길동";
                echo "name의 값은 $name<br>";
                $age = 13;
                $age = $age + 15;

                echo "이 사람의 이름은 $name" . "이고 나이는 " . "$age <br>";
                echo "이 사람의 이름은 $name 이고 나이는 $age <br>";

                // 주석
                /*
                    여러줄 주석
                    여러줄을 컴퓨터가 무시

                    비교 if(조건)
                */

                if($age >=20)
                {
                    echo "성인입니다.<br>";
                } else
                {
                    echo "미성년자입니다.<br>";
                }

                
                /*
                    반복문
                    문법 : for(초기값; 조건; 증감)
                */

                for($i=1; $i<=100; $i = $i + 2) 
                {
                    echo "$i ";
                    if($i % 10 == 0)
                        echo "<br>";
                }
            ?>
        </div>
    </div>
</div>
</body>
</html>
