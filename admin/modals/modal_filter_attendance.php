<?php 

if(isset($_POST['apply'])){
$fromDate = $_POST['overtime_year'].'-'.$_POST['overtime_month'].'-'.$_POST['overtime_day'];


echo "<script>window.location.href='attendance.php?filter=$fromDate'</script>";

}

?>


<div id="modal-filter-attendance" class="modal" data-backdrop="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title">Filtro de fecha de asistencia</h5>
      </div>
      <form action="" method="post"> 
      <div class="modal-body p-lg">         
        <div class="col-md-12">
          <div style="padding-left: 0px;" class="row">
            <div class="form-group" style="padding-right: 15px;">
              <label class="form-label">Filtrar</label>
              <select style="padding-right: 50px;" required name="overtime_month" class="form-control custom-select">
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
                  $start_year = 2015;
                  $current_year = date("Y", time())+1;
                  while($start_year != $current_year){
                    $current_year--;
                ?>
                  <option value="<?php echo $current_year ?>"><?php echo $current_year ?></option>
                <?php } ?>
              </select>
            </div> 
          </div> 
        </div>   
      </div>
      <div class="modal-footer">
        <div style="padding-right: 12px;" >
          <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">Cerrar</button>
          <button type="submit" name="apply" class="btn success p-x-md">Aplicar</button>
        </div>
      </div>
     </form>
    </div><!-- /.modal-content -->
  </div>
</div>