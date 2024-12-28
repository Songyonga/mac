import requests
import pymysql
import json
import time

# API 요청 설정
API_URL = "https://stdict.korean.go.kr/api/search.do"
API_KEY = "088FD96108809E96BA9505E7D2D56F7C"  # 발급받은 API 키 입력

# MySQL 연결 설정
db = pymysql.connect(
    host="localhost",        # MySQL 서버 주소
    user="yong",             # 사용자 이름
    password="1111",         # 비밀번호 (필요 시 입력)
    database="user_system",  # 데이터베이스 이름
    charset="utf8mb4"        # 한글 저장을 위해 utf8mb4 설정
)

cursor = db.cursor()

# 한자 데이터 저장 함수
def save_to_mysql(hanja, meaning, pronunciation):
    try:
        sql = "INSERT INTO hanzadata_all (hanja, meaning, pronunciation) VALUES (%s, %s, %s)"
        cursor.execute(sql, (hanja, meaning, pronunciation))
        db.commit()
        print(f"{hanja} 저장 완료")
    except Exception as e:
        print(f"저장 오류: {e}")
        db.rollback()

# API 호출 및 데이터 저장 함수
def fetch_hanja_data(query):
    params = {
        "key": API_KEY,
        "q": query,
        "req_type": "json",
        "num": 10  # 최대 검색 결과 수
    }
    
    response = requests.get(API_URL, params=params)
    
    # 응답 상태 코드와 텍스트 확인
    print(f"API 요청: {query}, 상태 코드: {response.status_code}")
    if response.status_code == 200:
        try:
            data = response.json()  # JSON 형식으로 변환 시도
            print(f"응답 데이터(JSON): {data}")  # 디버깅용 출력
            # JSON에서 데이터 추출
            items = data.get("channel", {}).get("item", [])
            if not items:
                print(f"'{query}'에 대한 검색 결과가 없습니다.")
                return
            for item in items:
                hanja = item.get("word")  # 한자
                sense = item.get("sense", {})
                meaning = sense.get("definition", "")  # 뜻
                pronunciation = sense.get("origin", "")  # 음
                
                # MySQL에 저장
                save_to_mysql(hanja, meaning, pronunciation)
        except json.JSONDecodeError:
            print(f"'{query}'에 대한 응답 디코딩 실패. 응답 내용:")
            print(response.text)  # 디코딩 실패 시 응답 내용 출력
    else:
        print(f"API 요청 실패: {response.status_code}, 응답 내용: {response.text}")

# 한자 목록 예시
hanja_list = ["學", "愛", "友", "家", "天", "地", "人", "中"]  # 필요한 한자 목록 입력

# 데이터 가져오기 및 저장
for hanja in hanja_list:
    fetch_hanja_data(hanja)
    time.sleep(0.2)  # 요청 간 간격(초당 5회 제한을 피하기 위해 대기 시간 추가)

# MySQL 연결 종료
cursor.close()
db.close()

# JSON 파일로 저장 (추가 데이터 저장 예시)
def save_to_json(file_name="hanja_data.json"):
    try:
        cursor.execute("SELECT hanja, meaning, pronunciation FROM hanzadata_all")
        rows = cursor.fetchall()
        data = [{"hanja": row[0], "meaning": row[1], "pronunciation": row[2]} for row in rows]
        
        with open(file_name, "w", encoding="utf-8") as json_file:
            json.dump(data, json_file, ensure_ascii=False, indent=4)
        print(f"JSON 파일로 저장 완료: {file_name}")
    except Exception as e:
        print(f"JSON 저장 실패: {e}")

# JSON 파일로 저장 호출
save_to_json()
