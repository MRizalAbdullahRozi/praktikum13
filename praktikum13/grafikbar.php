<?php
include('koneksi.php');
$negara = mysqli_query($koneksi,"select * from tb_negara");
while($row = mysqli_fetch_array($negara)){
	$nama_negara[] = $row['nama_negara'];
	$query = mysqli_query($koneksi,"select total_case  from tb_case where id_negara='".$row['id_negara']."'");
	$row = $query->fetch_array();
	$total_case[] = $row['total_case'];
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Grafik Total  Case</title>
	<script type="text/javascript" src="Chart.js"></script>
</head>
<body>
	<div style="width: 800px;height: 800px">
		<canvas id="myChart"></canvas>
	</div>

	<script>
		var ctx = document.getElementById("myChart").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: <?php echo json_encode($nama_negara); ?>,
				datasets: [{
					label: 'Grafik Total Case Covid-19 (10 Negara)',
					data: <?php echo json_encode($total_case); ?>,
					backgroundColor: 'rgb(0, 255, 254)',
					borderColor: 'rgba(255,99,132,1)',
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});
	</script>
</body>
</html>