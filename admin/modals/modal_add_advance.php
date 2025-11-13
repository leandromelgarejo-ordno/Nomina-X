<?php 

 if(!isset($_SESSION['official_username']) && !isset($_SESSION['official_password']) && !isset($_SESSION['official_id'])){
    header("location:index.php?utm_campaign=expired");
 }


 $queryPosition = "SELECT *, cashadvance.id AS caid, employees.employee_id AS empid FROM cashadvance LEFT JOIN employees ON employees.id=cashadvance.employee_id ORDER BY date_advance DESC;";
 $queryResult = mysqli_query($connection, $queryPosition);

 $numbers = '';
    for($i = 0; $i < 7; $i++){
      $numbers .= $i;
    }

$id = substr(str_shuffle($numbers), 0, 9);

 if(isset($_POST['add'])){
  $employee = $_POST['employee'];
  $amount = $_POST['amount'];

  $date = date("Y-m-d");

$insert = "INSERT INTO `cashadvance` (`cash_id`, `date_advance`, `employee_id`, `amount`) VALUES ('$id', '$date', '$employee', '$amount');";

$query = mysqli_query($connection, $insert) or die(mysqli_error().$insert);

echo "<script>window.location.href='advance.php'</script>";
}
?>


<div id="modal-add-advance" class="modal" data-backdrop="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
      	<h5 class="modal-title">Nuevo Adelanto de Efectivo</h5>
      </div>
      <form action="" method="post"> 
      <div class="modal-body p-lg">         
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="form-label">Empleado</label>
                        <select required name="employee" class="form-control">
                              <option value="" class="text-muted">Seleccionar Empleado</option>

                              <?php 
                              $pos = "SELECT `id`, `fullname` FROM `employees`;";
                              $res = mysqli_query($connection, $pos);
                              while($row = mysqli_fetch_assoc($res)){

                              ?>
                              
                              <option value="<?php echo $row['id']  ?>"><?php echo $row['fullname']  ?></option>
                            <?php } ?>
                          </select>
                      </div>
                      <div class="form-group">
                        <label class="form-label">Monto en Efectivo</label>
                        <input type="number" required="true" class="form-control" name="amount" maxlength="4" min="0" onkeypress="limitKeypress(event,this.value,8)" placeholder="Ingrese el Monto...">
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
        <div  style="padding-right: 12px;" >
        <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">Cerrar</button>
        <button type="submit" name="add" class="btn success p-x-md">Agregar adelanto de Efectivo</button>
        </div>
      </div>
     </form>
    </div><!-- /.modal-content -->
  </div>
</div>

