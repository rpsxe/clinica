<meta charset="utf-8">
<style>
table{
	font-family: Verdana;
}

</style>
<?php 
include("../conecta/conexao.php");
	
	//	nome do arquivo // 
	$extensao = ".xls";
	$nomeaqv = 'assistidos_'.date("m/Y");
	$arquivo =  $nomeaqv.$extensao;
	
	$ver = 0;
	$num=1;
	$html = '';
	$html .= '<table border="1">';
	$html .= '<tr>';
	$html .= '<th></th><th>Nome</th><th>Atendimento</th>';
	
	
		$select = "SELECT agenda.*, profissionais.nome as p_nome, servicos.nome as serv_nome, assistidos.nome as assist_nome
		FROM (((agenda
			INNER JOIN assistidos ON agenda.id_assist = assistidos.id_assist)
			INNER JOIN profissionais ON agenda.id_prof = profissionais.id)
			INNER JOIN servicos ON agenda.id_serv = servicos.id) WHERE ativo='S' ORDER BY assist_nome ASC";
			try{	
				$result=$conexao->prepare($select);
				$result->execute();
				$contar= $result->rowCount();
				if($contar>0){		
			while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {	
			$idAluno =  $linha->id_assist;
			if($ver == $idAluno){
		$html .= '<tr>';	
		$html .= '<td>';
		$html .= '</td>';
		$html .= '<td>';
		$html .= ''.$linha->assist_nome.'';
		$html .= '</td>';
		$html .= '<td>';
		$html .= ''.$linha->serv_nome.'';
		$html .= '</td>';
		$html .= '<td>';
		$html .= ''.$linha->tipo.'';
		$html .= '</td>';		
		$html .= '</tr>';
		$col=1;
		$ver = $idAluno;	

			}else{
		$html .= '<tr>';	
			$html .= '<td>';
		$html .= ''.$num.'';
		$num++;
		$html .= '</td>';	
		$html .= '<td>';
		$html .= ''.$linha->assist_nome.'';
		$html .= '</td>';	
		$html .= '<td>';
		$html .= ''.$linha->serv_nome.'';
		$html .= '</td>';
		$html .= '<td>';
		$html .= ''.$linha->tipo.'';
		$html .= '</td>';
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