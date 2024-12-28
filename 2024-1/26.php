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

<?php

  $local = "서울,경기,충청,대전,제주,기타";
  $split = explode(",", $local);

  for($i=0; $i< count($split); $i++)
  {
    echo "$split[$i]<br>";
  }

  $words = "水旱果天數乎。果人事乎。堯湯未免。天數也。休咎有徵。人事也。古之人修人事以應天數。故有九七年之厄而民不病。";
  $word = explode("。", $words);

  for($i=0; $i< count($word); $i++)
  {
    echo "$word[$i]<br>";
    for($j=0; $j< mb_strlen($word[$i]); $j++)
    {
      $ch = mb_substr($word[$i], $j, 1);
      echo "$ch <br>";
    }
  }


  $dict = array("apple", "desk", "computer");

  for($i=0; $i< count($dict); $i++)
  {
    echo "$dict[$i]<br>";
  }

  $degree = array(10, 20, 30, 40, 50, 13, 34, 21, 31);
  $degree[] = 33;
  $degree[] = 44;

  //sort($degree);
  rsort($degree);

  for($i=0; $i< count($degree); $i++)
  {
    echo "$degree[$i]<br>";
  }



  for($i=1; $i<=9; $i=$i+1)
  {
    echo "$i 단 출력<br>";

    //echo "9번 계산<br>";
    for($j=1; $j<=9; $j++)
    {
      $result = $i * $j;
      echo "$i * $j = $result<br>";
    }
    echo "<br>";
  }


  for($i=1; $i<=31; $i=$i+1)
  {
    
    echo "$i ";

    if($i % 7 == 0)
      echo "<br>";    
      
  }


?>

</body>
</html>