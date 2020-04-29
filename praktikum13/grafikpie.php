<?php
include('koneksi.php');
$negara = mysqli_query($koneksi,"select * from tb_negara");
while($row = mysqli_fetch_array($negara)){
	$nama_negara[] = $row['nama_negara'];
	$query = mysqli_query($koneksi,"select total_case from tb_case where id_negara ='".$row['id_negara']."'");
	$row = $query->fetch_array();
	$total_case[] = $row['total_case'];
}
?>

<!doctype html>
<html>
<head>
	<title>Pie Chart Total Case Covid 19</title>
	<script type="text/javascript" src="Chart.js"></script>
</head>
<body>
	<div id="canvas-holder" style="width:50%">
		<canvas id="chart-area"></canvas>
	</div>
	<script>
		var config = {
			type: 'pie',
			data: {
				datasets: [{
					data:<?php echo json_encode($total_case); ?>,
					backgroundColor: [
					'rgba(0, 255, 254)',
					'rgba(255, 255, 255, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(43, 191, 254)',
					'rgba(355, 102, 0, 0.2)',
					'rgba(127, 255, 1)',
					'rgba(102, 0, 102, 0.2)',
					'rgba(255, 153, 255, 0.2)',
					'rgba(0, 0, 0, 0.2)',
					'rgba(240, 230, 140)'
					],
					borderColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(255, 99, 132, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)',
					'rgba(355, 102, 0, 0.2)',
					'rgba(102, 51, 0, 0.2)',
					'rgba(102, 0, 102, 0.2)',
					'rgba(255, 153, 255, 0.2)',
					'rgba(0, 0, 0, 0.2)',
					'rgba(0, 152, 51, 0.2)'
					],
					label: 'Presentase covid'
				}],
				labels: <?php echo json_encode($nama_negara); ?>},
			options: {
				responsive: true
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('chart-area').getContext('2d');
			window.myPie = new Chart(ctx, config);
		};

		document.getElementById('randomizeData').addEventListener('click', function() {
			config.data.datasets.forEach(function(dataset) {
				dataset.data = dataset.data.map(function() {
					return randomScalingFactor();
				});
			});

			window.myPie.update();
		});

		var colorNames = Object.keys(window.chartColors);
		document.getElementById('addDataset').addEventListener('click', function() {
			var newDataset = {
				backgroundColor: [],
				data: [],
				label: 'New dataset ' + config.data.datasets.length,
			};

			for (var index = 0; index < config.data.labels.length; ++index) {
				newDataset.data.push(randomScalingFactor());
				var colorName = colorNames[index % colorNames.length];
				var newColor = window.chartColors[colorName];
				newDataset.backgroundColor.push(newColor);
			}
 
			config.data.datasets.push(newDataset);
			window.myPie.update();
		});
 
		document.getElementById('removeDataset').addEventListener('click', function() {
			config.data.datasets.splice(0, 1);
			window.myPie.update();
		});
	</script>
</body>
</html>