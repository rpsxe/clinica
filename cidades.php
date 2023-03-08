<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Pesquisa | Cidades</title>
</head>
<body>
	
	<table  style="font-family: Verdana; padding: 15px;">
		<tr>
			<th></th><th>Nome</th><th>Cidade</th>
		</tr>
		<?php 
		include("conecta/conexao.php");
		$ver = 0;
		$num=1;
		$coluna = 'list_espera';

		// $select = "SELECT assistidos.cidade cidade, assistidos.nome nome, assistidos.id_assist id_assist, servicos.nome serv_nome
		// FROM $coluna
		// INNER JOIN servicos ON $coluna.id_serv = servicos.id 
		// INNER JOIN assistidos ON $coluna.id_assist = assistidos.id_assist WHERE  cidade = 'Bagé'  ORDER BY cidade, nome ASC";
		$select = "SELECT * FROM assistidos WHERE  cidade != 'Bagé' ORDER BY cidade, nome ASC";
		try{	
			$result=$conexao->prepare($select);
			$result->execute();
			$contar= $result->rowCount();
			if($contar>0){		
				while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
					$nome = $linha->nome;
					$nome = implode('-', explode(' ', $nome));
					// echo '<tr><td>'.$num++.'</td><td><a href="p'.$nome.'-'.$linha->id_assist.'" target="_blank" style="color: black; text-decoration: none;">';	
					echo '<tr><td>'.$num++.'</td><td>';	
					echo $linha->nome;
					echo '</td>';
					echo '<td>';
					echo $linha->cidade;
					echo '</td>';
					echo '<tr>';
				}
			}
		}catch(PDOException $e){
			echo $e;
		}	

		?>
	</table>
</body>
</html>

