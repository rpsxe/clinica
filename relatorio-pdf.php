<?php 
include("conecta/conexao.php");
date_default_timezone_set('America/Sao_Paulo');
$numCont = NULL;


if(isset($_GET['date'])){
	$dataIni = $_GET['date'];
}else{
	$dataIni = date("Y-m-d");
}
$cont = 0;$faltas = 0;$saude=0;$smed=0;$desliga=0;$fj=0;  $num=0; $ins=0;$dis=0; $alta=0;$pfaus=0;
$tempo = $_GET['tempo'];
$prof = $_GET['prof'];
$dataFim = date('Y-m-d', strtotime('-'.$tempo.' days', strtotime($dataIni)));
$select = "SELECT atendimentos.*, atendimentos.id as id_at, profissionais.nome as p_nome, servicos.nome as serv_nome, assistidos.nome as assist_nome
FROM (((atendimentos
INNER JOIN assistidos ON atendimentos.id_assist = assistidos.id_assist)
INNER JOIN profissionais ON atendimentos.id_prof = profissionais.id)
INNER JOIN servicos ON atendimentos.id_serv = servicos.id) WHERE id_prof='$prof' AND (data BETWEEN '$dataFim' AND '$dataIni') ORDER BY id_at DESC";
$result=$conexao->prepare($select);
$result->execute();
$contar= $result->rowCount();
if($contar>0){

	echo '<!doctype html> 
	<title>Relatório de Atendimentos</title>
	<head>

	<!DOCTYPE html>
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=IBM+Plex+Serif" rel="stylesheet">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jqueryform.js"></script>
	</head>
	<div class="container ">  
	';
	
	echo '<table class="table table-striped" style="width: 100%">';
	echo '<tr>';
	echo '<th></th><th></th><th></th><th></th><th></th>';
	echo '</tr>';

	while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
		$estado = $linha->estado;
		$tipo=$linha->tipo;
		if($tipo=="SMED" && $estado=="Presente"){$smed++;}
		if($tipo=="Saúde" && $estado=="Presente"){$saude++;}
		if($estado=="Presente"){$cont++;}
		if($estado=="Falta"){$faltas++;}
		if($estado=="Falta Justificada"){$fj++;}
		if($estado=="Desligado"){$desliga++;}
		if($estado=="Inserido"){$ins++;}
		if($estado=="Dispensado"){$dis++;}
		if($estado=="Alta"){$alta++;}
		if($estado=="Profissional Ausente"){$pfaus++;}
		$profNome = $linha->p_nome;
		if( $estado=="Presente" ){ $class = 'class="success"';}if ($estado=="Falta"){$class =  'class="danger"';}if ($estado=="Inserido"){$class =  'class="active"';}if($estado=="Falta Justificada"){$class =  'class="warning"';}if($estado=="Desligado"){$class =  'class="info"';}if($estado=="Dispensado"){$class = "";}if($estado=="Profissional em Férias"){}else{
			echo '<tr '.$class.'>';
			echo '<td>'.$linha->assist_nome.'</td>';	
			echo '<td>'.$linha->estado.'</td>';
			echo '<td>'.$linha->serv_nome.'</td>';		
			echo '<td>'.date('d/m/Y',  strtotime($linha->data)).'</td>';		
			echo '<td>'.$linha->tipo.'</td>';		
			echo '</tr>';
		}
	}
	if($contar > 1){
		$total = $cont + $faltas;
		$total = ($cont * 100)/$total;
		$total = number_format($total, 0, ',', '.');
	}else{
		$total = 0;
	}


	echo '
	<div class="jumbotron" style="background: white;">
	<div class="text-center">
	<img src="img/logo.png" style="width: 150px; height: 150px;">
	<h1 style="font-family: "IBM Plex Serif", serif;">Relatório de Atendimentos '.$profNome.'</h1>
	Período: '.date('d/m/Y',  strtotime($dataFim)).' à '.date('d/m/Y',  strtotime($dataIni)).' <br><hr>
	</div>
	<h3 style="font-family: "IBM Plex Serif", serif;">Segundo o levantamento <b>'.$total.'%</b> dos atendimentos foram realizados neste período de tempo.</h3><br>
	<i style="color: red">OBS: A conta realizada para obter essa porcentagem é: (número de presenças * 100) / número de presenças + número de faltas</i><br><br>
	O total de atendimentos encontrados são <b>'.$contar.'</b>, destes são <b>'.$cont.'</b> presenças, onde <b>'.$saude.'</b> são atendimentos da saúde e <b>'.$smed.'</b> da SMED, também foram marcadas <b>'.$faltas.'</b> faltas, houveram também <b>'.$fj.'</b> faltas justificadas, deixando assim um total de <b>'.$falt = $fj + $faltas.'</b> faltas. Profissional esteve ausente em <b>'.$pfaus.'</b> vezes, e dispensou <b>'.$dis.'</b> atendidos durante este período. 
	</div> 
	</div> 
	<div class="text-center">'.date('d/m/Y - H:i:s', time()).'</div><br>
	</div>';
}else{
	echo '<h1>Nenhum dado encontrado</h1>';
}



?>

