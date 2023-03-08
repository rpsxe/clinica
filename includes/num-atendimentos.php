<?php
$cont=0;$saude=0;$smed=0;$desliga=0;$falta=0;$fj=0;  $num=0; $nConta=0; $frq = NULL;
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
		$tipo=$linha->tipo;
		$estado = $linha->estado;
		if($estado=="Presente"){$cont++;}
		if($estado=="Falta"){$falta++;}
		if($estado=="Falta Justificada"){$fj++;}
	/* if($estado=="Desligado"){$nConta++;}
	if($estado=="Inserido"){$nConta++;}
	if($estado=="Alta"){$nConta++;} */
	if($estado=="Profissional Ausente"){$nConta++;}
	}		// FIM IF COMPARAR
} // FIM WHILE
else{} 

//PORCENTAGEM

	$total = $cont + $falta + $fj;
$numTotal = $total;
if ($total > 0){
	$total = ($cont * 100)/$total;
	$total = number_format($total, 0, ',', '.');
	$frq = 1;
	echo '<br><h3>'.$nome.' possui frequência de <span class="frq">'.$total.'%</span></h3> '; 
}else{
	$total = 100;
	echo '<h3>'.$nome.' ainda não possui frequência registrada.</h3><br>';}
	?>
