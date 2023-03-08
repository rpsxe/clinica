 <table class="table table-hover">
 	<?php
 	$desligado = NULL;
 	$select = "SELECT agenda.*, profissionais.nome as p_nome, servicos.nome as serv_nome, assistidos.nome as assist_nome
 	FROM (((agenda
 	INNER JOIN assistidos ON agenda.id_assist = assistidos.id_assist)
 	INNER JOIN profissionais ON agenda.id_prof = profissionais.id)
 	INNER JOIN servicos ON agenda.id_serv = servicos.id) WHERE agenda.id_assist=:id ORDER BY dia, horario ASC";
 	$result=$conexao->prepare($select);
 	$result->bindParam(':id', $id, PDO::PARAM_INT);
 	$result->execute();
 	$contar= $result->rowCount();
 	if($contar>0){	?>
 		<h1 class="text-center">Atendimentos</h1>
 		<center><span style="color: red;">@Linha vermelha: Desligado!</span></center>
 		<br>	
 		<?php	while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {	$dia = $linha->dia;	?>
 			<tr <?php if($linha->ativo=="N"){echo 'style="background:#D41C0C; color: white;"'; $desligado++;} //quando tiver alguém desligado a linha vai ficar vermelha; ?>>
 				<td><?php	echo  $linha->horario; ?></td>
 				<td><?php if($dia==1){echo "Segunda";}elseif($dia==2){echo "Terça";}elseif($dia==3){echo "Quarta";}elseif($dia==4){echo "Quinta";}elseif($dia==5){echo "Sexta";}?></td>
 				<td><?php	echo  $linha->p_nome; ?></td>
 				<td><?php	echo $linha->serv_nome; ?></td>
 				<td><?php	echo $linha->tipo; ?></td>
 				<?php if ($_SESSION['nivel']  != ""){ ?>
 					<td><button class="btn"><a href="atualizar-horario<?php echo $linha->id; ?>">Atualizar</a></button></td>
 				<?php 	}else{} ?>
 			</tr>
 		<?php	}
 	}
 	?>
 </table>

 <div>
 	<?php 
 	$select = "SELECT list_espera.*, servicos.nome as serv_nome, assistidos.nome as assist_nome, assistidos.id_assist as id_assist, servicos.id as id_serv
 	FROM ((list_espera
 	INNER JOIN assistidos ON list_espera.id_assist = assistidos.id_assist)
 	INNER JOIN servicos ON list_espera.id_serv = servicos.id) WHERE list_espera.id_assist=:id ORDER BY data, id ASC";	
 	$result=$conexao->prepare($select);
 	$result->bindParam(':id', $id, PDO::PARAM_INT);
 	$result->execute();
 	$numRows= $result->rowCount();
 	if($numRows>0){
 		echo '<h3  class="text-center">Aguardando na lista de espera.</h3><br>';
 		echo ' <table class="table table-hover">';
 		while ($linha = $result->FETCH(PDO::FETCH_OBJ)) { 
 			echo '<tr><td>';
 			echo $linha->serv_nome;
 			echo '</td>';
 			echo '<td>';
 			echo date('d/m/Y',  strtotime($linha->data));
 			echo '</td>';
 			if ($_SESSION['nivel'] == 1){
 				echo '<td>';
 				echo '<button data-toggle="modal" data-target="#agendarhorario" class="btn">Agendar</button>';
 				echo '</td>';
 				echo '<td><a href="lista-espera?delete='.$linha->id.'" onClick="return confirm("Deseja realmente deletar?")" class="close" data-dismiss="alert" aria-label="close">×</a></td>';
 			}
 			echo '</tr>';
 		}
 		echo ' </table>';
 	}

 	?>
 </div>

 <div>
 	<?php 
 	$select = "SELECT lista_avaliacao.*, servicos.nome as serv_nome, assistidos.nome as assist_nome, assistidos.id_assist as id_assist, servicos.id as id_serv
 	FROM ((lista_avaliacao
 	INNER JOIN assistidos ON lista_avaliacao.id_assist = assistidos.id_assist)
 	INNER JOIN servicos ON lista_avaliacao.id_serv = servicos.id) WHERE lista_avaliacao.id_assist=:id ORDER BY data, id ASC";	
 	$result=$conexao->prepare($select);
 	$result->bindParam(':id', $id, PDO::PARAM_INT);
 	$result->execute();
 	$numRows= $result->rowCount();
 	if($numRows>0){
 		echo '<h3  class="text-center">Aguardando na lista de avaliação por especialidades.</h3><br>';
 		echo ' <table class="table table-hover">';
 		while ($linha = $result->FETCH(PDO::FETCH_OBJ)) { 
 			echo '<tr><td>';
 			echo $linha->serv_nome;
 			echo '</td>';
 			echo '<td>';
 			echo date('d/m/Y',  strtotime($linha->data));
 			echo '</td>';
 			if ($_SESSION['nivel'] == 1){ 			
 				echo '<td><a href="lista-avaliacao?delete='.$linha->id.'" onClick="return confirm("Deseja realmente deletar?")" class="close" data-dismiss="alert" aria-label="close">×</a></td>';
 			}
 			echo '</tr>';
 		}
 		echo ' </table>';
 	}

 	?>
 </div>


 <div>
 	<?php 
 	$select = "SELECT lista_triagem.id_assist, lista_triagem.data, lista_triagem.id as id
 	FROM (lista_triagem
 	INNER JOIN assistidos ON lista_triagem.id_assist = assistidos.id_assist) WHERE lista_triagem.id_assist=:id ORDER BY data, id ASC";	
 	$result=$conexao->prepare($select);
 	$result->bindParam(':id', $id, PDO::PARAM_INT);
 	$result->execute();
 	$numRows= $result->rowCount();
 	if($numRows>0){
 		echo '<h3  class="text-center">Aguardando na lista de triagem.</h3><br>';
 		echo ' <table class="table table-hover">';
 		while ($linha = $result->FETCH(PDO::FETCH_OBJ)) { 
 			echo '<td>';
 			echo 'Aguardando Psicologia desde '.date('d/m/Y',  strtotime($linha->data));
 			echo '</td>';
 			if ($_SESSION['nivel'] == 1){ 			
 				echo '<td><a href="triagens?delete='.$linha->id.'" onClick="return confirm("Deseja realmente deletar?")" class="close" data-dismiss="alert" aria-label="close">×</a></td>';
 			}
 			echo '</tr>';
 		}
 		echo ' </table>';
 	}

 	?>
 </div>