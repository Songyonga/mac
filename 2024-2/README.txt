README.txt
1. github테스트용
    https://github.com/eurekasolution/cnucc

    DB 세팅
    id : cnucc
    dbname : cnucc
    pass : 1111

    CREATE TABLE init(
        name    varchar(30)
    );

    INSERT INTO init (name) VALUES ('테스트');

    실행한 후 왼쪽의 cnucc/init를 클릭했을 때
    "테스트"라는 글씨가 보여야 함.
    한글깨짐이 있는 경우는 잘못 설치된 것임.

2. 홈페이지 실행
    C:/xampp/xampp_control.exe 실행
    Apache, MySQL의 "Start" 버튼을 클릭해 "Stop"으로 보여야 함.

    홈페이지 접속
    http://localhost

    데이터베이스 접속
    http://localhost/phpmyadmin
    

    chat.openai.com


    localhost/02.html

    w3schools.com


create table aaa ( 
    id char(20) unique,
    name char(20)

);

insert into aaa (id, name) values ('test', '테스트');
insert into aaa (id, name) values ('kdhong', '홍길동');

CREATE TABLE my_user_table (
    idx INT AUTO_INCREMENT PRIMARY KEY,   -- 기본 키이자 자동 증가 필드
    id VARCHAR(50) NOT NULL UNIQUE,       -- 사용자 아이디, 유일한 값
    name VARCHAR(100) NOT NULL,           -- 사용자 이름
    pass VARCHAR(255) NOT NULL,           -- 사용자 비밀번호
    birth DATE                            -- 생년월일 정보
);

INSERT INTO my_user_table (id, name, pass, birth) VALUES
('abcde', '세종', '1111', '1567-05-15'),
('fghij', '정조', '1111', '1745-08-28'),
('klmno', '이순신', '1111', '1545-09-08'),
('pqrst', '강감찬', '1111', '1582-12-12'),
('uvwxy', '이성계', '1111', '1357-01-20'),
('zabcd', '정도전', '1111', '1342-07-03'),
('efghi', '윤봉길', '1111', '1908-06-21'),
('jklmn', '안중근', '1111', '1879-09-02'),
('opqrs', '유관순', '1111', '1902-12-16'),
('tuvwx', '김구', '1111', '1876-08-29');

INSERT INTO my_user_table (id, name, pass, birth) VALUES
('yzabc', '허준', '1111', '1546-10-01'),
('defgh', '신사임당', '1111', '1504-10-29'),
('ijklm', '황희', '1111', '1363-02-03'),
('nopqr', '안창호', '1111', '1878-11-09'),
('stuvw', '장영실', '1111', '1390-07-01'),
('xyzaa', '이방원', '1111', '1367-10-13'),
('bcdef', '박지원', '1111', '1737-02-05'),
('ghijk', '유성룡', '1111', '1542-09-12'),
('lmnop', '신숙주', '1111', '1417-01-12'),
('qrstu', '정약용', '1111', '1762-06-16');

문법

insert into 테이블이름 (필드1, 필드2, ...) values ('값1', '값2', ..);

민경주 : kjmin
홍길동 : kdhong
insert into my_user_table (id, name, pass, birth) values 
                        ('kjmin', '민경주', '1111', '2000-10-03');

검색(SELECT)

SELECT column1, column2, ... FROM table_name;


SELECT * FROM my_user_table;
SELECT name,  birth from my_user_table;
SELECT name,  birth from my_user_table order by name asc;
SELECT name,  birth from my_user_table order by birth desc;
SELECT name,  birth from my_user_table 
        WHERE birth >='1800-01-01' and birth<'1900-01-01'
        order by name asc;

SELECT * from my_user_table where name like '%안%';

삽입(insert), 검색(select), 갱신(update), 삭제(delete)
UPDATE 테이블명 SET 필드1='새값1', 필드2='새값2', WHERE 조건

update my_user_table set id='gkim' where idx='10';
update my_user_table set id='djjung', birth='1500-01-01' where idx='6';

삭제

DELETE FROM 테이블명 WHERE 조건;

delete from my_user_table where idx='5';

PHP와 데이터베이스의 연동

DBname : culture
DBuser : culture
DBpass : 1111

PHP로 mysql과 연동하는 방법을 다음과 같이 만들어 줘.

- 파일의 이름은 db.php 파일
- $dbName = "culture";
- $dbUser = "culture";
- $dbPass = "1111";
- connectDB()함수를 이용해 DB에 연결해 줘.
- connectDB()는 $conn를 반환하도록 해줘.

다음과 같이 11.php 파일이 있어.
head.php는 HTML5와 bootstrap5에 관련된 헤더가 정의되어 있고
tail.php에는 HTML을 닫는 부분만 정의되어 있어.

위에서 제시해 준 db.php파일로 연결 확인도 되었다.
이때, 아래 코드에 my_user_table에 있는 모든 데이터를 이름순으로 가져와
idx, name, id, pass, birth를 테이블 형태로 출력하도록 코드를 추가해 줘.
이때 mysqli_query($conn, $sql); 형태로 코드를 만들어 줘.

$data =mysqli_fetch_array(); 형태로 코드를 생성해 줘.
<?php
    include "head.php";
    include "db.php";
?>
<div class="container">
    <div class="row">
        <div class="col colLine">DB 테스트</div>
    </div>
</div>
<?php 
    include "tail.php";
?>


w3schools.com

my_user_table이 다음과 같이 정의되어 있어.

CREATE TABLE my_user_table (
    idx INT AUTO_INCREMENT PRIMARY KEY,   -- 기본 키이자 자동 증가 필드
    id VARCHAR(50) NOT NULL UNIQUE,       -- 사용자 아이디, 유일한 값
    name VARCHAR(100) NOT NULL,           -- 사용자 이름
    pass VARCHAR(255) NOT NULL,           -- 사용자 비밀번호
    birth DATE                            -- 생년월일 정보
);


이때 13.php는 DB연결등을 다음과 같이 성공한 상태를 확인했어.

<?php
    include "head.php";
    include "db.php";

    // 데이터베이스 연결 확인
    $conn = connectDB();

    include "menu.php";

    include "dbtest.php";

    // 연결 종료
    mysqli_close($conn);
    include "tail.php";
?>

dbtest.php를 다음 조건에 맞게 제시해 줘.

제목: db정보 with ChatGPT
목록은 my_user_table에서 이름의 오름차순으로 모든 데이터를 가져와
table형태로 보여줘.
테이블의 목록은 idx, name, id, birth를 가져옴.




my_user_table이 다음과 같이 정의되어 있어.

CREATE TABLE my_user_table (
    idx INT AUTO_INCREMENT PRIMARY KEY,   -- 기본 키이자 자동 증가 필드
    id VARCHAR(50) NOT NULL UNIQUE,       -- 사용자 아이디, 유일한 값
    name VARCHAR(100) NOT NULL,           -- 사용자 이름
    pass VARCHAR(255) NOT NULL,           -- 사용자 비밀번호
    birth DATE                            -- 생년월일 정보
);

이와 같은 데이터베이스 테이블에 삽입 기능을 홈페이지와 연동하기 위한
코드가 13.php에서 include "dbtest.php"가 다음과 같이 만들어져 있다.

<div class="container mt-5">
    <h2>db정보 with ChatGPT</h2>

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

테이블 위에 id, name, birth, pass를 입력받아 데이터베이스에 추가하는
FORM을 만들고 기능을 완성해 줘.