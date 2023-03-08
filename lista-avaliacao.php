
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Lista de Avaliação</title>
	<?php 

	require_once('cabecalho.php');
	require_once('conecta/conexao.php');

	?>
</head>
<body>

	<div class="container text-center" style="padding: 40px;">

		<h1>Lista de Avaliação</h1><br>
		<input type="text" class="form-control" id="myInput" placeholder="Buscar nome" style="width: 100%;">
		
	</div>
	<div class="container">
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th></th>
						<th>Nome</th>
						<th>Especialidade</th>
						<th>Convênio</th>
						<th>Data</th>
						<th>Ação</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$num = 1;
					require_once('conecta/conexao.php');
					$select = "SELECT lista_avaliacao.*, assistidos.nome as nome_assistido, servicos.nome as servico
					FROM lista_avaliacao
					INNER JOIN assistidos ON lista_avaliacao.id_assist = assistidos.id_assist
					INNER JOIN servicos ON lista_avaliacao.id_serv = servicos.id
					ORDER BY data ASC";
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
							echo $linha->servico;
							echo '</td>';
							echo '<td>';
							echo $linha->convenio;
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

<script type="text/javascript">
	$("#myInput").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$(".table .busca").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});
</script>

<?php
if(isset($_GET['delete'])){
	$id_delete = $_GET['delete'];

	$select="DELETE from lista_avaliacao WHERE id=:id_delete";
	try{
		$result=$conexao->prepare($select);
		$result->bindParam('id_delete',$id_delete, PDO::PARAM_INT);
		$result->execute();
		$contar= $result->rowCount();
		if($contar>0){
			header("Location: lista-avaliacao");
		}
	}catch(PDOException $e){echo $e;}
}

?>


</body>
</html>