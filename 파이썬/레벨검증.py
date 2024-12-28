import pandas as pd
import pymysql

# MySQL 데이터베이스 설정
db_config = {
    'host': 'localhost',  # MySQL 호스트
    'user': 'yong',       # MySQL 사용자 이름
    'password': '1111',  # MySQL 비밀번호
    'database': 'user_system',  # MySQL 데이터베이스 이름
    'charset': 'utf8mb4'
}

# 엑셀 파일 경로 설정
input_file = '/Applications/XAMPP/xamppfiles/htdocs/파이썬/1gram.xlsx'
output_file = '/Applications/XAMPP/xamppfiles/htdocs/파이썬/hanzalevel.xlsx'

# 엑셀 데이터 읽기
data = pd.read_excel(input_file)

# MySQL 데이터베이스 연결
try:
    connection = pymysql.connect(**db_config)
    cursor = connection.cursor()
    print("데이터베이스에 연결되었습니다.")
except Exception as e:
    print(f"데이터베이스 연결 실패: {e}")
    exit()

# 급수 검증 함수
def get_hanja_level(hanja):
    try:
        # SQL 쿼리 실행 (hanzadata와 level 연결)
        query = """
            SELECT level.title 
            FROM hanzadata
            JOIN level ON hanzadata.level_id = level.id
            WHERE hanzadata.content LIKE %s
        """
        cursor.execute(query, ('%' + hanja + '%',))
        result = cursor.fetchone()
        if result:
            return result[0]  # title (급수명) 반환
        else:
            return "해당 없음"
    except Exception as e:
        print(f"Error for {hanja}: {e}")
        return "오류"

# 급수 데이터를 엑셀에 추가
try:
    data['한자급수'] = data['1-그램'].apply(get_hanja_level)
except KeyError as e:
    print(f"엑셀 컬럼 오류: {e}")
    cursor.close()
    connection.close()
    exit()

# MySQL 연결 종료
cursor.close()
connection.close()

# 결과를 엑셀 파일로 저장
try:
    data.to_excel(output_file, index=False)
    print(f"결과가 저장되었습니다: {output_file}")
except Exception as e:
    print(f"엑셀 저장 오류: {e}")
