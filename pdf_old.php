<!DOCTYPE html>
<html>
<head>
	<title>Agenda</title>
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=IBM+Plex+Serif" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jqueryform.js"></script>
	<style>
		@media print {
			.horario{
				background-color: #085085;
				color: white;
			}
		}
	</style>
</head>
<?php 
include("conecta/conexao.php");
$numCont = NULL;
$profissionais= $_GET['p'];
$verDia = 0;
include("includes/prof-infos.php");
include("header/horarios.php");

?>

<body style="font-family: 'Lato', sans-serif;">
	<div class="container">
		<div class="jumbotron" style="background: white;">
			<h1  style="font-family: 'Lato', sans-serif;">Agenda <?php echo $profNome; ?> <img src="img/logo.png" width="100px" style="float: right"></h1><hr>
			Atualizado em <?php echo date("d/m/Y"); ?>
		</div>
	</div>
	<div class="col-xs-12 col-lg-12 col-md-12 col-sm-12">
		<div class="container">
			<?php
			$horarioVago = 0;
			$numAtendimentos = 0;
			$totalLinhas = count($diasTrabalho);
			for ($i=0; $i < $totalLinhas ; $i++) { 
				$coluna = count($diasTrabalho[$i]);
				$numDia = $diasTrabalho[$i][0];
				if($numDia==1){$dia = 'Segunda-Feira'; }
				if($numDia==2){$dia = 'Terça-Feira';} 
				if($numDia==3){$dia = 'Quarta-Feira';} 
				if($numDia==4){$dia = 'Quinta-Feira';} 
				if($numDia==5){$dia = 'Sexta-Feira';} 
				echo '<div class="row"><h3  style="font-family:"Lato", sans-serif;"><strong>'.$dia.'</strong></h3><hr></div>';
				for ($numColumn=1; $numColumn < $coluna ; $numColumn++) { 
					$horaAtendimento = $diasTrabalho[$i][$numColumn];
					$select = "SELECT agenda.*, profissionais.nome as p_nome, servicos.nome as serv_nome, assistidos.nome as assist_nome
					FROM (((agenda
					INNER JOIN assistidos ON agenda.id_assist = assistidos.id_assist)
					INNER JOIN profissionais ON agenda.id_prof = profissionais.id)
					INNER JOIN servicos ON agenda.id_serv = servicos.id) WHERE id_prof='$profissionais' AND ativo='S' AND dia=$numDia AND horario='$horaAtendimento' ORDER BY dia ASC, horario ASC ";
					$result=$conexao->prepare($select);
					$result->bindParam(':dia', $dia, PDO::PARAM_INT);
					$result->execute();
					$contar= $result->rowCount();
					if($contar>0){
						while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
							if($linha->dia==1){$dia = 'Segunda-Feira'; }
							if($linha->dia==2){$dia = 'Terça-Feira';} 
							if($linha->dia==3){$dia = 'Quarta-Feira';} 
							if($linha->dia==4){$dia = 'Quinta-Feira';} 
							if($linha->dia==5){$dia = 'Sexta-Feira';} 
							?>

							<div class="row" style="padding: 5px; ">
								<div class="col-xs-1 horario text-center col-lg-1 col-md-1" style="background-color: #085085; color: white"><?php echo $linha->horario; ?></div>
								<div class="col-xs-5  col-lg-5 col-md-5"><?php echo $linha->assist_nome; ?></div>
								<div class="col-xs-4  col-lg-4 col-md-4"><?php echo $linha->serv_nome; ?></div>
							</div>

							<?php
							$numAtendimentos++;
						}
					}else{
						if (isset($diaAvaliacao2)) {
							if ($numDia == $diaAvaliacao2) {
								if ($horaAtendimento == $horaAvalicao2) {
									echo '<div class="row" style="padding: 5px;">
									<div class="col-xs-1 horario text-center" style="background-color: #085085; color: white">'.$horaAvalicao2.'</div>
									<div class="col-xs-11">Avaliação</div>
									</div>'; goto end;
								}
							}
						}
						if ($numDia == $diaAvaliacao) {	
							if ($profissionais == 30) {
								if ($horaAtendimento == "14:00" AND $numDia = 5) {
									echo '<div class="row" style="padding: 5px;">
									<div class="col-xs-1 horario text-center" style="background-color: #085085; color: white">14:00</div>
									<div class="col-xs-11">Grupo de Mães</div>
									</div>';
								}
							} //NATIELE GRUPO DE MÃES					
							if ($profissionais == 35) {
								if ($horaAtendimento == "15:15") {
									echo '<div class="row" style="padding: 5px;">
									<div class="col-xs-1 horario text-center" style="background-color: #085085; color: white">15:00</div>
									<div class="col-xs-11">Avaliação</div>
									</div>';								
								}else{
									echo '<div class="row" style="padding: 5px;">
									<div class="col-xs-1 horario text-center" style="background-color: #085085; color: white">'.$horaAtendimento.'</div>
									<div class="col-xs-11">Horário Vago</div>
									</div>';
									$horarioVago++;
								}
							}else{
								if ($horaAtendimento == $horaAvalicao) {
									echo '<div class="row" style="padding: 5px;">
									<div class="col-xs-1 horario text-center" style="background-color: #085085; color: white">'.$horaAvalicao.'</div>
									<div class="col-xs-11">Avaliação</div>
									</div>';
								}else{
									echo '<div class="row" style="padding: 5px;">
									<div class="col-xs-1 horario text-center" style="background-color: #085085; color: white">'.$horaAtendimento.'</div>
									<div class="col-xs-11">Horário Vago</div>
									</div>';
									$horarioVago++;
								}
							}						
						}else{
							// if ($numDia == 3 AND $horaAtendimento > "15:00" AND $profissionais!=6) {
							// 	echo '<div class="row" style="padding: 5px;">
							// 	<div class="col-xs-1 horario text-center" style="background-color: #085085; color: white">'.$horaAtendimento.'</div>
							// 	<div class="col-xs-11">Estudo de Caso</div>
							// 	</div>';	
							// }else{
							// 	echo '<div class="row" style="padding: 5px;">
							// 	<div class="col-xs-1 horario text-center" style="background-color: #085085; color: white">'.$horaAtendimento.'</div>
							// 	<div class="col-xs-11">Horário Vago</div>
							// 	</div>';
							// 	$horarioVago++;
							// }
							echo '<div class="row" style="padding: 5px;">
								<div class="col-xs-1 horario text-center" style="background-color: #085085; color: white">'.$horaAtendimento.'</div>
								<div class="col-xs-11">Horário Vago</div>
								</div>';
								$horarioVago++;
						}
						end:
					}
				}
			}
			echo '<hr><br>Número de atendimentos: '.$numAtendimentos;
			echo '<br>Horários vagos: '.$horarioVago;
			?>
		</div>
	</div>
</body>
</html>