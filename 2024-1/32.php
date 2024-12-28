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
  //$url = "https://plus.cnu.ac.kr/_prog/lostandfound/?site_dvs_cd=kr&menu_dvs_cd=07080301";
  $url = "https://plus.cnu.ac.kr/_prog/lostandfound/?site_dvs_cd=kr&menu_dvs_cd=07080301&gubun=1&skey=&sval=&GotoPage=2";
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

  $response = curl_exec($curl);
?>
<div class="container">
  <div class="row">
    <div class="col colLine">
      <textarea class="form-control" rows="10"><?php echo $response?></textarea>
    </div>
  </div>
</div>

<?php
  $split = explode("<td class='title'>", $response);
  for($i=1; $i< count($split); $i++)
  {
    //echo "<xmp>$split[$i]</xmp><hr>";
    $split2 = explode("</a>", $split[$i]);
    //echo "<xmp>$split2[0]</xmp><hr>";

    $split3 = explode("'>", $split2[0]);
    echo "<xmp>$split3[1]</xmp><hr>";

  }
?>

</body>
</html>