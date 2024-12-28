<!DOCTYPE html>
<html lang="ko">
<head>
  <title>Bootstrap 5 Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <link href="style.css" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

</head>
<body>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', '휴학생', '입학생', '졸업생'],
          ['2019',  1000,      400, 300],
          ['2020',  1170,      460, 800],
          ['2021',  660,       1120, 0],
          ['2022',  1030,      540, 550],
          ['2023',  1030,      540, 270],
          ['2024',  1030,      540, 330]
        ]);

        var options = {
          title: '한문학과 학생 분포',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>

<div class="container">
    <div class="row">
      <div class="col colLine">구글차트</div>
    </div>
    <div class="row">
      <div class="col colLine">
      <div id="curve_chart" style="width: 100%; height: 500px"></div>
      </div>
</div>
           
     
</body>
</html>