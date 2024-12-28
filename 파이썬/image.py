import os
import pytesseract
from PIL import Image

# Tesseract가 언어 데이터를 찾을 수 있도록 환경 변수 설정
os.environ['TESSDATA_PREFIX'] = '/opt/homebrew/share/'

# 이미지 파일 열기 (경로에 맞춰 수정)
image = Image.open()  # 예시 경로

# 이미지에서 텍스트 추출
text = pytesseract.image_to_string(image, lang='kor')  # 'kor' 옵션으로 한국어 인식

# 텍스트 파일로 저장
output_path = '/Users/song-yong-a/Desktop/extracted_text.txt'
with open(output_path, 'w', encoding='utf-8') as f:
    f.write(text)

print("텍스트가 다음 경로에 저장되었습니다:", output_path)
