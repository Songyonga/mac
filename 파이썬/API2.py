import requests
from bs4 import BeautifulSoup
import pandas as pd
import time

# CSV 파일에서 뉴스 링크 읽기
df = pd.read_csv('/Users/song-yong-a/Desktop/sk_hynix_news.csv')

# 본문 내용 저장할 리스트 생성
contents = []

# 본문 추출을 위한 함수 정의
def get_article_content(soup):
    # 본문 추출을 시도할 태그와 클래스 조합 리스트
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
    
    # 패턴별로 본문 추출 시도
    for tag, class_name in search_patterns:
        if class_name:
            content = soup.find(tag, {'class': class_name})
        else:
            content = soup.find(tag)
        
        # 본문을 찾으면 반환
        if content:
            return content.get_text(strip=True)
    
    # 본문이 없을 경우 None 반환
    return "본문 없음"

# 각 링크에 접속하여 본문 추출
for link in df['originallink']:
    response = requests.get(link)
    soup = BeautifulSoup(response.text, 'html.parser')

    # 본문 추출 함수 호출
    content = get_article_content(soup)
    contents.append(content)

    # 여러 요청을 보낼 때 서버에 부담을 줄이기 위해 잠시 대기
    time.sleep(1)

# 본문 내용 컬럼 추가
df['content'] = contents

# 결과를 새로운 CSV 파일로 저장
df.to_csv('/Users/song-yong-a/Desktop/sk_hynix_news_with_content.csv', index=False, encoding='utf-8-sig')
print("모든 기사 본문이 CSV 파일로 저장되었습니다.")
