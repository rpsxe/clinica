<select name="profissionais" class="form-control" required>
	<option value="<?php echo $prof; ?>" selected> <?php echo $profNome; ?> </option>
<?php

	// AQUI VOU SELECIONAR TODOS OS PROFISSIONAIS

$select = "SELECT * FROM `profissionais` WHERE ver='0' ORDER BY nome ASC";
try{
	$result=$conexao->prepare($select);
	$result->execute();
	$contar= $result->rowCount();
	if($contar>0){
		while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
		$idProf=$linha->id;
		$nomeProf=$linha->nome;
		if($idProf!="$prof"){ echo '<option value="'.$idProf.'">'.$nomeProf.'</option>'; }
		}
	}
}catch(PDOException $e){
		echo $e;
}
?>
</select>