<!DOCTYPE html>
<html lang="ko">
<head>
  <title>Google Chart</title>
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
          ['학년', '인원'],
          ['1학년',     11],
          ['2학년',      2],
          ['3학년',  12],
          ['4학년', 2]
        ]);

        var options = {
          title: '수강생 분포'
        };

        var chart = new google.visualization.PieChart(document.getElementById('pi_chart'));

        chart.draw(data, options);
      }
    </script>


<div class="container">
  <div class="row">
    <div class="col colLine">구글차트</div>
  </div>
  <div class="row">
    <div class="col colLine bg-danger">
    <div id="pi_chart" style="width: 100%; height: 500px"></div>
    </div>
  </div>
</div> <!-- container -->
</body>
</html>