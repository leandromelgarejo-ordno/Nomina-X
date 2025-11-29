<?php 

if(!isset($_SESSION['official_username']) && !isset($_SESSION['official_password']) && !isset($_SESSION['official_id'])){
  header("location:index.php?utm_campaign=expired");
}

$queryPosition = "SELECT *, overtime.id AS otid, employees.employee_id AS empid FROM overtime LEFT JOIN employees ON employees.id=overtime.employee_id ORDER BY date_overtime DESC;";
$queryResult = mysqli_query($connection, $queryPosition);

$numbers = '';
for($i = 0; $i < 7; $i++){
  $numbers .= $i;
}

$id = substr(str_shuffle($numbers), 0, 9);

if(isset($_POST['add'])){
  $employee = $_POST['employee'];
  $date = $_POST['overtime_year'].'-'.$_POST['overtime_month'].'-'.$_POST['overtime_day'];
  $hours = $_POST['hours'] + ($_POST['minutes']/60);
  $rate = $_POST['rate'];

  $insert = "INSERT INTO `overtime` (`employee_id`, `overtime_id`, `hours`, `rate_hour`, `date_overtime`) VALUES ('$employee', '$id', '$hours', '$rate', '$date');";
  $query = mysqli_query($connection, $insert) or die(mysqli_error().$insert);

  echo "<script>window.location.href='overtime.php'</script>";
}
?>

<div id="modal-add-overtime" class="modal" data-backdrop="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nuevo Horario Extra</h5>
      </div>
      <form action="" method="post"> 
        <div class="modal-body p-lg">         
          <div class="col-md-12">
            <div class="form-group">
              <label class="form-label">Empleado</label>
              <select name="employee" required="true" class="form-control">
                <option value="" class="text-muted">Seleccione empleado</option>
                <?php 
                  $pos = "SELECT `id`, `fullname` FROM `employees`;";

                  $res = mysqli_query($connection, $pos);
                  while($row = mysqli_fetch_assoc($res)){
                    echo '<option value="'.$row['id'].'">'.$row['fullname'].'</option>';
                  }
                ?>
              </select>
            </div>
            <div style="padding-left: 0px;" class="row">
              <div class="form-group" style="padding-right: 15px; padding-left: 10px">
                <label class="form-label">Fecha de horario extra</label>
                <select style="padding-right: 40px;" required name="overtime_month" class="form-control custom-select">
                  <option class="text-muted" value="">Mes</option>
                  <option value="01">Enero</option>
                  <option value="02">Febrero</option>
                  <option value="03">Marzo</option>
                  <option value="04">Abril</option>
                  <option value="05">Mayo</option>
                  <option value="06">Junio</option>
                  <option value="07">Julio</option>
                  <option value="08">Agosto</option>
                  <option value="09">Septiembre</option>
                  <option value="10">Octubre</option>
                  <option value="11">Noviembre</option>
                  <option value="12">Diciembre</option>
                </select>
              </div> 
              <div class="col-md-4">
                <label class="form-label">&nbsp</label>
                <select required name="overtime_day" class="form-control custom-select">
                  <option class="text-muted" value="">Día</option>
                  <?php for($d=1;$d<=31;$d++) { ?>
                    <option value="<?php echo str_pad($d,2,"0",STR_PAD_LEFT); ?>"><?php echo $d; ?></option>
                  <?php } ?>
                </select>
              </div>   
              <div class="col-md-4">
                <label class="form-label">&nbsp</label>
                <select required name="overtime_year" class="form-control custom-select">
                  <option class="text-muted" value="">Año</option>
                  <?php 
                    $start_year = 2010;
                    $current_year = date("Y", time())+1;
                    while($start_year != $current_year){
                      $current_year--;
                  ?>
                    <option value="<?php echo $current_year ?>"><?php echo $current_year ?></option>
                  <?php } ?>
                </select>
              </div> 
            </div> 
            <div class="form-group">
              <label class="form-label">Número de horas</label>
              <input name="hours" type="number" class="form-control" required placeholder="Ingrese el número de horas...">
            </div>
            <div class="form-group">
              <label class="form-label">Número de minutos</label>
              <input name="minutes" type="number" class="form-control" required placeholder="Ingrese el número de minutos...">
            </div>      
            <div class="form-group">
              <label class="form-label">Tarifa por hora</label>
              <input name="rate" type="number" maxlength="4" min="0" onkeypress="limitKeypress(event,this.value,4)" class="form-control" required placeholder="Ingrese la tarifa por hora...">
            </div>                                  
          </div>      
          <script type="text/javascript">
            function limitKeypress(event, value, maxLength) {
              if (value != undefined && value.toString().length >= maxLength) {
                event.preventDefault();
              }
            }                      
          </script>          
        </div>
        <div class="modal-footer">
          <div style="padding-right: 12px;" >
            <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">Cerrar</button>
            <button type="submit" name="add" class="btn success p-x-md">Agregar horario extra</button>
          </div>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div>
</div>
