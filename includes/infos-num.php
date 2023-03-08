<?php 
$seg = 0; $ter = 0; $quar = 0; $quin = 0; $sex = 0;
	$select = "SELECT * FROM `agenda` WHERE ativo='S'";
				$result=$conexao->prepare($select);
				$result->bindParam(':dia', $dia, PDO::PARAM_INT);
				$result->execute();
				$agenda= $result->rowCount();
				
	$select = "SELECT * FROM `assistidos`";
				$result=$conexao->prepare($select);
				$result->bindParam(':dia', $dia, PDO::PARAM_INT);
				$result->execute();
				$assist= $result->rowCount();


	$ver = 0;
	$col=1;$numAl=0;
	$select = "SELECT agenda.*, profissionais.nome as p_nome, servicos.nome as serv_nome, assistidos.nome as assist_nome
			FROM (((agenda
				INNER JOIN assistidos ON agenda.id_assist = assistidos.id_assist)
				INNER JOIN profissionais ON agenda.id_prof = profissionais.id)
				INNER JOIN servicos ON agenda.id_serv = servicos.id) WHERE ativo='S' ORDER BY assist_nome ASC";
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
		$col=1;
		$ver = $idAluno;
			$numAl++;
			}
		}
	}
	}catch(PDOException $e){
			echo $e;
	}
				
				
		$select = "SELECT * FROM agenda WHERE ativo='S' ORDER BY dia ASC";
				$result=$conexao->prepare($select);
				$result->bindParam(':dia', $dia, PDO::PARAM_INT);
				$result->execute();
				$contar= $result->rowCount();
				if($contar>0){		
				while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
					if($linha->dia == 1){ $seg++;}
					if($linha->dia == 2){ $ter++;}
					if($linha->dia == 3){ $quar++;}
					if($linha->dia == 4){ $quin++;}
					if($linha->dia == 5){ $sex++;}				
				}
			}		
				
				
				
				
				
?>