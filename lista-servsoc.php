<meta charset="utf-8">
<title>Serviço Social</title>
<?php 
include('cabecalho.php');

if (isset($_POST['enviar'])) {
	$nome = $_POST['nome'];
	$data = date("Y/m/d");
	$encaminhamento = $_POST['encaminhamento'];
	$convenio = $_POST['convenio'];
	$telefone = $_POST['telefone'];
	$insert = "INSERT into `lista_servsoc` (nome, data, local, convenio, telefone)	VALUES (:nome, :data, :encaminhamento, :convenio, :telefone)";
	try{
		$result = $conexao->prepare($insert);
		$result->bindParam(':nome', $nome, PDO::PARAM_STR);
		$result->bindParam(':data', $data, PDO::PARAM_STR);
		$result->bindParam(':encaminhamento', $encaminhamento, PDO::PARAM_STR);
		$result->bindParam(':convenio', $convenio, PDO::PARAM_STR);
		$result->bindParam(':telefone', $telefone, PDO::PARAM_STR);
		$result->execute();
		$contar = $result->rowCount();
		$grLog = '['.date("d/m/Y H:i:s").'] '.$_SESSION['nome'].' adicionou '.$nome.' da lista de serviço social';
		$quebra = chr(13).chr(10);
		$file = fopen("C:/Users/TeleServidorueb/Documents/backup/logs/usuarios.txt", "a+");
		fwrite($file, $quebra);
		fwrite($file, $grLog);
		fclose($file);				
		header("Location: lista-servsoc");
	}
	catch(PDOException $e){
		echo $e;}
	}


	if (isset($_GET['d'])) {
		if (is_numeric($_GET['d'])) {
			$id_delete = $_GET['d'];
			$nome_excluido = $_GET['n'];
			$select="DELETE FROM `lista_servsoc` WHERE id=:id_delete";
			try{
				$result=$conexao->prepare($select);
				$result->bindParam('id_delete',$id_delete, PDO::PARAM_INT);
				$result->execute();
				$contar= $result->rowCount();
				if($contar>0){
					$grLog = '['.date("d/m/Y H:i:s").'] '.$_SESSION['nome'].' excluiu '.$nome_excluido.' da lista de serviço social';
					$quebra = chr(13).chr(10);
					$file = fopen("C:/Users/TeleServidorueb/Documents/backup/logs/usuarios.txt", "a+");
					fwrite($file, $quebra);
					fwrite($file, $grLog);
					fclose($file);
					header("Location: lista-servsoc");
				}
			}catch(PDOException $e){echo $e;}
		}else{
			echo "error!";
			header("Location: lista-servsoc");
		}

	}


	?>

	<div class="container text-center">
		<h1>Aguardando Serviço Social <button type="button" class="btn btn-default" title="Infos" data-toggle="collapse" data-target="#infos">+</button></h1>
		<div id="infos" class="collapse">
			<form method="post">
				<div class="form-group">
					<div class="col-sm-4">
						<input type="text" name="nome" class="form-control" id="nome" placeholder="Nome" required="">
					</div>
					<div class="col-sm-2">
						<input type="text" class="form-control" name="telefone" id="telefone" placeholder="Número do telefone" required="">
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control" name="encaminhamento" id="encaminhamento" placeholder="Encaminhado por onde?" required="">
					</div>
					<div class="col-sm-2">
						<select name="convenio" class="form-control" id="" required="">
							<option value="SMED">SMED</option>
							<option value="Saúde">Saúde</option>
						</select>
					</div>
					<div class="col-sm-1">
						<input type="submit" class="form-control" name="enviar">
					</div>
				</div>

			</form>
		</div><br><br>
		<input type="text" class="form-control" id="myInput" placeholder="Buscar nome" style="width: 100%;">
	</div>
	<br><br>

	<div class="container">
		<table class="table">
			<thead>
				<th></th>
				<th>Nome</th>
				<th>Data</th>
				<th>Encaminhamento</th>
				<th>Convênio</th>
			</thead>
			<tbody>
				<?php 
				$numCont = 1;
				$select = "SELECT * FROM lista_servsoc ORDER BY data ASC";
				try{	
					$result=$conexao->prepare($select);
					$result->execute();
					$contar= $result->rowCount();
					if($contar>0){		
						while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
							echo '<tr class="busca"><td>';	
							echo $numCont++;
							echo '</td><td>';
							echo $linha->nome;
							echo '</td><td>';
							echo date('d/m/Y',  strtotime($linha->data));
							echo '</td><td>';
							echo $linha->local;
							echo '</td><td>';
							echo $linha->convenio;
							echo '<td>';
							echo $linha->telefone;
							echo '</td>';
							if ($_SESSION['nivel']  == 1){
								?>
								<td>
									<a href="?d=<?php echo $linha->id; ?>&n=<?php echo $linha->nome; ?>" onClick="return confirm('Deseja realmente excluir?')" class="close">×</a>
								</td>
								<?php
							}
							echo '<tr>';
						}
					}
				}catch(PDOException $e){
					echo $e;
				}	

				?>
			</tbody>
		</table>

		<script>
			$("#myInput").on("keyup", function() {
				var value = $(this).val().toLowerCase();
				$(".table .busca").filter(function() {
					$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
				});
			});
		</script>
	</div>