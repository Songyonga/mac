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

  // text 세팅

  if(isset($_POST["text"]))
  {
    $words = $_POST["text"];
  }else
  {
    $words = "水旱果天數乎。果人事乎。堯湯未免。天數也。休咎有徵。人事也。古之人修人事以應天數。故有九七年之厄而民不病。";
  }

 
?>
<div class="container">
  <form method="post" action="27.php">  
  <div class="row">
    <div class="col-10 colLine">
      <textarea name="text" class="form-control" rows="10"><?php echo $words?>
      </textarea>
    </div>
    <div class="col colLine">
      <button type="submit" class="btn btn-primary h-100">분석</button>

    </div>
  </div>
  </form>

  <?php 
  if(isset($_POST["text"]))
  {
    echo "분석 시작합니다.<br>";
    $words = $_POST["text"];

    $split = explode("。", $words);
    for($i=0; $i<count($split); $i++)
    {
      echo $split[$i] . "<br>";
    }
  }

?>
</div>



</body>
</html>