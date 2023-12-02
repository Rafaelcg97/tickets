  <?php 
    $num2=Mysql::consulta("SELECT id FROM ticket WHERE estado_ticket='Pendiente'");
    $contador = mysqli_num_rows($num2);


    $result =Mysql::consulta("SELECT limite_ FROM limite WHERE ID='1'");
    if ($result) {
      // Obtener el valor entero
      $row = $result->fetch_assoc();
      $lmt = (int)$row['limite_']-1;
    }

    //hora actual del servidor
    $hora = date('G');

    //rangos horarios permitidos
    $horario_manana_inicio = 1;
    $horario_manana_fin = 12;
    $horario_tarde_inicio = 13; // 1 PM
    $horario_tarde_fin = 24; // 5 PM


    //Ver la ultima creacion tocket
    $lastTicketTimeQuery = Mysql::consulta("SELECT last_ticket_created_time FROM limite WHERE id = 1");
    $row = $lastTicketTimeQuery->fetch_assoc();
    $lastTicketTime = strtotime($row['last_ticket_created_time']);
    
    // Calcular el tiempo actual
    $current_time = time();
    $tiempo=0.1;//tiempo a definir intervalo , sera por tipo de problema

    // Definir el intervalo 
    $intervalo_minutos = $tiempo* 60; 


    if($contador<=$lmt and $current_time - $lastTicketTime >= $intervalo_minutos){
      if(isset($_POST['fecha_ticket']) && isset($_POST['name_ticket']) && isset($_POST['email_ticket'])){


        /*Este codigo nos servira para generar un numero diferente para cada ticket*/
        $codigo = ""; 
        $longitud = 2; 
        for ($i=1; $i<=$longitud; $i++){ 
          $numero = rand(0,9); 
          $codigo .= $numero; 
        } 
        $num=Mysql::consulta("SELECT id FROM ticket");
        $numero_filas = mysqli_num_rows($num);

        $numero_filas_total=$numero_filas+1;
        $id_ticket="TK".$codigo."N".$numero_filas_total;
        /*Fin codigo numero de ticket*/

      


        $nombre_ticket= MysqlQuery::RequestPost('name_ticket');
        $email_ticket=MysqlQuery::RequestPost('email_ticket');
        $carnet_ticket=MysqlQuery::RequestPost('carnet_ticket');        
        $mensaje_ticket=MysqlQuery::RequestPost('mensaje_ticket');
        $estado_ticket="Pendiente";
        $con=MysqlQuery::RequestPost('id_problema');;

        if(MysqlQuery::Guardar("ticket","fecha,nombre_usuario,email_cliente,carnet,mensaje,estado_ticket,serie,solucion, id_problema", "NOW(),'$nombre_ticket','$email_ticket','$carnet_ticket','$mensaje_ticket', '$estado_ticket','$id_ticket','','$con'")){

          $updateTimeQuery = MysqlQuery::Actualizar("limite","last_ticket_created_time= NOW()","ID='1'");
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
                          <button href="index.php" type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                      </div>
                  </div>
              </div>
          </div>

          <script>
              $(document).ready(function() {
                  $('#ticketModal').modal('show');
              });
          </script>
<?php

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
  }elseif($contador>=$lmt){
    echo '
    <div class="alert alert-danger alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="text-center">OCURRIÓ UN ERROR</h4>
        <p class="text-center">
            Limite de tickets
        </p>
    </div>
  ';
  }elseif($current_time - $lastTicketTime <= $intervalo_minutos){
    echo '
    <div class="alert alert-danger alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="text-center"></h4>
        <p class="text-center">
            Espere  '.$tiempo.' minutos para generar otro ticket
        </p>
    </div>
  ';
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
                                $query_consul = Mysql::consulta("SELECT id_problema, consulta FROM problemas WHERE id_admin != 1 AND id_admin != '$idA'");
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
                              <button type="submit" class="btn btn-info" href="./index-view.php">Crear </button>
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