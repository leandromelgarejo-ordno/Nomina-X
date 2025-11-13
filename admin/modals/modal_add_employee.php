<?php

if (!isset($_SESSION['official_username']) && !isset($_SESSION['official_password']) && !isset($_SESSION['official_id'])) {
  header("location:index.php?utm_campaign=expired");
}



if (isset($_POST['add_new'])) {

  $numbers = '';
  for ($i = 0; $i < 10; $i++) {
    $numbers .= $i;
  }

  $employee_id = substr(str_shuffle($numbers), 0, 9);
  $position_id = $_POST['desired_position'];
  $schedule_id = $_POST['desired_schedule'];

  $photo = $_FILES['img_name']['name'];
  $target = "../image/" . basename($photo);
  move_uploaded_file($_FILES['img_name']['tmp_name'], $target);

  $first = ucwords($_POST['first']);
  $middle = ucwords($_POST['middle']);
  $last = ucwords($_POST['last']);

  $fullname = $first . ' ' . $middle . ' ' . $last;
  $address = ucwords($_POST['address']);
  $email = $_POST['email'];
  $phonenumber = $_POST['phonenumber'];
  $birthdate = $_POST['birth_year'] . '-' . $_POST['birth_month'] . '-' . $_POST['birth_day'];
  $sex = $_POST['sex'];
  $position = $_POST['desired_position'];
  $civil_status = $_POST['civil_status'];
  $citizenship = ucwords($_POST['citizenship']);
  $height = $_POST['height'];
  $weight = $_POST['weight'];
  $religion = ucwords($_POST['religion']);
  $spouse = ucwords($_POST['spouse_fullname']);
  $spouse_occupation = ucwords($_POST['spouse_occupation']);
  $father = ucwords($_POST['father_fullname']);
  $father_occupation = ucwords($_POST['father_occupation']);
  $mother = ucwords($_POST['mother_fullname']);
  $mother_occupation = ucwords($_POST['mother_occupation']);
  $parent_address = ucwords($_POST['parent_address']);
  $emergency_name = ucwords($_POST['emergency_name']);
  $emergency_contact = $_POST['emergency_contact'];
  $date = date("Y-m-d");

  $insert = "INSERT INTO `employees` (`employee_id`, `position_id`, `schedule_id`, `created_on`, `photo`, `fullname`, `address`, `email`, `phonenumber`, `birthdate`, `sex`, `position`, `civil_status`, `citizenship`, `height`, `weight`, `religion`, `spouse`, `spouse_occupation`, `father`, `father_occupation`, `mother`, `mother_occupation`, `parent_address`, `emergency_name`, `emergency_contact`) VALUES ('$employee_id', '$position_id', '$schedule_id', '$date', '$photo', '$fullname', '$address', '$email', '$phonenumber', '$birthdate', '$sex', '$position', '$civil_status', '$citizenship', '$height', '$weight', '$religion', '$spouse', '$spouse_occupation', '$father', '$father_occupation', '$mother', '$mother_occupation', '$parent_address', '$emergency_name', '$emergency_contact');";

  $query = mysqli_query($connection, $insert) or die("Could not insert: $insert");

  echo "<script>window.location.href='profile.php'</script>";
}

?>
<script type="text/javascript">
  function limitKeypress(event, value, maxLength) {
    if (value != undefined && value.toString().length >= maxLength) {
      event.preventDefault();
    }
  }
</script>


<div id="modal-add-employee" class="modal" data-backdrop="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nuevo registro de datos personales del empleado</h5>
      </div>
      <div class="modal-body p-lg">
        <div class="col-md-12">
          <form class="" method="post" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">Nombre</label>
                  <input name="first" type="text" class="form-control" required placeholder="Ingrese el nombre...">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">Segundo nombre</label>
                  <input name="middle" type="text" class="form-control" required placeholder="Ingrese el segundo nombre...">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">Apellido</label>
                  <input name="last" type="text" class="form-control" required placeholder="Ingrese el apellido...">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">Dirección</label>
                  <input name="address" type="text" class="form-control" required placeholder="Ingrese la dirección...">
                </div>
              </div>
              <div class="col-sm-6 col-md-6">
                <div class="form-group">
                  <label class="form-label">Correo electrónico</label>
                  <input name="email" type="email" class="form-control" required placeholder="Ingrese el correo electrónico...">
                </div>
              </div>
              <div class="col-sm-6 col-md-6">
                <div class="form-group">
                  <label class="form-label">Número de teléfono</label>
                  <input name="phonenumber" type="number" maxlength="11" min="0" onkeypress="limitKeypress(event,this.value,11)" class="form-control" required placeholder="Ingrese el número de teléfono...">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">Puesto deseado</label>
                  <select required name="desired_position" class="form-control custom-select">
                    <option class="text-muted">Seleccione el puesto</option>
                    <?php
                      $pos = "SELECT * FROM `position`;";
                      $res = mysqli_query($connection, $pos);
                      while ($row = mysqli_fetch_assoc($res)) {
                        echo '<option value="'.$row['id'].'">'.$row['description'].'</option>';
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">Horario deseado</label>
                  <select required name="desired_schedule" class="form-control custom-select">
                    <option class="text-muted">Seleccione el horario</option>
                    <?php
                      $pos = "SELECT * FROM `schedules`;";
                      $res = mysqli_query($connection, $pos);
                      while ($row = mysqli_fetch_assoc($res)) {
                        echo '<option value="'.$row['id'].'">'.$row['time_in_morning'].'-'.$row['time_out_morning'].'/'.$row['time_in_afternoon'].'-'.$row['time_out_afternoon'].'</option>';
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <div class="form-label">Subir imagen</div>
                  <div class="custom-file">
                    <input type="file" required class="custom-file-input" name="img_name">
                    <label class="custom-file-label">Seleccionar archivo de imagen</label>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">Fecha de nacimiento</label>
                  <select required="" name="birth_month" class="form-control custom-select">
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
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="form-group">
                  <label class="form-label">&nbsp</label>
                  <select required="" name="birth_day" class="form-control custom-select">
                    <option class="text-muted" value="">Día</option>
                    <option value="01">1</option>
                    <option value="02">2</option>
                    <option value="03">3</option>
                    <option value="04">4</option>
                    <option value="05">5</option>
                    <option value="06">6</option>
                    <option value="07">7</option>
                    <option value="08">8</option>
                    <option value="09">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                    <option value="31">31</option>
                  </select>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="form-group">
                  <label class="form-label">&nbsp</label>
                  <select required="" name="birth_year" class="form-control custom-select">
                    <option class="text-muted" value="">Año</option>
                    <?php
                    $start_year = 1930;
                    $current_year = date("Y", time()) + 1;

                    $diff_bt_year = $current_year - $start_year;

                    while ($start_year != $current_year) {
                      $current_year--;
                      ?>
                      <option value="<?php echo $current_year ?>"><?php echo $current_year ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">Estado civil</label>
                  <select required="" name="civil_status" class="form-control custom-select">
                    <option class="text-muted" value="">Seleccione estado civil</option>
                    <option value="Single">Soltero(a)</option>
                    <option value="Married">Casado(a)</option>
                    <option value="Separated">Separado(a)</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">Sexo</label>
                  <select required="" name="sex" class="form-control custom-select">
                    <option class="text-muted" value="">Seleccione sexo</option>
                    <option value="Male">Masculino</option>
                    <option value="Female">Femenino</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">Nacionalidad</label>
                  <input name="citizenship" type="text" class="form-control" required placeholder="Ingrese la nacionalidad...">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">Estatura</label>
                  <input name="height" type="number" class="form-control" required placeholder="Ingrese la estatura ej. 175">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">Peso</label>
                  <input name="weight" type="number" class="form-control" required placeholder="Ingrese el peso ej. 60">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">Religión</label>
                  <input name="religion" type="text" class="form-control" required placeholder="Ingrese la religión...">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">Cónyuge</label>
                  <input name="spouse_fullname" type="text" class="form-control" required placeholder="Ingrese el nombre completo del cónyuge...">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">Ocupación</label>
                  <input name="spouse_occupation" type="text" class="form-control" required placeholder="Ingrese la ocupación del cónyuge...">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">Nombre del padre</label>
                  <input name="father_fullname" type="text" class="form-control" required placeholder="Ingrese el nombre completo del padre...">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">Ocupación</label>
                  <input name="father_occupation" type="text" class="form-control" required placeholder="Ingrese la ocupación del padre...">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">Nombre de la madre</label>
                  <input name="mother_fullname" type="text" class="form-control" required placeholder="Ingrese el nombre completo de la madre...">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">Ocupación</label>
                  <input name="mother_occupation" type="text" class="form-control" required placeholder="Ingrese la ocupación de la madre...">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">Dirección de los padres</label>
                  <input name="parent_address" type="text" class="form-control" required placeholder="Ingrese la dirección de los padres...">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">Persona de contacto en caso de emergencia</label>
                  <input name="emergency_name" type="text" class="form-control" required placeholder="Ingrese los datos del nombre...">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-label">Datos de contacto de emergencia</label>
                  <input name="emergency_contact" type="number" maxlength="11" min="0" onkeypress="limitKeypress(event,this.value,11)" class="form-control" required placeholder="Ingrese los datos de contacto...">
                </div>
              </div>
            </div>


        </div>
      </div>
      <div class="modal-footer">
        <div style="padding-right: 12px;">
          <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">Cancelar</button>
          <button type="submit" name="add_new" class="btn danger p-x-md">Guardar</button></div>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div>
</div>