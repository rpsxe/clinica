<?php 
include("cabecalho.php"); 
include("header/pegainfos.php");
include("logs/logs.php");
?>
<title><?php echo $nome; ?></title>
<style>
	.link-modal{
		color: black;
		cursor: pointer;
		-moz-transition: all 0.3s;
		-webkit-transition: all 0.3s;
		transition: all 0.3s;
	}
	.link-modal:hover{
		color: #B8CEE1;
		-moz-transform: scale(1.1);
		-webkit-transform: scale(1.1);
		transform: scale(1.1);
	}
	#marcarAutista:hover{
		color: #B8CEE1;
		cursor: pointer;
		-moz-transform: scale(1.1);
		-webkit-transform: scale(1.1);
		transform: scale(1.1);
	}
</style>
<body>
	<div class="container">
		<?php

		if(isset($_POST['envTriagemPsicologia'])){
			$id_assist = $id;
			$data = date("Y/m/d");
			$convenio = $_POST['convenio'];	
			$estado = 0;		
			try{
				$insert = "INSERT into `lista_triagem` (id_assist, data, estado, convenio)
				VALUES (:id_assist, :data, :estado, :convenio)";
				$result = $conexao->prepare($insert);
				$result->bindParam(':id_assist', $id_assist, PDO::PARAM_INT);
				$result->bindParam(':data', $data, PDO::PARAM_STR);
				$result->bindParam(':estado', $estado, PDO::PARAM_STR);
				$result->bindParam(':convenio', $convenio, PDO::PARAM_STR);
				$result->execute();
				echo   '<div class="alert alert-success">
				<strong>Cadastro realizado com sucesso!</strong> 
				Aguarde o redirecionamento.
				</div>';
				header ("Refresh: 1");
			}
			catch(PDOException $e){		echo $e;}
		}

		if(isset($_POST['envListaAvaliacao'])){
			$id_assist = $id;
			$data = date("Y/m/d");
			$convenio = $_POST['convenio'];	
			$servicos = $_POST['servicos'];	
			$estado = 0;		
			try{
				$insert = "INSERT into `lista_avaliacao` (id_assist, id_serv, data, convenio)
				VALUES (:id_assist, :servicos, :data, :convenio)";
				$result = $conexao->prepare($insert);
				$result->bindParam(':id_assist', $id_assist, PDO::PARAM_INT);
				$result->bindParam(':servicos', $servicos, PDO::PARAM_INT);
				$result->bindParam(':data', $data, PDO::PARAM_STR);
				$result->bindParam(':convenio', $convenio, PDO::PARAM_STR);
				$result->execute();
				echo   '<div class="alert alert-success">
				<strong>Cadastro realizado com sucesso!</strong> 
				Aguarde o redirecionamento.
				</div>';
				header ("Refresh: 1");
			}
			catch(PDOException $e){		echo $e;}
		}

		if(isset($_POST['envListEsp'])){
			$servicos=trim(strip_tags($_POST['servicos'])); 
			$id_assist = $id;
			$data = date("Y/m/d");
			$mostrar = "S";			
			if (isset( $_POST['prioridade'] )) {
				$prioridade = $_POST['prioridade'];
			}else{
				$tipo = NULL;
			}
			if (isset( $_POST['convenio'])) {
				$tipo = $_POST['convenio'];
			}else{
				$tipo = NULL;
			}
			try{
				$insert = "INSERT into `list_espera` (id_assist, id_serv, data, tipo, mostrar, prioridade)
				VALUES (:id_assist, :servicos, :data, :tipo, :mostrar, :prioridade)";
				$result = $conexao->prepare($insert);
				$result->bindParam(':servicos', $servicos, PDO::PARAM_STR);
				$result->bindParam(':id_assist', $id_assist, PDO::PARAM_INT);
				$result->bindParam(':data', $data, PDO::PARAM_STR);
				$result->bindParam(':tipo', $tipo, PDO::PARAM_STR);
				$result->bindParam(':mostrar', $mostrar, PDO::PARAM_STR);
				$result->bindParam(':prioridade', $prioridade, PDO::PARAM_STR);
				$result->execute();
				echo   '<div class="alert alert-success">
				<strong>Cadastro realizado com sucesso!</strong> 
				Aguarde o redirecionamento.
				</div>';
				header ("Refresh: 1");
			}
			catch(PDOException $e){		echo $e;}
		}
		if(isset($_POST['submit']))
		{
			$horario=$_POST['horario'];
			$servicos=trim(strip_tags($_POST['servicos'])); 
			$profissionais=trim(strip_tags($_POST['profissionais'])); 
			$convenio =trim(strip_tags($_POST['convenio'])); 
			$dia =trim(strip_tags($_POST['dia']));
			$id_assist = $id;
			$ativo="S";
			try{
				$insert = "INSERT into `agenda` (id_prof,	id_serv, id_assist,	tipo, dia, horario, ativo)
				VALUES (:profissionais, :servicos, :id_assist, :convenio, :dia, :horario, :ativo)";
				$result = $conexao->prepare($insert);
				$result->bindParam(':profissionais', $profissionais, PDO::PARAM_STR);
				$result->bindParam(':servicos', $servicos, PDO::PARAM_STR);
				$result->bindParam(':id_assist', $id_assist, PDO::PARAM_INT);
				$result->bindParam(':convenio', $convenio, PDO::PARAM_STR);
				$result->bindParam(':dia', $dia, PDO::PARAM_STR);
				$result->bindParam(':horario', $horario, PDO::PARAM_STR);
				$result->bindParam(':ativo', $ativo, PDO::PARAM_STR);
				$result->execute();				
				registraLogAgenda($id_assist, $servicos, $profissionais, $_SESSION['nome'] );
				echo   '<div class="alert alert-success">
				<strong>Cadastro realizado com sucesso!</strong> 
				Aguarde o redirecionamento.
				</div>';
				header ("Refresh: 1");
			}
			catch(PDOException $e){		echo $e;}

			$data = date("Y/m/d");
			$estado = "Inserido";
			try{
				$insert = "INSERT into `atendimentos` (id_assist,data,estado,id_prof,id_serv,tipo)
				VALUES (:id_assist, :data, :estado, :id_prof, :id_serv, :tipo)";
				$result = $conexao->prepare($insert);
				$result->bindParam(':id_assist', $id_assist, PDO::PARAM_INT);
				$result->bindParam(':data', $data, PDO::PARAM_STR);
				$result->bindParam(':estado', $estado, PDO::PARAM_STR);
				$result->bindParam(':id_prof', $profissionais, PDO::PARAM_STR);
				$result->bindParam(':id_serv', $servicos, PDO::PARAM_STR);
				$result->bindParam(':tipo', $convenio, PDO::PARAM_STR);
				$result->execute();
			}catch(PDOException $e){echo $e;  die;exit;}
		}
		?>
		<div class="horario_austista"></div>
		<?php if ($nis == "" OR $nis == 0) {
			echo   '<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>Atenção!</strong> 
			Número do NIS não informado.
			</div>';
		} ?>
		<div class="row fundoBranco" >
			<?php if ($autista == 1) {
				$autistaCheck = 'readonly="true"';
				echo '<input type="hidden" id="autista" value="0">';
				echo "<h1 style='color: #ED9315;'>";
			}else{
				echo '<input type="hidden" id="autista" value="1">';
				echo '<h1>';
				$autistaCheck = NULL;
			} 
			?>
			<b><?php echo $nome; ?></b> <?php if ($_SESSION['usuario'] == '157' OR $_SESSION['usuario'] == '167' OR $_SESSION['usuario'] == '152') {
				?><i class="fa fa-puzzle-piece" id="marcarAutista"  aria-hidden="true"></i><?php } ?> <button type="button" class="btn" data-toggle="modal" data-target="#myModal" style="color: #337ab7;">Atualizar</button>
				<img src="upload/<?php 	echo $imagem; ?>"  class="img-thumbnail" title="<?php echo $nome; ?>" alt="<?php echo $nome; ?>" style="float:right; width: 175px; height: 175px; border-radius: 50%;">
			</h1>
			<?php echo $pasta; ?>
			<hr>
		</div>
		<div class="row fundoBranco">
			<div class="col-sm-3" style="border-right: 4px solid #085085;">
				<strong>Escola: </strong><?php echo $escola; ?><br>
				<strong>NIS: </strong><?php echo $nis; ?><br>
				<strong>Data de Nascimento: </strong><?php echo date('d/m/Y',  strtotime($datanasc)); ?><br>
				<strong>Naturalidade: </strong><?php echo $naturalidade; ?><br>
				<strong>Observação: </strong><?php echo $obs; ?><br>
			</div>
			<div class="col-sm-3" style="border-right: 4px solid #085085;">
				<strong>Rua: </strong><?php echo $rua; ?><br>
				<strong>Número: </strong><?php echo $numero; ?><br>
				<strong>Cidade: </strong><?php echo $cidade; ?><br>
				<strong>Bairro: </strong><?php echo $bairro; ?><br>
				<strong>Complemento: </strong><?php echo $complemento; ?><br>
				<strong>CEP: </strong><?php echo $cep; ?><br>
			</div>
			<div class="col-sm-3" style="border-right: 4px solid #085085;">
				<strong>Cartório: </strong><?php echo $cartorio; ?><br>
				<strong>Folha: </strong><?php echo $folha; ?><br>
				<strong>Livro: </strong><?php echo $livro; ?><br>
				<strong>Data de Registro: </strong><?php echo date('d/m/Y',  strtotime($datareg)); ?><br>
				<strong>Número de Certidão: </strong><?php echo $ncertidao;  ?><br>
			</div>
			<div class="col-sm-3" style="border-right: 4px solid #085085;">
				<strong>Nome:</strong> <?php echo $nome_tipo ;?><br>
				<strong>Telefone:</strong> <?php echo $telefone ;?><br>
				<strong>CPF:</strong> <?php echo $cpf ;?><br>
				<strong>RG:</strong> <?php echo $rg ;?><br>
				<strong>Data de Nascimento:</strong> <?php echo date('d/m/Y',  strtotime($data_nasc)); ?><br>
				<strong>Dependentes:</strong> <?php echo $dependentes ;?><br>
				<strong>Escolaridade:</strong> <?php echo $escolaridade ;?><br>
				<strong>Profissão:</strong> <?php echo $profissao ;?><br>
			</div>
		</div><br><br>
		<div class="row fundoBranco">
			<div class="col-sm-6">
				<?php include("header/hist-agenda.php"); ?>
			</div>
			<div class="col-sm-6"><br><br>
				<div class="row">
					<?php if ($_SESSION['nivel'] == 1){ ?>
						<a data-toggle="modal" data-target="#agendarhorario" class="link-modal">
							<div class="col-sm-6 text-center link-modal"  style="padding: 20px;">
								<i class="fa fa-clock-o fa-5x" aria-hidden="true"></i><br>
								Agendar Horário
							</div>
						</a>
						<a data-toggle="modal" data-target="#registrarconsulta" class="link-modal">
							<div class="col-sm-6 text-center link-modal"  style="padding: 20px;">
								<i class="fa fa-calendar-check-o fa-5x" aria-hidden="true"></i><br>
								Registrar Consulta
							</div>
						</a>
						<a data-toggle="modal" data-target="#modalListEspera" class="link-modal" >
							<div class="col-sm-6 text-center link-modal lstEspera"  style="padding: 20px;">
								<i class="fa fa-calendar fa-5x" aria-hidden="true"></i><br>
								Colocar na Lista de Espera
							</div>
						</a>					
						<a data-toggle="modal" data-target="#modalListaTriagemPsicologia" class="link-modal" >
							<div class="col-sm-6 text-center link-modal lstEspera"  style="padding: 20px;">
								<i class="fa fa-list-alt fa-5x" aria-hidden="true"></i><br>
								Triagem com a Psicologia
							</div>
						</a>				
						<a data-toggle="modal" data-target="#modalListaAvaliacao" class="link-modal" >
							<div class="col-sm-6 text-center link-modal lstEspera"  style="padding: 20px;">
								<i class="fa fa-tasks fa-5x" aria-hidden="true"></i><br>
								Lista de Avaliação
							</div>
						</a>
					<?php 	}else{} ?>
					<a data-toggle="modal" data-target="#hist" class="link-modal">
						<div class="col-sm-6 text-center link-modal"  style="padding: 20px;">
							<i class="fa fa-bar-chart fa-5x" aria-hidden="true"></i><br>
							Histórico
						</div>
					</a>		
					<?php 
					if($contar > 0 AND $contar > $desligado){ ?>			
						<a href="atestado-frequencia.php?id=<?php echo $id; ?>" class="link-modal" target="_blank">
							<div class="col-sm-6 text-center link-modal"  style="padding: 20px;">
								<i class="fa fa-sort-amount-desc fa-5x" aria-hidden="true"></i><br>
								Atestado de Frequência				
							</div>
						</a>		
						<a href="fa.php?id=<?php echo $id; ?>" class="link-modal" target="_blank">
							<div class="col-sm-6 text-center link-modal"  style="padding: 20px;">
								<i class="fa fa-book fa-5x" aria-hidden="true"></i><br>
								Ficha de Atendimento			
							</div>
						</a>	
					<?php } ?>				
						<a href="fa-branco.php?id=<?php echo $id; ?>" class="link-modal" target="_blank">
							<div class="col-sm-6 text-center link-modal"  style="padding: 20px;">
								<i class="fa fa-file-text fa-5x" aria-hidden="true"></i><br>
								Ficha de Atendimento em Branco			
							</div>
						</a>					
				</div>
				<div class="row text-center">
					<?php include("includes/num-atendimentos.php"); ?>
				</div>
			</div>
		</div>
		<br><br>
		<div class="row fundoBranco">
			<div class="col-sm-8 col-md-offset-2">
				<?php 
				if ($frq == 1) {
					include("graf.php");
				}else{} ?>
			</div>
		</div>
		<br><br>
	</div>
	<?php 

// $link = '55539'.$telefone;
// $aux = 'qr_img0.50j/php/qr_img.php?';
// $aux .= 'd='.$link.'&';
// $aux .= 'e=H&';
// $aux .= 's=10&';
// $aux .= 't=J';

	?>
<!-- 
	<center><img src="<?php echo $aux; ?>" />  -->

		<!-- Modal -->

		<div class="modal fade" id="modalListEspera" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4>Lista de Espera </h4>
					</div>
					<div class="modal-body">
						<p>Selecione abaixo o atendimento </p>
						<form action="" method="post" >
							<div class="row">
								<div class="col-lg-6">
									<label for="servico">Serviço</label>
									<?php include("includes/select.php"); ?>

								</div>
								<div class="col-lg-6">
									<label for="convenio">Convênio</label>
									<select class="form-control" name="convenio" required>
										<option selected disabled> </option>
										<option value="Saúde">Saúde</option>
										<option value="SMED">Educação</option>
										<option value="Centro">Centro</option>
										<option value="Candiota">Candiota</option>
										<option value="Unimed">UNIMED</option>
										<option value="Assistencia">Assistência</option>
										<option value="CLuz">Caminho da Luz</option>
									</select>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-lg-12">
									<input type="checkbox" name="prioridade" value="1" id="prioridade">
									<label for="prioridade">Atendimento pré-pandemia</label>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
							<button type="submit" name="envListEsp" class="btn btn-primary">Salvar mudanças</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modalListaTriagemPsicologia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4>Adicionar a lista de triagem com a Psicologia </h4>
					</div>
					<div class="modal-body">
						<p>Selecione abaixo o convênio. </p>
						<form action="" method="post" >
							<div class="row">
								<div class="col-lg-12">
									<label for="convenio">Convênio</label>
									<select class="form-control" name="convenio" required>
										<option selected disabled> </option>
										<option value="Saúde">Saúde</option>
										<option value="SMED">Educação</option>
										<option value="Centro">Centro</option>
										<option value="CLuz">Caminho da Luz</option>
										<option value="EJudicial">Encaminhamento Judicial</option>
									</select>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
							<button type="submit" name="envTriagemPsicologia" class="btn btn-primary">Salvar mudanças</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modalListaAvaliacao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4>Adicionar a lista de Avaliação </h4>
					</div>
					<div class="modal-body">
						<p>Selecione abaixo o convênio. </p>
						<form action="" method="post" >
							<div class="row">								
								<div class="col-lg-6">
									<label for="convenio">Serviço</label>
									<?php include("includes/select.php"); ?>
								</div>
								<div class="col-lg-6">
									<label for="convenio">Convênio</label>
									<select class="form-control" name="convenio" required>
										<option selected disabled> </option>
										<option value="Saúde">Saúde</option>
										<option value="SMED">Educação</option>
										<option value="Centro">Centro</option>
										<option value="CLuz">Caminho da Luz</option>
										<option value="EJudicial">Encaminhamento Judicial</option>
									</select>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
							<button type="submit" name="envListaAvaliacao" class="btn btn-primary">Salvar mudanças</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div id="myModal" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<div class="container-fluid text-center">    
							<div class="row content">
								<div class="col-sm-2 sidenav">
								</div>
								<div class="col-sm-8 text-left" style="background: white;"> <br>

									<h1>1. DADOS PESSOAIS <button type="button" class="btn btn-default" title="Infos" data-toggle="collapse" data-target="#dpes">+</button></h1>
									<hr>
									<form class="form-horizontal" method="post" action="u<?php echo $id; ?>" enctype="multipart/form-data">
										<div id="dpes" class="collapse">
											<div class="form-group">
												<label class="control-label col-sm-2" for="nome">Nome <span style="color:red">*</span></label>
												<div class="col-sm-10">
													<input type="text" class="form-control" name="nome" id="email" required value="<?php echo $nome; ?>">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-2" for="foto">Foto </label>
												<div class="col-sm-10"> 
													<input type="file" name="img" class="form-control" capture >
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-2" for="data de nascimento">Data de Nascimento <span style="color:red">*</span></label>
												<div class="col-sm-10">
													<input type="date"  name="datanasc" value="<?php echo $datanasc; ?>" class="form-control" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-2" for="número de certidão">Número de Certidão <span style="color:red">*</span></label>
												<div class="col-sm-10"> 
													<input type="text" value="<?php echo $ncertidao; ?>" onkeyup="somenteNumeros(this);" name="ncertidao" size="13" maxlength="13" placeholder="Número certidão (OBRIGATÓRIO)" required class="form-control">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-2" for="nis">NIS <span style="color:red">*</span></label>
												<div class="col-sm-10">
													<input type="text" onkeyup="somenteNumeros(this);"  value="<?php echo $nis; ?>" name="nis" size="12" maxlength="12" placeholder="NIS (OBRIGATÓRIO)" required class="form-control">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-2" for="escola">Escola <span style="color:red">*</span></label>
												<div class="col-sm-10"> 
													<input type="text" name="escola" value="<?php echo $escola; ?>" placeholder="Escola" required class="form-control">
												</div>
											</div>	  
											<div class="form-group">
												<label class="control-label col-sm-2" for="naturalidade">Naturalidade <span style="color:red">*</span></label>
												<div class="col-sm-10">
													<input type="text" name="naturalidade" value="<?php echo $naturalidade; ?>" placeholder="Naturalidade" required class="form-control">
												</div>
											</div> 
											<div class="form-group">
												<label class="control-label col-sm-2" for="pasta">Pasta <span style="color:red">*</span></label>
												<div class="col-sm-10">
													<input type="text" name="pasta" value="<?php echo $pasta; ?>" placeholder="Pasta" required class="form-control">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-2" for="observação">Observação</label>
												<div class="col-sm-10">
													<textarea class="form-control" name="obs" placeholder="Observação..." style="resize:vertical;"><?php echo $obs; ?></textarea>
												</div>
											</div>
											<span style="color:red">*</span> Obrigatório
										</div>
										<h1>2. DADOS RESPONSÁVEL <button type="button" class="btn btn-default" title="Infos" data-toggle="collapse" data-target="#dres">+</button></h1>
										<hr>
										<div id="dres" class="collapse">
											<div class="form-group">
												<label class="control-label col-sm-2" >Nome </label>
												<div class="col-sm-10">
													<input type="text"   name="nome_tipo" value="<?php echo $nome_tipo;?>" placeholder="Inserir nome completo (OBRIGATÓRIO)" class="form-control">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-2" for="pwd">RG </label>
												<div class="col-sm-10"> 
													<input type="text" onkeyup="somenteNumeros(this);" value="<?php echo $rg;?>" name="rg" size="10" maxlength="10" placeholder="Número RG" class="form-control" >
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-2" >CPF <span style="color:red">*</span></label>
												<div class="col-sm-10">
													<input type="text" onkeyup="somenteNumeros(this);" value="<?php echo $cpf;?>" name="cpf" size="11" maxlength="11" placeholder="Número CPF (OBRIGATÓRIO)" required class="form-control" >
													<input type="checkbox" name="existe" value="1" style="width: 15px; height: 15px;">Responsável já cadastrado
													<a href="javascript:void(0)" onclick="window.open('consulta.php', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=770, HEIGHT=400');" style="float: right;"><u style="color: black;">Consultar CPF</u></a>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-2" for="pwd">Dependentes </label>
												<div class="col-sm-10"> 
													<input type="text"   name="dependentes" value="<?php echo $dependentes;?>" placeholder="Dependentes" class="form-control" >
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-2" >Grau <span style="color:red">*</span></label>
												<div class="col-sm-10">
													<select class="form-control"  name="tipo">
														<option selected><?php echo $tipo; ?></option>
														<?php if($tipo!='Pai'){ echo '<option value="Pai">Pai</option>'; }?>
														<?php if($tipo!='Mãe'){ echo '<option value="Mãe">Mãe</option>'; }?>
														<?php if($tipo!='Responsável'){ echo '<option value="Responsável">Responsável</option>'; }?>
													</select>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="pwd">Data de Nascimento </label>
											<div class="col-sm-10"> 
												<input type="date" name="data_nasc_resp" value="<?php echo $data_nasc;?>" class="form-control">
											</div>
										</div>	  
										<div class="form-group">
											<label class="control-label col-sm-2" >Telefone <span style="color:red">*</span></label>
											<div class="col-sm-10">
												<input type="text" onkeyup="somenteNumeros(this);" value="<?php echo $telefone;?>" name="telefone" size="11" maxlength="11" placeholder="xx xxxx xxxx (OBRIGATÓRIO)" class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="pwd">Escolaridade </label>
											<div class="col-sm-10"> 
												<input type="text" name="escolaridade" value="<?php echo $escolaridade;?>" placeholder="Insira o grau de escolaridade" class="form-control">
											</div>
										</div>	  
										<div class="form-group">
											<label class="control-label col-sm-2" >Profissão </label>
											<div class="col-sm-10">
												<input type="text" name="profissao" value="<?php echo $profissao;?>" placeholder="Insira a profissão" class="form-control">
											</div>
										</div>
										<span style="color:red">*</span> Obrigatório
									</div>
									<h1>3. DADOS CARTÓRIO <button type="button" class="btn btn-default" title="Infos" data-toggle="collapse" data-target="#cart">+</button></h1>
									<hr>
									<div id="cart" class="collapse">
										<div class="form-group">
											<label class="control-label col-sm-2" >Nome Cartório <span style="color:red">*</span></label>
											<div class="col-sm-10">
												<input type="text"   name="cartorio" value="<?php echo $cartorio; ?>" placeholder="Nome do Cartório"  required class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="pwd">Folha <span style="color:red">*</span></label>
											<div class="col-sm-10"> 
												<input type="text"   name="livro" placeholder="Livro" value="<?php echo $folha; ?>" required class="form-control" >
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" >Livro <span style="color:red">*</span></label>
											<div class="col-sm-10">
												<input type="text" name="folha" placeholder="Folha" value="<?php echo $livro; ?>" required class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="pwd">Data <span style="color:red">*</span></label>
											<div class="col-sm-10"> 
												<input type="date" name="datareg" value="<?php echo $datareg; ?>" required class="form-control">
											</div>
										</div>
										<span style="color:red">*</span> Obrigatório
									</div>
									<h1>4. ENDEREÇO <button type="button" class="btn btn-default" title="Infos" data-toggle="collapse" data-target="#end">+</button></h1>
									<hr>

									<div id="end" class="collapse">
										<div class="form-group">
											<label class="control-label col-sm-2" >Rua <span style="color:red">*</span></label>
											<div class="col-sm-10">
												<input type="text"   name="rua" value="<?php echo $rua; ?>" placeholder="Inserir nome rua" required class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="pwd">Número <span style="color:red">*</span></label>
											<div class="col-sm-10"> 
												<input type="text"   name="numero" value="<?php echo $numero; ?>" size="6" maxlength="6" placeholder="xxx" required class="form-control" >
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" >Bairro <span style="color:red">*</span></label>
											<div class="col-sm-10">
												<input type="text"   name="bairro" value="<?php echo $bairro; ?>" placeholder="Inserir nome bairro" required class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="pwd">Complemento </label>
											<div class="col-sm-10"> 
												<input type="text"   name="complemento" value="<?php echo $complemento; ?>" placeholder="Inserir complemento" class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="pwd">Cidade <span style="color:red">*</span></label>
											<div class="col-sm-10"> 
												<input type="text"   name="cidade" value="<?php echo $cidade; ?>" placeholder="Inserir nome cidade" required class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="pwd">CEP <span style="color:red">*</span></label>
											<div class="col-sm-10"> 
												<input type="text" onkeyup="somenteNumeros(this);" value="<?php echo $cep; ?>" name="cep" size="9" maxlength="9" placeholder="Inserir CEP" required class="form-control">
											</div>
										</div> 
										<span style="color:red">*</span> Obrigatório	  
									</div>
									<center><button type="submit" class="btn" name="atualizar">Enviar</button>
									</form>
								</div>
								<br>
							</div>
						</div>

						<script>
							function somenteNumeros(num) {
								var er = /[^0-9.]/;
								er.lastIndex = 0;
								var campo = num;
								if (er.test(campo.value)) {
									campo.value = "";
								}
							}
						</script>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
					</div>
				</div>

			</div>
		</div>
		<!-- Modal histórico -->
		<div id="hist" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">

				<!-- Modal histórico-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<a href="historico-<?php echo $nome; ?>-<?php echo $id; ?>" class="link-modal">Baixar Histórico</a>
						<?php include ("historico.php"); ?>
					</div>
				</div>

			</div>
		</div>
		<!-- Modal agendar horario -->
		<div id="agendarhorario" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">

				<!-- Modal agendar horario-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<h1>Agendamento de Atendimentos</h1>
						<p>Aqui serão agendados os atendimentos dos assistidos que ingressaram na clínica.</p><br>
						<form id="agenda" method="post" action="">
							<div class="form-group">										
								<div class="col-xs-3"><?php include("includes/prof.php"); ?></div>
								<div class="col-xs-3">
									<select class="form-control resultado_select" name="servicos" required>	</select>						
								</div>
								<div class="col-xs-2">
									<select name="convenio" class="form-control" required>
										<option value="Saúde">Saúde</option>
										<option value="SMED">Educação</option>
										<option value="Centro">Centro</option>
										<option value="Candiota">Candiota</option>
										<option value="Unimed">UNIMED</option>
										<option value="Assistencia">Assistência</option>
										<option value="CLuz">Caminho da Luz</option>
										<option value="EJudicial">Encaminhamento Judicial</option>
									</select>
								</div>
								<div class="col-xs-2">
									<select name="dia" class="form-control" onchange="ValidarPreenchimento()" id="dia" required>
										<option value="1">Segunda</option>
										<option value="2">Terça</option>
										<option value="3">Quarta</option>
										<option value="4">Quinta</option>
										<option value="5">Sexta</option>
									</select>
								</div>
								<div class="col-xs-2">
									<input type="text" class="form-control" onkeyup="ValidarPreenchimento()" name="horario" id="horario" placeholder="Horário">
								</div>
							</div><br><br>
							<div class="btnConfirm"></div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
					</div>
				</div>

			</div>
		</div>
		<!-- Modal registrar consulta -->
		<div id="registrarconsulta" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">

				<!-- Modal agendar horario-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<h1>Registrar Consulta</h1><br>
						<p>Aqui serão registradas consultas que não estão na agenda.</p><br>
						<form id="agenda" action="consulta-<?php echo $id;?>" method="post">
							<input type="hidden" name="id_assist" id="idAssist" value="<?php echo $linha->id; ?>">
							<div class="form-group">
								<div class="col-sm-3">
									<select class="form-control" name="servicos" id="sel_servico" required>
										<option selected disabled>  </option>
										<?php
				//AQUI VOU SELECIONAR TODOS OS SERVIÇOS

										$select = "SELECT * FROM `servicos` ORDER BY nome ASC";
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
								<div class="col-sm-3">											
									<select class="form-control resultado_profissional" name="profissionais" required>				
									</select>
								</div>
								<div class="col-sm-3">
									<select name="convenio" class="form-control" required>
										<option selected disabled> </option>
										<option value="Saúde">Saúde</option>
										<option value="SMED">Educação</option>
										<option value="Centro">Centro</option>
										<option value="Candiota">Candiota</option>
										<option value="Unimed">UNIMED</option>
										<option value="Assistencia">Assistência</option>
										<option value="CLuz">Caminho da Luz</option>
										<option value="EJudicial">Encaminhamento Judicial</option>
									</select>
								</div>
								<div class="col-sm-3">
									<select name="status" class="form-control" required>
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
								</div><br><br>
								<center><input type="submit" class="btn btn-primary" name="submit" value="Enviar">
								</center></div>
							</form>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<script>
							// $(".lstEspera").click(function(){
							// 	$( "#envListEsp" ).submit();
							// })
							var id_assist = "<?php echo $id; ?>";
							function ValidarPreenchimento(){
								var dia = $("#dia").val();
								var hora = $("#horario").val();
								if(dia != "" && hora != ""){
									$.post("busca-horario.php", {dia:dia, hora:hora, id_assist:id_assist}, function(retorno){
										$(".btnConfirm").html(retorno)
									})
								}
							}


							
							$("#marcarAutista").click(function(){
								var autista = $("#autista").val();								
								$.post("marcar_autistas.php", {id_assist:id_assist, autista:autista}, function(retorno){
									$(".horario_austista").html(retorno)
									location.reload();
								})
							})


							var frequencia = "<?php echo $total; ?>";
							if(parseInt(frequencia) < 70){
								$("body").css("background-color", "#D41C0C").css("transition", "all .4s ease-in-out");
								$(".fundoBranco").css("background-color", "white").css("color", "black").css("padding", "20px").css("transition", "all .8s ease-in-out");
								$(".frq").css("color", "red");
							}else{
								$(".fundoBranco").css("padding", "20px").css("transition", "all .4s ease-in-out");
							}
							$("#prof_select").change(function(){
								var numero1 = $("#prof_select").val();
								$.post("resp-serv.php", {prof_select:numero1}, function(retorno){
									$(".resultado_select").html(retorno)
								});
							})
							$("#sel_servico").change(function(){
								var servico = $("#sel_servico").val();
								$.post("resp-serv.php", {servico:servico}, function(retorno){
									$(".resultado_profissional").html(retorno)
								});
							})
						</script>
					</body>
					</html>