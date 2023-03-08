<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title>Ficha de Atendimento</title>
	<link rel="stylesheet" href="css/normalize.min.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

	<style>@page { size: A4 landscape }</style>
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
$numCont = 0;
$data = date("d").' de '.$mes.' de '.date("Y");
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
?>
<body class="A4 landscape" style="background-color: #e0e0e0; font-family: Roboto;">
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
						<tr><td><strong>Nome:</strong> <?php echo $nome; ?></td><td><strong>Município:</strong> <?php echo $cidade; ?></td><td><strong>Data de Nascimento:</strong> <?php echo date('d/m/Y',  strtotime($datanasc)); ?></td></tr>
						<tr><td><strong>Idade:</strong> <?php 
						$idade = date('Y') - date('Y',  strtotime($datanasc)); 

						if ($idade <= 1) {
							echo '1 ano';
						}
						if ($idade > 1) {
							echo $idade . ' anos';
						}
					?></td><td><strong>Endereço:</strong> <?php echo $rua.', '.$numero; ?></td><td><strong>Bairro:</strong> <?php echo $bairro; ?></td></tr>
				</table>
				<table class="table  table-bordered" border='1'>
					<thead>
						<th>Especialidade</th>	
						<th><p  style="margin-bottom: -10px">___/___/___ à ___/___/___</p></th>
						<th><p  style="margin-bottom: -10px">___/___/___ à ___/___/___</p></th>
						<th><p  style="margin-bottom: -10px">___/___/___ à ___/___/___</p></th>
						<th><p  style="margin-bottom: -10px">___/___/___ à ___/___/___</p></th>

					</thead>
					<?php

					$select = "SELECT agenda.*, profissionais.nome as p_nome, servicos.nome as serv_nome, assistidos.nome as assist_nome
					FROM (((agenda
					INNER JOIN assistidos ON agenda.id_assist = assistidos.id_assist)
					INNER JOIN profissionais ON agenda.id_prof = profissionais.id)
					INNER JOIN servicos ON agenda.id_serv = servicos.id) WHERE agenda.id_assist=:id AND ativo='S' ORDER BY dia, horario ASC";
					$result=$conexao->prepare($select);
					$result->bindParam(':id', $id, PDO::PARAM_INT);
					$result->execute();
					$contar= $result->rowCount();
					if($contar>0){	
						echo '<tr><td style="width: 30%; text-align: left;">Recepção</td><td></td><td></td><td></td><td></td>';
						echo '<tr><td style="width: 30%;  text-align: left;">Assistente Social</td><td></td><td></td><td></td><td></td>';
						while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {	
							if ($numCont == 5) {
								echo '</table></article></section>';
								echo '<section class="sheet padding-10mm">
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
								<article>';
								echo '<table class="table  table-bordered" border="1">
					<thead>
						<th>Especialidade</th>	
						<th><p  style="margin-bottom: -10px">___/___/___ à ___/___/___</p></th>
						<th><p  style="margin-bottom: -10px">___/___/___ à ___/___/___</p></th>
						<th><p  style="margin-bottom: -10px">___/___/___ à ___/___/___</p></th>
						<th><p  style="margin-bottom: -10px">___/___/___ à ___/___/___</p></th>
						
					</thead>';
							}
							$dia = $linha->dia;
							echo '	<tr>								
							<td  style="width: 30%;  text-align: left;">'.$linha->serv_nome.'</td>
							<td   height:50px; text-align: left;"></td><td></td><td></td><td></td>
							</tr>
							';
							$numCont++;
						}

					}
					?>

				</table><br>
				<p style="text-align: right">Total de atendimentos mês: ________</p>
				<br>

				<div style="margin: 0 auto; width: 50%; height: 1px; background: black; border-bottom: 1px solid black"></div>
				<p style="text-align: center">
					Assinatura do Responsável

				</p>

			</div>
		</div>
	</article>
</section>
</body>
</html>