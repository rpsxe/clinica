<?php 
include("cabecalho.php");
require_once('conecta/conexao.php');

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Agenda Provisória</title>
</head>
<body>
	<?php 
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
		<div class="row"> 
			<h1>Agenda Provisória</h1>
			<p>Horários gerados de acordo com dados das semanas anteriores.<br>Caso não tenha algum nome na lista, buscar na caixa de busca no canto superior direito.</p>
			<br>
			<div id="agenda">
				<?php
				$data = date("Y-m-d");
				$lastweek = date('Y-m-d', strtotime('-7 days', strtotime($data)));
				$select = "SELECT atendimentos.*, profissionais.nome as p_nome, servicos.nome as serv_nome, assistidos.nome as assist_nome
				FROM atendimentos
				INNER JOIN assistidos ON atendimentos.id_assist = assistidos.id_assist
				INNER JOIN profissionais ON atendimentos.id_prof = profissionais.id
				INNER JOIN servicos ON atendimentos.id_serv = servicos.id
				WHERE NOT EXISTS (select 1
				from atendimentos
				WHERE data = '$data'
				AND OBS = atendimentos.id)
				AND data=:data ORDER BY p_nome ASC";
				$result=$conexao->prepare($select);
				$result->bindParam(':data', $lastweek, PDO::PARAM_INT);
				$result->execute();
				$contar= $result->rowCount();
				if($contar>0){		
					while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {	
						$nome = $linha->assist_nome;
						$nome = implode('-', explode(' ', $nome));				
						?>
						<div class="row row-striped busca">
							<div class="col-lg-10" style="text-align: left">
								<h4 class="text-uppercase"><strong><a href="p<?php echo $nome;?>-<?php echo $linha->id_assist;?>"><?php	echo $linha->assist_nome; ?></a></strong></h4>
								<ul class="list-inline">								
									<li class="list-inline-item"><i class="fa fa-user" aria-hidden="true"></i> <?php	echo  $linha->p_nome; ?></li>
									<li class="list-inline-item"><i class="fa fa-stethoscope" aria-hidden="true"></i> <?php	echo $linha->serv_nome; ?></li>
								</ul>
							</div>
							<?php if($_SESSION['nivel'] == 1){ ?>	<div class="col-lg-2"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalVisualizar" data-nome="<?php echo $linha->assist_nome ?>" data-id="<?php echo $linha->id_assist; ?>" data-idprof="<?php echo $linha->id_prof; ?>" data-idserv="<?php echo $linha->id_serv; ?>" data-idatendimento="<?php echo $linha->obs; ?>" data-conv="<?php echo $linha->tipo; ?>" data-idagenda="<?php echo $linha->id; ?>" data-nomeprof="<?php	echo  $linha->p_nome; ?>" data-nomeserv="<?php echo $linha->serv_nome; ?>">Registrar</button></div><?php } ?>
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

			});

		</script>




	</body>
	</html>

