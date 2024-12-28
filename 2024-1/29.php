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
    $line = $_POST["line"];
  }else
  {
    $line = 30;
    $words = "水旱果天數乎。果人事乎。堯湯未免。天數也。休咎有徵。人事也。古之人修人事以應天數。故有九七年之厄而民不病。";
  }

 
?>
<div class="container">
  <form method="post" action="<?php echo $_SERVER["PHP_SELF"]?>">  
  <div class="row">
    <div class="col-10 colLine">
      <textarea name="text" class="form-control" rows="10"><?php echo $words?>
      </textarea>
    </div>
    <div class="col colLine">
      <button type="submit" class="btn btn-primary h-100">분석</button>
    </div>
  </div>

  <div class="row">
    <div class="col-2 colLine">라인수</div>
    <div class="col colLine">
      <input type="number" name="line" class="form-control" value="<?php echo $line?>" step="1" min="10" max="1000">   
    </div>
  </div>

  </form>

  <?php 
  if(isset($_POST["text"]))
  {
    // 네이버 : 논어집주 네이버 지식백과
    // 子曰(자왈) 學而時習之(학이시습지)면 不亦說(悅)乎 (불역열호)1)아
    echo "분석 시작합니다.<br>";
    $doc = $_POST["text"];

    // 정규식 : a-zA-Z가-힣
    $doc = preg_replace("/[a-zA-Z0-9가-힣_\s]+/u", "", $doc);
    $doc = preg_replace("/[。?&()]/u", " ", $doc);
    $doc = preg_replace("/[\s]+/", " ", $doc);

    $split = explode(" ", $doc);

    // 분석 데이터 저장을 위한 배열, 2차원배열
    // dict[음절수][자] = 1
    $wordArray = array();

    for($i=0; $i<count($split); $i++)
    {
      // echo $split[$i] . "<br>";
      $chars = mb_strlen($split[$i]);

      $maxSyllable = $chars;

      // n-gram 분리 : 대한민국
      for($gram = 1; $gram<=$chars; $gram ++)
      {
        //echo "$gram gram 분석합니다.<br>";

        for($pos = 0; $pos <= $chars; $pos ++)
        {
          if($pos + $gram <= $chars)
          {
            $subText = mb_substr($split[$i] , $pos, $gram);
            // echo "$pos, $gram : $subText<br>";
            $syllable = mb_strlen($subText);
            if(isset($wordArray[$syllable][$subText]))
            {
              $wordArray[$syllable][$subText] ++;
            }else
            {
              $wordArray[$syllable][$subText] = 1;
            }
          }else
          {
            break; // 나를 둘러싼 첫번째 반복문을 빠져나가라
          }
        }
      }
    }

    /*
    for($n = 1; $n <=5; $n++)
    {
      echo "$n 음절 단어 확인<br>";
      arsort($wordArray[$n]);
      foreach($wordArray[$n] as $key => $value)
      {
        echo "$key : $value <br>";
      }
    }
    */
  ?>

<div class="row">
    <div class="col">
      <h5 class="text-primary">n그램 분석 결과</h5>
    </div>
  </div>

  <div class="row">
    <div class="col">
      과제 : 학번 % 20 +1 <br>
      5음절까지 가장 많이 출현하는 음절별 글자를 찾아서, 분석해서
      스크린샷, HWP 에 넣어서 이메일..<br>
      5.19(일) :23:59<br>


      <table class="table table-borderd">
        <?php
          for($i=1; $i<=$line; $i++)
          {
            echo "
            <tr>
              <td># $i</td>
            ";

            for($n = 1; $n <=5; $n++)
            {
              arsort($wordArray[$n]); // 음절별로 내림차순 정렬
              $tmp = 0; // temporay

              foreach($wordArray[$n] as $key => $value)
              {
                if($tmp < $i -1)
                {

                }else
                {
                  if($value <1 )
                  {
                    echo "<td>-</td>";
                  }else
                  {
                    echo "<td>$key</td>";
                    echo "<td>$value</td>";
                  }
                  break;
                }
                $tmp ++;
              }
            }
              
            echo "</tr>";
          }
        ?>
      </table>
    </div>
  </div>

  <?php
  }
?>


</div> <!-- container -->



</body>
</html>