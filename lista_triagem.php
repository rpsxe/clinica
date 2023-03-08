<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Lista de Triagens</title>
	<?php include('cabecalho.php'); ?>
</head>
<body>

	<div class="container text-center" style="padding: 40px;">

		<h1>Lista de triagem com a Psicologia.</h1>
		<br>
		<input type="text" class="form-control" id="myInput" placeholder="Buscar nome" style="width: 100%;">
		
	</div>
	<div class="container">
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th></th>
						<th>Nome</th>
						<th>Convênio</th>
						<th>Escola</th>
						<th>Data</th>
						<th>Ação</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$num = 1;
					require_once('conecta/conexao.php');
					$select = "SELECT lista_triagem.*, assistidos.nome as nome_assistido, assistidos.escola as escola
					FROM (lista_triagem
					INNER JOIN assistidos ON lista_triagem.id_assist = assistidos.id_assist) ORDER BY estado, id ASC";
					$result=$conexao->prepare($select);
					$result->execute();
					$contar= $result->rowCount();
					if($contar>0){
						while ($linha = $result->FETCH(PDO::FETCH_OBJ)) { 	
							$nome = $linha->nome_assistido;
							$nome = implode('-', explode(' ', $nome));						
							echo '<tr class="busca">';
							echo '<td>';
							echo $num++;
							echo '</td>';
							echo '<td>';
							?>
							<a href="p<?php echo $nome;?>-<?php echo $linha->id_assist;?>"><?php	echo $linha->nome_assistido; ?></a>
							<?php
							echo '</td>';
							echo '<td>';
							echo $linha->convenio;
							echo '</td>';
							echo '<td>';							
							switch ($linha->escola) {
								case '0':
								echo '';
								break;
								
								default:
								echo $linha->escola;
								break;
							}
							echo '</td>';
							echo '<td>';
							echo date('d/m/Y',  strtotime($linha->data));
							echo '</td>';
							if ($_SESSION['nivel']  == 1){ ?>
								<td><a href="?delete=<?php echo $linha->id;?>" onClick="return confirm('Deseja realmente deletar?')" class="close" data-dismiss="alert" aria-label="close">×</a></td>
							<?php 	}else{} 
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
				<form action="grava-atendimento.php" method="post">
					<input type="hidden" class="form-control" name="id_assist" id="id_assist">	
					<input type="hidden" class="form-control" name="id" id="id">	
					<input type="hidden" class="form-control" name="estado" id="estado">	
					<div class="row">
						<div class="col-sm-6">	
							<div class="form-group">
								<label for="servico">Profissional</label>						
								<select class="form-control" name="profissionais" id="id_prof" required>
									<?php 
									$select = "SELECT profissionais.nome as nome_prof, profissionais.id as id_prof
									FROM ((prof_serv
									INNER JOIN servicos ON prof_serv.id_serv = servicos.id)
									INNER JOIN profissionais ON prof_serv.id_prof = profissionais.id) WHERE servicos.id='5' AND profissionais.ver='0'";
									$result=$conexao->prepare($select);
									$result->execute();
									$contar= $result->rowCount();
									if($contar>0){ 
										while ($linha = $result->FETCH(PDO::FETCH_OBJ)) { 
											?>
											<option value="<?php echo $linha->id_prof; ?>"><?php echo $linha->nome_prof; ?></option>
											<?php
										}	// FIM IF COMPARAR
										} // FIM WHILE
										?>
									</select>
								</div>
							</div>
							<div class="col-sm-6">	
								<div class="form-group">
									<label for="servico">Data</label>
									<input type="date" name="data" id="data" class="form-control" required="">
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
						</div>
						<div class="row text-center">
							<button id="envia" type="button" class="btn btn-primary" style="display: none">
								Agendar
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
				    var recipientid = button.data('id'); 
				    var recipientidassist = button.data('id_assist'); 
				    var recipientestado = button.data('estado'); 
				    var recipientconvenio = button.data('convenio'); 


				    var modal = $(this)
				    modal.find('#id').val(recipientid)
				    modal.find('#id_assist').val(recipientidassist)
				    modal.find('#estado').val(recipientestado)
				    modal.find('#convenio').val(recipientconvenio)

				    

				    $("#data").change(function(){
				    	$("#envia").show();
				    })

				    $("#envia").click(function(){

				    	var id_prof = $("#id_prof").val();
				    	var data = $("#data").val();
				    	var serv = '19';
				    	$.post("lista_triagem_actions.php", {
				    		id:recipientid, 
				    		estado:recipientestado, 
				    		id_assist:recipientidassist, 
				    		convenio:recipientconvenio, 
				    		prof:id_prof, serv:serv,
				    		data: data
				    	}, function(retorno){
				    		$(".retorno").html(retorno)
				    		alert('Sucesso!')
				    		location.reload();
				    	})

				    })
				});


			$("#myInput").on("keyup", function() {
				var value = $(this).val().toLowerCase();
				$(".table .busca").filter(function() {
					$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
				});
			});

		</script>
	</body>
	</html>

	<?php
	if(isset($_GET['delete'])){
		$id_delete = $_GET['delete'];

		$select="DELETE from lista_triagem WHERE id=:id_delete";
		try{
			$result=$conexao->prepare($select);
			$result->bindParam('id_delete',$id_delete, PDO::PARAM_INT);
			$result->execute();
			$contar= $result->rowCount();
			if($contar>0){
				header("Refresh:0");
			}
		}catch(PDOException $e){echo $e;}
	}

	?>