<?php
    include "head.php";
    include "db.php";

    // 데이터베이스 연결 확인
    $conn = connectDB();

    // my_user_table에서 데이터를 이름순으로 가져오는 SQL 쿼리
    $sql = "SELECT idx, name, id, pass, birth FROM my_user_table ORDER BY name ASC";
    $sql = "SELECT idx, name, id, pass, birth FROM my_user_table ORDER BY idx ASC";
    $sql = "SELECT idx, name, id, pass, birth FROM my_user_table
                    WHERE birth >='1700-01-01'
                 ORDER BY name ASC";
    $sql = "SELECT idx, name, id, pass, birth FROM my_user_table
                    WHERE birth >='1700-01-01'
                ORDER BY birth ASC";
    
    $result = mysqli_query($conn, $sql);
?>
<div class="container">
    <div class="row">
        <div class="col colLine">
            <h2>DB 테스트 - 사용자 목록</h2>

            <!-- 테이블 출력 -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>idx</th>
                        <th>name</th>
                        <th>id</th>
                        <th>pass</th>
                        <th>birth</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // 쿼리 실행 결과가 있는지 확인
                    if (mysqli_num_rows($result) > 0) {
                        // 결과 데이터를 한 행씩 배열로 가져옴
                        while ($data = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $data['idx'] . "</td>";
                            echo "<td>" . $data['name'] . "</td>";
                            echo "<td>" . $data['id'] . "</td>";
                            echo "<td>" . $data['pass'] . "</td>";
                            echo "<td>" . $data['birth'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>데이터가 없습니다.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 
    // 연결 종료
    mysqli_close($conn);
    include "tail.php";
?>
