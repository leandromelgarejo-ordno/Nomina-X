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
	
	</head>
	<body class="">
		<div class="page">
			<div class="page-single">
				<div class="container">
					<div style="text-align: center;">
						
						<img src="assets/images/Logo/573731156_17915151642213024_7390212680820214453_n.png" alt="logo" style="width: 300px;">

					</div>
					<div style="padding-bottom: 20px;" class="text-center">
						<h1 id="date"></h1>
						<h1 class="text" id="time"></h1>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="card">
								<div class="card-header">
									<h3 class="card-title"><b>Asistencia Matutina</b> <i class="fe fe-sunrise"></i></h3>
									<div class="card-options">
										<a href="time-in-morning.php" class="btn btn-primary btn-sm" >Entrada</a>
										<a href="time-out-morning.php" class="btn btn-warning btn-sm ml-2">Salida</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="card">
								<div class="card-header">
									<h3 class="card-title"><b>Asistencia Vespertina</b> <i class="fe fe-sunset"></i></h3>
									<div class="card-options">
										<a href="time-in-afternoon.php" class="btn btn-primary btn-sm">Entrada</a>
										<a href="time-out-afternoon.php" class="btn btn-warning btn-sm ml-2">Salida</a>
									</div>
								</div>
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
	<script type="text/javascript">
	$(function() {
		moment.locale('es');
		var interval = setInterval(function() {
			var momentNow = moment();
			$('#date').html(momentNow.format('dddd').substring(0,3).toUpperCase() + ' - ' + momentNow.format('D [de] MMMM, YYYY'));
			$('#time').html(momentNow.format('hh:mm:ss A'));
		}, 100);
	});
	
	e.preventDefault();
	var attendance = $(this).serialize();
	$.ajax({
	type: 'POST',
	url: 'attendance.php',
	data: attendance,
	dataType: 'json',
	success: function(response){
	if(response.error){
	$('.alert').hide();
	$('.alert-danger').show();
	$('.message').html(response.message);
	}
	else{
	$('.alert').hide();
	$('.alert-success').show();
	$('.message').html(response.message);
	$('#employee').val('');
	}
	}
	});
	
	
	</script>
</body>
</html>