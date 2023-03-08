<select class="form-control" name="profissionais" id="prof_select" required>
	<option >  </option>
<?php

	// AQUI VOU SELECIONAR TODOS OS PROFISSIONAIS

$select = "SELECT * FROM `profissionais` WHERE ver='0' ORDER BY nome ASC";
try{
	$result=$conexao->prepare($select);
	$result->execute();
	$contar= $result->rowCount();
	if($contar>0){
		while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
?>
	<option value="<?php echo $linha->id; ?>"><?php echo $linha->nome; ?></option>
<?php
		}
	}
}catch(PDOException $e){
		echo $e;
}
?>
</select>