<!DOCTYPE html>
<html lang="ko">
<head>
  <title>로그인 페이지</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom CSS for styling -->
  <style>
    body {
      background-color: #f8f9fa;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .login-container {
      background-color: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
      max-width: 400px;
      width: 100%;
    }
    .form-label {
      font-size: 14px;
      font-weight: bold;
    }
    .form-control {
      height: 45px;
      font-size: 14px;
    }
    .login-options {
      display: flex;
      justify-content: space-between;
      margin-top: 15px;
    }
    .login-options a {
      font-size: 12px;
      color: #6c757d;
    }
    .checkbox label {
      font-size: 12px;
      color: #6c757d;
    }
    .divider {
      display: flex;
      align-items: center;
      text-align: center;
      margin: 20px 0;
    }
    .divider::before, .divider::after {
      content: '';
      flex: 1;
      border-bottom: 1px solid #ddd;
    }
    .divider:not(:empty)::before {
      margin-right: .25em;
    }
    .divider:not(:empty)::after {
      margin-left: .25em;
    }
    .social-login-container {
      margin-top: 30px;
    }
    .social-btn {
      display: flex;
      justify-content: space-between;
    }
    .social-btn .btn {
      width: 32%;
      font-weight: bold;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .btn-kakao {
      background-color: #fee500;
      color: black;
    }
    .btn-google {
      background-color: #4285f4;
      color: white;
    }
    .btn-naver {
      background-color: #03c75a;
      color: white;
    }
    /* 상단 로고 스타일 */
    .logo {
      position: absolute;
      top: 20px;
      left: 20px;
      font-family: 'Nanum Gothic', sans-serif;
      font-weight: bold;
      font-size: 18px;
      color: #333;
    }
  </style>
</head>
<body>


    <!-- 상단 로고 텍스트 (진한 글씨 및 파란색 밑줄) -->
    <div class="mb-4" style="position: absolute; top: 10px; left: 10px; font-size: 12px; color: #555;">
     <a href="test.php" style="text-decoration: none; color: inherit;">
      <span style="text-color: #007bff; text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;font-weight: bold; font-size: 18px;">한문학</span><span style="text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;">의 <span style="text-decoration: underline; text-decoration-color: #007bff; text-decoration-thickness: 2px;">모든 것</span>
        </a>
    </div>

  <div class="login-container">
    <!-- 로그인 폼 -->
    <h2 class="text-center">로그인</h2>
    <form action="process_login.php" method="post">
      <div class="mb-3">
        <label for="email" class="form-label">이메일</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="이메일을 입력하세요" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">비밀번호</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="비밀번호를 입력하세요" required>
      </div>
      <div class="form-check mb-3">
        <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe">
        <label class="form-check-label" for="rememberMe">로그인 상태 유지</label>
      </div>
      <button type="submit" class="btn btn-primary w-100">로그인</button>
    </form>

    <!-- 회원가입/아이디 찾기 링크 -->
    <div class="login-options">
      <a href="#">회원가입</a>
      <a href="#">아이디/비밀번호 찾기</a>
    </div>

    <div class="divider">또는</div>

    <!-- 소셜 로그인 버튼 -->
    <div class="social-login-container">
      <div class="social-btn">
        <a href="#" class="btn btn-kakao">카카오</a>
        <a href="#" class="btn btn-google">구글</a>
        <a href="#" class="btn btn-naver">네이버</a>
      </div>
    </div>

  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
