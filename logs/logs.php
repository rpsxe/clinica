<?php 


function registraLog($id_assist, $id_servico, $id_prof, $estado, $nome_responsavel){
	include('conecta/conexao.php');
	$select = "SELECT agenda.*, profissionais.nome as p_nome, servicos.nome as serv_nome, assistidos.nome as assist_nome
	FROM (((agenda
	INNER JOIN assistidos ON agenda.id_assist = assistidos.id_assist)
	INNER JOIN profissionais ON agenda.id_prof = profissionais.id)
	INNER JOIN servicos ON agenda.id_serv = servicos.id) WHERE agenda.id_assist=:id_assist AND agenda.id_prof=:id_prof AND agenda.id_serv=:id_serv LIMIT 1";
	$result=$conexao->prepare($select);
	$result->bindParam(':id_assist', $id_assist, PDO::PARAM_INT);
	$result->bindParam(':id_prof', $id_prof, PDO::PARAM_INT);
	$result->bindParam(':id_serv', $id_servico, PDO::PARAM_INT);
	$result->execute();
	$contar= $result->rowCount();
	if($contar>0){		
		while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
			$nome_assistido = $linha->assist_nome;
			$nome_profissional = $linha->p_nome;
			$nome_servico = $linha->serv_nome;
		}
	}else{
		$select = "SELECT nome FROM assistidos WHERE id_assist=:id_assist LIMIT 1";
		$result=$conexao->prepare($select);
		$result->bindParam(':id_assist', $id_assist, PDO::PARAM_INT);
		$result->execute();
		$contar= $result->rowCount();
		if($contar>0){	
			while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
				$nome_assistido = $linha->nome;
			}
		}

		unset($select);
		unset($result);
		unset($contar);

		$select = "SELECT nome FROM profissionais WHERE id=:id_prof LIMIT 1";
		$result=$conexao->prepare($select);
		$result->bindParam(':id_prof', $id_prof, PDO::PARAM_INT);
		$result->execute();
		$contar= $result->rowCount();
		if($contar>0){	
			while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
				$nome_profissional = $linha->nome;
			}
		}

		unset($select);
		unset($result);
		unset($contar);	

		$select = "SELECT nome FROM servicos WHERE id=:id_serv LIMIT 1";
		$result=$conexao->prepare($select);
		$result->bindParam(':id_serv', $id_servico, PDO::PARAM_INT);
		$result->execute();
		$contar= $result->rowCount();
		if($contar>0){	
			while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
				$nome_servico = $linha->nome;
			}
		}

	}

	$grLog = '['.date("d/m/Y H:i:s").'] '.$nome_responsavel.' marcou '.$estado.' para '.$nome_assistido.' no atendimento '.$nome_servico.' com '.$nome_profissional;
	$quebra = chr(13).chr(10);
	$file = fopen("C:/Users/TeleServidorueb/Documents/backup/logs/usuarios.txt", "a+");
	fwrite($file, $quebra);
	fwrite($file, $grLog);
	fclose($file);

}


function registraLogAgenda($id_assist, $id_servico, $id_prof, $nome_responsavel){
	include('conecta/conexao.php');

	$select = "SELECT nome FROM assistidos WHERE id_assist=:id_assist LIMIT 1";
	$result=$conexao->prepare($select);
	$result->bindParam(':id_assist', $id_assist, PDO::PARAM_INT);
	$result->execute();
	$contar= $result->rowCount();
	if($contar>0){	
		while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
			$nome_assistido = $linha->nome;
		}
	}

	unset($select);
	unset($result);
	unset($contar);

	$select = "SELECT nome FROM profissionais WHERE id=:id_prof LIMIT 1";
	$result=$conexao->prepare($select);
	$result->bindParam(':id_prof', $id_prof, PDO::PARAM_INT);
	$result->execute();
	$contar= $result->rowCount();
	if($contar>0){	
		while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
			$nome_profissional = $linha->nome;
		}
	}

	unset($select);
	unset($result);
	unset($contar);	

	$select = "SELECT nome FROM servicos WHERE id=:id_serv LIMIT 1";
	$result=$conexao->prepare($select);
	$result->bindParam(':id_serv', $id_servico, PDO::PARAM_INT);
	$result->execute();
	$contar= $result->rowCount();
	if($contar>0){	
		while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
			$nome_servico = $linha->nome;
		}
	}

$grLog = '['.date("d/m/Y H:i:s").'] '.$nome_responsavel.' agendou um horário para '.$nome_assistido.' no atendimento '.$nome_servico.' com '.$nome_profissional;
$quebra = chr(13).chr(10);
$file = fopen("C:/Users/TeleServidorueb/Documents/backup/logs/usuarios.txt", "a+");
fwrite($file, $quebra);
fwrite($file, $grLog);
fclose($file);


}


?>