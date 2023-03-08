<select name="servicos" class="form-control" required>
	<option value="<?php echo $servId; ?>" selected> <?php echo $nomeServ; ?> </option>
<?php
	//AQUI VOU SELECIONAR TODOS OS SERVIÇOS

$select = "SELECT * FROM `servicos` WHERE id!='19' ORDER BY nome ASC";
try{
	$result=$conexao->prepare($select);
	$result->execute();
	$contar= $result->rowCount();
	if($contar>0){
		while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
		$idServ=$linha->id;
		$servNome=$linha->nome;
		if($idServ!="$servId"){ echo '<option value="'.$idServ.'">'.$servNome.'</option>'; }
		}
	}
}catch(PDOException $e){echo $e;}
?>
</select>