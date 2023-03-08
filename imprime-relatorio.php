<meta charset="utf-8">
<style>
table{
	font-family: Verdana;
	width: 63%;
}
</style>
<?php 
include("conecta/conexao.php");
$cont=0;$saude=0;$smed=0;$desliga=0;$falta=0;$fj=0; 

if(!isset($_GET['mes'])){
	header("Location: registros.php"); 
	exit;
}
$mes=$_GET['mes'];

	//	nome do arquivo // 
$extensao = ".xls";	
$arquivo = $mes.$extensao;

$html = '';
$html .= '<table border="1">';
$html .= '<tr>';
$html .= '<td colspan="6"><center>Planilha de Atendimentos</center></tr>';
$html .= '</tr>';

$html .= '<tr>';
$html .= '<td></td>';
$html .= '<td><b>Nome</b></td>';
$html .= '<td><b>Profissional</b></td>';
$html .= '<td><b>Serviço</b></td>';
$html .= '<td><b>Convênio</b></td>';
$html .= '<td><b>Status</b></td>';
$html .= '<td><b>Data</b></td>';
$html .= '</tr>';


$select = "SELECT atendimentos.*, atendimentos.id as id_at, profissionais.nome as p_nome, servicos.nome as serv_nome, assistidos.nome as assist_nome
FROM (((atendimentos
INNER JOIN assistidos ON atendimentos.id_assist = assistidos.id_assist)
INNER JOIN profissionais ON atendimentos.id_prof = profissionais.id)
INNER JOIN servicos ON atendimentos.id_serv = servicos.id) WHERE date_format(data, '%m/%Y')='$mes' ORDER BY id_at DESC";
$result=$conexao->prepare($select);
$result->execute();
$contar= $result->rowCount();
if($contar>0){ $num = $contar;
	while ($linha = $result->FETCH(PDO::FETCH_OBJ)) { 
		$tipo = $linha->tipo;
		$estado = $linha->estado;
		$data=$linha->data;
		
		$html .= '<tr>';
		$html .= '<td>'.$num.'</td>';
		$num--;
		$html .= '<td>'.$linha->assist_nome.'</td>';
		$html .= '<td>'.$linha->p_nome.'</td>';
		$html .= '<td>'.$linha->serv_nome.'</td>';
		$html .= '<td>'.$linha->tipo.'</td>';
		$html .= '<td>'.$linha->estado.'</td>';
		$html .= '<td>'.date('d/m/Y',  strtotime($data)).'</td>';
		$html .= '</tr>';
		
		if($tipo=="SMED" && $estado=="Presente"){$smed++;}
		if($tipo=="Saúde" && $estado=="Presente"){$saude++;}
		if($estado=="Presente"){$cont++;}
		if($estado=="Falta"){$falta++;}
		if($estado=="Falta Justificada"){$fj++;}
		if($estado=="Desligado"){$desliga++;}

	} // FIM WHILE
} // FIM IF $CONTAR
$html .= '<tr>';
$html .= '<td>'."Total".'</td>';
$html .= '<td>'.$contar.'</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td style="background: green; color: white;">'."Presenças".'</td>';
$html .= '<td  style="background: green; color: white;">'.$cont.'</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td  style="background: blue; color: white;">'."Saúde".'</td><td  style="background: blue; color: white;">'.$saude.'</td>';
$html .= '<tr><td>'."Educação".'</td><td>'.$smed.'</td>';
$html .= '<tr>';
$html .= '<td style="background: red; color: white;">'."Desligamentos".'</td><td style="background: red; color: white;">'.$desliga.'</td>';
$html .= '<tr>';
$html .= '<td  style="background: silver; color: white;">'."Faltas".'</td><td  style="background: silver; color: white;">'.$falta.'</td><tr><td>'."Faltas Justificadas".'</td><td>'.$fj.'</td>';
$html .= '</tr>';

header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
header ("Content-Description: PHP Generated Data" );
echo $html;
exit;
?>