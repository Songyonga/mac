import requests
import pandas as pd
from bs4 import BeautifulSoup
import time
from datetime import datetime, timedelta
from urllib.parse import quote

# 네이버 API 인증 정보
client_id = 'LbXlFSKlFA66EYyD6yzG'
client_secret = 'aZUHeFjTgR'

# 검색어와 기간 설정
query = quote("SK하이닉스 HBM AI가속기 엔비디아")
today = datetime.now()
start_date = today - timedelta(days=30)

# 뉴스 데이터 저장할 빈 리스트
all_items = []

# 날짜별로 1일 단위로 이동하면서 데이터 수집
current_date = start_date
while current_date <= today:
    # API 호출 URL (날짜별로 100개씩 수집)
    url = f"https://openapi.naver.com/v1/search/news.json?query={query}&display=10&start=1&sort=date"
    headers = {
        'X-Naver-Client-Id': client_id,
        'X-Naver-Client-Secret': client_secret
    }

    # API 요청
    response = requests.get(url, headers=headers)
    if response.status_code == 200:
        data = response.json()
        items = data.get('items', [])
        if items:
            all_items.extend(items)  # 수집한 기사를 리스트에 추가
        else:
            break  # 더 이상 기사가 없으면 종료
    else:
        print(f"API 호출 오류: {response.status_code}")
    time.sleep(1)  # API 호출 사이에 대기 시간 설정
    current_date += timedelta(days=1)  # 날짜를 하루씩 증가

# 데이터프레임으로 변환 및 날짜 필터링
df = pd.DataFrame(all_items)
df = df[['title', 'originallink', 'pubDate']]
df['pubDate'] = pd.to_datetime(df['pubDate'])
df = df[(df['pubDate'] >= start_date.strftime('%Y-%m-%d'))]

# 본문 추출 함수 정의 및 본문 추가
def get_article_content(soup):
    search_patterns = [
        ('div', 'article-content'),
        ('div', 'content'),
        ('p', 'text'),
        ('article', None),
        ('div', 'post-content'),
        ('div', 'entry-content'),
        ('section', 'article-body'),
        ('div', 'main-content')
    ]
    for tag, class_name in search_patterns:
        if class_name:
            content = soup.find(tag, {'class': class_name})
        else:
            content = soup.find(tag)
        if content:
            return content.get_text(strip=True)
    return "본문 없음"

# 각 링크에 접속하여 본문 추출
contents = []
for link in df['originallink']:
    response = requests.get(link)
    soup = BeautifulSoup(response.text, 'html.parser')
    content = get_article_content(soup)
    contents.append(content)
    time.sleep(1)

df['content'] = contents

# SK하이닉스와 HBM 관련성이 높은 기사만 필터링
df_filtered = df[(df['title'].str.contains("SK하이닉스", case=False) | df['content'].str.contains("SK하이닉스", case=False, na=False)) &
                 (df['title'].str.contains("HBM", case=False) | df['content'].str.contains("HBM", case=False, na=False))]

# 결과를 새로운 CSV 파일로 저장
df_filtered.to_csv('/Users/song-yong-a/Desktop/sk_hynix_filtered_news_with_content.csv', index=False, encoding='utf-8-sig')
print("필터링된 기사들이 CSV 파일로 저장되었습니다.")
