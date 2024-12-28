// idiom.js

// 사자성어 데이터 배열
const idioms = [
    { title: "學而時習", meaning: "배우고 때로 익힌다는 뜻으로, 배운 것을 복습하고 연습하면 그 참 뜻을 알게 된다는 말입니다." },
    { title: "愛人者人恒愛之", meaning: "남을 사랑하는 사람은 항상 남으로부터 사랑을 받는다." },
    { title: "知行合一", meaning: "아는 것과 행하는 것이 하나로 일치해야 한다는 뜻입니다." },
    { title: "和而不同", meaning: "서로 조화롭지만 꼭 같을 필요는 없다는 뜻입니다." }
  ];
  
  function updateIdiom(elementIdTitle, elementIdMeaning) {
    const today = new Date();
    const dayIndex = today.getDate() % idioms.length; // 일별로 인덱스 계산
  
    // 오늘의 사자성어와 뜻
    const todaysIdiom = idioms[dayIndex];
    document.getElementById(elementIdTitle).innerText = todaysIdiom.title;
    document.getElementById(elementIdMeaning).innerText = todaysIdiom.meaning;
  }
  