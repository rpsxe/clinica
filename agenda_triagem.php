<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Lista de Triagens</title>
	<?php include('cabecalho.php'); ?>
</head>
<body>

	<div class="container">
		<div class="jumbotron" style="background: none;">
			<h2 class="text-center">Agenda de Triagens<br><?php echo date("d.m"); ?></h2><br>				
		</div>
	</div>
	<div class="container">
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th>Nome</th>
						<th>Profissional</th>
						<th>Estágio</th>
						<th>Convênio</th>
						<th>Data</th>
						<th>Ação</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$data = date('Y-m-d');
					require_once('conecta/conexao.php');
					$select = "SELECT agenda_triagens.*, assistidos.nome as nome_assistido, profissionais.nome as nome_prof
					FROM ((agenda_triagens
					INNER JOIN assistidos ON agenda_triagens.id_assist = assistidos.id_assist)
					INNER JOIN profissionais ON agenda_triagens.id_prof = profissionais.id) WHERE data='$data' ORDER BY id ASC";
					$result=$conexao->prepare($select);
					$result->execute();
					$contar= $result->rowCount();
					if($contar>0){ $num=$contar;
						while ($linha = $result->FETCH(PDO::FETCH_OBJ)) { 
							switch ($linha->estado) {
								case 0:
								$estado = 'Triagem com responsável.';
								break;

								case 1:
								$estado = 'Triagem com assistido.';
								break;

								default:
								$estado = 'Erro! Procure o adm do sistema';
								break;
							}
							echo '<tr>';
							echo '<td>';
							echo $linha->nome_assistido;
							echo '</td>';
							echo '<td>';
							echo $linha->nome_prof;
							echo '</td>';
							echo '<td>';
							echo $estado;
							echo '</td>';
							echo '<td>';
							echo $linha->convenio;
							echo '</td>';
							echo '<td>';
							echo date('d/m/Y',  strtotime($linha->data));
							echo '</td>';
							echo '<td>';
							echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalVisualizar" data-estado="'.$linha->estado.'"  data-id="'.$linha->id.'" data-id_lista="'.$linha->id_lista.'" data-id_assist="'.$linha->id_assist.'" data-convenio="'.$linha->convenio.'" data-profissional="'.$linha->nome_prof.'" data-idprof="'.$linha->id_prof.'">Registrar</button>';
							echo '</td>';
							echo '</tr>';
								}	// FIM IF COMPARAR
							} 
							?>
						</tbody>
					</table>
				</div>
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
							<form action="agenda_triagem_actions.php" method="post">
								<input type="hidden" class="form-control" name="id_assist" id="id_assist">	
								<input type="hidden" class="form-control" name="idprof" id="idprof">	
								<input type="hidden" class="form-control" name="estado" id="estado">	
								<input type="hidden" class="form-control" name="id_lista" id="id_lista">	
								<input type="hidden" class="form-control" name="id_agenda" id="id_agenda">	
								<input type="hidden" class="form-control" name="serv" value="19">	
								<div class="row">
									<div class="col-sm-6">	
										<div class="form-group">
											<label for="servico">Profissional</label>		
											<input type="text" name="profissionais" id="nome_prof"  class="form-control" readonly="" >
										</div>
									</div>
									<div class="col-sm-6">	
										<div class="form-group">
											<label for="servico">Data</label>
											<input type="text" name="data" id="data" class="form-control" readonly="" value="<?php echo date('d/m/Y'); ?>">
										</div>
									</div>
									<div class="col-sm-6">	
										<div class="form-group">
											<label for="servico">Atendimento</label>
											<input type="text" class="form-control" value='Triagem' placeholder="Triagem" readonly="">	
										</div>
									</div>
									<div class="col-sm-6">	
										<div class="form-group">
											<label for="conv">Convênio</label>
											<input type="text" class="form-control" name="convenio" id="convenio" readonly="">	
										</div>	
									</div>	
									<div class="col-sm-12">	
										<div class="form-group">
											<label for="conv">Estado</label>
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
								<br>
								<div class="row text-center">
									<button id="envia" type="submit" class="btn btn-primary">
										Enviar
									</button>
								</div>
								<br>
								<div class="modal-footer">
									<!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button> -->
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
								</form>
							</div>
						</div>
					</div>
				</div>



				<div class="retorno"></div>

				<script>


					$('#ModalVisualizar').on('show.bs.modal', function (event) {
				    var button = $(event.relatedTarget); // Button that triggered the modal
				    var recipientidagenda = button.data('id'); 
				    var recipientidlista = button.data('id_lista'); 
				    var recipientidassist = button.data('id_assist'); 
				    var recipientestado = button.data('estado'); 
				    var recipientconvenio = button.data('convenio'); 
				    var recipientprof = button.data('profissional'); 
				    var recipientidprof = button.data('idprof'); 


				    var modal = $(this)
				    modal.find('#id_agenda').val(recipientidagenda)
				    modal.find('#id_lista').val(recipientidlista)
				    modal.find('#id_assist').val(recipientidassist)
				    modal.find('#estado').val(recipientestado)
				    modal.find('#convenio').val(recipientconvenio)
				    modal.find('#nome_prof').val(recipientprof)
				    modal.find('#idprof').val(recipientidprof)
				});


			</script>
		</body>
		</html>