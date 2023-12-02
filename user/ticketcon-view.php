<?php
if (isset($_POST['del_ticket'])) {
    $id = MysqlQuery::RequestPost('del_ticket');

    if (MysqlQuery::Eliminar("ticket", "serie='$id'")) {
        echo '
            <div class="alert alert-info alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="text-center">TICKET ELIMINADO</h4>
                <p class="text-center">
                    El ticket fue eliminado con éxito
                </p>
            </div>
        ';
    } else {
        echo '
            <div class="alert alert-danger alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="text-center">OCURRIÓ UN ERROR</h4>
                <p class="text-center">
                    Lo sentimos, no hemos podido eliminar el ticket
                </p>
            </div>
        ';
    }
}

$email_consul = MysqlQuery::RequestGet('email_consul');
$id_colsul = MysqlQuery::RequestGet('id_consul');

$consulta_tablaTicket = Mysql::consulta("SELECT * FROM ticket WHERE serie= '$id_colsul' AND email_cliente='$email_consul'");
if (mysqli_num_rows($consulta_tablaTicket) >= 1) {
    $lsT = mysqli_fetch_array($consulta_tablaTicket, MYSQLI_ASSOC);
    ?>
    <div class="container">
        <div class="row well">
            <div class="col-sm-2">
                <img src="img/status.png" class="img-responsive" alt="Image">
            </div>
            <div class="col-sm-10 lead text-justify">
                <h2 class="text-info">Estado de ticket de soporte</h2>
                <p>Si su <strong>ticket</strong> no ha sido solucionado aún, espere pacientemente, estamos trabajando para poder resolver su problema y darle una solución.</p>
            </div>
        </div><!--fin row well-->
        <div class="row">
            <div class="col-sm-12">
              <div class="col-sm-12">
                    <div class="panel panel-success">
                        <div class="panel-heading text-center"><h4><i class="fa fa-ticket"></i> Ticket &nbsp;#<?php echo $lsT['serie']; ?></h4></div>
                      <div class="panel-body">
                          <div class="container">
                              <div class="col-sm-12">
                                  <div class="row">
                                      <div class="col-sm-4">
                                          <img class="img-responsive" alt="Image" src="img/logo.png">
                                      </div>
                                      <div class="col-sm-8">
                                          <div class="row">
                                              <div class="col-sm-6"><strong>Fecha:</strong> <?php echo $lsT['fecha']; ?></div>
                                              <div class="col-sm-6"><strong>Estado:</strong> <?php echo $lsT['estado_ticket']; ?></div>
                                          </div>
                                          <br>
                                          <div class="row">
                                              <div class="col-sm-6"><strong>Nombre:</strong> <?php echo $lsT['nombre_usuario']; ?></div>
                                              <div class="col-sm-6"><strong>Email:</strong> <?php echo $lsT['email_cliente']; ?></div>
                                          </div>
                                          <br>
                                          <div class="row">
                                              <div class="col-sm-6"><strong>Carnet:</strong> <?php echo $lsT['carnet']; ?></div>
                                          </div>
                                          <br>
                                          <div class="row">
                                              <div class="col-sm-12"><strong>Problema:</strong> <?php echo $lsT['mensaje']; ?></div>
                                          </div>
                                          <br>
                                          <div class="row">
                                              <div class="col-sm-12"><strong>Solución:</strong> <?php echo $lsT['solucion']; ?></div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                    </div>
                    <div class="panel-footer text-center">
                        <div class="row">
                            <h4>Opciones</h4>
                            <br class="hidden-lg hidden-md hidden-sm">
                            <div class="col-sm-6">
                                <a href="./index.php"  class="btn btn-primary"><span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp; Volver</a>
                            </div>
                            <?php
                            // Agregar condición para mostrar el botón solo si el estado es diferente de "Pendiente"
                            if ($lsT['estado_ticket'] =='Pendiente' or  $lsT['estado_ticket'] == 'Pendiente(Actual)' ) {
                                ?>
                                <div class="col-sm-6">
                                    <form action="" method="POST">
                                        <input type="text" value="<?php echo $lsT['serie']; ?>" name="del_ticket" hidden="">
                                        <button class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span>&nbsp;  Eliminar ticket</button>
                                    </form>
                                </div>
                                <?php
                            }
                            if ($lsT['estado_ticket'] == 'En proceso' or $lsT['estado_ticket'] == 'Resuelto'  ) {
                                ?>
                            <br class="hidden-lg hidden-md hidden-sm">
                            <div class="col-sm-6">
                                <button id="save" class="btn btn-success" data-id="<?php echo $lsT['serie']; ?>"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp; Guardar ticket en PDF</button>
                            </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
} else {
    ?>
        <div class="container">
        <div class="row well">
            <div class="col-sm-2">
                <img src="img/status.png" class="img-responsive" alt="Image">
            </div>
            <div class="col-sm-10 lead text-justify">
                <h2 class="text-info">Estado de ticket de soporte</h2>
                <p><strong>Ticket </strong>  no existente, favor verificar su ticket o correo.</p>
            </div>
            <div class="row">
            <h4>Opciones</h4>
            <br class="hidden-lg hidden-md hidden-sm">
                            <div class="col-sm-6">
                                <a href="./index.php"  class="btn btn-primary"><span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp; Volver</a>
                            </div>
            </div>
        </div>
<?php
}
?>
<script>
    $(document).ready(function () {
        $("button#save").click(function () {
            window.open("./lib/pdf_user.php?id=" + $(this).attr("data-id"));
        });
    });
</script>
