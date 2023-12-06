<?php 
    if(isset($_POST['fecha_ticket']) && isset($_POST['name_ticket']) && isset($_POST['email_ticket'])){


// Este código nos servirá para generar un número diferente para cada ticket
$queryUltimoNumero = Mysql::consulta("SELECT MAX(id) AS ultimo_numero FROM ticket");
$ultimoNumero = mysqli_fetch_assoc($queryUltimoNumero)['ultimo_numero'];
$ultimoNumero = ($ultimoNumero) ? $ultimoNumero : 0;

// Incrementa el contador para el próximo ticket
$nuevoNumeroCorrelativo = $ultimoNumero + 1;

// Si el contador supera los 999999, reinicia a 1
if ($nuevoNumeroCorrelativo > 9999999) {
    $nuevoNumeroCorrelativo = 1;
}

// Genera el nuevo código de ticket
$codigo = str_pad($nuevoNumeroCorrelativo, 6, '0', STR_PAD_LEFT);  // Asegura que el número tenga 6 dígitos, puedes ajustar según sea necesario

// Actualiza el contador en la base de datos
MysqlQuery::Actualizar("limite", "ultimo_numero='$nuevoNumeroCorrelativo'", "ID='1'");

// Crea el ID del ticket
$id_ticket = "TK" . $codigo;

      $nombre_ticket= MysqlQuery::RequestPost('name_ticket');
      $email_ticket=MysqlQuery::RequestPost('email_ticket');
      $carnet_ticket=MysqlQuery::RequestPost('carnet_ticket');        
      $mensaje_ticket=MysqlQuery::RequestPost('mensaje_ticket');
      $estado_ticket="Pendiente";
      $con=MysqlQuery::RequestPost('id_problema');


      if(MysqlQuery::Guardar("ticket","fecha,nombre_usuario,email_cliente,carnet,mensaje,estado_ticket,serie,solucion, id_problema", "NOW(),'$nombre_ticket','$email_ticket','$carnet_ticket','$mensaje_ticket', '$estado_ticket','$id_ticket','','$con'")){
        ob_start();
       ?>
        
<div class="modal fade" id="ticketModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">TICKET CREADO</h1>
            </div>
            <div class="modal-body">
                <H2>Ticket creado con éxito <br>El TICKET ID es: <strong><?php echo $id_ticket; ?></strong></H2>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                <button name="save" id="save" class="btn btn-sm btn-success"><i class="fa fa-print" aria-hidden="true"></i> Guardar ticket en PDF</button>            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#ticketModal').modal('show');
    });
</script>

<script>
    $(document).ready(function () {
        $("button#save").click(function () {
            var idTicket = "<?php echo $id_ticket; ?>";
            var emailTicket = "<?php echo $email_ticket; ?>";
            
            // Utilizando window.open para abrir dos ventanas a la vez
            window.open("./lib/pdf_user.php?id=" + idTicket);
        });
    });
</script>

<?php
ob_end_flush();
      }else{
        echo '
            <div class="alert alert-danger alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="text-center">OCURRIÓ UN ERROR</h4>
                <p class="text-center">
                    No hemos podido crear el ticket. Por favor intente nuevamente.
                </p>
            </div>
        ';
      }
    }
  ?>
          <div class="container">
            <div class="row well">
              <div class="col-sm-3">
                <img src="img/tick.png" class="img-responsive" alt="Image">
              </div>
              <div class="col-sm-9 lead">
              
                <h2 class="text-info">¿Cómo crear una nueva cita?</h2>
                <p>Para crear una nueva cita deberá de llenar todos los campos de el siguiente formulario. Usted podra verificar el estado de su ticket mediante el <strong>Ticket ID</strong> que se le proporcionara cuando envie el formulario.</p>
              </div>
            </div><!--fin row 1-->

            <div class="row">
              <div class="col-sm-12">
                <div class="panel panel-info">
                  <div class="panel-heading">
                    <h3 class="panel-title text-center"><strong><i class="fa fa-ticket"></i>&nbsp;&nbsp;&nbsp;Ticket</strong></h3>
                  </div>
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-sm-4 text-center">
                        <br><br><br>
                        <img src="img/contrato.png" alt=""><br><br>
                        <p class="text-primary text-justify">Por favor llene todos los datos de este formulario para crear la cita.</p>
                      </div>
                      <div class="col-sm-8">
                        <form class="form-horizontal" role="form" action="" method="POST">
                            <fieldset>
                          <div class="form-group">
                              <label class="col-sm-2 control-label">Fecha</label>
                              <div class='col-sm-10'>
                                  <div class="input-group">
                                    <div id="fecha"></div>
                                    <input type="hidden" name="fecha_ticket" id="fecha_ticket">
                                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                  </div>
                              </div>
                          </div>

                          <div class="form-group">
                            <label  class="col-sm-2 control-label">Nombre</label>
                            <div class="col-sm-10">
                                <div class='input-group'>
                                  <input type="text" class="form-control" placeholder="Nombre" required="" pattern="[a-zA-Z ]{1,30}" name="name_ticket" title="Nombre Apellido" >
                                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                <div class='input-group'>
                                  <input type="email" class="form-control" id="inputEmail3" placeholder="Email" name="email_ticket" required="" title="Ejemplo@dominio.com" >
                                  <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                                </div> 
                            </div>
                          </div>

                          <div class="form-group">
                            <label  class="col-sm-2 control-label">Carnet</label>
                            <div class="col-sm-10">
                                <div class='input-group'>
                                <input type="text" class="form-control" placeholder="Carnet" name="carnet_ticket" required="">
                                  <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                </div> 
                            </div>
                          </div>

                          <div class="form-group">
                            <label  class="col-sm-2 control-label">Consulta</label>
                            <div class="col-sm-10">
                              <select class="form-control" name="id_problema" required="">
                                <?php
                                // 
                                $query_consul = Mysql::consulta("SELECT problemas.id_problema, problemas.consulta FROM problemas INNER JOIN administrador ON problemas.id_admin=administrador.id_admin WHERE problemas.id_admin != 1 AND problemas.id_admin != '$idA' and administrador.estado='activo'");
                                 if ($query_consul) {
                                  while ($consul = mysqli_fetch_assoc($query_consul)) {
                                    $idcons = $consul['id_problema'];
                                    $consulta = $consul['consulta'];
                                    // 
                                    $selected = ($idAdmin == $selectedNombreCompleto) ? 'selected' : '';
                                    echo '<option value="' . $idcons . '" ' . $selected . '>' . $consulta . '</option>';
                                  }
                                  mysqli_free_result($query_consul); 
                                } else {
                                  echo '<option value="" disabled>No hay administradores disponibles</option>';
                                }
                                ?>
                              </select>


                            </div>
                          </div>

                          <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-info" data-toggle="modal" data-target="#ticketModal">Crear </button>
                            </div>
                          </div>
                          
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

  <?php

  ?>

<script>
        // Obtener la fecha y hora actual en el formato deseado (día, mes, año, hora corta)
        var fechaHora = new Date();
        var dia = fechaHora.getDate();
        var mes = fechaHora.getMonth() + 1; // Sumamos 1 porque enero es 0
        var ano = fechaHora.getFullYear();
        var hora = fechaHora.getHours();
        var minutos = fechaHora.getMinutes();

        // Formatear la fecha y hora en el formato deseado
        var fechaHoraFormateada = dia + '/' + mes + '/' + ano + ' ' + hora + ':' + minutos;

        // Mostrar la fecha y hora en la página
        document.getElementById('fecha').innerHTML = fechaHoraFormateada;

        document.getElementById('fecha_ticket').value = fechaHoraFormateada;
    </script>
