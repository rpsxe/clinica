<?php

$saude=0;$smed=0;$cl=0;$ast=0;$desligado=0;$ins=0;
$rCont=0;$desliga=0;$rFalta=0;$rFj=0; 
$rIns=0; $rDis=0; $rAlta=0; $pfaus=0;

$select = "SELECT * FROM profissionais WHERE id='$profissionais'";
$result=$conexao->prepare($select);
$result->execute();
$numAgenda= $result->rowCount();
if($numAgenda>0){		
	while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
		$profNome=$linha->nome;
	}
}

$select = "SELECT agenda.*, profissionais.nome as p_nome, servicos.nome as serv_nome, assistidos.nome as assist_nome
FROM (((agenda
INNER JOIN assistidos ON agenda.id_assist = assistidos.id_assist)
INNER JOIN profissionais ON agenda.id_prof = profissionais.id)
INNER JOIN servicos ON agenda.id_serv = servicos.id) WHERE id_prof='$profissionais' AND ativo='S' ORDER BY dia ASC, horario ASC ";
$result=$conexao->prepare($select);
$result->bindParam(':dia', $dia, PDO::PARAM_INT);
$result->execute();
$numAgenda= $result->rowCount();
if($numAgenda>0){		
	while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
		if($linha->tipo=="Saúde"){$saude++;}
		if($linha->tipo=="SMED"){$smed++;}
		if($linha->tipo=="CLuz"){$cl++;}
		if($linha->tipo=="Assistencia"){$ast++;}

	}
}


/**//**//**/

$atd=0;
$select = "SELECT * FROM atendimentos WHERE id_prof='$profissionais' ";
$result=$conexao->prepare($select);
$result->execute();
$contar= $result->rowCount();
if($contar>0){		
	while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
		if($linha->estado=="Presente"){$rCont++;}
		if($linha->estado=="Falta"){$rFalta++;}
		if($linha->estado=="Falta Justificada"){$rFj++;}
		if($linha->estado=="Inserido"){$rIns++;}
		if($linha->estado=="Dispensado"){$rDis++;}
		if($linha->estado=="Alta"){$rAlta++;}
		if($linha->estado=="Profissional Ausente"){$pfaus++;}
		if($linha->estado=="Desligado"){$desligado++;}
		$atd++;
	}
}


?>