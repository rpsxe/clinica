<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title>Ficha de Atendimento</title>
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
$mes = date("m");
switch ($mes) {
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

$data = date("d").' de '.$mes.' de '.date("Y");
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
?>
<body class="A4" style="background-color: #e0e0e0; font-family: Roboto;">
	<section class="sheet padding-10mm" >
		<article >
			<div class="row">
				<div class="col-xs-3 text-center"><br>
					<img src="img/logo.png" alt="" style="width: 80px; ">
				</div>
				<div class="col-xs-8 text-center">
					<h4 style="font-family: Roboto;">UNIÃO ESPÍRITA BAGEENSE<br>CAMINHO DA LUZ</h4>
					<p style="font-size: 12px">
						Fundada em 27-12-59<br>
						Mantenedora da Escola Especial, Clínica e Oficinas<br>
						Av. General Osório, 2478 - Bagé/RS - CEP 96400-101 <br> 
						Fone (53)32403500 - E-mail: uebageense@gmail.com
					</p>
				</div>
			</div>
			<hr>
		</article>
		<article>
					<?php include("header/pegainfos.php"); ?>
			<div class="row">
				<div class="col-xs-12">
					<h4 class="text-center"  style="font-family: Roboto;"><b>FICHA DE ATENDIMENTO</b></h4>
					<table class="table table-bordered" >
						<tr><td><strong>Nome:</strong> <?php echo $nome; ?></td><td><strong>Município:</strong> <?php echo $cidade; ?></td></tr>
						<tr><td><strong>Data de Nascimento:</strong> <?php echo date('d/m/Y',  strtotime($datanasc)); ?></td><td><strong>Idade:</strong> <?php echo date('Y') - date('Y',  strtotime($datanasc)); ?></td></tr>
						<tr><td><strong>Endereço:</strong> <?php echo $rua.', '.$numero; ?></td><td><strong>Bairro:</strong> <?php echo $bairro; ?></td></tr>
					</table>
					<div style="border: 1px solid #ddd; width: 100%; height: 30px; margin-top: -20px"></div>
					<div style="border: 1px solid #ddd; width: 100%; height: 30px; margin-top: 0px"></div>
<br>
<br>
	<div style="margin: 0 auto; width: 50%; height: 1px; background: black; border-bottom: 1px solid black"></div>
	<p style="text-align: center">
		Assinatura do Responsável
	</p><br>
	<p style="text-align: right;">
		Bagé,  ____/____/________
	</p>
</div>
</div>
</article>
<br><br>
<article >
			<div class="row">
				<div class="col-xs-3 text-center"><br>
					<img src="img/logo.png" alt="" style="width: 80px; ">
				</div>
				<div class="col-xs-8 text-center">
					<h4 style="font-family: Roboto;">UNIÃO ESPÍRITA BAGEENSE<br>CAMINHO DA LUZ</h4>
					<p style="font-size: 12px">
						Fundada em 27-12-59<br>
						Mantenedora da Escola Especial, Clínica e Oficinas<br>
						Av. General Osório, 2478 - Bagé/RS - CEP 96400-101 <br> 
						Fone (53)32403500 - E-mail: uebageense@gmail.com
					</p>
				</div>
			</div>
			<hr>
		</article>
		<article>
					<?php include("header/pegainfos.php"); ?>
			<div class="row">
				<div class="col-xs-12">
					<h4 class="text-center"  style="font-family: Roboto;"><b>FICHA DE ATENDIMENTO</b></h4>
					<table class="table table-bordered" >
						<tr><td><strong>Nome:</strong> <?php echo $nome; ?></td><td><strong>Município:</strong> <?php echo $cidade; ?></td></tr>
						<tr><td><strong>Data de Nascimento:</strong> <?php echo date('d/m/Y',  strtotime($datanasc)); ?></td><td><strong>Idade:</strong> <?php echo date('Y') - date('Y',  strtotime($datanasc)); ?></td></tr>
						<tr><td><strong>Endereço:</strong> <?php echo $rua.', '.$numero; ?></td><td><strong>Bairro:</strong> <?php echo $bairro; ?></td></tr>
					</table>
					<div style="border: 1px solid #ddd; width: 100%; height: 30px; margin-top: -20px"></div>
					<div style="border: 1px solid #ddd; width: 100%; height: 30px; margin-top: 0px"></div>
<br>
<br>
	<div style="margin: 0 auto; width: 50%; height: 1px; background: black; border-bottom: 1px solid black"></div>
	<p style="text-align: center">
		Assinatura do Responsável
	</p>
	<p style="text-align: right;">
		Bagé,  ____/____/________
	</p>
</div>
</div>
</article>
</section>
</body>
</html>