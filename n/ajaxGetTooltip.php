<?php
session_save_path("sess");
session_start();

include "db.php";

// 데이터베이스 연결 확인
$conn = connectDB();

// Handle AJAX POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the input JSON
    $input = json_decode(file_get_contents('php://input'), true);

    // Extract the 'text' parameter
    $text = $input['text'] ?? '';
    $sori = $input['sori'] ?? false;
    $mean = $input['mean'] ?? false;
    $base = $input['base'] ?? false;
    $total = $input['total'] ?? false;

    $cleanedText = preg_replace('/[^\p{Han}]/u', '', $text);

    $count = mb_strlen($cleanedText, "utf-8");
    $tooltipContent = "";
    for($i=0; $i<$count; $i++)
    {
        $word = mb_substr($cleanedText, $i, 1);
        $sql = "select * from han_level where hanja='$word'";
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_array($result);
        if($data)
        {
            $tooltipContent = $tooltipContent . "$data[hanja] : ";

            if($mean)
                $tooltipContent = $tooltipContent . "$data[mean] ";
            if($sori)
                $tooltipContent = $tooltipContent . "($data[sound]) ";
            if($base)
                $tooltipContent = $tooltipContent . " 부수($data[base]) ";

            if($total)
                $tooltipContent = $tooltipContent . " 총획($data[total]) ";

            $tooltipContent = $tooltipContent . " |   ";
            //$tooltipContent = $tooltipContent . "$data[hanja] : $data[mean] ($data[sound]) 부수 $data[base] 총획 $data[total] | ";
        }else
        {
            $tooltipContent = $tooltipContent . "$word 기록 없음 |  ";
        }
    }

    // Respond with the formatted text
    //echo "\"$text\"를 출력합니다.";

    //echo json_encode(['tooltip' => $tooltipContent]);
    echo $tooltipContent;
}