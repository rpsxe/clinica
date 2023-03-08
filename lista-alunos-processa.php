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


if(isset($_POST['envia'])){
	$mes=$_POST['mes'];
	$prof=$_POST['profissionais'];
	$servico=$_POST['servicos'];
	$conv=$_POST['conv'];
	$meuArray = array();
	include("lista-alunos-dias.php");

	
	//	nome do arquivo // 
	$extensao = ".xls";
	$arquivo =  $prof.$extensao;

	
	$html = '';
	$html .= '<center><h3>UNIÃO ESPIRITA BAGEENSE</h3>';
	$html .= 'Fundada em 27/12/1959- CNPJ: 87415550/0001-50<br>
	Mantenedora da Escola de Educação Especial “Caminho da Luz”<br>
	e da Clínica de Diagnóstico, Tratamento e Reabilitação.<br>
	Av. General Osório, 2478 – Bagé-RS – CEP 96400101<br>
	';
	$html .= '<p>'.$profNome.' - '.$nomemes.'/2018'.'<br>'.$servNome.' / '.$conv.'</center>';
	$html .= '<table border="1">';
	$html .= '<tr>';
	$html .= '<th></th><th  style="width: 10%;">Nome</th>';

	for($i = 0; $i < count($meuArray);$i++){
		$html .= '<th><font size="1">'.($meuArray[$i]).'</font></th>';
	} 
}
$html .='<th>Responsável</th>';
$html .= '</tr>';


$ver = 0;
$i=$i+1;$col=1;$num=1;
$select = "SELECT agenda.*, profissionais.nome as p_nome, servicos.nome as serv_nome, assistidos.nome as assist_nome
FROM (((agenda
INNER JOIN assistidos ON agenda.id_assist = assistidos.id_assist)
INNER JOIN profissionais ON agenda.id_prof = profissionais.id)
INNER JOIN servicos ON agenda.id_serv = servicos.id) WHERE agenda.id_prof=:prof AND tipo=:conv AND agenda.id_serv=:servico AND ativo='S' ORDER BY assist_nome ASC";
try{
	$result=$conexao->prepare($select);
	$result->bindParam(':prof', $prof, PDO::PARAM_INT);
	$result->bindParam(':servico', $servico, PDO::PARAM_INT);
	$result->bindParam(':conv', $conv, PDO::PARAM_INT);
	$result->execute();
	$contar= $result->rowCount();
	if($contar>0){
		while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
			$idAluno =  $linha->id_assist;
			if($ver == $idAluno){}else{
				if ($num=="23"){
					$html .= '<tr></tr>';
					$html .= '<tr></tr>';
				}
				$html .= '<tr>';
				$html .= '<td style="width: 2%">';
				$html .= ''.$num.'';
				$num++;
				$html .= '</td>';
				$html .= '<td style="text-align: left;">'.$linha->assist_nome.'</td>';;
				while($col <= $i){
					$html .= '<td></td>';
					$col++;
				}
				$html .= '</tr>';
				$col=1;
				$ver = $idAluno;
			}
		}
	}
}catch(PDOException $e){
	echo $e;
}

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