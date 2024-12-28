<?php
    session_save_path("sess");
    session_start();
?>
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
        <form method="post" action="24.php">
        <div class="row">
            <?php
                if(isset($_SESSION["sinoid"]))
                {
                    $name = $_SESSION["sinoname"];
                    echo "
                    <script>
                        function goLogout()
                        {
                            location.href='25logout.php';
                        }
                    </script>
                    <div class='col colLine text-end'>
                        $name 님 
                        <button type='button' class='btn btn-primary' onClick='goLogout()'>로그아웃</button>
                    </div>
                    ";
                   
                }else
                {
                    ?>
                    
                    <div class="col-6 colLine"></div>
                    <div class="col colLine">
                        <input type="text" class="form-control" placeholder="ID" name="id">
                    </div>
                    <div class="col colLine">
                        <input type="password" class="form-control" placeholder="비밀번호" name="pass">
                    </div>
                    <div class="col colLine">
                        <button type="submit" class="btn btn-primary form-control">로그인</button>
                    </div>
                    

                    <?php
                }
            ?>
        </div>
        </form>
    </div>
</body>
</html>