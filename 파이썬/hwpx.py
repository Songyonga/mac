import csv

# RTF 파일 경로와 출력 CSV 파일 경로
rtf_file = "논어.rtf"  # RTF 파일 경로
csv_file = "논어.csv"   # 변환된 CSV 파일 경로

try:
    # RTF 파일 읽기
    with open(rtf_file, 'r', encoding='utf-8') as file:
        lines = file.readlines()

    # CSV 파일로 쓰기
    with open(csv_file, 'w', encoding='utf-8', newline='') as csv_file:
        writer = csv.writer(csv_file)
        for line in lines:
            # RTF 구분자로 데이터 나누기
            # 수정: 실제 구분자를 "\t"나 다른 구분자로 변경
            row = line.strip().split(r'\tab')  # 기본 예시는 RTF의 '\tab' 구분자
            writer.writerow(row)

    print(f"RTF 데이터를 성공적으로 CSV로 변환했습니다: {csv_file.name}")

except Exception as e:
    print(f"오류 발생: {e}")
