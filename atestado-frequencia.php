<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title>Atestado de Frequência</title>
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
					<img src="img/logo.png" alt="" style="width: 100px; ">
				</div>
				<div class="col-xs-8 text-center">
					<h3 style="font-family: Roboto;">UNIÃO ESPÍRITA BAGEENSE<br>CAMINHO DA LUZ</h3>
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
			<div class="row">
				<div class="col-xs-3" style="border-right: 1px solid #eee; font-size: 12px; padding: 20px; ">
					<h4 class="text-center" style=" font-family: Roboto;"><strong>REGISTROS</strong></h4><br>
					<p style="font-size: 12px; text-align: justify;">CNPJ 87415550/0001-50 <br><br>
						P. Jurídica Reg. 185
						De 23/11/60<br><br>
						Util. Púb. Est. Dec. Nº
						23.011 de 19/02/74<br><br>
						Util. Púb. Municipal
						Lei Municipal nº 1490
						De 04/01/68
						SEC – 007066 DE 14/07/75<br><br>
						CNAS – Certif. de
						Filantropia
						PROC. 267.916/72<br><br>
						Util. Púb. Federal
						Dec. 88.488 de 07/07/83<br><br>
						Isenção I.R. Dec. Nº 76.186
						De 02/09/75<br><br>
						Alvará de Func. Nº 1.708
						Pref. Municipal de Bagé<br><br>
						Secretaria de Saúde
						Alvará de Licença
						Sanitária
						Da SMS<br><br>
						Registro do Cons. Reg.
						Fisioterapia Sob nº 522 –
						RS,<br><br>
						Em 14/09/98
						CREMERS
						Inscrição nº 0054 de
						08/02/83		
					</p>		
				</div>
				<div class="col-xs-9 text-center" style="padding: 40px">
					<?php include("header/pegainfos.php"); ?>
					<h3 class="text-center"  style="font-family: Roboto;">Atestado de Frequência</h3>
					<br>
					<p style="text-align: justify;">
						Atesto para os devidos fins que <b><?php echo $nome; ?></b> encontra-se em atendimento nesta Instituição, nos seguintes dias e horários: 	
					</p>
					<table class="table">
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
							while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {	$dia = $linha->dia;
								echo '	<tr>
								<td style="width: 33%">'.$linha->horario.'</td>
								<td  style="width: 33%">'.$linha->serv_nome.'</td>
								<td  style="width: 33%">';
								if($dia==1){echo 'Segunda';
							}elseif($dia==2){echo 'Terça';
						}elseif($dia==3){echo 'Quarta';
					}elseif($dia==4){echo 'Quinta';
				}elseif($dia==5){echo 'Sexta';}
				echo  '</td>
				</tr>
				';
			}
		}
		?>

	</table>
	<br><br>
	<p style="text-align: right">
		Bagé, <?php echo $data; ?>
	</p><br><br><br>
	<br><br>
	<div style="margin: 0 auto; width: 50%; height: 1px; background: black; border-bottom: 1px solid black"></div>
	<p style="text-align: center">
		Coordenação Clínica

	</p>
</div>
</div>
</article>
</section>
</body>
</html>