<?php
    
?>
<form method="post" action="index.php?cmd=sino&mode=analysis">
<div class="row">
    <div class="col colLine">
        <input type="text" name="level" placeholder="급수를 입력하세요" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col colLine">
        <textarea class="form-control" rows="10" name="memo"></textarea>
    </div>
</div>
<div class="row">
    <div class="col colLine text-center">
        <button type="submit" class="btn btn-primary">분석</button>
    </div>
</div>
</form>

<?php
    if(isset($_GET["mode"]))
    {
        $mode = $_GET["mode"];
        $memo = $_POST["memo"];
        $level = $_POST["level"];
        echo "memo = $memo<br>";

        $split = explode("\n", $memo);

        $count = count($split);

        for($i=0; $i<$count; $i = $i + 3)
        {
            echo "글자라인 $i : $split[$i]<br>";
            $i2 = $i + 1;
            echo "부수라인 $i2 : $split[$i2]<br>";
            $i3 = $i + 2;
            echo "훈음라인 $i3 : $split[$i3]<br>";

            


        
            $splitTab = explode("\t", $split[$i]);
            $countTab = count($splitTab);
            for($j = 0; $j< $countTab; $j++)
            {
                $save1 = $splitTab[$j];
                echo "[ $j ] $splitTab[$j] <br>"; // SAVE
                // 부수, 총획, 음훈
                $splitTab2 = explode("\t", $split[$i2]);
                
                $j2 = $j + 1;
                $temp = explode("|", $splitTab2[$j]);
                echo "A$temp[0] / B$temp[1]<br>";  
                $temp2 = explode(":", $temp[0]);
                $base = $temp2[1]; // SAVE
                $save2 = $base;
                $temp3 = explode(":", $temp[1]);
                $total = str_replace("획", "", $temp3[1]);
                $save3 = $total;
                // SAVE
                echo "부수#$base#총회#$total<br>";

                $splitTab3 = explode("\t", $split[$i3]);
                $temp = explode(" | ", $splitTab3[$j]);
                $countSori = count($temp);
                for($k=0; $k< $countSori; $k++)
                {
                    $splitSpace = explode(" ", $temp[$k]);
                    $mean = $splitSpace[0];
                    $save4 = $mean;
                    $sori = $splitSpace[1];
                    $save5 = $sori;

                    echo "mean = $mean, sori = $sori<br>";

                    /*
                    create table han_level(
                    idx integer auto_increment primary key,
                    hanja char(10),
                    base  char(10),
                    total integer,
                    mean char(30),
                    sound char(10),
                    level char(10) defaul '0'

);
                    */

                    $sql = "insert into han_level (hanja, base, total, mean, sound, level) 
                            values ('$save1', '$save2', '$save3', '$save4', '$save5',  '$level')";
                    $result = mysqli_query($conn, $sql);
                    echo "sql = $sql<br>";      
                }

                



            }
        }
    }
?>