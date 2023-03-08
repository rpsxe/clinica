<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title>Relatório Lista de Espera</title>
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
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set("America/Fortaleza");

$smed = 0; $saude = 0; $cluz = 0; $assist = 0; $centro = 0;
$equo = 0; $fisio = 0; $fono = 0; $hidro = 0; $mus = 0; $nat = 0; $pmotricidade = 0; $pdagogia = 0; $pterapia = 0; $to = 0; $neuro=0;
$equoSMED = 0; $equoSaude = 0; $equoCluz = 0; $equoAssist = 0; $equoCentro = 0;
$fisioSMED = 0; $fisioSaude = 0; $fisioCluz = 0; $fisioAssist = 0; $fisioCentro = 0;
$fonoSMED = 0; $fonoSaude = 0; $fonoCluz = 0; $fonoAssist = 0; $fonoCentro = 0;
$hidroSMED = 0; $hidroSaude = 0; $hidroCluz = 0; $hidroAssist = 0; $hidroCentro = 0;
$musSMED = 0; $musSaude = 0; $musCluz = 0; $musAssist = 0; $musCentro = 0;
$natSMED = 0; $natSaude = 0; $natCluz = 0; $natAssist = 0; $natCentro = 0;
$pmotricidadeSMED = 0; $pmotricidadeSaude = 0; $pmotricidadeCluz = 0; $pmotricidadeAssist = 0; $pmotricidadeCentro = 0;
$pdagogiaSMED = 0; $pdagogiaSaude = 0; $pdagogiaCluz = 0; $pdagogiaAssist = 0; $pdagogiaCentro = 0;
$pterapiaSMED = 0; $pterapiaSaude = 0; $pterapiaCluz = 0; $pterapiaAssist = 0; $pterapiaCentro = 0;
$toSMED = 0; $toSaude = 0; $toCluz = 0; $toAssist = 0; $toCentro = 0;
$neuroSMED = 0; $neuroSaude = 0; $neuroCluz = 0; $neuroAssist = 0; $neuroCentro = 0;
$select = "SELECT list_espera.*, servicos.nome as serv_nome, assistidos.nome as assist_nome, assistidos.id_assist as id_assist, servicos.id as id_serv
FROM ((list_espera
INNER JOIN assistidos ON list_espera.id_assist = assistidos.id_assist)
INNER JOIN servicos ON list_espera.id_serv = servicos.id) WHERE mostrar = 'S' ORDER BY data, id ASC";
$result=$conexao->prepare($select);
$result->execute();
$contar= $result->rowCount();
if($contar>0){
	while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
		switch ($linha->tipo) {
			case 'SMED':
			$smed++;
			break;
			case 'Saúde':
			$saude++;
			break;
			case 'CLuz':
			$cluz++;
			break;
			case 'Assistencia':
			$assist++;
			break;
			case 'Centro':
			$centro++;
			break;
			
			default:
				# code...
			break;
		}

		switch ($linha->serv_nome) {
			case 'Equoterapia':
			switch ($linha->tipo) {
				case 'SMED':
				$equoSMED++;
				break;
				case 'Saúde':
				$equoSaude++;
				break;
				case 'CLuz':
				$equoCluz++;
				break;
				case 'Assistencia':
				$equoAssist++;
				break;
				case 'Centro':
				$equoCentro++;
				break;

				default:
				# code...
				break;
			}
			$equo++;
			break;
			case 'Fisioterapia':
			switch ($linha->tipo) {
				case 'SMED':
				$fisioSMED++;
				break;
				case 'Saúde':
				$fisioSaude++;
				break;
				case 'CLuz':
				$fisioCluz++;
				break;
				case 'Assistencia':
				$fisioAssist++;
				break;
				case 'Centro':
				$fisioCentro++;
				break;

				default:
				# code...
				break;
			}
			$fisio++;
			break;
			case 'Fonoterapia':
			switch ($linha->tipo) {
				case 'SMED':
				$fonoSMED++;
				break;
				case 'Saúde':
				$fonoSaude++;
				break;
				case 'CLuz':
				$fonoCluz++;
				break;
				case 'Assistencia':
				$fonoAssist++;
				break;
				case 'Centro':
				$fonoCentro++;
				break;

				default:
				# code...
				break;
			}
			$fono++;
			break;
			case 'Hidrocinesioterapia':
			switch ($linha->tipo) {
				case 'SMED':
				$hidroSMED++;
				break;
				case 'Saúde':
				$hidroSaude++;
				break;
				case 'CLuz':
				$hidroCluz++;
				break;
				case 'Assistencia':
				$hidroAssist++;
				break;
				case 'Centro':
				$hidroCentro++;
				break;

				default:
				# code...
				break;
			}
			$hidro++;
			break;
			case 'Musicalização':
			switch ($linha->tipo) {
				case 'SMED':
				$musSMED++;
				break;
				case 'Saúde':
				$musSaude++;
				break;
				case 'CLuz':
				$musCluz++;
				break;
				case 'Assistencia':
				$musAssist++;
				break;
				case 'Centro':
				$musCentro++;
				break;

				default:
				# code...
				break;
			}
			$mus++;
			break;
			case 'Natação':
			switch ($linha->tipo) {
				case 'SMED':
				$natSMED++;
				break;
				case 'Saúde':
				$natSaude++;
				break;
				case 'CLuz':
				$natCluz++;
				break;
				case 'Assistencia':
				$natAssist++;
				break;
				case 'Centro':
				$natCentro++;
				break;

				default:
				# code...
				break;
			}
			$nat++;
			break;
			case 'Psicomotricidade':
			switch ($linha->tipo) {
				case 'SMED':
				$pmotricidadeSMED++;
				break;
				case 'Saúde':
				$pmotricidadeSaude++;
				break;
				case 'CLuz':
				$pmotricidadeCluz++;
				break;
				case 'Assistencia':
				$pmotricidadeAssist++;
				break;
				case 'Centro':
				$pmotricidadeCentro++;
				break;

				default:
				# code...
				break;
			}
			$pmotricidade++;
			break;
			case 'Psicopedagogia':
			switch ($linha->tipo) {
				case 'SMED':
				$pdagogiaSMED++;
				break;
				case 'Saúde':
				$pdagogiaSaude++;
				break;
				case 'CLuz':
				$pdagogiaCluz++;
				break;
				case 'Assistencia':
				$pdagogiaAssist++;
				break;
				case 'Centro':
				$pdagogiaCentro++;
				break;

				default:
				# code...
				break;
			}
			$pdagogia++;
			break;
			case 'Psicoterapia':
			switch ($linha->tipo) {
				case 'SMED':
				$pterapiaSMED++;
				break;
				case 'Saúde':
				$pterapiaSaude++;
				break;
				case 'CLuz':
				$pterapiaCluz++;
				break;
				case 'Assistencia':
				$pterapiaAssist++;
				break;
				case 'Centro':
				$pterapiaCentro++;
				break;

				default:
				# code...
				break;
			}
			$pterapia++;
			break;
			case 'Terapia Ocupacional':
			switch ($linha->tipo) {
				case 'SMED':
				$toSMED++;
				break;
				case 'Saúde':
				$toSaude++;
				break;
				case 'CLuz':
				$toCluz++;
				break;
				case 'Assistencia':
				$toAssist++;
				break;
				case 'Centro':
				$toCentro++;
				break;

				default:
				# code...
				break;
			}
			$to++;
			break;
			case 'Neuropediatria':
			switch ($linha->tipo) {
				case 'SMED':
				$neuroSMED++;
				break;
				case 'Saúde':
				$neuroSaude++;
				break;
				case 'CLuz':
				$neuroCluz++;
				break;
				case 'Assistencia':
				$neuroAssist++;
				break;
				case 'Centro':
				$neuroCentro++;
				break;

				default:
				# code...
				break;
			}
			$neuro++;
			break;
			
			default:
				# code...
			break;
		}

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
				O presente documento tem o objetivo de apresentar os dados referentes a lista de espera por atendimentos da Clínica de Diagnóstico, Tratamento e Reabilitação da União Espírita Bageense, Caminho da Luz.				

				<br>
				<br>

				Atualmente temos <strong><?php echo $contar; ?></strong> solicitações de atendimentos, dentre as inumeras especialidades de atendimentos. 
				<br>
				<br>
				São <strong><?php echo $smed; ?></strong> solicitações via convênio SMED, <strong><?php echo $saude; ?></strong> solicitações via convênio Saúde, <strong><?php echo $cluz; ?></strong> via convênio Caminho da Luz, <strong><?php echo $assist; ?></strong> via convênio da Assistência e <strong><?php echo $centro; ?></strong> via convênio do Centro de Referência.
			</p>
			<br><br>
			<table class="table table-striped" style="width: 100%">
				<thead>
					<th>Serviço</th><th>Solicitações</th><th>SMED</th><th>Saúde</th><th>Caminho da Luz</th><th>Assistência</th><th>Centro</th>
				</thead>
				<tbody>
					<tr>
						<td>Equoterapia</td>
						<td><?php echo $equo; ?></td>
						<td><?php echo $equoSMED; ?></td>
						<td><?php echo $equoSaude; ?></td>
						<td><?php echo $equoCluz; ?></td>
						<td><?php echo $equoAssist; ?></td>
						<td><?php echo $equoCentro; ?></td>
					</tr>
					<tr>
						<td>Fisioterapia</td>
						<td><?php echo $fisio; ?></td>
						<td><?php echo $fisioSMED; ?></td>
						<td><?php echo $fisioSaude; ?></td>
						<td><?php echo $fisioCluz; ?></td>
						<td><?php echo $fisioAssist; ?></td>
						<td><?php echo $fisioCentro; ?></td>
					</tr>
					<tr>
						<td>Fonoterapia</td>
						<td><?php echo $fono; ?></td>
						<td><?php echo $fonoSMED; ?></td>
						<td><?php echo $fonoSaude; ?></td>
						<td><?php echo $fonoCluz; ?></td>
						<td><?php echo $fonoAssist; ?></td>
						<td><?php echo $fonoCentro; ?></td>
					</tr>
					<tr>
						<td>Hidrocinesioterapia</td>
						<td><?php echo $hidro; ?></td>
						<td><?php echo $hidroSMED; ?></td>
						<td><?php echo $hidroSaude; ?></td>
						<td><?php echo $hidroCluz; ?></td>
						<td><?php echo $hidroAssist; ?></td>
						<td><?php echo $hidroCentro; ?></td>
					</tr>
					<tr>
						<td>Musicalização</td>
						<td><?php echo $mus; ?></td>
						<td><?php echo $musSMED; ?></td>
						<td><?php echo $musSaude; ?></td>
						<td><?php echo $musCluz; ?></td>
						<td><?php echo $musAssist; ?></td>
						<td><?php echo $musCentro; ?></td>
					</tr>
					<tr>
						<td>Natação</td>
						<td><?php echo $nat; ?></td>
						<td><?php echo $natSMED; ?></td>
						<td><?php echo $natSaude; ?></td>
						<td><?php echo $natCluz; ?></td>
						<td><?php echo $natAssist; ?></td>
						<td><?php echo $natCentro; ?></td>
					</tr>
					<tr>
						<td>Psicomotricidade</td>
						<td><?php echo $pmotricidade; ?></td>
						<td><?php echo $pmotricidadeSMED; ?></td>
						<td><?php echo $pmotricidadeSaude; ?></td>
						<td><?php echo $pmotricidadeCluz; ?></td>
						<td><?php echo $pmotricidadeAssist; ?></td>
						<td><?php echo $pmotricidadeCentro; ?></td>
					</tr>
					<tr>
						<td>Psicopedagogia</td>
						<td><?php echo $pdagogia; ?></td>
						<td><?php echo $pdagogiaSMED; ?></td>
						<td><?php echo $pdagogiaSaude; ?></td>
						<td><?php echo $pdagogiaCluz; ?></td>
						<td><?php echo $pdagogiaAssist; ?></td>
						<td><?php echo $pdagogiaCentro; ?></td>
					</tr>
					<tr>
						<td>Psicoterapia</td>
						<td><?php echo $pterapia; ?></td>
						<td><?php echo $pterapiaSMED; ?></td>
						<td><?php echo $pterapiaSaude; ?></td>
						<td><?php echo $pterapiaCluz; ?></td>
						<td><?php echo $pterapiaAssist; ?></td>
						<td><?php echo $pterapiaCentro; ?></td>
					</tr>
					<tr>
						<td>Terapia Ocupacional</td>
						<td><?php echo $to; ?></td>
						<td><?php echo $toSMED; ?></td>
						<td><?php echo $toSaude; ?></td>
						<td><?php echo $toCluz; ?></td>
						<td><?php echo $toAssist; ?></td>
						<td><?php echo $toCentro; ?></td>
					</tr>
					<tr>
						<td>Neuropediatria</td>
						<td><?php echo $neuro; ?></td>
						<td><?php echo $neuroSMED; ?></td>
						<td><?php echo $neuroSaude; ?></td>
						<td><?php echo $neuroCluz; ?></td>
						<td><?php echo $neuroAssist; ?></td>
						<td><?php echo $neuroCentro; ?></td>
					</tr>
				</tbody>
			</table>
			<br><br>
			<br><br>
			<p class="text-center">Gerado automaticamente - <?php echo date("d/m/Y").' às '.date("H:i"); ?></p>
		</article>
	</section>
</body>
</html>