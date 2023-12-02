<?php if($_SESSION['nombre']!="" && $_SESSION['tipo']=="admin"){ 

 if(isset($_POST['id_del'])){
     $id = MysqlQuery::RequestPost('id_del');
     if(MysqlQuery::Eliminar("problemas", "id_problema='$id'")){
    echo '
     <div class="alert alert-info alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
     <h4 class="text-center">Problema Eliminado con Exito</h4>
     <p class="text-center">
     Eliminado del sistema con exito
 </p>
 </div>
 ';
    }else{
        echo '
             <div class="alert alert-danger alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
             <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
             <h4 class="text-center">OCURRIÓ UN ERROR</h4>
             <p class="text-center">
             No hemos podido eliminar 
             </p>
         </div>
         '; 
     }
 }

if(isset($_POST['encargado']) && isset($_POST['consulta'])){

  
    $encargado= MysqlQuery::RequestPost('encargado');
    $problema=MysqlQuery::RequestPost('consulta');

    if(MysqlQuery::Guardar("problemas","id_admin,consulta", " '$encargado','$problema'")){
        echo '
        <div class="alert alert-danger alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="text-center">Exito</h4>
            <p class="text-center">
                Agregado con exito
            </p>
        </div>
    ';

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
            $idA=$_SESSION['id'];
            /* Todos los admins*/
            $num_admin=Mysql::consulta("SELECT * FROM administrador WHERE id_admin!='1' AND id_admin!='$idA'");
            $num_total_admin = mysqli_num_rows($num_admin);
          
        ?>
        <div class="container">
          <div class="row">
            <div class="col-sm-2">
                <img src="./img/set.png" alt="Image" class="img-responsive animated flipInY">
            </div>
            <div class="col-sm-10">
              <p class="lead text-info">Bienvenido administrador, en esta página se muestran las consultas a realizar.</p>
            </div>
          </div>
        </div>
        
        <br><br>
        
        <div class="container">
        <div class="row">
            <!-- Izquierda: Agregar Tipo de Consulta -->
            <div class="col-sm-4">
                <div class="panel panel-success">
                    <div class="panel-heading text-center"><i class="fa fa-plus"></i>&nbsp;<strong>Agregar nuevo tipo de consulta</strong></div>
                    <div class="panel-body">
                        <form role="form" action="" method="post">
                            <div class= "form-group">
                            <label><i class="fa fa-comment"></i>&nbsp;Encargado</label>
                            <select class="form-control" name="encargado" required="">
    <?php
    // Obtener la lista de administradores
    $query_admins = Mysql::consulta("SELECT id_admin, nombre_completo FROM administrador WHERE id_admin != 1 AND id_admin != '$idA'");
    
    if ($query_admins) {
        while ($admin = mysqli_fetch_assoc($query_admins)) {
            $idAdmin = $admin['id_admin'];
            $nombreCompleto = $admin['nombre_completo'];

            // Marcar el administrador actualmente seleccionado, si es necesario
            $selected = ($idAdmin == $selectedNombreCompleto) ? 'selected' : '';

            echo '<option value="' . $idAdmin . '" ' . $selected . '>' . $nombreCompleto . '</option>';
        }

        mysqli_free_result($query_admins); // Liberar el conjunto de resultados
    } else {
        echo '<option value="" disabled>No hay administradores disponibles</option>';
    }
    ?>
</select>

                            </div>
                            <div class="form-group">
                                <label><i class="fa fa-comment"></i>&nbsp;Consulta</label>
                                <input type="text" class="form-control" name="consulta" placeholder="Consulta" required="">
                            </div>
                            <center><button type="submit" class="btn btn-success">Agregar consulta</button></center>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Derecha: Consulta -->
            <div class="col-sm-8">
                    <div class="col-md-12 text-center">
                        <ul class="nav nav-pills nav-justified">
                            <li><a href="./admin.php?view=admin"><i class="fa fa-male"></i>&nbsp;&nbsp;Administradores&nbsp;&nbsp;<span class="badge"><?php echo $num_total_admin; ?></span></a></li>
                        </ul>
                    </div>
                    <div class="table-responsive">
                        <?php
                    $mysqli = mysqli_connect(SERVER, USER, PASS, BD);
                    mysqli_set_charset($mysqli, "utf8");

                    $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
                    $regpagina = 15;
                    $inicio = ($pagina > 1) ? (($pagina * $regpagina) - $regpagina) : 0;

                    // Consultar las filas de la tabla 'consultas' paginadas
                    $selconsultas = mysqli_query( $mysqli,"SELECT SQL_CALC_FOUND_ROWS problemas.*, administrador.nombre_completo AS nombre_admin FROM problemas
                    INNER JOIN administrador ON problemas.id_admin = administrador.id_admin
                    LIMIT $inicio, $regpagina");

                    $totalregistros = mysqli_query($mysqli, "SELECT FOUND_ROWS()");
                    $totalregistros = mysqli_fetch_array($totalregistros, MYSQLI_ASSOC);

                    $numeropaginas = ceil($totalregistros["FOUND_ROWS()"] / $regpagina);
                    if (mysqli_num_rows($selconsultas) > 0) :
                    ?>
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Encargado</th>
                                    <th class="text-center">Problema</th>
                                    <th class="text-center">Opciones</th>
                                    <!-- Agregar más columnas si es necesario -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $ct = $inicio + 1;
                                while ($row = mysqli_fetch_array($selconsultas, MYSQLI_ASSOC)) :
                                ?>
                                    <tr>
                                        <td class="text-center"><?php echo $ct; ?></td>
                                        <td class="text-center"><?php echo $row['nombre_admin']; ?></td>
                                        <td class="text-center"><?php echo $row['consulta']; ?></td>
                                        <td class="text-center">
                                            <form action="" method="POST" style="display: inline-block;">
                                                <input type="hidden" name="id_del" value="<?php echo $row['id_problema']; ?>">
                                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                            </form>
                                        </td>
                                        <!-- Agregar más celdas si es necesario -->
                                    </tr>
                                <?php
                                    $ct++;
                                endwhile;
                                ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <h2 class="text-center">No hay consultas registradas en el sistema</h2>
                    <?php endif; ?>
                    <?php if ($numeropaginas >= 1) : ?>
                    <!-- Aquí va la sección de paginación -->
                <?php endif; ?>
                </div>
                </div>
            </div>
        </div>
    </div>
<?php
?>
                        </div>
                        <?php if($numeropaginas>=1): ?>
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
                                        <a href="./admin.php?view=admin&pagina=<?php echo $pagina-1; ?>" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                
                                
                                <?php
                                    for($i=1; $i <= $numeropaginas; $i++ ){
                                        if($pagina == $i){
                                            echo '<li class="active"><a href="./admin.php?view=admin&pagina='.$i.'">'.$i.'</a></li>';
                                        }else{
                                            echo '<li><a href="./admin.php?view=admin&pagina='.$i.'">'.$i.'</a></li>';
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
                                        <a href="./admin.php?view=admin&pagina=<?php echo $pagina+1; ?>" aria-label="Previous">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
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