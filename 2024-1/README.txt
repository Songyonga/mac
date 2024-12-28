이 파일을 수시로 확인하세요.
작업하는 순서를 알 수 있도록 이곳을 통해 정보가 제공됩니다.
2024-03-20
고전종합DB 운양집 속 4권 링크
https://db.itkc.or.kr/dir/item?itemId=MO#dir/node?grpId=&itemId=MO&gubun=book&depth=5&cate1=H&cate2=&dataGubun=%EC%B5%9C%EC%A2%85%EC%A0%95%EB%B3%B4&dataId=ITKC_MO_0650A_0240_070_0050

2024-06-05(수) - 데이터베이스
아이디, 이름, 생년월일
http://localhost/phpmyadmin

create table users(
    idx int(10) auto_increment,
    id  char(20) unique,
    name    char(20),
    birth   date,
    primary key(idx)
);


삽입(Insert)

insert into users(id, name, birth) values ('test', '테스트', '2000-01-01');
insert into users(id, name, birth) values ('kdhong', '홍길동', '2010-02-07');
insert into users(id, name, birth) values ('sslee', '이순신', '1935-03-09');
insert into users(id, name, birth) values ('kim', '김개똥', '2001-01-01');

검색(Select)

select * from users;
select * from users order by name asc;


select * from users where birth>'2000-01-05';



갱신(Update)

update users set id='xyz' where idx='3';


삭제(Delete)
delete from users where idx='3';


동영상 강의 : http://naver.me/GxNgScqA
Git hub : https://github.com/eurekasolution/cnudc

로또 프로그램을 PHP로 다음 조건을 만족하도록 만들어줘.
- 몇 게임 할 것인지 사용자한테 입력을 받는다.
- 게임 수 만큼 1~45까지 랜덤한 값을 6회 뽑는다.
- 6개의 숫자에는 중복이 허용되지 않음
- 각 6개를 오름차순으로 정렬
- 10 미만의 수는 03과 같은 형태로 출력해 줘.



w3schools.com
2024-04-03

    key : 	bb3f82f2d9b250ce96ad9e74cbb316eb
    
2024-03-13(수)
    필요한 검색 : 
        네이버 : 지식백과 논어집주
        네이버 : 애국가 가사

1. 동해물과 백두산이 마르고 닳도록
하느님이 보우하사 우리나라 만세
무궁화 삼천리 화려 강산
대한 사람 대한으로 길이 보전하세

2. 남산 위에 저 소나무 철갑을 두른 듯
바람 서리 불변함은 우리 기상일세
무궁화 삼천리 화려 강산
대한 사람 대한으로 길이 보전하세

3. 가을 하늘 공활한데 높고 구름 없이
밝은 달은 우리 가슴 일편단심일세
무궁화 삼천리 화려 강산
대한 사람 대한으로 길이 보전하세

4. 이 기상과 이 맘으로 충성을 다하여
괴로우나 즐거우나 나라 사랑하세
무궁화 삼천리 화려 강산
대한 사람 대한으로 길이 보전하세


test
수업중 생성되는 코드는 실시간으로 github를 통해 배포되면
필요시 "커밋(commit) 해 주세요"라고 말씀하시면,
강의자용 컴퓨터와 환경을 똑같이 할 수 있습니다.

주소는 https://github.com/eurekasolution/cnudc 입니다.