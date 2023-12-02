<div class="container">
  <div class="row well">
    <div class="col-sm-3">
      <img src="img/unicaes.png" class="img-responsive" alt="Image">
    </div>
    <div class="col-sm-9 lead">
      <h2 class="text-info">Registrar una nueva cita</h2>
      <p>Si tienes dudas en algun proceso academico de la faculta de ingenieria y arquitectura crea una nueva cita y se te asignara un horario para tu consulta de acuerdo a disponibilidad.<br>Si ya nos ha enviado un ticket puede consultar el estado de este mediante su <strong>Ticket ID</strong>.</p>
    </div>
  </div><!--fin row 1-->

  <div class="row">
    <div class="col-sm-6">
      <div class="panel panel-info">
        <div class="panel-heading text-center"><i class="fa fa-file-text"></i>&nbsp;<strong>Nuevo Ticket</strong></div>
        <div class="panel-body text-center">
          <img src="./img/new_.png" alt="">
          <h4>Abrir un nuevo ticket</h4>
          <p class="text-justify">Si tienes algun problema reportalo creando un nuevo ticket, te ayudaremos a solucionarlo. Si desea actualizar una peticion ya realizada utiliza el formulario de la derecha <em>Comprobar estado de Ticket</em>.</p>
          <p>Para abrir un nuevo <strong>ticket</strong> has click en el siguiente boton</p>
          <a type="button" class="btn btn-info" href="./index.php?view=ticket">Nuevo Ticket</a>
        </div>
      </div>
    </div><!--fin col-md-6-->
    
    <div class="col-sm-6">
      <div class="panel panel-danger">
        <div class="panel-heading text-center"><i class="fa fa-link"></i>&nbsp;<strong>Comprobar estado de Ticket</strong></div>
        <div class="panel-body text-center">
          <img src="./img/old_.png" alt="">
          <h4>Consultar estado de ticket</h4>
          <form class="form-horizontal" role="form" method="GET" action="./index.php">
            <input type="hidden" name="view" value="ticketcon">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
              <div class="col-sm-10">
                  <input type="email" class="form-control" name="email_consul" placeholder="Email" required="">
              </div>
            </div>
            <div class="form-group">
              <label  class="col-sm-2 control-label">ID Ticket</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" name="id_consul" placeholder="ID Ticket" required="">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-success" >Consultar</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div><!--fin col-md-6-->
  </div><!--fin row 2-->
</div><!--fin container-->