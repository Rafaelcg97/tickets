    <?php

    if( $_SESSION['nombre']!="" && $_SESSION['clave']!="" && $_SESSION['tipo']=="admin"){ ?>
            <div class="container">
            <div class="row">
                <div class="col-sm-2">
                <img src="./img/msj.png" alt="Image" class="img-responsive animated tada">
                </div>
                <div class="col-sm-10">
                <p class="lead text-info">Bienvenido administrador, aqui se muestran todos los Tickets los cuales podrá eliminar, modificar e imprimir.</p>

                </div>
            </div>
            </div>
                <?php
                    if(isset($_POST['id_del'])){
                        $id = MysqlQuery::RequestPost('id_del');
                        if(MysqlQuery::Eliminar("ticket", "id='$id'")){
                            
                            echo '
                                <div class="alert alert-info alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <h4 class="text-center">TICKET ELIMINADO</h4>
                                    <p class="text-center">
                                        El ticket fue eliminado del sistema con exito
                                    </p>
                                </div>
                            ';
                        }else{
                            echo '
                                <div class="alert alert-danger alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <h4 class="text-center">OCURRIÓ UN ERROR</h4>
                                    <p class="text-center">
                                        No hemos podido eliminar el ticket
                                    </p>
                                </div>
                            '; 
                        }
                    }
                    /* Todos los tickets*/
                    $num_ticket_all=Mysql::consulta("SELECT * FROM ticket");
                    $num_total_all=mysqli_num_rows($num_ticket_all);

                    /* Tickets pendientes*/
                    $num_ticket_pend=Mysql::consulta("SELECT * FROM ticket WHERE estado_ticket='Pendiente'");
                    $num_total_pend=mysqli_num_rows($num_ticket_pend);

                    /* Tickets en proceso*/
                    $num_ticket_proceso=Mysql::consulta("SELECT * FROM ticket WHERE estado_ticket='En proceso'");
                    $num_total_proceso=mysqli_num_rows($num_ticket_proceso);

                    /* Tickets resueltos*/
                    $num_ticket_res=Mysql::consulta("SELECT * FROM ticket WHERE estado_ticket='Resuelto'");
                    $num_total_res=mysqli_num_rows($num_ticket_res);



                    
                    /* Limite de tickets
                    $num_limt = Mysql::consulta("SELECT limite_ FROM limite WHERE ID='1'");
                    $row_num_limt = $num_limt->fetch_assoc();
                    $num_limt=(int)$row_num_limt['limite_'] ?? null;

                    if (isset($_POST['limit1_'])) {
                        // El formulario para actualizar el límite se envió
                        $limite = MysqlQuery::RequestPost('limit1_');
                        $result = Mysql::consulta("SELECT limite_ FROM limite WHERE ID='1'");
                        
                        $result_id = Mysql::consulta("SELECT limite_ FROM limite WHERE ID='0' OR ID IS NULL");
                        
                        if ($result) {
                            // Obtener el valor de 'limite_' cuando 'ID' es igual a 1
                            $row = $result->fetch_assoc();
                            $lmt = (int)$row['limite_'] ?? null;
                        
                            if ($limite != $lmt && $limite != 0) {
                                MysqlQuery::Actualizar("limite", "limite_='$limite'", "ID='1'");
                            }
                        }
                        
                        if ($result_id) {
                            // Comprobar si 'ID' es 0 o nulo
                            if ($result_id->num_rows > 0) {
                                // Si 'ID' es 0 o nulo, agregar 5 a 'limite_' y establecer 'ID' en 1
                                MysqlQuery::guardar("limite", "ID,limite_", "'1','5'");
                            }
                        }
                    }*/
                    

                ?> 
    <div class="modal fade" tabindex="-1" role="dialog" id="cont" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title text-center text-primary" id="myModalLabel">Rango de fechas</h4>
                </div>
                <form action="./admin.php?view=ticketadmin&ticket=fecha" method="POST" style="margin: 20px;">
                    <div class="form-group">
                        <label><span class="p3 glyphicon glyphicon-calendar"></span>&nbsp;Fecha inicial</label>
                        <input type="date" class="form-control p-5" required="" id="fecha_inicial" name="fecha_inicial" value="" />
                    </div>
                    <div class="form-group">
                        <label><span class="p3 glyphicon glyphicon-calendar"></span>&nbsp;Fecha final</label>
                        <input type="date" class="form-control p-5" required="" name="fecha_final" name="fecha_final" value=""/>
                    </div>
                    <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Aceptar</button>
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-pills nav-justified">
                                <li><a href="./admin.php?view=ticketadmin&ticket=all"><i class="fa fa-list"></i>&nbsp;&nbsp;Todos los tickets&nbsp;&nbsp;<span class="badge"><?php echo $num_total_all; ?></span></a></li>
                                <li><a href="./admin.php?view=ticketadmin&ticket=pending"><i class="fa fa-envelope"></i>&nbsp;&nbsp;Tickets pendientes&nbsp;&nbsp;<span class="badge"><?php echo $num_total_pend; ?></span></a></li>
                                <li><a href="./admin.php?view=ticketadmin&ticket=process"><i class="fa fa-folder-open"></i>&nbsp;&nbsp;Tickets en proceso&nbsp;&nbsp;<span class="badge"><?php echo $num_total_proceso; ?></span></a></li>
                                <li><a href="./admin.php?view=ticketadmin&ticket=resolved"><i class="fa fa-thumbs-o-up"></i>&nbsp;&nbsp;Tickets resueltos&nbsp;&nbsp;<span class="badge"><?php echo $num_total_res; ?></span></a></li>  
                                <li><a href="#!" data-toggle="modal" data-target="#cont"><span class="fa fa-stop-circle-o"></span>&nbsp;&nbsp;Filtrar por fecha<span class="badge"></a></li>
                            </ul>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <?php
                                                        
                                    $mysqli = mysqli_connect(SERVER, USER, PASS, BD);
                                    mysqli_set_charset($mysqli, "utf8");

                                    $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
                                    $regpagina = 15;
                                    $inicio = ($pagina > 1) ? (($pagina * $regpagina) - $regpagina) : 0;

                                    
                                    if(isset($_GET['ticket'])){
                                        $fechaInicial = MysqlQuery::RequestPost('fecha_inicial');
                                        $fechaFinal = MysqlQuery::RequestPost('fecha_final');
                                        if($_GET['ticket']=="all"){
                                            $consulta="SELECT SQL_CALC_FOUND_ROWS ticket.*, problemas.*, administrador.nombre_completo AS nombre_admin FROM ticket
                                            INNER JOIN problemas ON ticket.id_problema = problemas.id_problema
                                            INNER JOIN administrador ON problemas.id_admin = administrador.id_admin
                                            LIMIT $inicio, $regpagina";
                                        } elseif($_GET['ticket']=="pending") {
                                            $consulta="SELECT SQL_CALC_FOUND_ROWS ticket.*, problemas.*, administrador.nombre_completo AS nombre_admin FROM ticket
                                            INNER JOIN problemas ON ticket.id_problema = problemas.id_problema
                                            INNER JOIN administrador ON problemas.id_admin = administrador.id_admin
                                            WHERE estado_ticket='Pendiente' LIMIT $inicio, $regpagina";
                                        } elseif($_GET['ticket']=="process") {
                                            $consulta="SELECT SQL_CALC_FOUND_ROWS ticket.*, problemas.*, administrador.nombre_completo AS nombre_admin FROM ticket
                                            INNER JOIN problemas ON ticket.id_problema = problemas.id_problema
                                            INNER JOIN administrador ON problemas.id_admin = administrador.id_admin
                                            WHERE estado_ticket='En proceso' LIMIT $inicio, $regpagina";
                                        } elseif($_GET['ticket']=="resolved") {
                                            $consulta="SELECT SQL_CALC_FOUND_ROWS ticket.*, problemas.*, administrador.nombre_completo AS nombre_admin FROM ticket
                                            INNER JOIN problemas ON ticket.id_problema = problemas.id_problema
                                            INNER JOIN administrador ON problemas.id_admin = administrador.id_admin
                                            WHERE estado_ticket='Resuelto' LIMIT $inicio, $regpagina";
                                        } elseif($_GET['ticket']=="fecha" && (isset($_POST['fecha_inicial']) && isset($_POST['fecha_final']))) {
                                            $consulta="SELECT SQL_CALC_FOUND_ROWS ticket.*, problemas.*, administrador.nombre_completo AS nombre_admin 
                                            FROM ticket
                                            INNER JOIN problemas ON ticket.id_problema = problemas.id_problema
                                            INNER JOIN administrador ON problemas.id_admin = administrador.id_admin 
                                            WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinal'
                                            LIMIT $inicio, $regpagina";
                                        } else {
                                            $consulta="SELECT SQL_CALC_FOUND_ROWS ticket.*, problemas.*, administrador.nombre_completo AS nombre_admin FROM ticket
                                            INNER JOIN problemas ON ticket.id_problema = problemas.id_problema
                                            INNER JOIN administrador ON problemas.id_admin = administrador.id_admin 
                                            LIMIT $inicio, $regpagina";
                                        }
                                    } else {
                                        $consulta="SELECT SQL_CALC_FOUND_ROWS ticket.*, problemas.*, administrador.nombre_completo AS nombre_admin FROM ticket
                                        INNER JOIN problemas ON ticket.id_problema = problemas.id_problema
                                        INNER JOIN administrador ON problemas.id_admin = administrador.id_admin LIMIT $inicio, $regpagina";
                                    }


                                    $selticket=mysqli_query($mysqli,$consulta);



                                    $totalregistros = mysqli_query($mysqli,"SELECT FOUND_ROWS()");
                                    $totalregistros = mysqli_fetch_array($totalregistros, MYSQLI_ASSOC);
                            
                                    $numeropaginas = ceil($totalregistros["FOUND_ROWS()"]/$regpagina);

                                    if(mysqli_num_rows($selticket)>0):

                                ?>
                                
                                <table class="table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Fecha</th>
                                            <th class="text-center">Serie</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Nombre</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Carnet</th>
                                            <th class="text-center">encargado</th>
                                            <th class="text-center">cita</th>
                                            <th class="text-center ">Fecha de resolucion</th>
                                            <th class="text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $ct=$inicio+1;
                                            while ($row=mysqli_fetch_array($selticket, MYSQLI_ASSOC)): 
                                        
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $ct; ?></td>
                                            <td class="text-center"><?php echo $row['fecha']; ?></td>
                                            <td class="text-center"><?php echo $row['serie']; ?></td>
                                            <td class="text-center"><?php echo $row['estado_ticket']; ?></td>
                                            <td class="text-center"><?php echo $row['nombre_usuario']; ?></td>
                                            <td class="text-center"><?php echo $row['email_cliente']; ?></td>
                                            <td class="text-center"><?php echo $row['carnet']; ?></td>
                                            <td class="text-center"><?php echo $row['nombre_admin']; ?></td>
                                            <td class="text-center"><?php echo $row['hora_cita']; ?></td>
                                            <td class="text-center"><?php echo $row['fecha_resolucion']; ?></td>
                                            <td class="text-center">
                                                <a href="./lib/pdf.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success" target="_blank"><i class="fa fa-print" aria-hidden="true"></i></a>

                                                <a href="admin.php?view=ticketedit&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></a>

                                                <form action="" method="POST" style="display: inline-block;">
                                                    <input type="hidden" name="id_del" value="<?php echo $row['id']; ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php
                                            $ct++;
                                            endwhile; 
                                        ?>
                                    </tbody>
                                </table>
                                <?php else: ?>
                                    <h2 class="text-center">No hay tickets registrados en el sistema</h2>
                                <?php endif; ?>
                            </div>
                            <?php 
                                if($numeropaginas>=1):
                                if(isset($_GET['ticket'])){
                                    $ticketselected=$_GET['ticket'];
                                }else{
                                    $ticketselected="all";
                                }
                            ?>
                            <nav aria-label="Page navigation" class="text-center">
                                <ul class="pagination">
                                    <?php if($pagina == 1): ?>
                                        <li class="disabled">
                                            <a aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                    <?php else: ?>
                                        <li>
                                            <a href="./admin.php?view=ticketadmin&ticket=<?php echo $ticketselected; ?>&pagina=<?php echo $pagina-1; ?>" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    
                                    
                                    <?php
                                        for($i=1; $i <= $numeropaginas; $i++ ){
                                            if($pagina == $i){
                                                echo '<li class="active"><a href="./admin.php?view=ticketadmin&ticket='.$ticketselected.'&pagina='.$i.'">'.$i.'</a></li>';
                                            }else{
                                                echo '<li><a href="./admin.php?view=ticketadmin&ticket='.$ticketselected.'&pagina='.$i.'">'.$i.'</a></li>';
                                            }
                                        }
                                    ?>
                                    
                                    
                                    <?php if($pagina == $numeropaginas): ?>
                                        <li class="disabled">
                                            <a aria-label="Previous">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    <?php else: ?>
                                        <li>
                                            <a href="./admin.php?view=ticketadmin&ticket=<?php echo $ticketselected; ?>&pagina=<?php echo $pagina+1; ?>" aria-label="Previous">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                            <?php endif; ?>
                        </div>
                    </div>
                </div><!--container principal-->
    <?php
    }else{
    ?>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <img src="./img/Stop.png" alt="Image" class="img-responsive animated slideInDown"/><br>
                        
                    </div>
                    <div class="col-sm-7 animated flip">
                        <h1 class="text-danger">Lo sentimos esta página es solamente para administradores</h1>
                        <h3 class="text-info text-center">Inicia sesión como administrador para poder acceder</h3>
                    </div>
                    <div class="col-sm-1">&nbsp;</div>
                </div>
            </div>
    <?php
    }
    ?>
