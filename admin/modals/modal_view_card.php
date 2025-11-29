<?php

if (!isset($_SESSION['official_username']) && !isset($_SESSION['official_password']) && !isset($_SESSION['official_id'])) {
    header("location:index.php?utm_campaign=expired");
}


$queryPosition = "SELECT * FROM `position`;";
$queryResult = mysqli_query($connection, $queryPosition);

$numbers = '';
for ($i = 0; $i < 10; $i++) {
    $numbers .= $i;
}

$empd = $_GET['id'];

$empid = $emp['empid'];
$employee_id = $emp['employee_id'];

$id = substr(str_shuffle($numbers), 0, 9);

if (isset($_POST['add_deploy'])) {
    $edu = $_POST['project'];
    $year  = $_POST['year'];
    $deg = ucwords($_POST['location']);


    $insert = "UPDATE `employees` SET `project_name` = '$edu', `site_location` = '$deg' WHERE (`employee_id` = '$empd');";

    $query = mysqli_query($connection, $insert) or die(mysqli_error() . $insert);

    echo "<script>window.location.href='view.php?id=$empd'</script>";
}

?>

<script type="text/javascript">
function printPage3() {
    var divElements = document.getElementById('printDataHolder3').innerHTML;

    // Abrir una ventana nueva para imprimir
    var printWindow = window.open('', '', 'height=600,width=800');
    printWindow.document.write('<html><head><title>Imprimir Carnet</title>');
    printWindow.document.write('<link rel="stylesheet" href="css/common.css" type="text/css" />');
    printWindow.document.write('</head><body>');
    printWindow.document.write(divElements);
    printWindow.document.write('</body></html>');

    printWindow.document.close(); // Necesario para IE y algunos navegadores
    printWindow.focus();
    printWindow.print();
    printWindow.close();
}


    window.onafterprint = function() {
        $('#modal-view-card').modal('handleUpdate');
    };

    // Otra forma: volver a enganchar el evento click después de imprimir
    window.addEventListener('afterprint', function () {
        $('[data-dismiss="modal"]').off().on('click', function () {
            $('#modal-view-card').modal('hide');
        });
    });
</script>   

<div id="modal-view-card" class="modal" data-backdrop="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Carnet de identificación del empleado</h5>
            </div>
            <form action="" method="post">
                <div class="modal-body p-lg" id="printDataHolder3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <center><label style="padding-top: 15px; padding-bottom:1px"  class="form-label">Alca Consultora<p style="padding-top: 0px;" class="-label">Hernandarias Área 6</p></label></center>
                            <center><img height="120" width="120" src="../image/<?php echo $emp['photo'] ?>"></center>
                            <br><center><p><?php echo $emp['fullname'] ?><br><?php echo $emp['address'] ?><br><?php echo $emp['description'] ?><br><?php echo $emp['phonenumber'] ?></p></center>
                            <center><img src="<?php echo $emp['path'] ?>">  </center> 
                            
                            <center><br><small style="padding-top: 20px">Persona a contactar en caso de emergencia<br> <?php echo($emp['emergency_name']) ?> (<?php echo $emp['emergency_contact'] ?>)</small>
                            </center>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <div style="padding-right: 12px;">
                        <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">Cerrar<span style="display:none;">Close</span></button>
                        <button type="submit" class="btn success p-x-md" onclick="printPage3()">Imprimir</button>
                    </div>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div>
</div>