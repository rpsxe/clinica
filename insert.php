<meta charset="utf-8">
<?php
	//Incluindo cabeçalho
include ("cabecalho.php");
include ("conecta/conexao.php");
//RECUPERAR DADOS DO FORM
		//trim — Retira espaço no ínicio e final de uma string
		//strip_tags — Retira as tags HTML e PHP de uma string
		// devido ao uso do "trim" e "strip_tags"
$nome=trim(strip_tags($_POST['nome'])); 
$datanasc=trim(strip_tags($_POST['datanasc'])); 
$naturalidade =trim(strip_tags($_POST['naturalidade'])); 
$nis =trim(strip_tags($_POST['nis']));
$obs =trim(strip_tags($_POST['obs']));  
$escola=trim(strip_tags($_POST['escola']));
$pasta=trim(strip_tags($_POST['pasta']));

// DADOS CARTÓRIO
$folha =trim(strip_tags($_POST['folha'])); 
$livro =trim(strip_tags($_POST['livro'])); 
$datareg =trim(strip_tags($_POST['datareg'])); 
$cartorio =trim(strip_tags($_POST['cartorio'])); 
$ncertidao =trim(strip_tags($_POST['ncertidao']));

// DADOS ENDEREÇO  
$rua =trim(strip_tags($_POST['rua'])); 
$numero =trim(strip_tags($_POST['numero'])); 
$cep =trim(strip_tags($_POST['cep']));
$cidade =trim(strip_tags($_POST['cidade'])); 
$bairro=trim(strip_tags($_POST['bairro'])); 
$complemento=trim(strip_tags($_POST['complemento'])); 



// DADOS RESPONSÁVEL
$cpf=trim(strip_tags($_POST['cpf']));
$tipo=trim(strip_tags($_POST['tipo']));
	$existe=$_POST['existe']; //VERIFICA SE JÁ EXISTE O REGISTRO DE CPF

	if ($existe != NULL OR $existe!= "") {
		if(!empty($_FILES['img']['name'])){
			$cimg=0;
			$altura = "175";
			$largura = "175";	
			switch($_FILES['img']['type']):
				case 'image/jpeg';
				case 'image/pjpeg';
				$imagem_temporaria = imagecreatefromjpeg($_FILES['img']['tmp_name']);
				$largura_original = imagesx($imagem_temporaria);
				$altura_original = imagesy($imagem_temporaria);			
				$nova_largura = $largura ? $largura : floor (($largura_original / $altura_original) * $altura);

				$nova_altura = $altura ? $altura : floor (($altura_original / $largura_original) * $largura);

				$imagem_redimensionada = imagecreatetruecolor($nova_largura, $nova_altura);
				imagecopyresampled($imagem_redimensionada, $imagem_temporaria, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura_original, $altura_original);

				$extensao = strtolower(substr($_FILES['img']['name'], -4));
				$novoNome = md5(time()) . $extensao;
				$diretorio = "upload/";

				$cimg++;
				break;

		//Caso a imagem seja extensão PNG cai nesse CASE
				case 'image/png':
				case 'image/x-png';
				$imagem_temporaria = imagecreatefrompng($_FILES['img']['tmp_name']);

				$largura_original = imagesx($imagem_temporaria);
				$altura_original = imagesy($imagem_temporaria);			
				/* Configura a nova largura */
				$nova_largura = $largura ? $largura : floor(( $largura_original / $altura_original ) * $altura);

				/* Configura a nova altura */
				$nova_altura = $altura ? $altura : floor(( $altura_original / $largura_original ) * $largura);

				/* Retorna a nova imagem criada */
				$imagem_redimensionada = imagecreatetruecolor($nova_largura, $nova_altura);

				/* Copia a nova imagem da imagem antiga com o tamanho correto */
			//imagealphablending($imagem_redimensionada, false);
			//imagesavealpha($imagem_redimensionada, true);

				imagecopyresampled($imagem_redimensionada, $imagem_temporaria, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura_original, $altura_original);


				$extensao = strtolower(substr($_FILES['img']['name'], -4));
				$novoNome = md5(time()) . $extensao;
				$diretorio = "upload/";

				break;
			endswitch;
			$cont = 0;
		}else{
			$novoNome = "imagem_padrao.png";
		}
		
		if ($existe == 1) {
			$insert = "INSERT into `assistidos` (nome, imagem, datanasc, naturalidade, obs, folha, livro, datareg, cartorio, ncertidao, rua, numero, cidade, bairro, complemento, nis, cep, escola, pasta)
			VALUES (:nome, :imagem, :datanasc, :naturalidade, :obs, :folha, :livro, :datareg, :cartorio, :ncertidao, :rua, :numero, :cidade, :bairro, :complemento, :nis, :cep, :escola, :pasta)";
			try{
				$result = $conexao->prepare($insert);
				$result->bindParam(':nome', $nome, PDO::PARAM_STR);
				$result->bindParam(':imagem', $novoNome, PDO::PARAM_STR);
				$result->bindParam(':datanasc', $datanasc, PDO::PARAM_STR);
				$result->bindParam(':naturalidade', $naturalidade, PDO::PARAM_STR);
				$result->bindParam(':obs', $obs, PDO::PARAM_STR);
				$result->bindParam(':folha', $folha, PDO::PARAM_STR);
				$result->bindParam(':livro', $livro, PDO::PARAM_STR);
				$result->bindParam(':datareg', $datareg, PDO::PARAM_STR);
				$result->bindParam(':cartorio', $cartorio, PDO::PARAM_STR);
				$result->bindParam(':cartorio', $cartorio, PDO::PARAM_STR);
				$result->bindParam(':ncertidao', $ncertidao, PDO::PARAM_STR);
				$result->bindParam(':rua', $rua, PDO::PARAM_STR);
				$result->bindParam(':numero', $numero, PDO::PARAM_STR);
				$result->bindParam(':cidade', $cidade, PDO::PARAM_STR);
				$result->bindParam(':bairro', $bairro, PDO::PARAM_STR);
				$result->bindParam(':complemento', $complemento, PDO::PARAM_STR);
				$result->bindParam(':nis', $nis, PDO::PARAM_STR);
				$result->bindParam(':cep', $cep, PDO::PARAM_STR);
				$result->bindParam(':escola', $escola, PDO::PARAM_STR);
				$result->bindParam(':pasta', $pasta, PDO::PARAM_STR);
				$result->execute();
				$contar = $result->rowCount();
				$numId = $conexao->lastInsertId();
			}
			catch(PDOException $e){
				echo $e;
			}

			$id_prof= $_POST['assistente_social'];
			$convenio= $_POST['convenio'];
			$data= date("Y/m/d");
			$estado= "Presente";
			$id_assist=$numId;
			$id_serv= '6';
			$nivel_triagem = '0';


#Atendimento
			try{
				$insert = "INSERT into `atendimentos` (id_assist,data,estado,id_prof,id_serv,tipo)
				VALUES (:id_assist, :data, :estado, :id_prof, :id_serv, :tipo)";
				$result = $conexao->prepare($insert);
				$result->bindParam(':id_assist', $id_assist, PDO::PARAM_INT);
				$result->bindParam(':data', $data, PDO::PARAM_STR);
				$result->bindParam(':estado', $estado, PDO::PARAM_STR);
				$result->bindParam(':id_prof', $id_prof, PDO::PARAM_STR);
				$result->bindParam(':id_serv', $id_serv, PDO::PARAM_STR);
				$result->bindParam(':tipo', $convenio, PDO::PARAM_STR);
				$result->execute();
			}catch(PDOException $e){echo $e;}

			try{
				$insert = "INSERT into `lista_triagem` (id_assist,data,estado,convenio)
				VALUES (:id_assist, :data, :nivel_triagem, :convenio)";
				$result = $conexao->prepare($insert);
				$result->bindParam(':id_assist', $id_assist, PDO::PARAM_INT);
				$result->bindParam(':data', $data, PDO::PARAM_STR);
				$result->bindParam(':nivel_triagem', $nivel_triagem, PDO::PARAM_STR);
				$result->bindParam(':convenio', $convenio, PDO::PARAM_STR);
				$result->execute();
			}catch(PDOException $e){echo $e;}


			$insert = "INSERT into `assist_resp` (id_assist, cpf, tipo)	VALUES (:numId, :cpf, :tipo)";
			try{
				$result = $conexao->prepare($insert);
				$result->bindParam(':numId', $numId, PDO::PARAM_STR);
				$result->bindParam(':cpf', $cpf, PDO::PARAM_STR);
				$result->bindParam(':tipo', $tipo, PDO::PARAM_STR);
				$result->execute();
				$contar = $result->rowCount();				
				header("Location: inicio");
			}
			catch(PDOException $e){
				echo $e;}


			}else{
				// DADOS DO RESPONSÁVEL
				$nome_tipo=trim(strip_tags($_POST['nome_tipo']));
				$rg=trim(strip_tags($_POST['rg']));
				$data_nasc=trim(strip_tags($_POST['data_nasc']));
				$dependentes=trim(strip_tags($_POST['dependentes']));
				$telefone=trim(strip_tags($_POST['telefone']));
				$escolaridade=trim(strip_tags($_POST['escolaridade']));
				$profissao=trim(strip_tags($_POST['profissao']));

				$insert = "INSERT into `assistidos` (nome, imagem, datanasc, naturalidade, obs, folha, livro, datareg, cartorio, ncertidao, rua, numero, cidade, bairro, complemento, nis, cep, escola, pasta)
				VALUES (:nome, :imagem, :datanasc, :naturalidade, :obs,  :folha, :livro, :datareg, :cartorio, :ncertidao, :rua, :numero, :cidade, :bairro, :complemento, :nis, :cep, :escola, :pasta)";
				try{
					$result = $conexao->prepare($insert);
					$result->bindParam(':nome', $nome, PDO::PARAM_STR);
					$result->bindParam(':imagem', $novoNome, PDO::PARAM_STR);
					$result->bindParam(':datanasc', $datanasc, PDO::PARAM_STR);
					$result->bindParam(':naturalidade', $naturalidade, PDO::PARAM_STR);
					$result->bindParam(':obs', $obs, PDO::PARAM_STR);
					$result->bindParam(':folha', $folha, PDO::PARAM_STR);
					$result->bindParam(':livro', $livro, PDO::PARAM_STR);
					$result->bindParam(':datareg', $datareg, PDO::PARAM_STR);
					$result->bindParam(':cartorio', $cartorio, PDO::PARAM_STR);
					$result->bindParam(':cartorio', $cartorio, PDO::PARAM_STR);
					$result->bindParam(':ncertidao', $ncertidao, PDO::PARAM_STR);
					$result->bindParam(':rua', $rua, PDO::PARAM_STR);
					$result->bindParam(':numero', $numero, PDO::PARAM_STR);
					$result->bindParam(':cidade', $cidade, PDO::PARAM_STR);
					$result->bindParam(':bairro', $bairro, PDO::PARAM_STR);
					$result->bindParam(':complemento', $complemento, PDO::PARAM_STR);
					$result->bindParam(':nis', $nis, PDO::PARAM_STR);
					$result->bindParam(':cep', $cep, PDO::PARAM_STR);
					$result->bindParam(':escola', $escola, PDO::PARAM_STR);
					$result->bindParam(':pasta', $pasta, PDO::PARAM_STR);
					$result->execute();
					$contar = $result->rowCount();
					$numId = $conexao->lastInsertId();
				}catch(PDOException $e){echo $e;}

	//INSERINDO DADOS RESPONSÁVEL		
				$insert = "INSERT into `resp` (nome, cpf, rg, datanasc, dependentes, telefone, escolaridade, profissao)
				VALUES (:nome_tipo, :cpf, :rg, :data_nasc, :dependentes, :telefone, :escolaridade, :profissao)";
				try{
					$result = $conexao->prepare($insert);
					$result->bindParam(':nome_tipo', $nome_tipo, PDO::PARAM_STR);
					$result->bindParam(':cpf', $cpf, PDO::PARAM_STR);
					$result->bindParam(':rg', $rg, PDO::PARAM_STR);
					$result->bindParam(':data_nasc', $data_nasc, PDO::PARAM_STR);
					$result->bindParam(':dependentes', $dependentes, PDO::PARAM_STR);
					$result->bindParam(':telefone', $telefone, PDO::PARAM_STR);
					$result->bindParam(':escolaridade', $escolaridade, PDO::PARAM_STR);
					$result->bindParam(':profissao', $profissao, PDO::PARAM_STR);
					$result->execute();
					$contar = $result->rowCount();	
		}catch(PDOException $e){echo $e;}//FIM RESPONSÁVEL
		
		
		$id_prof= $_POST['assistente_social'];
		$convenio= $_POST['convenio'];
		$data= date("Y/m/d");
		$estado= "Presente";
		$id_assist=$numId;
		$id_serv= '6';
		$nivel_triagem = '0';
		
		try{
			$insert = "INSERT into `atendimentos` (id_assist,data,estado,id_prof,id_serv,tipo)
			VALUES (:id_assist, :data, :estado, :id_prof, :id_serv, :tipo)";
			$result = $conexao->prepare($insert);
			$result->bindParam(':id_assist', $id_assist, PDO::PARAM_INT);
			$result->bindParam(':data', $data, PDO::PARAM_STR);
			$result->bindParam(':estado', $estado, PDO::PARAM_STR);
			$result->bindParam(':id_prof', $id_prof, PDO::PARAM_STR);
			$result->bindParam(':id_serv', $id_serv, PDO::PARAM_STR);
			$result->bindParam(':tipo', $convenio, PDO::PARAM_STR);
			$result->execute();
		}catch(PDOException $e){echo $e;}

		try{
			$insert = "INSERT into `lista_triagem` (id_assist,data,estado,convenio)
			VALUES (:id_assist, :data, :nivel_triagem, :convenio)";
			$result = $conexao->prepare($insert);
			$result->bindParam(':id_assist', $id_assist, PDO::PARAM_INT);
			$result->bindParam(':data', $data, PDO::PARAM_STR);
			$result->bindParam(':nivel_triagem', $nivel_triagem, PDO::PARAM_STR);
			$result->bindParam(':convenio', $convenio, PDO::PARAM_STR);
			$result->execute();
		}catch(PDOException $e){echo $e;}



			//INSERINDO NA CHAVE ESTRANGEIRA//
		$insert = "INSERT into `assist_resp` (id_assist, cpf, tipo)	VALUES (:numId, :cpf, :tipo)";
		try{
			$result = $conexao->prepare($insert);
			$result->bindParam(':numId', $numId, PDO::PARAM_STR);
			$result->bindParam(':cpf', $cpf, PDO::PARAM_STR);
			$result->bindParam(':tipo', $tipo, PDO::PARAM_STR);
			$result->execute();
			$contar = $result->rowCount();
			header("Location: inicio");
		}catch(PDOException $e){echo $e;} //FIM CHAVE ESTRANGEIRA
	}
}else{
	echo "Tivemos algum problema, informe o responsável.";exit;
}

?>
