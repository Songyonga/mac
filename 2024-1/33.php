<!DOCTYPE html>
<html lang="ko">
<head>
  <title>Google Chart</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <link href="style.css" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

</head>
<body>
 
<?php
  $name1 = "김,이,박,최,정,민,조,가,곽,장,남궁,김,김,이,채,송,장,심,김,라,우,임";
  $name2 = "동,정,신,용,석,혜,윤,영,민,검,재,연,예,연,재,승,민,나,소,아";
  $name3 = "현,한,행,아,훈,현,우,진,주,명,아,서,은,은,영";

  $sn1 = explode(",", $name1);
  $sn2 = explode(",", $name2);
  $sn3 = explode(",", $name3);

  for($i=1; $i<=100; $i++)
  {
    $a = rand(0, count($sn1)-1);
    $b = rand(0, count($sn2)-1);
    $c = rand(0, count($sn3)-1);

    $name = $sn1[$a] . $sn2[$b] . $sn3[$c];
    
    echo "$i : $name <br>";
  }
?>

</body>
</html>