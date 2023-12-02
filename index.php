<?php
session_start();
include './lib/class_mysql.php';
include './lib/config.php';
header('Content-Type: text/html; charset=UTF-8');  
$_SESSION['start_time'] = time();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Registro de Consultas</title>
        <?php include "./inc/links.php"; ?>        
    </head>
    <body>   
        <?php include "./inc/navbar.php"; ?>
        <div class="container">
          <div class="row">
            <div class="col-sm-12">
              <div class="page-header">
                <h1 class="animated lightSpeedIn">Registro de consultas <small>Universidad Católica de El Salvador</small></h1>
                <span class="label label-danger">Decanato de Ingeniería y Arquitectura</span>
                <p class="pull-right text-primary">
                  <strong>
                  <?php include "./inc/timezone.php"; ?>
                 </strong>
               </p>
              </div>
            </div>
          </div>
        </div>
        <br>
        <?php
            if(isset($_GET['view'])){
                $content=$_GET['view'];
                $WhiteList=["index","ticket","ticketcon", "consulta", "consulta"];
                if(in_array($content, $WhiteList) && is_file("./user/".$content."-view.php")){
                    include "./user/".$content."-view.php";
                }else{
        ?>

        <?php
                }
            }else{
                include "./user/index-view.php";
            }
        ?>
                <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>

      <?php include './inc/footer.php'; ?>
    </body>
</html>
