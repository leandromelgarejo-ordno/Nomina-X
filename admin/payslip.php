<?php 

require_once('includes/script.php');  
require_once('session/Login.php'); 

 $model = new Dashboard();
 $session = new AdministratorSession();
 $session->LoginSession();

 date_default_timezone_get();

 if(!isset($_SESSION['official_username']) && !isset($_SESSION['official_password']) && !isset($_SESSION['official_id'])){
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
$to = date('Y-m-d');
$from = date('Y-m-d', strtotime('-6 day', strtotime($to)));

$id = $_GET['id'];

$select = "SELECT `id` FROM `employees` WHERE `employee_id` = '$id';";
$thisQuery = mysqli_query($connection, $select);
$row = mysqli_fetch_assoc($thisQuery);


 $number = '';
    for($i = 0; $i < 10; $i++){
      $number .= $i;
    }

$number = substr(str_shuffle($number), 0, 9);

$myId = $row['id'];

?>
<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <title>Sistema de Gestión de Perfiles y Nómina</title>
  </head>
  <body class="">
    <div class="page" id="app">
      <div class="page-main">
        <div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
          <div class="container">
            <div class="row align-items-center">
              <div class="d-flex">
                <?php require_once('includes/header.php') ?>
              </div>
              <div class="col-lg order-lg-first">
                <?php require_once('includes/subheader.php') ?> 
              </div>
            </div>
          </div>
        </div>
        <div class="my-3 my-md-5">
          <div class="container">
            <div class="page-header">
              <h1 class="page-title">
                <a href="home.php" class="text-primary">Panel de control</a> <i style="font-size: 20px;" class="fe fe-chevron-right"></i> Recibo de pago
              </h1>
            </div>
              <div style="padding-left: 0; padding-bottom: 25px;" class="dropdown">
                <button type="button" class="btn btn-secondary  " onclick="printPage()">
                   <i class="fe fe-printer mr-2"></i> Imprimir recibo de pago
                </button>
                <div class="dropdown-menu">
                </div>
              </div>             
            <div class="row row-cards">

              <?php require_once('modals/modal_filter_date.php') ?>
              <script type="text/javascript">
              function printPage(){
                  var divElements = document.getElementById('printDataHolder').innerHTML;
                  var oldPage = document.body.innerHTML;
                  document.body.innerHTML="<link rel='stylesheet' href='css/common.css' type='text/css' /><body class='bodytext'><div class='padding'><b style='font-size: 16px;'><p class=''>Recibo de pago generado el <?php echo date("d/n/Y") ?> <?php echo date("G:i A") ?> por <?php echo $firstname ?> <?php echo $lastname ?></p></b></div>"+divElements+"</body>";
                  window.print();
                  document.body.innerHTML = oldPage;
                  }
              </script>
              <div class="col-12" id="printDataHolder">
                

                  <div class="card">
                          <?php 
                          // Calculating the payroll from SAT - FRI (7 Days)

                          $sql = "SELECT *, SUM(num_hr_morning) AS morning, SUM(num_hr_afternoon) AS afternoon, attendance.employee_id AS empid FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id LEFT JOIN position ON position.id=employees.position_id WHERE attendance.employee_id='$myId' AND date BETWEEN '$from' AND '$to' GROUP BY attendance.employee_id ORDER BY employees.fullname ASC";


                          $overtime = "SELECT *, SUM(hours) AS hour, SUM(rate_hour) AS rate_h, COUNT(employee_id) AS tot  FROM overtime WHERE overtime.employee_id='$myId' AND date_overtime BETWEEN '$from' AND '$to';";
                          $otresult = mysqli_query($connection, $overtime);
                     
                          while ($otrow = mysqli_fetch_assoc($otresult)) {
                       
                            $ot=0;
                            //$total = ($otrow['tot']) * 8;

                            $total_ot = $otrow['tot'];
                            if($total_ot == 0){
                             $total_ot = 1; 
                            }

                            if($otrow['tot'] == 0){
                              $total = 8;
                            } else {
                              $total = ($otrow['tot']) * 8;
                            }
                          $gross = ($otrow['rate_h']) / $total_ot * round($otrow['hour'], 1);
                          $ot = $gross;
                         // echo $ot." ";
                             
                          }



                          $sqlPayroll = mysqli_query($connection, $sql);
                          $total = 0;

                          $numbers = 0;

                          while($row = mysqli_fetch_assoc($sqlPayroll)){

                          $numbers++;     

                              $employee_id = $row['empid'];
                              $total_hr = $row['morning'] + $row['afternoon']; // total hour

                              $casql = "SELECT *, SUM(amount) AS cashamount FROM cashadvance WHERE employee_id='$employee_id' AND date_advance BETWEEN '$from' AND '$to'";

                              $caquery = mysqli_query($connection, $casql);
                              $carow = mysqli_fetch_assoc($caquery);

                              $cashadvance = $carow['cashamount'];

                              $gross = $row['rate'] * $total_hr;
                              $net_pay = $gross - $cashadvance;


                          ?>
                <div class="table-responsive push">
                  <table class="table table-bordered table-hover">
                    <tr>
                      <th colspan="8">Recibo de pago de Alca Consultora #<?php echo $number ?></th>

                    </tr>
                    <tr>
                      <td colspan="4">
                        <p class="font-w600 mb-1"><P>Período de pago</P></p>
                   </td>
                      <td colspan="4" class="text-right"><b><?php echo date('F d, Y', strtotime($from)) ?> <b>-</b> <?php echo date('F d, Y', strtotime($to)) ?></b></td>
                    </tr>
                    <tr>
                      <td colspan="4">
                        <p class="font-w600 mb-1">Nombre del empleado</p>
                   </td>
                      <td colspan="4" class="text-right"><b><?php echo $row['fullname'] ?></b></td>
                    </tr>
                    <tr>
                      <td colspan="4">
                        <p class="font-w600 mb-1">Número de empleado</p>
                   </td>
                      <td colspan="4" class="text-right"><b>ID <?php echo $row['employee_id'] ?></b></td>
                    </tr>
                    <tr>
                      <td colspan="4" class="font-w600 text-right">Tarifa</td>
                      <td class="text-right"><?php echo $row['rate'] ?>.00</td>
                    </tr>
                    <tr>
                      <td colspan="4" class="font-w600 text-right">Total de horas</td>
                      <td class="text-right"><?php echo  round($total_hr, 2) ?> Horas</td>
                    </tr>
                    <tr>
                      <td colspan="4" class="font-w600 text-right">Ingreso bruto</td>
                      <td class="text-right"><?php echo  number_format($gross) ?> GS</td>
                    </tr>
                    <tr>
                      <td colspan="4" class="font-w600 text-right">Anticipo en efectivo</td>
                      <td class="text-right">-<?php echo  number_format($cashadvance) ?> GS</td>
                    </tr>  
                    <tr>
                      <td colspan="4" class="font-w600 text-right">Tiempo extra</td>
                      <td class="text-right"><?php echo  number_format($ot) ?> GS</td>
                    </tr>   
                                        <tr>
                      <td colspan="4" class="font-w600 text-right">Ingreso neto (Ingreso bruto - Anticipo en efectivo)</td>
                      <td class="text-right"><b><?php echo  number_format($net_pay) ?> GS</b> </td>
                    </tr>                                    
                    <tr color="dark">
                      <td colspan="4" class="font-weight-bold text-uppercase text-right">PAGO NETO (Ingreso neto + Horas extra)</td>
                      <td class="text-right"><strong><?php echo  number_format($net_pay + $ot) ?>  GS </strong></td>
                    </tr>
                  </table>
                </div>
                <p class="text-muted text-center">Recibo de pago generado el <?php echo date("d/m/Y") ?> <?php echo date("H:i A") ?> por <?php echo $firstname ?> <?php echo $lastname ?></p>
              </div> 

                          <?php } ?>                   
                  </div>
                </div>
              </div> 
            </div>           
          </div>
        </div>
      </div>
      <?php require_once('includes/footer.php') ?>
    </div>   
    <?php require_once('includes/datatables.php') ?>
  </body>
</html>