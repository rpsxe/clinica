<title>Histórico</title>
<div class="row">
	<?php
	$select = "SELECT atendimentos.*, atendimentos.id as id_at, profissionais.nome as p_nome, servicos.nome as serv_nome, assistidos.nome as assist_nome
	FROM (((atendimentos
	INNER JOIN assistidos ON atendimentos.id_assist = assistidos.id_assist)
	INNER JOIN profissionais ON atendimentos.id_prof = profissionais.id)
	INNER JOIN servicos ON atendimentos.id_serv = servicos.id) WHERE atendimentos.id_assist=:id ORDER BY id_at DESC";
	$result=$conexao->prepare($select);
	$result->bindParam(':id', $id, PDO::PARAM_INT);
	$result->execute();
	$contar= $result->rowCount();
	if($contar>0){ $num=$contar;?>
		<div class="table-responsive">  				
			<table class="table">
				<thead style="background: white;">
					<tr>
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
		$num--;}	// FIM IF COMPARAR
	} // FIM WHILE
else{echo '<center><br><h1>Nenhum dado encontrado!';} // FIM IF $CONTAR
?>
</tbody>
</table>
</div>
</div>