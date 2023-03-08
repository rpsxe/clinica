<title>Ver Registros</title>
<?php include("cabecalho.php"); ?>
<style> 
.paginas{
	width: 100%;
	text-align: center;
	padding: 30px 0;
	
}
.paginas a{
	color: black;
	padding: 8px 16px;
	text-decoration: none;
	transition: background-color .3s;
}
.paginas a:hover{
	background-color: #101010;
	color: white;
}
<?php
if(isset($_GET['pagina'])){
	$num_pagina = $_GET['pagina'];
}else{$num_pagina = 1;}
?>
.paginas a.ativo<?php echo $num_pagina; ?>{
	background-color: #101010;
	color: white;
}
</style>
<div class="container text-center">
	<div class="row">
		<div class="jumbotron" style="background: white;">
			<h1 style="font-family: 'IBM Plex Serif', serif;">Nossos Cadastros</h1>
			<hr>
			<?php echo $assist; ?> pessoas estão cadastradas no sistema. 
		</div>
		<div class="row">
			<?php
			$cont = 0;
			if(empty($_GET['pagina'])){}
				else{
					$pagina = $_GET['pagina'];
					if (is_numeric($pagina)){}else{
						header("Location: home.php");
					} 
				}
				if(isset($pagina)){$pagina=$_GET['pagina'];} else{$pagina = 1;}

				$quantidade = 12;
				$inicio = ($pagina*$quantidade) - $quantidade;
				$select = "SELECT * FROM `assistidos` ORDER BY id_assist DESC LIMIT $inicio, $quantidade";
				try{
					$result=$conexao->prepare($select);
					$result->execute();
					$contar= $result->rowCount();
					if($contar>0){
						while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
							$nome = $linha->nome;
							$nome = implode('-', explode(' ', $nome));

							?>
							<div class="col-sm-4">
								<div class="well" style="height: 350px; background: #f8f8f8; border-color:#e7e7e7;">
									<a href="p<?php echo $nome;?>-<?php echo $linha->id_assist;?>"><img src="upload/<?php echo $imagem = $linha->imagem; ?>"  class="img-thumbnail" title="<?php echo $linha->nome; ?>" alt="<?php echo $linha->nome; ?>" style="width: 175px; height: 175px;"></a>
									
									<hr>
									<h4><?php echo $linha->nome; ?></h4><br><br>
									<button type="button" class="btn"><a href="p<?php echo $nome;?>-<?php echo $linha->id_assist;?>">VER</a></button>
									<button type="button" class="btn"><a href="u<?php echo $linha->id_assist;?>">ATUALIZAR</a></button>
									<br><br>
								</div>
							</div>  
							
							<?php	
							$cont++;}
						}
					}catch(PDOException $e){
						echo $e;
					}

					?>
				</div>
				<hr>
				<br>
				<div class="row">
					<?php
//paginação 
					$sql = "SELECT * from assistidos";
					try{
						$result=$conexao->prepare($sql);
						$result->execute();
						$totalRegistros= $result->rowCount();
					}catch(PDOException $e){
						echo $e;}
						
						if($totalRegistros <= $quantidade){}
							else{
								$paginas = ceil($totalRegistros/$quantidade);
								if($pagina > $paginas){
									header ("Location: registros");
								}
								$links=3;
								
								if(isset($i)){}
									else{$i = '1';}
								?><center>
									<div class="paginas">
										<a href="registros?pagina=1">&laquo;</a> 
										<?php 
										if(isset($_GET['pagina'])){
											$num_pagina = $_GET['pagina'];
										}
										for($i = $pagina-$links; $i <= $pagina-1; $i++){
											if($i<=0){}
												else {?>
													<a href="registros?pagina=<?php echo $i; ?>" class="ativo<?php echo $i;?>"><?php echo $i;?></a>
													<?php
				}// FIM ELSE
			}
			?>
			<a href="registros?pagina=<?php echo $pagina; ?>" class="ativo<?php echo $i;?>"><?php echo $pagina; ?></a>
			<?php 
			for($i = $pagina+1; $i <= $pagina+$links; $i++){
				if($i>$paginas){}
					else{
						?>
						<a href="registros?pagina=<?php echo $i; ?>" class="ativo<?php echo $i;?>"><?php echo $i;?></a> <!-- PÁGINAS -->



						<?php	
			} // ELSE
		}	// FOR	
		?>
		<a href="registros?pagina=<?php echo $paginas; ?>">&raquo;</a>
	</div>
	<?php

} // FIM ELSE

?>
<!-- FIM PAGINAÇÃO -->
</div>

</div>
</div>

