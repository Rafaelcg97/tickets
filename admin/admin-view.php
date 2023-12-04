<?php if($_SESSION['nombre']!="" && $_SESSION['tipo']=="admin"){ ?>    
        <?php
if (isset($_POST['admin_id_nuevo_encargado'])) {
    $adminNuevo = MysqlQuery::RequestPost('admin_id_nuevo_encargado');
    $id_admin = MysqlQuery::RequestPost('admin_id');

    // Obtener el límite de tickets del administrador actual
    $num_ = Mysql::consulta("SELECT tickets_permitidos FROM administrador WHERE id_admin='$id_admin'");
    $row = mysqli_fetch_assoc($num_);
    $tic_actual = $row['tickets_permitidos'];

    // Actualizar datos del administrador actual
    if (MysqlQuery::Actualizar("administrador", "tickets_permitidos=0, estado='deshabilitado'", "id_admin='$id_admin'")) {
        // Obtener el límite de tickets del nuevo administrador
        $numNuevo = Mysql::consulta("SELECT tickets_permitidos FROM administrador WHERE id_admin='$adminNuevo'");
        $rowNuevo = mysqli_fetch_assoc($numNuevo);
        $tic_nuevo = $rowNuevo['tickets_permitidos'];

        // Actualizar datos del nuevo administrador
        if (MysqlQuery::Actualizar("administrador", "tickets_permitidos='$tic_nuevo' + '$tic_actual'", "id_admin='$adminNuevo'") &&
            MysqlQuery::Actualizar("problemas", "id_admin='$adminNuevo'", "id_admin='$id_admin'")
        ) {
            echo '
                <div class="alert alert-info alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="text-center">ADMINISTRADOR ELIMINADO</h4>
                    <p class="text-center">
                        El administrador fue eliminado del sistema con éxito(trabajando)
                    </p>
                </div>
            ';
        } else {
            echo '
                <div class="alert alert-danger alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="text-center">OCURRIÓ UN ERROR</h4>
                    <p class="text-center">
                        No hemos podido eliminar el administrador
                    </p>
                </div>
            ';
        }
        }
            }elseif(isset($_POST['id_tick']) ){
                $id_tic=MysqlQuery::RequestPost('id_tick');
                $id_ad=MysqlQuery::RequestPost('admin_id');
                if(MysqlQuery::Actualizar("administrador", "tickets_permitidos='$id_tic'","id_admin='$id_ad'")){
                    echo '
                        <div class="alert alert-info alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="text-center">Actualizado</h4>
                            <p class="text-center">
                                Actualizado con exito
                            </p>
                        </div>
                    ';
                }else{
                    echo '
                        <div class="alert alert-danger alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="text-center">OCURRIÓ UN ERROR</h4>
                            <p class="text-center">
                                No hemos podido cambiar el limite de ticket
                            </p>
                        </div>
                    ';
                } 
            }
            


            $idA=$_SESSION['id'];
            /* Todos los admins*/
            $num_admin=Mysql::consulta("SELECT * FROM administrador WHERE id_admin!='1' AND id_admin!='$idA'");
            $num_total_admin = mysqli_num_rows($num_admin);
            $id_ad=MysqlQuery::RequestPost('admin_id');
          
        ?>
        <div class="container">
          <div class="row">
            <div class="col-sm-2">
                <img src="./img/set.png" alt="Image" class="img-responsive animated flipInY">
            </div>
            <div class="col-sm-10">
              <p class="lead text-info">Bienvenido administrador, en esta página se muestran todos los usuarios y administradores registrados, usted podra eliminarlos si lo desea.</p>
            </div>
          </div>
        </div>
        <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <ul class="nav nav-pills nav-justified">
                            <li><a href="./admin.php?view=admin"><i class="fa fa-male"></i>&nbsp;&nbsp;Administradores&nbsp;&nbsp;<span class="badge"><?php echo $num_total_admin; ?></span></a></li>
                        </ul>
                    </div>
                </div>
                <br>
                <?php
        /* Modal para eliminar*/
?>
        <br><br>
        



                <?php
        /* Modal para actualizar*/
?>
                <div class="modal fade" tabindex="-1" role="dialog" id="cont" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content p-3">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center text-primary" id="myModalLabel">Limite de tickets</h4>
            </div>
            <form action="" method="POST" style="margin: 20px;">
                <div class="form-group">
                    <label><span class=" p3 glyphicon glyphicon-user"></span>&nbsp;Cantidad</label>
                    <input type="hidden" id="admin_id" name="admin_id" value="">
                    <input type="number" min="1" pattern="^[0-9]+" class="form-control p-5" placeholder="Escribe la cantidad de ticket" name="id_tick" />
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Aceptar</button>
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="desactivarAdminModal" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content p-3">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center text-primary" id="myModalLabel1">Deshabilitar administrador</h4>
            </div>
            <form action="" method="POST" style="margin: 20px;">
            <div class="form-group">
                    <label><span class="glyphicon glyphicon-info-sign"></span>&nbsp;Selecciona nuevo encargado</label>
                    <input type="hidden" id="admin_id_nuevo_encargado" name="admin_id_nuevo_encargado">
                    <select class="form-control" name="nuevo_encargado" id="nuevo_encargado" required>
                        <?php
                        $id_ad=MysqlQuery::RequestPost('admin_id');
                        // Obtener la lista de administradores activos (id diferente de 1)
                        $query = Mysql::consulta("SELECT id_admin, nombre_completo, tickets_permitidos FROM administrador WHERE estado='activo' AND id_admin!='1'  ");
                        if ($query)
                        {
                            while ($consul = mysqli_fetch_assoc($query)) {
                                $idc = $consul['id_admin'];
                                $nom = $consul['nombre_completo'];
                                $tic_n=$consul['tickets_permitidos'];
                                $selected = ($idc == $adminNuevo) ? 'selected' : '';
                                echo '<option value="' . $idc . '" ' . $selected . '>' . $nom . '</option>';
                            }
                            mysqli_free_result($query); 
                        }else {
                            echo '<option value="" disabled>No hay administradores disponibles</option>';
                          }
                        ?>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger btn-sm">Deshabilitar</button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>



                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <?php 
                                $mysqli = mysqli_connect(SERVER, USER, PASS, BD);
                                mysqli_set_charset($mysqli, "utf8");

                                $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
                                $regpagina = 15;
                                $inicio = ($pagina > 1) ? (($pagina * $regpagina) - $regpagina) : 0;

                                $seladmin=mysqli_query($mysqli,"SELECT SQL_CALC_FOUND_ROWS * FROM administrador WHERE id_admin!='1' AND id_admin!='$idA' LIMIT $inicio, $regpagina");

                                $totalregistros = mysqli_query($mysqli,"SELECT FOUND_ROWS()");
                                $totalregistros = mysqli_fetch_array($totalregistros, MYSQLI_ASSOC);
                        
                                $numeropaginas = ceil($totalregistros["FOUND_ROWS()"]/$regpagina);
                                if(mysqli_num_rows($seladmin)>0):
                            ?>
                            <table class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Nombre completo</th>
                                        <th class="text-center">Nombre de usuario</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Tickets</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $ct=$inicio+1;
                                        while ($row=mysqli_fetch_array($seladmin, MYSQLI_ASSOC)): 
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo $ct; ?></td>
                                        <td class="text-center"><?php echo $row['nombre_completo']; ?></td>
                                        <td class="text-center"><?php echo $row['nombre_admin']; ?></td>
                                        <td class="text-center"><?php echo $row['email_admin']; ?></td>
                                        <td class="text-center"><?php echo $row['tickets_permitidos']; ?></td>
                                        <td class="text-center"><?php echo $row['estado']; ?></td>
                                        <td class="text-center">
                                        <a href="#desactivarAdminModal" data-toggle="modal" data-target="#desactivarAdminModal" data-id="<?php echo $row['id_admin']; ?>" class="btn btn-sm btn-warning open-modal"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                        <a href="#cont" data-toggle="modal" data-target="#cont" data-id="<?php echo $row['id_admin']; ?>" class="btn btn-sm btn-info open-modal"><i class="fa fa-plus-square" aria-hidden="true"></i></a></td>
                                    </tr>
                                    <?php
                                        $ct++;
                                        endwhile; 
                                    ?>
                                </tbody>
                            </table>
                            <?php else: ?>
                                <h2 class="text-center">No hay administradores registrados en el sistema</h2>
                            <?php endif; ?>
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
<!-- Agrega esto al final del cuerpo del documento -->
<script>
    $(document).on("click", ".open-modal", function () {
        var adminId = $(this).data('id');
        $("#admin_id").val(adminId);
    });
</script>


<script>
        // Script para abrir el modal de deshabilitar administrador
        $(document).on("click", ".disable-admin-modal", function () {
            var adminId = $(this).data('id');
            $("#admin_id_disable").val(adminId); // Corregir el ID del campo oculto

            // Obtener el valor seleccionado en el select y establecerlo en el campo correspondiente
            var nuevoEncargadoId = $("#nuevo_encargado").val();
            $("#admin_id_nuevo_encargado").val(nuevoEncargadoId);

            $('#desactivarAdminModal').modal('show');
        });
    </script>


