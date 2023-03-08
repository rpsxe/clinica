<select class="form-control" name="servicos" required>
	<option selected disabled>  </option>
<?php
	//AQUI VOU SELECIONAR TODOS OS SERVIÇOS

$select = "SELECT * FROM `servicos` WHERE id!='19' ORDER BY nome ASC";
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