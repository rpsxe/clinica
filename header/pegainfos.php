<?php
if(!isset($_GET['id'])){
	header("Location: registros.php"); 
	exit;
}
	$id=trim(strip_tags($_GET['id']));
	if (is_numeric($id)){}else{
		header("Location: inicio"); exit;
	}
$select = "SELECT * FROM `assist_resp` WHERE id_assist=:id";
try{
	$result=$conexao->prepare($select);
	$result->bindParam(':id', $id, PDO::PARAM_INT);
	$result->execute();
	$contar= $result->rowCount();
	if($contar>0){
		while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
		$cpfNum = $linha->cpf;
		$tipo = $linha->tipo;
		}
	}
}catch(PDOException $e){
		echo $e;
}
$select = "SELECT * FROM `resp` WHERE cpf=:cpfNum";
try{
	$result=$conexao->prepare($select);
	$result->bindParam(':cpfNum', $cpfNum, PDO::PARAM_INT);
	$result->execute();
	$contar= $result->rowCount();
	if($contar>0){
		while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
			$nome_tipo=$linha->nome;
			$cpf=$linha->cpf;
			$rg=$linha->rg;
			$data_nasc=$linha->datanasc;
			$dependentes=$linha->dependentes;
			$telefone=$linha->telefone;
			$escolaridade=$linha->escolaridade;
			$profissao=$linha->profissao;
		}
	}
}catch(PDOException $e){
		echo $e;
}
$select = "SELECT * FROM `assistidos` WHERE id_assist=:id";
try{
	$result=$conexao->prepare($select);
	$result->bindParam(':id', $id, PDO::PARAM_INT);
	$result->execute();
	$contar= $result->rowCount();
	if($contar>0){
		while ($linha = $result->FETCH(PDO::FETCH_OBJ)){
			$nome=$linha->nome;
			$datanasc=$linha->datanasc;
			$naturalidade =$linha->naturalidade;
			$obs =$linha->obs; 
			$folha =$linha->folha;
			$livro =$linha->livro;
			$datareg =$linha->datareg;
			$cartorio =$linha->cartorio;
			$ncertidao =$linha->ncertidao; 
			$rua =$linha->rua;
			$numero =$linha->numero;
			$cidade =$linha->cidade;
			$bairro=$linha->bairro;
			$complemento=$linha->complemento;
			$cep=$linha->cep;
			$nis=$linha->nis;
			$imagem=$linha->imagem;
			$escola=$linha->escola;
			$autista=$linha->autista;
			$pasta=$linha->pasta;
}
	}else{
		header ("Refresh: 0, registros"); exit;
			
	}
}catch(PDOException $e){
		echo $e;
}
?>