<?php
    $submenu[1] = "급수등록";
    $submenu[2] = "툴";
    $submenu[3] = "테스트";

    if(!isset($_GET["sub"]))
        $sub = 1;
    else
        $sub = $_GET["sub"];

    $cnt = 1;

    echo "sub = $sub, cnt = $cnt<br>";
    ?>
    <div class="row">
        <div class="col text-center">
    <ul class="pagination">
    <?php
    while(isset($submenu[$cnt]) and $submenu[$cnt])
    {
        if($cnt == $sub)
        {
            ?>
            <li class="page-item active"><a class="page-link" href="<?php echo $_SERVER["PHP_SELF"]?>?cmd=<?php echo $cmd?>&sub=<?php echo $cnt?>"><?php echo $submenu[$cnt]?></a></li>
            <?php
        }else
        {
            ?>
            <li class="page-item"><a class="page-link" href="<?php echo $_SERVER["PHP_SELF"]?>?cmd=<?php echo $cmd?>&sub=<?php echo $cnt?>"><?php echo $submenu[$cnt]?></a></li>
            <?php

        }

        $cnt ++;
    }
    ?>
    </ul>
        </div>
    </div>
    <?php

    if($sub == 2)
    {
        if(isset($_POST["text"]) and $_POST["text"])
            $baseText = $_POST["text"];
        else {
            $baseText = "子曰, “學而時習之, 不亦說乎? 有朋自遠方來, 不亦樂乎? 人不知而不慍, 不亦君子乎?”
有子曰, “其爲人也孝弟, 而好犯上者, 鮮矣, 不好犯上, 而好作亂者, 未之有也. 君子務本, 本立而道生. 孝弟也者, 其爲仁之本與!”
子曰, “巧言令色, 鮮矣仁!”
曾子曰, “吾日三省吾身, 爲人謀而不忠乎? 與朋友交而不信乎? 傳不習乎?”
子曰, “道千乘之國, 敬事而信, 節用而愛人, 使民以時.”
子曰, “弟子, 入則孝, 出則悌, 謹而信, 汎愛衆, 而親仁. 行有餘力, 則以學文.”
子夏曰, “賢賢易色, 事父母, 能竭其力, 事君, 能致其身, 與朋友交, 言而有信. 雖曰未學, 吾必謂之學矣.”
子曰, “君子不重, 則不威, 學則不固. 主忠信. 無友不如己者. 過則勿憚改.”
曾子曰, “愼終追遠, 民德歸厚矣.”";
        }
        ?>
        <style>
            .hanWord {
                font-size: 40px;
                color:#333333;
            }
            .china {
                font-size: 40px;
                color:#333333;
            }
            .korea {
                font-size: 10px;
                color:#FF0000;
            }
            .space {
                font-size: 30px;
                color:#FFFFFF;
            }
            .etc {
                font-size: 30px;
                color:#0000FF;
            }
            .new {
                background-color:#EEEEEE;
            }

            .level {
                font-size: 16px; /* 작은 글씨 크기 설정 */
                position: relative;
                top: -1.2em; /* 위로 올리는 위치 조정 */
                margin-left: 2px; /* 한자와 숫자 사이의 간격 조정 */
                color: #FF0000; /* 첨자의 색상 설정 */
                display:;
            }

            span.new {
                position: relative;
                cursor: pointer;
            }

            /* 툴팁 스타일 */
            span.new:hover::after {
                content: attr(data-tooltip);
                position: absolute;
                bottom: 100%;
                left: 50%;
                transform: translateX(-50%);
                background-color: yellow;
                color: black;
                padding: 5px;
                border-radius: 5px;
                white-space: nowrap;
                font-size: 14px;
                box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);
                z-index: 10;
                opacity: 1;
                pointer-events: none;
            }

            span.new::after {
                content: '';
                position: absolute;
                bottom: 100%;
                left: 50%;
                transform: translateX(-50%);
                opacity: 0;
                transition: opacity 0.2s ease-in-out;
            }
        </style>

        <script>
            function showHideLevel()
            {
                var level = document.querySelector('#level').checked;

                const elements = document.querySelectorAll('.level');


                if(level == true)
                {
                    // Loop through each element and set display to none
                    elements.forEach(element => {
                        element.style.display = '';
                    });
                }else
                {
                    
                    // Loop through each element and set display to none
                    elements.forEach(element => {
                        element.style.display = 'none';
                    });
                }
                
            }
        </script>

        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]?>?cmd=<?php echo $cmd?>&sub=<?php echo $sub?>&mode=analysis">
        <div class="row">
            <div class="col colLine">
                <textarea name="text" class="form-control" rows="7"><?php echo $baseText?></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col colLine">
                <input type="checkbox" name="sori" id="sori" checked> 音 &nbsp; 
                <input type="checkbox" name="mean" id="mean"> 訓 &nbsp;
                <input type="checkbox" name="base" id="base" checked> 부수 &nbsp; 
                <input type="checkbox" name="total" id="total"> 총획 &nbsp; &nbsp; &nbsp;
                <input type="checkbox" name="level" id="level" checked onClick="showHideLevel()"> 급수보기
            </div>

            <div class="col colLine">
                <input name="unit" type="radio" value="1" checked> 급수를 원문에 &nbsp; 
                <input name="unit" type="radio" value="2"> 급수를 도움말로 보기 &nbsp;
            </div>
        </div>
        <div class="row">
            <div class="col text-center colLine">
                <button type="submit" class="btn btn-primary">분석</button>
            </div>
        </div>
        </form>

        <?php
        $naList = array();

        function styleText($text) {
            global $naList;
            global $conn;

            if (!mb_check_encoding($text, 'UTF-8')) {
                $text = mb_convert_encoding($text, 'UTF-8', 'auto');
            }

            if (preg_match('/[가-힣]/u', $text)) {
                return "<span class='korean'>$text</span>";
            } else if (preg_match('/[一-龥樂]/u', $text)) {
                // 한자인 경우
                $sql = "select * from han_level where hanja='$text'";
                $result = mysqli_query($conn, $sql);
                $data = mysqli_fetch_array($result);
                if($data)
                {
                    $level = str_replace("급", "", $data["level"]);
                }else
                {
                    if(isset($naList[$text]))
                        $naList[$text] ++;
                    else
                        $naList[$text] = 1;
                    $level = "N/A";
                }
                return "<span class='china'>$text</span><span class='level'>$level</span>";
            } elseif (preg_match('/[\s\t]/u', $text)) {
                // 공백인 경우
                return "<span class='space'>$text</span>";
            } else {
                // 기타 문자
                return "<span class='etc'>$text</span>";
            }
        }
    
        if(isset($_GET["mode"]) and $_GET["mode"] == "analysis")
        {
            $text = $_POST["text"];
    
            // echo "text = $text<br>";
            $lines = explode("\n", $text);
            for($i = 0; $i < count($lines); $i++)
            {
                if($lines[$i])
                {
                    //echo "$i : $lines[$i]<br>";
 
                    $flag = false;

                    for($n=0; $n< mb_strlen($lines[$i]); $n++)
                    {
                        $item = mb_substr($lines[$i], $n, 1);
                        if($flag == false and preg_match('/[一-龥]/u', $item))
                        {
                            $start = "<span class='new'>";
                            $flag = true;
                            $end = "";
                        }else
                        {
                            $start = "";

                            if($flag == true and preg_match('/[^一-龥]/u', $item))
                            {
                                $end = "</span>";
                                $flag = false;
                            }else
                            {
                                $end = "";
                            }
                        }
                            
                        $printText = styleText($item);
                        
                        echo "$start$end$printText";
                        //echo "<span class='hanWord'>$item</span>";
                    }
                        
                }else
                {
                    echo "$i : no data line<br>";
                }
                echo "<br>";
            }

            arsort($naList);
            //print_r($naList);
            foreach ($naList as $key => $value) {
                echo $key . PHP_EOL;
            }

            echo "<br>";
            ?>
<script>
    // Iterate through all elements with the class 'new'
    document.querySelectorAll('span.new').forEach(element => {
        // Add mouseover event to each element
        element.addEventListener('mouseover', () => {
            const text = element.textContent.trim(); // Get the text content

            // Dynamically check the current state of checkboxes
            const sori = document.querySelector('#sori')?.checked || false;
            const mean = document.querySelector('#mean')?.checked || false;
            const base = document.querySelector('#base')?.checked || false;
            const total = document.querySelector('#total')?.checked || false;

            // Send an AJAX request with the text as a JSON payload
            fetch('ajaxGetTooltip.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ text, sori, mean, base, total }) // Send text in JSON format
            })
            .then(response => response.text()) // Parse response as text
            .then(data => {
                // Set the response as the tooltip content
                element.setAttribute('data-tooltip', data);
            })
            .catch(error => console.error('Error:', error));
        });
    });
</script>
            <?php
        }        
    }

    if($sub == 1)
    {
        ?>
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]?>?cmd=sino&sub=<?php echo $sub?>&mode=analysis">
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
    }
?>
