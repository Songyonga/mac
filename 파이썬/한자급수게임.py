import tkinter as tk
import mysql.connector
import random
import re  # 정규식을 이용해 공백 및 기호 제거

# MySQL 데이터 가져오기 함수
def load_questions(level):
    try:
        connection = mysql.connector.connect(
            host='localhost',
            user='yong',
            password='1111',
            database='user_system'
        )
        cursor = connection.cursor(dictionary=True)
        query = f"SELECT hanja, mean, sound FROM han_level2 WHERE level = '{level}';"
        cursor.execute(query)
        results = cursor.fetchall()
        return results
    except mysql.connector.Error as e:
        print(f"Database Error: {e}")
        return []
    finally:
        if 'connection' in locals() and connection.is_connected():
            cursor.close()
            connection.close()

# 정답 처리 함수 (공백 및 기호 제거)
def normalize_answer(answer):
    return re.sub(r'[^\w]', '', answer).strip()

# 틀린 문제 저장
wrong_answers = {}

# 홈 화면 생성
def create_home():
    for widget in root.winfo_children():
        widget.destroy()

    tk.Label(root, text="한자 퀴즈 게임", font=("Helvetica", 24)).pack(pady=20)

    # 급수 선택
    tk.Label(root, text="급수를 선택하세요:", font=("Helvetica", 16)).pack(pady=10)
    levels = ["8", "7급II"]
    for level in levels:
        tk.Button(root, text=level, font=("Helvetica", 14),
                  command=lambda l=level: select_mode(l)).pack(pady=5)

        # 틀린 문제가 있는 경우 '다시 풀기' 버튼 추가
        if level in wrong_answers and wrong_answers[level]:
            tk.Button(root, text=f"{level} 틀린 문제 다시 풀기", font=("Helvetica", 12),
                      command=lambda l=level: start_game(l, "틀린 문제")).pack(pady=2)

# 게임 모드 선택 화면
def select_mode(level):
    for widget in root.winfo_children():
        widget.destroy()

    tk.Label(root, text=f"선택된 급수: {level}", font=("Helvetica", 20)).pack(pady=20)
    tk.Label(root, text="게임 모드를 선택하세요:", font=("Helvetica", 16)).pack(pady=10)

    modes = [("뜻 맞추기", "뜻"), ("음 맞추기", "음"), ("둘 다 맞추기", "둘다")]
    for mode_text, mode_value in modes:
        tk.Button(root, text=mode_text, font=("Helvetica", 14),
                  command=lambda m=mode_value: start_game(level, m)).pack(pady=5)

    tk.Button(root, text="홈으로 돌아가기", font=("Helvetica", 12), command=create_home).pack(pady=20)

def start_game(level, mode):
    for widget in root.winfo_children():
        widget.destroy()

    if mode == "틀린 문제":
        questions = wrong_answers.get(level, [])
    else:
        questions = load_questions(level)

    if not questions:
        tk.Label(root, text="문제를 불러오지 못했습니다.", font=("Helvetica", 14), fg="red").pack(pady=20)
        tk.Button(root, text="홈으로 돌아가기", font=("Helvetica", 12), command=create_home).pack(pady=20)
        return

    state = {
        "questions": questions[:],  # 중복 없이 모든 문제 사용
        "current": None,
        "remaining": len(questions),
        "correct": 0,
        "total": len(questions),
        "level": level,
        "mode": mode,
        "wrong": [],
        "waiting_for_confirmation": False
    }

    def next_question():
        if state["remaining"] <= 0:
            finish_game()
            return

        state["current"] = state["questions"].pop(0)  # 순차적으로 문제 제거
        state["remaining"] -= 1
        hanja_label.config(text=state["current"]["hanja"])
        result_label.config(text="")
        confirm_button.pack_forget()
        entry.delete(0, tk.END)
        remaining_label.config(text=f"남은 문제: {state['remaining']}")
        state["waiting_for_confirmation"] = False
        entry.focus()

    def check_answer(event=None):
        if state["waiting_for_confirmation"]:
            return  # 확인 버튼이 눌릴 때까지 대기

        # 엔터키만 처리
        if event and event.keysym != "Return":
            return

        user_answer = normalize_answer(entry.get())  # 입력값 정규화
        correct_answer = ""

        if state["mode"] == "뜻":
            correct_answer = normalize_answer(state["current"]["mean"])
        elif state["mode"] == "음":
            correct_answer = normalize_answer(state["current"]["sound"])
        else:
            correct_answer = normalize_answer(
                f"{state['current']['mean']}, {state['current']['sound']}"
            )

        if user_answer == correct_answer:
            state["correct"] += 1
            result_label.config(text="정답입니다! 😊", fg="green")
            next_question()
        else:
            state["wrong"].append(state["current"])
            result_label.config(text=f"오답입니다! 정답: {state['current']['mean']}, {state['current']['sound']}", fg="red")
            state["waiting_for_confirmation"] = True
            confirm_button.pack(pady=10)

    def finish_game():
        for widget in root.winfo_children():
            widget.destroy()

        score = state["correct"]
        total = state["total"]
        wrong_answers[state["level"]] = state["wrong"]

        tk.Label(root, text=f"점수: {score}/{total}", font=("Helvetica", 20), fg="blue").pack(pady=20)

        if state["wrong"]:
            tk.Label(root, text=f"틀린 문제: {len(state['wrong'])}개", font=("Helvetica", 14), fg="red").pack(pady=10)

        tk.Button(root, text="홈으로 돌아가기", font=("Helvetica", 12), command=create_home).pack(pady=20)

    # 게임 화면
    tk.Label(root, text=f"{level} - {mode} 모드", font=("Helvetica", 20)).pack(pady=10)
    remaining_label = tk.Label(root, text=f"남은 문제: {state['remaining']}", font=("Helvetica", 14))
    remaining_label.pack(pady=5)

    hanja_label = tk.Label(root, text="", font=("Helvetica", 48))
    hanja_label.pack(pady=20)

    entry = tk.Entry(root, font=("Helvetica", 18))
    entry.pack(pady=10)
    entry.bind("<KeyRelease>", check_answer)  # 키 릴리즈 이벤트 바인딩
    entry.focus()

    result_label = tk.Label(root, text="", font=("Helvetica", 14))
    result_label.pack(pady=10)

    confirm_button = tk.Button(root, text="확인", font=("Helvetica", 14), command=next_question)

    tk.Button(root, text="홈으로 돌아가기", command=create_home, font=("Helvetica", 12)).pack(pady=20)

    next_question()


# GUI 초기화
root = tk.Tk()
root.title("한자 퀴즈 게임")
create_home()
root.mainloop()
