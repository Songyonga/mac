import pymysql
from fuzzywuzzy import fuzz
import random
import readline  # 입력 처리를 개선하기 위해 추가

# 데이터베이스 연결 설정
def get_connection():
    try:
        return pymysql.connect(
            host='localhost',  # 데이터베이스 호스트
            user='yong',       # 사용자명
            password='1111',  # 비밀번호
            database='user_system',  # 데이터베이스 이름
            charset='utf8mb4',
        )
    except pymysql.MySQLError as e:
        print(f"데이터베이스 연결에 실패했습니다: {e}")
        return None

# 랜덤으로 한자 문제 가져오기
def get_random_hanja_question():
    connection = get_connection()
    if not connection:
        return None

    try:
        with connection.cursor() as cursor:
            # 랜덤으로 한자와 정답(훈, 음) 가져오기
            sql = "SELECT hanja, CONCAT(mean, ' ', sound) AS answer FROM han_level2 ORDER BY RAND() LIMIT 1"
            cursor.execute(sql)
            result = cursor.fetchone()
            if result:
                return {'hanja': result[0], 'answer': result[1]}  # {'hanja': '家', 'answer': '집 가'}
            else:
                print("데이터가 없습니다.")
                return None
    finally:
        connection.close()

# 문자열 유사도 기반 정답 확인
def check_answer(user_input, correct_answer):
    user_input = user_input.replace(' ', '')  # 띄어쓰기 제거
    correct_answer = correct_answer.replace(' ', '')
    similarity = fuzz.ratio(user_input, correct_answer)  # 유사도 계산
    return similarity >= 70  # 유사도 70% 이상이면 정답 처리

# 테스트 실행
def main():
    correct_count = 0
    total_questions = 10

    for i in range(total_questions):
        question = get_random_hanja_question()
        if not question:
            print("문제를 가져올 수 없습니다.")
            continue

        hanja = question['hanja']
        correct_answer = question['answer']

        print(f"문제 {i + 1}: {hanja}")
        try:
            user_input = input("훈/음을 입력하세요: ")
        except KeyboardInterrupt:
            print("\n입력을 취소했습니다. 다음 문제로 넘어갑니다.")
            continue

        if check_answer(user_input, correct_answer):
            print("정답입니다!")
            correct_count += 1
        else:
            print(f"오답입니다. 정답은: {correct_answer}")

    print(f"총 {total_questions}문제 중 {correct_count}문제를 맞췄습니다.")

if __name__ == "__main__":
    main()