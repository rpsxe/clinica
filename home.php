<?php 
include("cabecalho.php"); 
echo '<title>Inicio</title>';
?>
<body>
  <div class="container text-center">  
    <div class="row"> 
      <div class="jumbotron" style="background: white;">
        <div class="col-sm-4 col-md-offset-3">
          <img src="img/logo.png" class="img-responsive">
          <h2>Seja bem vindo!</h2>
          <a data-toggle="modal" data-target="#mais" style="cursor: pointer;">Saiba mais</a>
          <hr>
        </div>
        <div class="col-sm-4 col-md-offset-1">
          <div class="row">
            <div class="col-sm-12">
              <h3 style="font-family: Roboto;">Aniversariantes de hoje</h3><br>
              <?php include("header/aniversario.php"); ?>
            </div>
          </div><br><br>
<!--           <div class="row">
            <div class="col-sm-12">
              <center><button class="btn btn-default" data-toggle="modal" data-target="#lista">Lista de Presenças</button></center>
            </div>
          </div> -->
        </div>
      </div>
    </div>
  </div>
</body>
</html>





<div id="lista" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p><?php include("lista-alunos.php"); ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>

  </div>
</div>
<div class="modal fade" id="mais" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">SOBRE O SISTEMA</h4>
      </div>
      <div class="modal-body">
        <div class="jumbotron" style="background-color: white; padding: 20px; text-align: justify;">
          <p>
            O sistema foi desenvolvido no final de 2017 e inicio de 2018, sendo colocado em produção em março de 2018, desde então vem sendo usado com bastante frequência, guardando e gerenciando os dados referentes a parte clínica da instituição. 
            <br><br>
            Este por sua vez vem ajudando não somente no gerenciamento de dados, mas cada vez mais está facilitando o trabalho dos profissionais envolvidos com o setor, tanto na parte da secretaria, profissionais e até na parte da coordenação, o mesmo também reduziu o consumo de papel e tinta usados anteriormente para registro de atividades, presenças, entre outros.
            Muitas melhorias e atualizações estão sendo feitas diariamente, buscando cada vez mais facilitar os profissionais que utilizam o mesmo.
            <br>
            <br>
            Atualmente temos mais de 60.000 registros no banco de dados, são cerca de 57.000 só de atendimentos entre março/2018 quando este foi colocado em produção, até o dia de hoje 01/11/2019, também existe mais de 1300 cadastros de atendidos, com seus dados pessoais assim como de seus familiares, e também a agenda de atendimentos semanais, a qual tem mais de 1300 registros, entre ativos e inativos.
          </p>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>