<?php 
$i=0;
$data=date("d/m"); //BUSCA DIA E MÊS ATUAL
$dtano=date("Y");	
$select = "SELECT datanasc, nome, id_assist, imagem FROM assistidos ORDER BY nome ASC";	// PROCURA NOME E DATA DE NASCIMENTO
try{
	$result=$conexao->prepare($select);
	$result->execute();
	$aniversario= $result->rowCount();
	if($aniversario>0){ 
		while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
		$datanasc=$linha->datanasc; //ATRIBUI OS VALORES ENCONTRADOS NO BANCO
		$dtaniver=date("d/m",strtotime($datanasc));	// TRANSFORMA ESSES VALORES PARA DIA/MÊS
		$ano=date("Y",strtotime($datanasc));	// TRANSFORMA ESSES VALORES PARA DIA/MÊS
		$idade=$dtano-$ano; //COMPARA ANO PRA VER IDADE
		if($dtaniver==$data){ //COMPARA PARA VER SE EXISTE ALGUÉM COM A DATA DE NASCIMENTO IGUAL A DATA ATUAL
		$i++;
			$nome = $linha->nome;
			$nome = implode('-', explode(' ', $nome));
		?>
		<a href="p<?php echo $nome;?>-<?php echo $linha->id_assist;?>">
		<?php
		echo $linha->nome.' ('.$idade, " anos)"; ?></a>
		<br><?php
			}
		}//fim while
	}//fim if
}// fim try
catch(PDOException $e){	echo $e;	}
if($i == 0){echo "Não temos aniversariantes hoje!";}
?>