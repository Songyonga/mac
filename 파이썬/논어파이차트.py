import pandas as pd
import matplotlib.pyplot as plt

# 엑셀 파일 경로와 시트 이름
file_path = '/Applications/XAMPP/xamppfiles/htdocs/ngram분석.xlsx'
sheet_name = '2-그램'  # 읽어올 시트 이름

# 엑셀 파일 읽기 (특정 시트 지정)
data = pd.read_excel(file_path, sheet_name=sheet_name)

# 컬럼 이름 설정
hanzi_column = '한자'  # 한자 컬럼
frequency_column = '빈도수'  # 빈도수 컬럼

# 빈도수 데이터를 숫자로 변환
data[frequency_column] = pd.to_numeric(data[frequency_column], errors='coerce')

# 숫자가 아닌 값 제거 (NaN 처리된 행 제거)
data = data.dropna(subset=[frequency_column])

# 10개 미만 데이터 제외
data = data[data[frequency_column] >= 10]

# 새로운 범위 정의와 라벨
bins = [10, 16, 21, max(data[frequency_column]) + 1]  # 새로운 범위 정의 (10 이상만)
labels = ['10-15', '16-20', '20+']  # 새로운 범위 라벨
data['Frequency Range'] = pd.cut(data[frequency_column], bins=bins, labels=labels, right=False)

# 범위별 빈도수 카운트
range_counts = data['Frequency Range'].value_counts().sort_index()

# 퍼센트와 개수 표시를 위한 함수
def autopct_format(pct, all_vals):
    total = sum(all_vals)
    absolute = int(round(pct * total / 100.0))  # 실제 개수 계산
    return f"{pct:.1f}%\n({absolute}개)"

# 파이 차트 생성
plt.figure(figsize=(8, 8))
plt.pie(
    range_counts, 
    labels=range_counts.index, 
    autopct=lambda pct: autopct_format(pct, range_counts.values), 
    startangle=140, 
    colors=plt.cm.tab10.colors
)
plt.title("2-그램 한자 빈도수 분포 (10개 이상)")
plt.show()

# 범위별 카운트 결과를 엑셀로 저장
output_path = '/Applications/XAMPP/xamppfiles/htdocs/ngram분석_결과.xlsx'
range_counts.to_excel(output_path, sheet_name='2-그램 Frequency Distribution')
print(f"범위별 빈도수 데이터가 {output_path}에 저장되었습니다.")
