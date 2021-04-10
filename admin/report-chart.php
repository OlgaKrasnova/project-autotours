
<?php
require_once '../connection.php'; // подключаем скрипт              
// подключаемся к серверу
$link = mysqli_connect($host, $user, $password, $database) 
    or die("Ошибка " . mysqli_error($link)); 
?>

<h1>Полный отчет:</h1>
<div class="filter">
<?php
$sql_dir = mysqli_query($link, "SELECT * FROM direction");
print "<script type='text/javascript'>
google.charts.load('current', {packages:['corechart']});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
  var data = google.visualization.arrayToDataTable([
    ['Task', 'Hours per Day'],";
while($row_dir = mysqli_fetch_array($sql_dir)) { 
    $sql_c_tour = mysqli_query($link, "SELECT COUNT(*) FROM tours WHERE id_direction = ".$row_dir['id_direction']."");
    while($row_c_tour = mysqli_fetch_array($sql_c_tour)) { 
        print "['".$row_dir['name_direction']."', ".$row_c_tour['COUNT(*)']."],";
    }
}
  print "]);
  var options = {
    title: 'Статистика по направлениям:',
    pieHole: 0.4,
  };

  var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
  chart.draw(data, options);
}
</script>";
?>
<div id="donutchart" style="width: 600px; height: 400px;"></div>
<?php
$sql_tour = mysqli_query($link, "SELECT * FROM tours");
print "<script type='text/javascript'>
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
    var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([";
while($row_tour = mysqli_fetch_array($sql_tour)) { 
    $sql_fav = mysqli_query($link, "SELECT COUNT(*) FROM favorites WHERE id_tour = ".$row_tour['id_tour']."");
    while($row_fav = mysqli_fetch_array($sql_fav)) { 
        print "['".$row_tour['title']."',".$row_fav['COUNT(*)']."],";        
    }
}
print "]);
var options = {
    'title': 'Популярность заказов среди пользователей:',
    'width':400,
    'height':300};
var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
chart.draw(data, options);
}
</script>";



?>
<div id="chart_div"></div>
<a class ="print-doc" href="javascript:(print());"><button> Распечатать</button></a>
</div>

