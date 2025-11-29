<?php
$timezone = 'America/Asuncion';
date_default_timezone_set($timezone);
?>
<!doctype html>
<html lang="en" dir="ltr">
	<head>
		<?php require_once('admin/includes/script.php') ?>
		<title>Sistema de Gestión de Perfiles y Nómina</title>
		<link rel="icon" href="favicon.ico" type="image/x-icon"/>
		<!-- Dashboard Core -->
		<link href="./assets/css/dashboard.css" rel="stylesheet" />
		<script src="js/vue.js"></script>
	
	</head>

	<body class="" >
		<div class="page" id="app">
			<div class="page-single">
				<div class="container">
					<div class="text-center" style="margin-bottom:12px;">
						<img src="assets/images/Logo/573731156_17915151642213024_7390212680820214453_n.png" alt="logo" class="img-responsive center-block" style="max-width:300px; height:auto;">
					</div>
					<div style="padding-bottom: 20px;" class="text-center">
						<h1 id="date"></h1>
						<h1 class="text" id="time"></h1>
					</div>

					<div class="">
						<center>
							<div>
								<h4 class="timein">Tiempo de entrada vespertina</h4>
							</div>
							<div class="col-md-4">
								<div class="form-group">
								<form v-on:submit.prevent="TimeInAfternoon">
									<input type="text" required="true"  v-model="time_in_afternoon" class="form-control" id="employee-id" placeholder="Identificación de Empleado" autofocus="true">
								</form>
								</div>						
							</div>
						</center>
					</div>
				</div>
			</div>
				<a href="admin" target="_blank" class="btn">Panel de Control</a>
			</div>
		</div>
	</div>
	
	<!-- jQuery 3 -->
	<script src="bower_components/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- Moment JS -->
	<script src="bower_components/moment/moment.js"></script>
	<script src="bower_components/moment/locale/es.js"></script>

	<script src="js/model.js"></script>
	
	<script type="text/javascript">
	$(function() {
		moment.locale('es');
		var interval = setInterval(function() {
			var momentNow = moment();
			$('#date').html(momentNow.format('dddd').substring(0,3).toUpperCase() + ' - ' + momentNow.format('D [de] MMMM, YYYY'));
			$('#time').html(momentNow.format('hh:mm:ss A'));
		}, 100);
	});
	</script>
</body>
</html>