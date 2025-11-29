<?php

if (!isset($_SESSION['official_username']) && !isset($_SESSION['official_password']) && !isset($_SESSION['official_id'])) {
  header("location:index.php?utm_campaign=expired");
}

$model = new Dashboard();
$password = $_SESSION['official_password'];
$username = $_SESSION['official_username'];
$uid = $_SESSION['official_id'];

$connection = $model->TemporaryConnection();

$query = $model->GetAdministrator($username, $password);
$admin = mysqli_fetch_assoc($query);
$id = $admin['id'];
$firstname = $admin['firstname'];
$lastname = $admin['lastname'];
$photo = $admin['photo'];
$create = $admin['created_on'];
$type = $admin['type'];
?>


<?php 


$date = date("Y-m-d");
if($type == "Administrator") {

  echo('<ul class="nav nav-tabs border-0 flex-column flex-lg-row">
  <li class="nav-item">
    <a href="index.php" class="nav-link"><i class="fe fe-home"></i> Nómina</a>
  </li>
  <li class="nav-item">
    <a href="attendance.php?filter='.$date.'" class="nav-link"><i class="fe fe-calendar"></i> Asistencia</a>
  </li>
  <li class="nav-item">
    <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-users"></i> Empleados</a>
    <div class="dropdown-menu dropdown-menu-arrow">
      <a href="overtime.php" class="dropdown-item ">Horas extra</a>
      <a href="advance.php" class="dropdown-item ">Adelanto de efectivo</a>
      <a href="schedule.php" class="dropdown-item ">Horario</a>
    </div>
  </li>
  <li class="nav-item dropdown">
    <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-user"></i> Gestión de perfiles</a>
    <div class="dropdown-menu dropdown-menu-arrow">
      <a href="profile.php" class="dropdown-item ">Perfil del empleado</a>
    </div>
  <li class="nav-item">
    <a href="position.php" class="nav-link"><i class="fe fe-list"></i> Cargos</a>
  </li>
  <li class="nav-item dropdown">
    <a href="scheduling.php" class="nav-link"><i class="fe fe-flag"></i> Horario del empleado</a>
  </li>
</ul>');

} elseif($type == "Secretary") {

  echo('<ul class="nav nav-tabs border-0 flex-column flex-lg-row">
  <li class="nav-item">
    <a href="index.php" class="nav-link"><i class="fe fe-home"></i> Nómina</a>
  </li>
  <li class="nav-item dropdown">
    <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-user"></i> Gestión de perfiles</a>
    <div class="dropdown-menu dropdown-menu-arrow">
      <a href="profile.php" class="dropdown-item ">Perfil del empleado</a>
    </div>

</ul>');

} elseif($type == "Timekeeper") {

  

  echo('

  
  <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
  
  <li class="nav-item">
    <a href="attendance.php?filter='. date("Y-m-d") .'" class="nav-link"><i class="fe fe-calendar"></i> Asistencia</a>
  </li>

</ul>');

}

?>