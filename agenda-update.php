<?php 
include("cabecalho.php");
$id=$_GET['id'];
?>
<title>Atualizar Atendimento</title>
<center>
	<?php
	$select = "SELECT agenda.*, profissionais.nome as p_nome, servicos.nome as serv_nome, assistidos.nome as as_nome
	FROM (((agenda
	INNER JOIN profissionais ON agenda.id_prof = profissionais.id)
	INNER JOIN assistidos ON agenda.id_assist = assistidos.id_assist)
	INNER JOIN servicos ON agenda.id_serv = servicos.id) WHERE agenda.id=:id";
	try{
		$result=$conexao->prepare($select);
		$result->bindParam(':id', $id, PDO::PARAM_INT);
		$result->execute();
		$contar= $result->rowCount();
		if($contar>0){
			while ($linha = $result->FETCH(PDO::FETCH_OBJ))
			{
				$tipo = $linha->tipo;
				$dia = $linha->dia;
				$horario = $linha->horario;
				$prof= $linha->id_prof;
				$profNome=$linha->p_nome;
				$nomeServ=$linha->serv_nome;
				$servId=$linha->id_serv;
				$CompAtivo=$linha->ativo;
				$nome=$linha->as_nome;
				$id_assist=$linha->id_assist;
			}
		}else{
			echo '
			<div class="alert alert-danger">
			<strong>Nenhum dado encontrado!</strong> Tente novamente.
			</div>'; exit;
		}
	}catch(PDOException $e){echo $e;}
	if(isset($_POST['atualizar'])){
		$horario=$_POST['horario'];
		$servicos=trim(strip_tags($_POST['servicos'])); 
		$profissionais=trim(strip_tags($_POST['profissionais'])); 
		$convenio =trim(strip_tags($_POST['convenio'])); 
		$dia =trim(strip_tags($_POST['dia']));
		$ativo=trim(strip_tags($_POST['ativo']));

		// if ($CompAtivo != $ativo) {
		// 	$id_prof = $profissionais;
		// 	$id_serv = $servicos;
		// 	switch($ativo){
		// 		case "S":	
		// 		// include ("header/agenda-up-desliga.php");
		// 		break;
		// 		case 'N':
		// 		// include ("header/agenda-up-desliga.php");
		// 		break;
		// 	}
		// }

		if ($ativo == "N") {
			# CASO SEJA DESLIGADO VIA ATUALIZAÇÃO DE HORÁRIO, AUTOMATICAMENTE O SISTEMA CRIA UMA LINHA NOS ATENDIMENTOS INFORMANDO O DESLIGAMENTO
			$data = date("Y-m-d");
			$estado = "Desligado";
			try{
				$insert = "INSERT into `atendimentos` (id_assist,data,estado,id_prof,id_serv,tipo)
				VALUES (:id_assist, :data, :estado, :id_prof, :id_serv, :tipo)";
				$result = $conexao->prepare($insert);
				$result->bindParam(':id_assist', $id_assist, PDO::PARAM_STR);
				$result->bindParam(':data', $data, PDO::PARAM_STR);
				$result->bindParam(':estado', $estado, PDO::PARAM_STR);
				$result->bindParam(':id_prof', $prof, PDO::PARAM_STR);
				$result->bindParam(':id_serv', $servId, PDO::PARAM_STR);
				$result->bindParam(':tipo', $tipo, PDO::PARAM_STR);
				$result->execute();
			}catch(PDOException $e){echo $e;}
		}
		
		try{
			$update = "UPDATE `agenda` SET id_prof=:profissionais,	id_serv=:servicos, 	tipo=:convenio, dia=:dia, horario=:horario, ativo=:ativo WHERE id=:id";
			$result = $conexao->prepare($update);
			$result->bindParam(':id', $id, PDO::PARAM_INT);
			$result->bindParam(':profissionais', $profissionais, PDO::PARAM_STR);
			$result->bindParam(':servicos', $servicos, PDO::PARAM_STR);
			$result->bindParam(':convenio', $convenio, PDO::PARAM_STR);
			$result->bindParam(':dia', $dia, PDO::PARAM_STR);
			$result->bindParam(':horario', $horario, PDO::PARAM_STR);
			$result->bindParam(':ativo', $ativo, PDO::PARAM_STR);
			$result->execute();
			echo   '<div class="alert alert-success">
			<strong>Cadastro realizado com sucesso!</strong> 
			Aguarde o redirecionamento.
			</div>';
			header ("Refresh: 1, agenda.php");
		}
		catch(PDOException $e){		echo $e;}
	}

	$anome = implode('-', explode(' ', $nome));
	?>
	<div class="container-fluid text-center">    
		<div class="row content">
			<div class="col-sm-2 sidenav" ></div>

			<div class="col-sm-8 text-left" style="background: white;">
				<form id="agenda" method="post" action="">
					<h1>Atualizar Horário</h1>
					<a href="inicio">Home</a> > <a href="registros">Registros</a> > <a href="p<?php echo $anome;?>-<?php echo $id_assist;?>"><?php echo $nome; ?></a> > Atualizar Horário
					<hr>
					<div class="col-sm-2">	<?php include("includes/select-up.php"); ?> </div>
					<div class="col-sm-2">	<?php include("includes/prof-up.php"); ?> </div>
					<div class="col-sm-2">
						<select class="form-control" name="convenio" required>
							<option value="<?php echo $tipo; ?>" selected><?php echo $tipo; ?></option>
							<?php if($tipo!='Saúde'){ echo '<option value="Saúde">Saúde</option>'; }?>
							<?php if($tipo!='SMED'){ echo '<option value="SMED">SMED</option>'; }?>
							<?php if($tipo!='Centro'){ echo '<option value="Centro">Centro</option>'; }?>
							<?php if($tipo!='Candiota'){ echo '<option value="Candiota">Candiota</option>'; }?>
							<?php if($tipo!='Unimed'){ echo '<option value="Unimed">UNIMED</option>'; }?>
							<?php if($tipo!='Assistencia'){ echo '<option value="Assistencia">Assistência</option>'; }?>
							<?php if($tipo!='CLuz'){ echo '<option value="CLuz">Caminho da Luz</option>'; }?>
							<?php if($tipo!='EJudicial'){ echo '<option value="CLuz">Encaminhamento Judicial</option>'; }?>
						</select>
					</div><div class="col-sm-2">
						<select class="form-control" name="dia" required>
							<option value="<?php echo $dia ?>" selected>	<?php if($dia==1){echo "Segunda";}elseif($dia==2){echo "Terça";}elseif($dia==3){echo "Quarta";}elseif($dia==4){echo "Quinta";}elseif($dia==5){echo "Sexta";}?> </option>
							<?php if($dia!='1'){ echo '<option value="1">Segunda</option>'; }?>
							<?php if($dia!='2'){ echo '<option value="2">Terça</option>'; }?>
							<?php if($dia!='3'){ echo '<option value="3">Quarta</option>'; }?>
							<?php if($dia!='4'){ echo '<option value="4">Quinta</option>'; }?>
							<?php if($dia!='5'){ echo '<option value="5">Sexta</option>'; }?>
						</select>
					</div><div class="col-sm-2">
						<input class="form-control" type="text" name="horario" value="<?php echo $horario; ?>">
					</div><div class="col-sm-2">		
						<select class="form-control" name="ativo" required>
							<option value="<?php echo $CompAtivo; ?>"><?php if($CompAtivo=="N"){echo "Desligado";}else{echo "Ativo";}?></option>
							<?php if($CompAtivo!='N'){ echo '<option value="N">Desligado</option>'; }?>
							<?php if($CompAtivo!='S'){ echo '<option value="S">Ativo</option>'; }?>
							<?php if($CompAtivo!='P'){ echo '<option value="S">Passivo</option>'; }?>
						</select>
					</div>	<br><br><center>
						<input type="submit" class="btn" name="atualizar" value="Atualizar">

					</form>
				</div>
			</div>
		</div>