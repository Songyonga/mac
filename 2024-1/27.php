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
    
<div class = "container">
    <form method="post" acction="27.php">
        <div class = "row">
            <div class = "col-10 colLine">
                <textarea class="form-control" rows="10">
                    가나다 라마바
                @@                      @@
                  ********
                </textarea>
            </div>    
            <div class = "col colLine">
                <button type="submit" class="btn btn-primary h-100">분석</button>
            </div>

            </div>

        </div>
    </form>

    <?<php>
    if(isst($_POST["text"]))
    {
        echo "분석 시작함.<br>";
    }

    {
        echo $split[$i] . "<br>";
    }

    </php>
</div>  
</body>
</html>