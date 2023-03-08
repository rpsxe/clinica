<?php include("cabecalho.php");
if ($_SESSION['nivel'] >= 1) {
	?>
	<title>Lista de Espera</title>
	<style>
		.danger-row{
			background-color: red;
			color: white;
		}
		.danger-row a{
			color: white;
		}
	</style>
	<?php 
	$num = 1; 
	function verificaAgenda($id_assist, $id_serv){
		include ('conecta/conexao.php');

		$select = "SELECT id_serv, id_assist FROM agenda WHERE ativo='S' AND agenda.id_serv=:id_serv AND agenda.id_assist=:id_assist ORDER BY horario ASC";
		$result=$conexao->prepare($select);
		$result->bindParam(':id_serv', $id_serv, PDO::PARAM_INT);
		$result->bindParam(':id_assist', $id_assist, PDO::PARAM_INT);
		$result->execute();
		$contar= $result->rowCount();
		if($contar>0){	
			while ($linha = $result->FETCH(PDO::FETCH_OBJ)) { 
				echo '<tr class="danger-row busca">';
			}
		}else{
			echo '<tr class="busca">';
		}
	}


	if(isset($_GET['delete'])){
		$id_delete = $_GET['delete'];

		$select="DELETE from list_espera WHERE id=:id_delete";
		try{
			$result=$conexao->prepare($select);
			$result->bindParam('id_delete',$id_delete, PDO::PARAM_INT);
			$result->execute();
			$contar= $result->rowCount();
			if($contar>0){
				header("Refresh:0, lista-espera");
			}
		}catch(PDOException $e){echo $e;}
	}

	if (isset($_POST['Agendar'])) {	

		$id_assist = $_POST['assistido'];
		$id_lista = $_POST['id_lista'];
		$id_serv = $_POST['servico'];
		$id_prof = $_POST['profissionais'];
		$tipo = $_POST['convenio'];
		$dia = $_POST['dia'];
		$horario = $_POST['horario'];
		$ativo = 'S';
		$data= date("Y/m/d");
		$estado = "Inserido";
		$mostrar = "N";
		try{
			$insert = "INSERT into `agenda` (id_prof,	id_serv, id_assist,	tipo, dia, horario, ativo)
			VALUES (:profissionais, :servicos, :id_assist, :convenio, :dia, :horario, :ativo)";
			$result = $conexao->prepare($insert);
			$result->bindParam(':profissionais', $id_prof, PDO::PARAM_STR);
			$result->bindParam(':servicos', $id_serv, PDO::PARAM_STR);
			$result->bindParam(':id_assist', $id_assist, PDO::PARAM_INT);
			$result->bindParam(':convenio', $tipo, PDO::PARAM_STR);
			$result->bindParam(':dia', $dia, PDO::PARAM_STR);
			$result->bindParam(':horario', $horario, PDO::PARAM_STR);
			$result->bindParam(':ativo', $ativo, PDO::PARAM_STR);
			$result->execute();
			echo   '<div class="alert alert-success">
			<strong>Horário agendado com sucesso!</strong> 
			Aguarde o redirecionamento.
			</div>';
			// header ("Refresh: 1");
		}
		catch(PDOException $e){		echo $e; die;exit;}

		try{
			$insert = "INSERT into `atendimentos` (id_assist,data,estado,id_prof,id_serv,tipo)
			VALUES (:id_assist, :data, :estado, :id_prof, :id_serv, :tipo)";
			$result = $conexao->prepare($insert);
			$result->bindParam(':id_assist', $id_assist, PDO::PARAM_INT);
			$result->bindParam(':data', $data, PDO::PARAM_STR);
			$result->bindParam(':estado', $estado, PDO::PARAM_STR);
			$result->bindParam(':id_prof', $id_prof, PDO::PARAM_STR);
			$result->bindParam(':id_serv', $id_serv, PDO::PARAM_STR);
			$result->bindParam(':tipo', $tipo, PDO::PARAM_STR);
			$result->execute();
		}catch(PDOException $e){echo $e;  die;exit;}

		$update = "UPDATE list_espera SET  mostrar=:mostrar WHERE id=:id_lista";
		try{
			$result = $conexao->prepare($update);
			$result->bindParam(':id_lista', $id_lista, PDO::PARAM_INT);
			$result->bindParam(':mostrar', $mostrar, PDO::PARAM_STR);
			$result->execute();
			$contar= $result->rowCount();
			header ("Refresh: 1");
		}catch(PDOException $e){echo $e;}
	}
	?>
	<div class="container">
		<div class="jumbotron" style="background: none;">
			<h1 class="text-center">Lista de Espera <a href="relatorio-listaespera" target="_blank"><button class="btn btn-primary" >Relatório </button></a></h1><br>				
			<form method="post">
				<div class="row">
					<div class="col-xs-4">
						<input type="text" class="form-control" id="myInput" placeholder="Buscar nome">
					</div>
					<div class="col-xs-3">
						<select class="form-control" name="servicos" required="">
							<option selected disabled>Atendimento</option>
							<?php
	//AQUI VOU SELECIONAR TODOS OS SERVIÇOS

							$select = "SELECT * FROM `servicos` WHERE id!='19' ORDER BY nome ASC";
							try{
								$result=$conexao->prepare($select);
								$result->execute();
								$contar= $result->rowCount();
								if($contar>0){
									while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
										?>
										<option value="<?php echo $linha->id; ?>"><?php echo $linha->nome; ?></option>
										<?php
									}
								}
							}catch(PDOException $e){
								echo $e;
							}
							?>
						</select>
					</div>
					<div class="col-xs-3">
						<select class="form-control" name="conv" required="">
							<option selected disabled> Convênio </option>
							<option value="Saúde">Saúde</option>
							<option value="SMED">Educação</option>
							<option value="Assistencia">Assistência</option>
							<option value="CLuz">Caminho da Luz</option>
							<option value="Centro">Centro</option>
							<option value="Candiota">Candiota</option>
							<option value="Unimed">UNIMED</option>
							<option value="EJudicial">Encaminhamento Judicial</option>
						</select>
					</div>
					<div class="col-xs-2">
						<input type="submit" value="Pesquisar" class="btn btn-primary" name="pesquisar">
					</div>
				</div>
			</form>
			<br>
			<div class="table-responsive">
				<table class="table">
					<?php

				//0 para avaliação 1 para atendimentos 2 assistente social
					$tipo = 2;
					if(isset($_POST['pesquisar'])){	
						if (!isset($_POST['servicos']) AND !isset($_POST['conv'])) {
							echo '
							<div class="alert alert-danger">
							<strong>Pesquisa inválida!</strong> Selecione um item ao menos.
							</div>';
							die; exit;
						}	

						if (isset($_POST['servicos'])) {
							$servico = $_POST['servicos'];
							$query = "id_serv='$servico'";
						}
						if (isset($_POST['conv'])) {
							$conv = $_POST['conv'];
							$query = "tipo='$conv'";
						}
						if (isset($_POST['servicos']) AND isset($_POST['conv'])) {
							$query = "id_serv='$servico' AND tipo='$conv'";							
						}

						$select = "SELECT list_espera.*, servicos.nome as serv_nome, assistidos.nome as assist_nome, assistidos.id_assist as id_assist, servicos.id as id_serv, assistidos.escola as escola
						FROM ((list_espera
						INNER JOIN assistidos ON list_espera.id_assist = assistidos.id_assist)
						INNER JOIN servicos ON list_espera.id_serv = servicos.id) WHERE $query AND mostrar = 'S' ORDER BY data,id ASC";

					}else{
						$select = "SELECT list_espera.*, servicos.nome as serv_nome, assistidos.nome as assist_nome, assistidos.id_assist as id_assist, servicos.id as id_serv, assistidos.escola as escola
						FROM ((list_espera
						INNER JOIN assistidos ON list_espera.id_assist = assistidos.id_assist)
						INNER JOIN servicos ON list_espera.id_serv = servicos.id) WHERE mostrar = 'S' ORDER BY data, id ASC";
					}	
					
					$result=$conexao->prepare($select);
					$result->execute();
					$contar= $result->rowCount();
					if($contar>0){
						while ($linha = $result->FETCH(PDO::FETCH_OBJ)) { 
							verificaAgenda($linha->id_assist, $linha->id_serv);
							$nome = $linha->assist_nome;
							$nome = implode('-', explode(' ', $nome));
							?>
							<td>
								<?php echo $num++; ?>
							</td>
							<td>
								<a href="p<?php echo $nome;?>-<?php echo $linha->id_assist;?>"><?php	echo $linha->assist_nome; ?></a>
							</td>
							<td>								
								<?php	echo $linha->serv_nome; ?>
							</td>
							<td>
								<?php	 $data=$linha->data; echo date('d/m/Y',  strtotime($data)) ?></p>
							</td>
							<td>
								<?php	echo $linha->tipo; ?>
							</td>
							<td>
								<?php	echo $linha->escola; ?>
							</td>
							<td>
								<?php	if ($linha->prioridade != "") {
									echo 'Atendimento pré-pandemia.';
								}?>
							</td>
							<?php if ($_SESSION['nivel'] == 1) { ?>
								<td class="text-center">
									<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalVisualizar"  data-id="<?php echo $linha->id_assist; ?>" data-convenio="<?php echo $linha->tipo; ?>" data-serv_nome="<?php echo $linha->serv_nome; ?>" data-serv_id="<?php echo $linha->id_serv; ?>" data-id_lista = "<?php echo $linha->id; ?>">Agendar horário</button>
								</td>
								<td><a href="lista-espera?delete=<?php echo $linha->id;?>" onClick="return confirm('Deseja realmente deletar?')" class="close" data-dismiss="alert" aria-label="close">×</a></td>
							<?php 	}else{} ?>
						</tr>
						<?php
					}
				}else{ echo '<h2 class="text-center">Nenhum dado encontrado!';}
				?>
			</table>
		</div>
	</div>
</div>
<div class="modal fade" id="ModalVisualizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header bg-dark text-light">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="" method="post">
					<input type="hidden" name="id_lista" id="id_lista">									
					<input type="hidden" name="servico" id="serv_id">									
					<input type="hidden" name="assistido" id="id_assist">									
					<div class="form-group">	
						<div class="col-xs-3"><?php include("includes/prof.php"); ?></div>
						<div class="col-xs-3">
							<input type="text" class="form-control" readonly="true" id="servico">
						</div>
						<div class="col-xs-2">
							<select name="convenio" class="form-control" required>
								<option id="convenio"></option>
								<option value="Saúde">Saúde</option>
								<option value="SMED">Educação</option>
								<option value="Centro">Centro</option>
								<option value="Assistencia">Assistência</option>
								<option value="CLuz">Caminho da Luz</option>
								<option value="EJudicial">Encaminhamento Judicial</option>
							</select>
						</div>
						<div class="col-xs-2">
							<select name="dia" class="form-control" id="dia" required>
								<option value="1">Segunda</option>
								<option value="2">Terça</option>
								<option value="3">Quarta</option>
								<option value="4">Quinta</option>
								<option value="5">Sexta</option>
							</select>
						</div>
						<div class="col-xs-2">
							<input type="text" class="form-control" name="horario" id="horario" placeholder="Horário" required="">
						</div>
					</div><br><br>
					<br><br>
					<div class="row text-center">
						<input type="submit" class="btn btn-primary" name="Agendar">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	$('#ModalVisualizar').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); 
		var recipientid = button.data('id'); 							
		var recipientid_lista = button.data('id_lista'); 							
		var recipientconvenio = button.data('convenio'); 				
		var recipientserv_nome = button.data('serv_nome'); 				
		var recipientserv_id = button.data('serv_id'); 				

		var modal = $(this)
		modal.find('#id_assist').val(recipientid)
		modal.find('#convenio').val(recipientconvenio)
		modal.find('#convenio').html(recipientconvenio)
		modal.find('#servico').val(recipientserv_nome)
		modal.find('#serv_id').val(recipientserv_id)
		modal.find('#id_lista').val(recipientid_lista)
	});


	$("#myInput").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$(".table .busca").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});

</script>
<?php }else{header("Location: inicio");} ?>