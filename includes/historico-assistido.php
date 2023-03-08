<meta charset="utf-8">
<?php 
include("../conecta/conexao.php");
	
	//	nome do arquivo // 
	if(isset($_GET['nome'])){
		$nome=$_GET['nome'];
		$id=$_GET['id'];
	}
	$extensao = ".xls";
	$nomeaqv = $nome.'-historico';
	$arquivo =  $nomeaqv.$extensao;
	
	$ver = 0;
	$num=1;
	$html = '';		
	$html .= '<table border="1"> ';	
	$html .= '<thead style="background: white;"> ';	
	$html .= ' <tr > ';	
	$html .= '<th> </th> ';	
	$html .= '<th>Assistido</th> ';	
	$html .= '<th>Profissional</th> ';	
	$html .= '<th>Atendimento</th> ';	
	$html .= '<th>Estado</th> ';	
	$html .= '<th>Data</th> ';	
	$html .= '</tr> ';	
	$html .= '</thead> ';	
	$html .= '<tbody> ';	
	
	
	$select = "SELECT atendimentos.*, atendimentos.id as id_at, profissionais.nome as p_nome, servicos.nome as serv_nome, assistidos.nome as assist_nome
		FROM (((atendimentos
			INNER JOIN assistidos ON atendimentos.id_assist = assistidos.id_assist)
			INNER JOIN profissionais ON atendimentos.id_prof = profissionais.id)
			INNER JOIN servicos ON atendimentos.id_serv = servicos.id) WHERE atendimentos.id_assist=:id";
				$result=$conexao->prepare($select);
				$result->bindParam(':id', $id, PDO::PARAM_INT);
				$result->execute();
				$contar= $result->rowCount();
				if($contar>0){ $num=$contar;
			while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {	
			$estado = $linha->estado;
			$data=$linha->data;
			if( $estado=="Presente" ){ $nomeclass = 'class="success"';}if ($estado=="Falta"){$nomeclass = 'class="danger"';}if ($estado=="Inserido"){$nomeclass = 'class="active"';}if($estado=="Falta Justificada"){$nomeclass = 'class="warning"';}if($estado=="Desligado"){$nomeclass = 'class="info"';}
		$html .= '<tr>';
		$html .= '<td>'.$num.'</td>';
		$html .= '<td>'.$linha->assist_nome.'</td>';
		$html .= '<td>';
		$html .= ''.$linha->p_nome.'';
		$html .= '</td>';
		$html .= '<td>';
		$html .= ''.$linha->serv_nome.'';
		$html .= '</td>';
		$html .= '<td>';
		$html .= ''.$estado.'';
		$html .= '</td>';	
		$html .= '<td>'.date('d/m/Y',  strtotime($data)).'</td>';
		$html .= '</tr>';
		$col=1;
		$num--;
		}
	}	
	    $html .= '</tbody>';
		$html .= '</table>';
			
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