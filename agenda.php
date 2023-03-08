<title>Agenda</title>
<?php 
include("cabecalho.php");
if(isset($_GET['dia']))
{
	$dia=$_GET['dia'];
	if (is_numeric($dia)){if($dia>5){
		header("Location: inicio");}
	}else{
		header("Location: inicio"); exit;
	}
}else{
	$dia=date("N");
}
$cont=1;
$ativarContador = NULL;
?> 
<style>
	.row-striped:nth-of-type(odd){
		background-color: #efefef;
		border-left: 4px #000000 solid;
	}

	.row-striped:nth-of-type(even){
		background-color: #ffffff;
		border-left: 4px #efefef solid;
	}

	.row-striped {
		padding: 15px 0;
	}
</style>
<div class="container text-center">  
	<div class="resultado"></div>
	<div class="row"> 
		<div class="jumbotron" style="background: white;">
			<h1 style="font-family: 'IBM Plex Serif', serif;">Agenda <button type="button" class="btn btn-default" title="Infos" data-toggle="collapse" data-target="#infos">+</button></h1> 
			<hr>
			<a href="1" ><?php if($dia == 1){ $vDia = 'Segunda'; echo '<strong>'; } ?>Segunda</strong></a> / <a href="2" ><?php if($dia == 2){ $vDia = 'Terça'; echo '<strong>'; } ?>Terça</strong></a> / <a href="3" ><?php if($dia == 3){ $vDia = 'Quarta'; echo '<strong>'; } ?>Quarta</strong></a> / <a href="4" ><?php if($dia == 4){ $vDia = 'Quinta'; echo '<strong>'; } ?>Quinta</strong></a> / <a href="5" ><?php if($dia == 5){ $vDia = 'Sexta'; echo '<strong>'; } ?>Sexta</strong></a> 
			<br><br>
			<input class="form-control" id="myInput" type="text" placeholder="Buscar...">
			<div id="infos" class="collapse">
				Existem <b><?php echo $agenda; ?></b> atendimentos agendados para a semana e <b><?php echo $numAl; ?></b> assistidos ativos!<br>
				Estão marcados <b><?php echo $seg; ?></b> atendimentos para segunda-feira, <b><?php echo $ter; ?></b> para terça-feira, <b><?php echo $quar; ?></b> para quarta-feira, <b><?php echo $quin; ?></b> para quinta-feira, <b><?php echo $sex; ?></b> para sexta-feira.
			</div>
		</div>
		<div id="agenda">
			<?php
			$data = date("Y-m-d");
			$select = "SELECT agenda.*, profissionais.nome as p_nome, servicos.nome as serv_nome, assistidos.nome as assist_nome, assistidos.pasta as pasta
			FROM agenda
			INNER JOIN assistidos ON agenda.id_assist = assistidos.id_assist
			INNER JOIN profissionais ON agenda.id_prof = profissionais.id
			INNER JOIN servicos ON agenda.id_serv = servicos.id
			WHERE NOT EXISTS (select 1
			from atendimentos
			WHERE data = '$data'
			AND OBS = agenda.id)
			AND dia=:dia
			AND ativo='S'
			AND profissionais.ver = '0'
			AND id_prof!='22'
			AND tipo!='Oficinas'
			AND tipo!='pOficinas'
			ORDER BY horario ASC";
			$result=$conexao->prepare($select);
			$result->bindParam(':dia', $dia, PDO::PARAM_INT);
			$result->execute();
			$contar= $result->rowCount();
			if($contar>0){		
				while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {	
					$nome = $linha->assist_nome;
					$nome = implode('-', explode(' ', $nome));
					$horaAtendimento = date('H:i', strtotime($linha->horario));
					$fimAtendimento = date('H:i', strtotime('+30 minute', strtotime($linha->horario)));
					$horaVerifica = date('H:i');
					if($dia == date("N")){
						if ($horaVerifica  >= $horaAtendimento AND $horaVerifica  < $fimAtendimento){
							$classeBadge = 'class="badge animated infinite pulse" style="background-color: #085085; color: white;"';
							$ativarContador = 1;
							$fimHorario = $fimAtendimento;
							
						}else{
							$classeBadge = 'class="badge" style="background-color: #777; color: white;"';
							$ativarContador = NULL;
						}
					}else{
						$classeBadge = 'class="badge"';
					}
					?>
					<div class="row row-striped busca" style="margin: 10px; border-radius: 15px; background-color: #efefef">
						<div class="col-lg-2 text-center">
							<span <?php echo $classeBadge; ?>><h3><?php echo $linha->horario; ?></h3></span>
							<?php 
							if ($ativarContador == 1) {
								echo '<br>
								<input type="hidden" id="fimAtendimento" value="'.$fimHorario.'">
								<div class="mostraTempo"></div>';
							}else{

							}
							?>
						</div>
						<div class="col-lg-8" style="text-align: left">
							<h4 class="text-uppercase"><strong><a href="p<?php echo $nome;?>-<?php echo $linha->id_assist;?>"><?php	echo $linha->assist_nome; ?></a></strong></h4>
							<ul class="list-inline">
								<!-- <li class="list-inline-item"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $linha->horario.' - '.date('H:i', strtotime('+30 minute', strtotime($linha->horario))); ?></li> -->
								<li class="list-inline-item"><i class="fa fa-user" aria-hidden="true"></i> <?php	echo  $linha->p_nome; ?></li>
								<li class="list-inline-item"><i class="fa fa-stethoscope" aria-hidden="true"></i> <?php	echo $linha->serv_nome; ?></li>
								<li class="list-inline-item"><i class="fa fa-id-card" aria-hidden="true"></i> <?php	echo $linha->tipo; ?></li>
								<li class="list-inline-item"><i class="fa fa-address-book-o" aria-hidden="true"></i> <?php	echo $linha->pasta; ?></li>
							</ul>
						</div>
						<?php if($_SESSION['nivel'] == 1){

							if ($dia == date('N')) {


								?>	<div class="col-lg-1"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalVisualizar" data-nome="<?php echo $linha->assist_nome ?>" data-id="<?php echo $linha->id_assist; ?>" data-idprof="<?php echo $linha->id_prof; ?>" data-idserv="<?php echo $linha->id_serv; ?>" data-idatendimento="<?php echo $linha->id; ?>" data-conv="<?php echo $linha->tipo; ?>" data-idagenda="<?php echo $linha->id; ?>" data-nomeprof="<?php	echo  $linha->p_nome; ?>" data-nomeserv="<?php echo $linha->serv_nome; ?>">Registrar</button></div>
								<div class="col-lg-1 text-center" style="display: inline-block;">
									<div class="row">								
										<button class="btn btn-success action-present" data-id_assist="<?php echo $linha->id_assist; ?>" data-id_prof="<?php echo $linha->id_prof; ?>" data-idserv="<?php echo $linha->id_serv; ?>" data-idatendimento="<?php echo $linha->id; ?>" data-conv="<?php echo $linha->tipo; ?>" data-idagenda="<?php echo $linha->id; ?>" data-estado="Presente">v</button>
										<button class="btn btn-danger action-present"  data-id_assist="<?php echo $linha->id_assist; ?>" data-id_prof="<?php echo $linha->id_prof; ?>" data-idserv="<?php echo $linha->id_serv; ?>" data-idatendimento="<?php echo $linha->id; ?>" data-conv="<?php echo $linha->tipo; ?>" data-idagenda="<?php echo $linha->id; ?>" data-estado="Falta">x</button>
									</div>
								</div>
								<?php 
							}else{

							}

						} ?>
					</div>



					<?php 	
				}
			}
			?>
		</div>
	</div>
	<input type="hidden" id="dataAtual" value="<?php echo date("m/d/Y"); ?>">
</div>
<div class="modal fade" id="ModalVisualizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header bg-dark text-light">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="grava-atendimento.php" method="post">
					<input type="hidden" class="form-control" name="id_assist" id="id">	
					<input type="hidden" class="form-control" name="id_prof" id="idprof">	
					<input type="hidden" class="form-control" name="id_serv" id="idserv">			
					<input type="hidden" class="form-control" name="id_agenda" id="idagenda">	
					<input type="hidden" class="form-control" name="conv" id="conv">

					<div class="col-sm-6">
						<div class="form-group">
							<label for="nome">Nome:</label>
							<input type="text" class="form-control" name="nome" id="nome" disabled="">	
						</div>	
						<div class="form-group">
							<label for="profissionail">Profissional:</label>
							<input type="text" class="form-control" name="profissionail" id="profissionail" disabled="">	
						</div>
					</div>
					<div class="col-sm-6">	
						<div class="form-group">
							<label for="servico">Atendimento:</label>
							<input type="text" class="form-control" name="servico" id="servico" disabled="">	
						</div>
						<div class="form-group">
							<label for="conv">Convênio:</label>
							<input type="text" class="form-control" name="conv" id="mostra-conv" disabled="">	
						</div>	
					</div>	
					<div class="row">
						<div class="col-sm-8 col-md-offset-2">
							<div class="form-group">
								<select class="form-control" name="status" required>
									<option selected value="Presente">Presente</option>
									<option value="Falta">Falta</option>
									<option value="Falta Justificada">Falta Justificada</option>
									<option value="Dispensado">Dispensado</option>
									<option value="Inserido">Inserido</option>
									<option value="Desligado">Desligado</option>
									<option value="Alta">Alta</option>
									<option value="Profissional Ausente">Profissional Ausente</option>
									<option value="Profissional em Férias">Profissional  em Férias</option>
									<option value="Profissional em Atestado">Profissional  em Atestado</option>
									<option value="Festividades">Festividades</option>
									<option value="Informações Sobre">Informações Sobre</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<center><button class="btn btn-primary" type="submit" name="enviar"  style="margin-right: 3px">Enviar</button>
							<button class="btn btn-default" style="padding: 5px;"><a id="linkAtualiza">Atualizar</a></button></center>			
						</div>
					</div>
					<div class="modal-footer">
						<!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button> -->
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$(document).ready(function(){

			$(function() {
				timeout = setTimeout(function() {
					location.reload();
				}, 120000);
			});

			$(document).on('mousemove', function() {
				if (timeout !== null) { 
					clearTimeout(timeout);
				}
				timeout = setTimeout(function() {
					location.reload();
				}, 120000);
			});

			// function verhora(){
			// 	var data = document.getElementById("dataAtual").value;
			// 	var hora = document.getElementById("fimAtendimento").value;

			// 	var countDownDate = new Date(data + ' ' + hora).getTime();

			// 	var x = setInterval(function() {
			// 		var now = new Date().getTime();
			// 		var distance = countDownDate - now;

			// 		var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			// 		var seconds = Math.floor((distance % (1000 * 60)) / 1000);


			// 		$(".mostraTempo").html( minutes + "m " + seconds + "s ");

			// 		if (distance < 0) {
			// 			clearInterval(x);
			// 			$(".mostraTempo").html( "Atendimento finalizado!");
			// 			window.location.reload();
			// 		}
			// 	}, 1000);
			// };

			$(".action-present").click(function(){
				var id_assist = $(this).data('id_assist');					
				    var id_agenda = $(this).data('idatendimento'); // Extract info from data-* attributes
				    var id_prof = $(this).data('id_prof');
				    var idserv = $(this).data('idserv');
				    var conv = $(this).data('conv');
				    var estado = $(this).data('estado');

				    $.post("grava-atendimento.php", {id_assist:id_assist, id_agenda:id_agenda, id_prof:id_prof, id_serv:idserv, conv:conv, status:estado }, function(retorno){
				    	$('html, body').animate({scrollTop:0}, 'fast');
				    	location.reload();
				    });
				})

			$('#ModalVisualizar').on('show.bs.modal', function (event) {
				    var button = $(event.relatedTarget); // Button that triggered the modal
				    var recipientid = button.data('id'); // Extract info from data-* attributes
				    var recipientidatendimento = button.data('idatendimento'); // Extract info from data-* attributes
				    var recipientnome = button.data('nome');
				    var recipientidprof = button.data('idprof');
				    var recipientidserv = button.data('idserv');
				    var recipientconv = button.data('conv');
				    var recipientidagenda = button.data('idagenda');
				    var recipientnomeserv = button.data('nomeserv');
				    var recipientnomeprof = button.data('nomeprof');
				    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
				    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
				    var modal = $(this)
				    modal.find('#id').val(recipientid)
				    modal.find('#nome').val(recipientnome)
				    modal.find('#idprof').val(recipientidprof)
				    modal.find('#idserv').val(recipientidserv)
				    modal.find('#conv').val(recipientconv)
				    modal.find('#mostra-conv').val(recipientconv)
				    modal.find('#idagenda').val(recipientidagenda)
				    modal.find('#profissionail').val(recipientnomeprof)
				    modal.find('#servico').val(recipientnomeserv)
				    $("#linkAtualiza").attr('href', 'atualizar-horario' + recipientidatendimento)
				});

			$("#myInput").on("keyup", function() {
				var value = $(this).val().toLowerCase();
				$("#agenda .busca").filter(function() {
					$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
				});
			});
			// verhora();
		});

	</script>