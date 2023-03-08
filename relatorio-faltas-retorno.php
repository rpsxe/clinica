<?php 
include("conecta/conexao.php");
if(isset($_POST['date'])){
	$dataIni = $_POST['date'];
}else{
	$dataIni = date("Y-m-d");
}

$tempo = $_POST['tempo'];
$dataFim = date('Y-m-d', strtotime('-'.$tempo.' days', strtotime($dataIni)));

$select = "SELECT atendimentos.*, atendimentos.id as id_at, profissionais.nome as p_nome, servicos.nome as serv_nome, assistidos.nome as assist_nome
FROM (((atendimentos
INNER JOIN assistidos ON atendimentos.id_assist = assistidos.id_assist)
INNER JOIN profissionais ON atendimentos.id_prof = profissionais.id)
INNER JOIN servicos ON atendimentos.id_serv = servicos.id) WHERE (estado='Falta' OR estado='Falta Justificada') AND (data BETWEEN '$dataFim' AND '$dataIni') ORDER BY id_assist, data DESC";
$result=$conexao->prepare($select);
$result->execute();
$contar= $result->rowCount();
if($contar>0){ $num=$contar;
	?>

<br>
<p>Atendimentos entre <?php echo date('d/m/Y', strtotime($dataIni)); ?> à <?php echo date('d/m/Y', strtotime($dataFim)); ?></p>

		<p id="presencas" class="text-center"></p><br>
		<div class="table-responsive" id="tabela">  				
			<table class="table">
				<thead style="background: white;">
					<tr >
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
						<tr>
							
							<td><a href="p<?php echo $nome;?>-<?php echo $linha->id_assist;?>"><p><dl><?php	echo $linha->assist_nome; ?></p></a> </td>
								<td><?php	echo  $linha->p_nome; ?></td>
								<td><?php	echo $linha->serv_nome; ?></td>
								<td><?php echo $estado; ?></td>
								<td><?php $data=$linha->data; echo date('d/m/Y',  strtotime($data)) ?></td>
							</tr>
							<?php

		}	// FIM IF COMPARAR
	} // FIM WHILE

else{echo '<center><br><h1>Nenhum dado encontrado!';} // FIM IF $CONTAR
?>
</tbody>
</table>
</div>

<!-- <script>
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
	
</script> -->