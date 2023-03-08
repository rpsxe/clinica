<title> Resultado</title>

<?php //vai puxar cabeçalho
include ("cabecalho.php"); 
?>
<br>
<div class="container text-center"> 
	<?php
	$busca=trim($_POST['busca']);  //$busca recebe o valor da busca
	$consulta = $conexao->query("SELECT * FROM assistidos WHERE nome LIKE '%".$busca."%';"); //vai procurar no banco se existem algum nome igual ao procurado
	$contar = $consulta->rowCount(); //vai fazer a contagem de linhas encontradas
	if ($busca== ""){ //se a pesquisa tiver valor vazio vai dar uma mensagem e retornar para os registros
		echo '
		<div class="alert alert-danger">
		<strong>Digite um nome!</strong> Tente novamente.
		</div>'; ;
		header ("Refresh: 1, registros.php"); 
	}else{
	if ($contar == 0){ //se não existir nenhum registro com o nome procurado vai aparecer mensagem informando
		?><div class="row">
			<?php			echo '
			<div class="alert alert-danger">
			<strong>Nenhum registro encontrado!</strong> Tente novamente.
			</div>'; ?>
		</div>
		<?php
	}else{	 echo '<div class="row" style="background: white; padding: 10px;"><h3>Resultado(s) para: '.$busca.' ('.$contar.')</h3></div>';
	while ($linha = $consulta->fetch(PDO::FETCH_OBJ)) //a $linha vai receber os valores do informados no banco e vai mostrar eles na tela
	{
		$nome = $linha->nome;
		$nome = implode('-', explode(' ', $nome));
		?>

		<div class="row" style="background: white; padding: 10px;">
			<hr>
			<div class="col-sm-2"> 
				<a href="p<?php echo $nome;?>-<?php echo $linha->id_assist;?>">
					<img src="upload/<?php 	echo $linha->imagem; ?>" title="<?php 	echo $linha->nome; ?>" alt="<?php 	echo $linha->nome; ?>" class="thumbnail" style="width: 75%">
				</div>
				<div class="col-sm-4"> 
					<p><?php	echo $linha->nome; ?></p>    
				</div>
			</a>
			<div class="col-sm-2">
				<?php $data=$linha->datanasc; echo date('d/m/Y',  strtotime($data)); ?>
			</div>
			<div class="col-sm-2">
				<?php echo $linha->cidade; ?>
			</div>
			<div class="col-sm-2">
				<button type="button" class="btn update"><a href="u<?php echo $linha->id_assist;?>">ATUALIZAR</a></button>
			</div>
		</div>
		<?php
	}
} 
	}//fim else
	?>