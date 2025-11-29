<?php 

if(isset($_POST['applydate'])){
$getMonth = $_POST['overtime_month'];
$getYear = $_POST['overtime_year'];

$toDate = date("Y-m-d");

echo "<script>window.location.href='attendance.php?filter=$toDate&showall=$getMonth $getYear'</script>";


}



$thisYear = date('Y');
$thisMonth = date('F');

if(isset($_GET['showall'])){
  $showall = $_GET['showall'];
  $ex = explode(' ', $showall);
  $thisMonth = date('F', strtotime($ex[0]));
  $thisYear = $ex[1];



}


   $queryPosition2 = "SELECT *, employees.employee_id AS empid, attendance.id AS attid FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id WHERE attendance.month='$thisMonth' AND attendance.year=$thisYear ORDER BY attendance.date DESC";
   $queryResult2 = mysqli_query($connection, $queryPosition2);

?>


<div id="modal-show-attendance" class="modal" data-backdrop="true" >
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header">
      	<h5 style="padding-top: 8px" class="modal-title">Asistencia desde <?php echo $thisMonth.' '.$thisYear ?></h5>
             <form action="" method="post">
                   <div class="row">
                    <div class=" col-md-7" >
                        
                          <select  required="" name="overtime_month" class="form-control custom-select">
                              <option class="text-muted" value="">Mes</option>
                              <option value="January">Enero</option>
                              <option value="February">Febrero</option>
                              <option value="March">Marzo</option>
                              <option value="April">Abril</option>
                              <option value="May">Mayo</option>
                              <option value="June">Junio</option>
                              <option value="July">Julio</option>
                              <option value="August">Agosto</option>
                              <option value="September">Septiembre</option>
                              <option value="October">Octubre</option>
                              <option value="November">Noviembre</option>
                              <option value="December">Diciembre</option>
                            </select>
                      </div> 

                     <div  class="col-md-5">
                       
                              <select  required="" name="overtime_year" class="form-control custom-select">
                              <option class="text-muted" value="">año</option>
                              <?php 
                              $start_year = 2015;
                              $current_year = date("Y", time())+1;

                              $diff_bt_year = $current_year - $start_year;

                              while($start_year != $current_year){
                                $current_year--;
                              ?>
                                <option value="<?php echo $current_year ?>"><?php echo $current_year ?></option>
                              <?php } ?>
                            </select>
                      </div>  
      </div>
    </div>
      <form action="" method="post"> 
      <div class="modal-body p-lg">         
<div class="table-responsive" id="printDataHolder">
                      <table class="table table-hovered" id="" cellspacing="5">
                        <thead>
                          <tr>

                    
                            <th >Nombre del Empleado</th>
                            <th >Hora de Entrada AM</th>
                            <th >Hora de Salida AM</th>
                            
                            <th >Hora de Entrada PM</th>
                            <th >Hora de Salida PM</th>
                            <th>Tiempo Total</th>
                            <th>Fecha</th>
   
                          </tr>
                        </thead>
                        <tbody>
                          <?php while($row = mysqli_fetch_assoc($queryResult2)) { 

                              $statusMorning = ($row['status_morning'])?'&nbsp&nbsp<span class="badge badge-info">Ontime</span>':'&nbsp&nbsp<span class="badge badge-warning">Late</span>';

                              $statusAfternoon = ($row['status_afternoon'])?'&nbsp&nbsp<span class="badge badge-info">Ontime</span>':'&nbsp&nbsp<span class="badge badge-warning">Late</span>';

                              $total = $row['num_hr_morning'] + $row['num_hr_afternoon'];

                            ?>
                            
                            
                          <tr>
                            
          
                            
                            <td ><a class="text-inherit"><?php echo $row['fullname'] ?></a></td>
                            <td class=""><a class="text-inherit"><?php echo date('h:i A', strtotime($row['time_in_morning'])) ?></td>
                            <td ><a class="text-inherit"><?php echo date('h:i A', strtotime($row['time_out_morning'])) ?></a></td>



                      
                            <td >
                              <?php echo date('h:i A', strtotime($row['time_in_afternoon'])) ?>
                            </td>
                            <td ><?php echo date('h:i A', strtotime($row['time_out_afternoon'])) ?></td>
                        <td><?php echo round($total, 2) ?> Hours</td>
                  <td class="text"><?php echo date('d M, Y', strtotime($row['date'])) ?></td>
                          
                          </tr>
                          <?php } ?>

                        </tbody>
                      </table>
                    </div>                    
  
                                 
      </div>
      <div class="modal-footer">
        <div  style="padding-right: 12px;" >
        <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">Cerrar</button>
        <button type="submit" name="applydate" class="btn success p-x-md">Aplicar</button>
        </div>
      </div>
     </form>
    </div><!-- /.modal-content -->
  </div>
</div>