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
<script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
    <script type='text/javascript'>
     google.charts.load('current', {
       'packages': ['geochart'],
       // Note: Because markers require geocoding, you'll need a mapsApiKey.
       // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
       'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'
     });
     google.charts.setOnLoadCallback(drawRegionsMap);

      function drawRegionsMap() {
      var data = google.visualization.arrayToDataTable([
        ['Province',   'Value'],
        ['KR-11',  1000],
        ['KR-30', 140],
        ['KR-26',  600]
      ]);

      // KR-30110 , 30140, 170, 210, 240

      var options = {
        sizeAxis: { minValue: 0, maxValue: 1200 },
        region: 'KR', // Western Europe
        displayMode: 'regions',
        resolution: 'provinces',
        colorAxis: {colors: ['#FFFFFF', '#FF0000']} // orange to blue
      };

      var chart = new google.visualization.GeoChart(document.getElementById('map_chart'));
      chart.draw(data, options);
    };
    </script>
<div class="container">
  <div class="row">
    <div class="col colLine">구글차트</div>
  </div>
  <div class="row">
    <div class="col colLine">
    <div id="map_chart" style="width: 100%; height: 500px"></div>
    </div>
  </div>
</div> <!-- container -->
</body>
</html>