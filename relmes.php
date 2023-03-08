<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title>Relatório de atendimentos</title>
	<link rel="stylesheet" href="css/normalize.min.css">
	<link rel="stylesheet" href="css/paper.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

	<style>@page { size: A4 }</style>
</head>
<?php	
include("conecta/conexao.php");
// $mes = date("m");

$dataBusca = $_GET['m'];
$mesBusca = explode("/", $dataBusca);


$verificaData = strlen($dataBusca);
if ($verificaData > 7) {
	header("Location: inicio");
	die; exit;
}
if (!is_numeric($mesBusca[0]) || !is_numeric($mesBusca[1])) {
	header("Location: inicio");
	die; exit;
}
if ($mesBusca[0] < 1 OR $mesBusca[0] > 12) {
	header("Location: inicio");
	die; exit;
}



$ano = date("Y");
switch ($mesBusca[0]) {
	case '1':
	$mes = "janeiro";
	break;
	case '2':
	$mes = "fevereiro";
	break;
	case '3':
	$mes = "março";
	break;
	case '4':
	$mes = "abril";
	break;
	case '5':
	$mes = "maio";
	break;
	case '6':
	$mes = "junho";
	break;
	case '7':
	$mes = "julho";
	break;
	case '8':
	$mes = "agosto";
	break;
	case '9':
	$mes = "setembro";
	break;
	case '10':
	$mes = "outubro";
	break;
	case '11':
	$mes = "novembro";
	break;
	case '12':
	$mes = "dezembro";
	break;
	default:
		# code...
	break;
}



$total = null;
$presenca = null;
$smed = null; $saude=null; $cluz=null;$assistencia=null;
$falta = null; $fj = null;
$desligado = 0; $inserido = 0;
$dispensado = 0; $paus = 0;
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$select = "SELECT atendimentos.*, atendimentos.id as id_at, profissionais.nome as p_nome, servicos.nome as serv_nome, assistidos.nome as assist_nome
FROM (((atendimentos
INNER JOIN assistidos ON atendimentos.id_assist = assistidos.id_assist)
INNER JOIN profissionais ON atendimentos.id_prof = profissionais.id)
INNER JOIN servicos ON atendimentos.id_serv = servicos.id) WHERE date_format(data, '%m/%Y')=:dataBusca ORDER BY id_at DESC";
$result=$conexao->prepare($select);
$result->bindParam(':dataBusca', $dataBusca, PDO::PARAM_STR);
$result->execute();
$contar= $result->rowCount();
if($contar>0){ 
	while ($linha = $result->FETCH(PDO::FETCH_OBJ)) { 
		$linha->estado == "Presente" ? $presenca++ : null;
		$linha->estado == "Presente" AND $linha->tipo == "SMED" ? $smed++ : null;
		$linha->estado == "Presente" AND $linha->tipo == "Saúde" ? $saude++ : null;
		$linha->estado == "Presente" AND $linha->tipo == "CLuz" ? $cluz++ : null;
		$linha->estado == "Presente" AND $linha->tipo == "Assistencia" ? $assistencia++ : null;
		$linha->estado == "Falta" ? $falta++ : null;
		$linha->estado == "Falta Justificada" ? $fj++ : null;
		$linha->estado == "Desligado" ? $desligado++ : null;
		$linha->estado == "Inserido" ? $inserido++ : null;
		$linha->estado == "Dispensado" ? $dispensado++ : null;
		$linha->estado == "Profissional Ausente" ? $paus++ : null;
		$total++;

	}
}

?>
<body class="A4" style="background-color: #e0e0e0; font-family: Roboto;">
	<section class="sheet padding-10mm" >
		<article >
			<div class="row">
				<div class="col-xs-3 text-center"><br>
					<img src="img/logo.png" alt="" style="width: 100px; ">
				</div>
				<div class="col-xs-8 text-center" style="">
					<h3 style="font-family: Roboto;">UNIÃO ESPÍRITA BAGEENSE<br>CAMINHO DA LUZ</h3>
					<p style="font-size: 12px">
						Fundada em 27-12-59<br>
						Mantenedora da Escola Especial, Clínica e Oficinas<br>
						Av. General Osório, 2478 - Bagé/RS - CEP 96400-101 <br> 
						Fone (53)32403500 - E-mail: uebageense@brturbo.com.br
					</p>
				</div>
			</div>
			<hr>
		</article>
		<article  style="text-align: justify; padding: 20px;">
			<br>
			<p>
				O presente documento tem o objetivo de apresentar os dados referentes aos atendimentos do mês de <?php echo $mes.'/'.$mesBusca[1]; ?> da Clínica de Diagnóstico, Tratamento e Reabilitação da União Espírita Bageense, Caminho da Luz.				
			</p>
			<br>
			<p>No mês de <?php echo $mes.', tivemos <strong>'.$presenca; ?> atendimentos</strong> realizados, destes, <strong><?php echo $smed; ?> atendimentos</strong> foram realizados pelo convênio SMED, <strong><?php echo $saude; ?> atendimentos</strong> pelo convênio da Saúde, <strong><?php echo $cluz; ?> atendimentos</strong> pelo convênio do Caminho da Luz e <strong><?php echo $assistencia; ?>  atendimentos</strong> pelo convênio da assistência.</p>
			<br>
			<p>Foram registradas <strong><?php echo $falta+$fj; ?> faltas</strong>, sendo <strong><?php echo $fj; ?> faltas justificadas</strong>.</p>
			<br>
			<p>Tivemos <strong><?php echo $desligado; ?> desligamento(s)</strong>, e <strong><?php echo $inserido; ?> novo(s) inserido(s)</strong> para atendimentos.</p>
			<br>
			<p>Foram <strong><?php echo $dispensado; ?> atendimento(s)</strong> dispensados, e <strong><?php echo $paus; ?> atendimento(s)</strong> onde o(a) profissional estava ausente.</p>

			
		</article>
	</section>
</body>
</html>