<?php 
include("conecta/conexao.php");
if(isset($_POST['date'])){
	$dataIni = $_POST['date'];
}else{
	$dataIni = date("Y-m-d");
}
$prof = $_POST['prof'];
$tempo = $_POST['tempo'];
$dataFim = date('Y-m-d', strtotime('-'.$tempo.' days', strtotime($dataIni)));
$cont = 0;$faltas = 0;$saude=0;$smed=0;$desliga=0;$fj=0;  $num=0; $ins=0;$dis=0; $alta=0;$pfaus=0;
$select = "SELECT atendimentos.*, atendimentos.id as id_at, profissionais.nome as p_nome, servicos.nome as serv_nome, assistidos.nome as assist_nome
FROM (((atendimentos
INNER JOIN assistidos ON atendimentos.id_assist = assistidos.id_assist)
INNER JOIN profissionais ON atendimentos.id_prof = profissionais.id)
INNER JOIN servicos ON atendimentos.id_serv = servicos.id) WHERE id_prof='$prof' AND (data BETWEEN '$dataFim' AND '$dataIni') ORDER BY id_at DESC";
$result=$conexao->prepare($select);
$result->execute();
$contar= $result->rowCount();
if($contar>0){ $num=$contar;
	?>
<h2 class="text-center">Atendimentos entre <?php echo date('d/m/Y', strtotime($dataIni)); ?> à <?php echo date('d/m/Y', strtotime($dataFim)); ?></h2>
<div class="row text-center">
<a href="relatorio-atendimentos-<?php echo $prof; ?>-<?php echo $tempo; ?>-<?php echo $dataIni; ?>">Gerar PDF</a>
</div>
		<p id="presencas" class="text-center"></p><br>
		<div class="table-responsive" id="tabela">  				
			<table class="table">
				<thead style="background: white;">
					<tr >
						<th> </th>
						<th>Assistido</th>
						<th>Profissional</th>
						<th>Atendimento</th>
						<th>Estado</th>
						<th>Data</th>
					</tr>
				</thead>
				<tbody>
					<?php
					while ($linha = $result->FETCH(PDO::FETCH_OBJ)) { 
						$tipo=$linha->tipo;
						$estado = $linha->estado;
						$nome = $linha->assist_nome;
						$nome = implode('-', explode(' ', $nome));
						?>
						<tr <?php if( $estado=="Presente" ){ echo 'class="success"';}if ($estado=="Falta"){echo 'class="danger"';}if ($estado=="Inserido"){echo 'class="active"';}if($estado=="Falta Justificada"){echo 'class="warning"';}if($estado=="Desligado"){echo 'class="info"';}?>>
							<td><?php echo $num; ?></td>
							<td><a href="p<?php echo $nome;?>-<?php echo $linha->id_assist;?>"><p><dl><?php	echo $linha->assist_nome; ?></p></a> </td>
								<td><?php	echo  $linha->p_nome; ?></td>
								<td><?php	echo $linha->serv_nome; ?></td>
								<td><?php echo $estado; ?></td>
								<td><?php $data=$linha->data; echo date('d/m/Y',  strtotime($data)) ?></td>
							</tr>
							<?php
	//Informação de atividade
							if($tipo=="SMED" && $estado=="Presente"){$smed++;}
							if($tipo=="Saúde" && $estado=="Presente"){$saude++;}
							if($estado=="Presente"){$cont++;}
							if($estado=="Falta"){$faltas++;}
							if($estado=="Falta Justificada"){$fj++;}
							if($estado=="Desligado"){$desliga++;}
							if($estado=="Inserido"){$ins++;}
							if($estado=="Dispensado"){$dis++;}
							if($estado=="Alta"){$alta++;}
							if($estado=="Profissional Ausente"){$pfaus++;}
		$num--;}	// FIM IF COMPARAR
	} // FIM WHILE

else{echo '<center><br><h1>Nenhum dado encontrado!';} // FIM IF $CONTAR
?>
</tbody>
</table>
</div>
<?php 
if($contar > 1){
$total = $cont + $faltas + $fj;
$total = ($cont * 100)/$total;
$total = number_format($total, 0, ',', '.');
}
?>
<script>
	$("#presencas").html("<h3><span style='color: green'><?php echo $total; ?>% de presenças</span></h3><br>")
	.append(" <?php echo $smed; ?> SMED,")
	.append(" <?php echo $saude; ?> Saúde<br>")
	.append(" <?php echo $cont; ?> Presenças,")
	.append(" <?php echo $faltas; ?> Faltas,")
	.append(" <?php echo $fj; ?> Faltas Justificadas,")
	.append(" <?php echo $desliga; ?> Desligados,")
	.append(" <?php echo $ins; ?> Inseridos,")
	.append(" <?php echo $dis; ?> Dispensados,")
	.append(" <?php echo $alta; ?> Altas,")
	.append(" <?php echo $pfaus; ?> Profissional Ausente");
	
</script>