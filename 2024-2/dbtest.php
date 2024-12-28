<div class="container mt-5">
    <h2>db정보 with ChatGPT</h2>

    <div class="container mt-5">
    <h2>사용자 정보 추가</h2>

    <input type="text" class="form-control" name="test1" placeholder="아이디 입력">
    <input type="email" class="form-control" name="test1">
    <input type="url" class="form-control" name="test1">
    <input type="password" class="form-control" name="test1">

    <select class="form-control" name="test1">
        <option value='0'>== 선택 ==</option>
        <option value='1'>서울</option>
        <option value='2' selected>대전</option>
    </select>

    <textarea class="form-control" name="test1" rows="10"></textarea>

    <input type="radio" name="gender" value="1">남 
    <input type="radio" name="gender" value="2" checked>여 
    <input type="radio" name="gender" value="3">N/A 

    <script>
        function confirmDelete()
        {
            if(confirm('삭제한 데이터는 복구할 수 없습니다.\n\n정말 삭제하시겠습니까?'))
            {
                alert('삭제를 시작합니다.');
                location.href='index.php?cmd=dbtest&mode=delete';
            }else
            {
                alert('취소되었습니다.');
            }
        }

        function checkError() {
            var id = document.getElementById('id').value.trim();
            var name = document.getElementById('name').value.trim();

            if (id === "") {
                alert("아이디를 입력하세요");
                document.getElementById('id').focus();
                return false; // 폼 전송 중단
            }

            if (name === "") {
                alert("이름을 입력하세요");
                document.getElementById('name').focus();
                return false; // 폼 전송 중단
            }

            return true; // 폼 전송
        }
    </script>
    
    <!-- 사용자 정보 입력 폼 -->
    <form action="13.php" method="POST" onSubmit="return checkError()"> 
        <div class="mb-3">
            <label for="id" class="form-label">아이디 (id)</label>
            <input type="text" class="form-control" id="id" name="id">
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">이름 (name)</label>
            <input type="text" class="form-control" id="name" name="name" >
        </div>
        <div class="mb-3">
            <label for="birth" class="form-label">생년월일 (birth)</label>
            <input type="date" class="form-control" id="birth" name="birth" >
        </div>
        <div class="mb-3">
            <label for="pass" class="form-label">비밀번호 (pass)</label>
            <input type="password" class="form-control" id="pass" name="pass" >
        </div>
        <button type="submit" class="btn btn-primary">추가</button>

        <button type="button" class="btn btn-success" onClick="alert('안녕하세요. \n충남대학교 한문학과입니다.')">인사하기</button>
        <button type="button" class="btn btn-danger" onClick="confirmDelete()">삭제하기</button>
    </form>

    <?php
    // POST 요청이 있는 경우에만 실행
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // 입력받은 데이터 가져오기
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $birth = mysqli_real_escape_string($conn, $_POST['birth']);
        $pass = mysqli_real_escape_string($conn, $_POST['pass']);
        
        // 비밀번호는 해싱하여 저장하는 것이 권장됨 (예: password_hash)
        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
        
        // 데이터베이스에 삽입하는 쿼리
        $sql_insert = "INSERT INTO my_user_table (id, name, pass, birth) VALUES ('$id', '$name', '$hashed_pass', '$birth')";
        
        // 삽입 실행
        if (mysqli_query($conn, $sql_insert)) {
            echo "<div class='alert alert-success mt-3'>새 사용자 정보가 추가되었습니다.</div>";
        } else {
            echo "<div class='alert alert-danger mt-3'>오류 발생: " . mysqli_error($conn) . "</div>";
        }
    }
    ?>


    <!-- 데이터 테이블 -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>idx</th>
                <th>name</th>
                <th>id</th>
                <th>birth</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // my_user_table에서 데이터를 이름 오름차순으로 가져오는 쿼리
            $sql = "SELECT idx, name, id, birth FROM my_user_table ORDER BY name ASC";
            $result = mysqli_query($conn, $sql);

            // 결과가 있는지 확인
            if (mysqli_num_rows($result) > 0) {
                // 각 행을 출력
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['idx'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['birth'] . "</td>";
                    echo "</tr>";
                }
            } else {
                // 결과가 없을 때
                echo "<tr><td colspan='4'>데이터가 없습니다.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
