<?php 
include("conecta/conexao.php");
if (isset($_POST['prof_select'])) {
	$prof = $_POST['prof_select'];

	$select = "SELECT prof_serv.*, servicos.nome as nome_servico, servicos.id = id_serv
	FROM (prof_serv
	INNER JOIN servicos ON prof_serv.id_serv = servicos.id) WHERE id_prof=:prof ORDER BY nome_servico DESC";
	$result=$conexao->prepare($select);
	$result->bindParam(':prof', $prof, PDO::PARAM_INT);
	$result->execute();
	$contar= $result->rowCount();
	if($contar>0){ $num=$contar;
		while ($linha = $result->FETCH(PDO::FETCH_OBJ)) { 
			?>
			<option value="<?php echo $linha->id_serv; ?>"><?php echo $linha->nome_servico; ?></option>
			<?php
	}	// FIM IF COMPARAR
	} // FIM WHILE
}

if (isset($_POST['servico'])) {
	$servico = $_POST['servico'];

//se for triagem aceita qualquer profissional
	if ($servico == 19) {
		include("includes/prof.php");
	}else{
		$select = "SELECT prof_serv.*, profissionais.nome as nome_prof, profissionais.id = id_prof, profissionais.ver as ver
		FROM (prof_serv
		INNER JOIN profissionais ON prof_serv.id_prof = profissionais.id) WHERE id_serv=:servico AND ver='0' ORDER BY nome DESC";
		$result=$conexao->prepare($select);
		$result->bindParam(':servico', $servico, PDO::PARAM_INT);
		$result->execute();
		$contar= $result->rowCount();
		if($contar>0){ $num=$contar;
			while ($linha = $result->FETCH(PDO::FETCH_OBJ)) { 
				?>
				<option value="<?php echo $linha->id_prof; ?>"><?php echo $linha->nome_prof; ?></option>
				<?php
	}	// FIM IF COMPARAR
}
}

}
?>