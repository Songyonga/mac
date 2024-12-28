<?php
    include "head.php";
?>
<div class="container">
    <div class="row">
        <div class="col colLine">프로그래밍(함수)<br>
            <?php 
                function add($num1, $num2)
                {
                    return $num1 + $num2;
                }

                $age = add(1, 2);

                echo "age = $age<br>";

                $total = add(70, 80);
                echo "total = $total<br>";
            ?>
        </div>
        
        <div class="row">
            <table class="table-bordered">
            <?php
                /*
                    변수 이름이나, 함수 이름이 복잡한 경우
                    $myfamilycount = 3;
                    $my_family_count = 3; // snake expression
                    $myFamilyCount = 3;   // camel expression
                    $MyFamilyCount = 3;   // 비추천

                    $PI = 3.14;

                    $maxMonth = 12;
                    $MAX_MONTH = 12;
                */

                /* 
                    while(조건)
                    {
                        
                        조건을 빠져 나가는지 눈으로 꼭 확인 !!
                    }

                    for($i=10; $i>=0; $i = $i -1)
                */

                $sum = 0;
                for($i=1; $i<=77777; $i++)
                {
                    $sum = $sum +$i;
                }
                echo "sum = $sum<br>";

                include "10.php";
                
                $k = $i  = 10;

                echo "i = $i <br>";

                // counter 카운터 
                $cnt = 10;

                while($cnt >=0)
                {
                    echo "$cnt <br>";
                    $cnt = $cnt -1;
                }


                for($i=1; $i<=30; $i++)
                {
                    if($i % 7 == 1)
                    echo "<tr>";
                        
                    if($i % 7 == 1)
                        $textColor = "text-danger";
                    else if($i % 7 == 0)
                        $textColor = "text-primary";
                    else 
                        $textColor = "";

                    echo "<td class='col $textColor'>$i</td>";

                    if($i % 7 == 0)
                        echo "</tr>";
                }
            ?>
            </table>
        </div>

    </div>
</div>
<?php 
    include "tail.php";
?>
