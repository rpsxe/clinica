<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Atualizar</title>
<body>
	<?php 
	include ("cabecalho.php");
	if(!isset($_GET['id'])){
		header("Location: home.php"); 
		exit;
	}
	$id=$_GET['id'];
	$select = "SELECT * FROM `assist_resp` WHERE id_assist=:id";
	try{
		$result=$conexao->prepare($select);
		$result->bindParam(':id', $id, PDO::PARAM_INT);
		$result->execute();
		$contar= $result->rowCount();
		if($contar>0){
			while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
				$fk_id = $linha->id;
				$idNum = $linha->id_assist;
				$cpfNum = $linha->cpf;
				$tipo = $linha->tipo;
			}
		}
	}catch(PDOException $e){
		echo $e;
	}

	$select = "SELECT * FROM `assistidos` WHERE id_assist=:idNum";
	try{
		$result=$conexao->prepare($select);
		$result->bindParam(':idNum', $idNum, PDO::PARAM_INT);
		$result->execute();
		$contar= $result->rowCount();
		if($contar>0){
			while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
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
				$pasta=$linha->pasta;
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
				$idResp=$linha->id_resp;
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

	if(isset($_POST['atualizar'])){
		$nome=trim(strip_tags($_POST['nome'])); 
		$datanasc=trim(strip_tags($_POST['datanasc'])); 
		$naturalidade =trim(strip_tags($_POST['naturalidade'])); 
		$obs =trim(strip_tags($_POST['obs']));  
		$folha =trim(strip_tags($_POST['folha'])); 
		$livro =trim(strip_tags($_POST['livro'])); 
		$datareg =trim(strip_tags($_POST['datareg'])); 
		$cartorio =trim(strip_tags($_POST['cartorio'])); 
		$ncertidao =trim(strip_tags($_POST['ncertidao']));  
		$rua =trim(strip_tags($_POST['rua'])); 
		$numero =trim(strip_tags($_POST['numero'])); 
		$cidade =trim(strip_tags($_POST['cidade'])); 
		$bairro=trim(strip_tags($_POST['bairro'])); 
		$complemento=trim(strip_tags($_POST['complemento'])); 
		$nome_tipo=trim(strip_tags($_POST['nome_tipo']));
		$cpf=trim(strip_tags($_POST['cpf']));
		$rg=trim(strip_tags($_POST['rg']));
		$data_nasc=trim(strip_tags($_POST['data_nasc_resp']));
		$dependentes=trim(strip_tags($_POST['dependentes']));
		$telefone=trim(strip_tags($_POST['telefone']));
		$escolaridade=trim(strip_tags($_POST['escolaridade']));
		$profissao=trim(strip_tags($_POST['profissao']));
		$tipo=trim(strip_tags($_POST['tipo']));
		$nis =trim(strip_tags($_POST['nis']));
		$cep =trim(strip_tags($_POST['cep']));	
		$escola =trim(strip_tags($_POST['escola']));
		$pasta =trim(strip_tags($_POST['pasta']));
		$novoNome = $imagem;
		
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
			
			if($cimg == 1){ // INICIO IF
				imagejpeg($imagem_redimensionada, $diretorio.$novoNome);
					$arquivo = "upload/" .$imagem; //PASTA ONDE ESTÃO AS FOTOS
					if($imagem == "imagem_padrao.png"){}else{
						unlink($arquivo);
					}
				}else{ // FIM IF - INICIO ELSE
					imagepng($imagem_redimensionada, $diretorio.$novoNome);
					$arquivo = "upload/" .$imagem; //PASTA ONDE ESTÃO AS FOTOS
					if($imagem == "imagem_padrao.png"){}else{
						unlink($arquivo);
					}
					} // FIM ELSE
				}else{
					$novoNome = $imagem;
				}


						//INSERINDO DADOS
				$update = "UPDATE `assistidos` SET nome=:nome, imagem=:imagem, datanasc=:datanasc, naturalidade=:naturalidade, obs=:obs, folha=:folha, livro=:livro, datareg=:datareg, 
				cartorio=:cartorio, ncertidao=:ncertidao, rua=:rua, numero=:numero, cidade=:cidade, bairro=:bairro, complemento=:complemento, cep=:cep, nis=:nis, escola=:escola, pasta=:pasta WHERE id_assist=:id";
				try{
					$result = $conexao->prepare($update);
					$result->bindParam(':id', $id, PDO::PARAM_INT);
					$result->bindParam(':nome', $nome, PDO::PARAM_STR);
					$result->bindParam(':imagem', $novoNome, PDO::PARAM_STR);
					$result->bindParam(':datanasc', $datanasc, PDO::PARAM_STR);
					$result->bindParam(':naturalidade', $naturalidade, PDO::PARAM_STR);
					$result->bindParam(':obs', $obs, PDO::PARAM_STR);
					$result->bindParam(':folha', $folha, PDO::PARAM_STR);
					$result->bindParam(':livro', $livro, PDO::PARAM_STR);
					$result->bindParam(':datareg', $datareg, PDO::PARAM_STR);
					$result->bindParam(':cartorio', $cartorio, PDO::PARAM_STR);
					$result->bindParam(':ncertidao', $ncertidao, PDO::PARAM_STR);
					$result->bindParam(':rua', $rua, PDO::PARAM_STR);
					$result->bindParam(':numero', $numero, PDO::PARAM_STR);
					$result->bindParam(':cidade', $cidade, PDO::PARAM_STR);
					$result->bindParam(':bairro', $bairro, PDO::PARAM_STR);
					$result->bindParam(':complemento', $complemento, PDO::PARAM_STR);
					$result->bindParam(':cep', $cep, PDO::PARAM_STR);
					$result->bindParam(':nis', $nis, PDO::PARAM_STR);
					$result->bindParam(':escola', $escola, PDO::PARAM_STR);
					$result->bindParam(':pasta', $pasta, PDO::PARAM_STR);
					$result->execute();
					$contar = $result->rowCount();
					echo '<div class="alert alert-success">
					<strong>Sucesso!</strong> 
					Aguarde o redirecionamento.
					</div>'; 
					header ("Refresh: 1, home.php");
				}
				catch(PDOException $e){
					echo $e;}

					$update = "UPDATE `resp` SET nome=:nome_tipo, cpf=:cpf, rg=:rg, datanasc=:data_nasc, dependentes=:dependentes, telefone=:telefone, escolaridade=:escolaridade, profissao=:profissao WHERE id_resp=:idResp";
					try{
						$result = $conexao->prepare($update);
						$result->bindParam(':idResp', $idResp, PDO::PARAM_INT);
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
					}
					catch(PDOException $e){
						echo $e;}
						$update = "UPDATE `assist_resp` SET tipo=:tipo WHERE id=:fk_id";
						try{
							$result = $conexao->prepare($update);
							$result->bindParam(':fk_id', $fk_id, PDO::PARAM_INT); 
							$result->bindParam(':tipo', $tipo, PDO::PARAM_STR);
							$result->execute();
							$contar = $result->rowCount();
						}
						catch(PDOException $e){
							echo $e;}					
						}

			//Atribuindo - no lugar dos espaços no nome para a U
						$Nvnome = implode('-', explode(' ', $nome));
						?>

						<div class="container-fluid text-center">    
							<div class="row content">
								<div class="col-sm-2 sidenav">
								</div>
								<div class="col-sm-8 text-left" style="background: white;"> <br>
									<h1><?php echo $nome; ?></h1>
									<a href="inicio">Inicio</a> > <a href="registros">Registros</a> > <a href="p<?php echo $Nvnome; ?>-<?php echo $id; ?>"><?php echo $nome; ?></a> > Atualizar
									<hr>
									<h1>1. DADOS PESSOAIS <button type="button" class="btn btn-default" title="Infos" data-toggle="collapse" data-target="#dpes">+</button></h1>
									<hr>
									<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
										<div id="dpes" class="collapse">
											<div class="form-group">
												<label class="control-label col-sm-2" for="nome">Nome <span style="color:red">*</span></label>
												<div class="col-sm-10">
													<input type="text" class="form-control" name="nome" id="email" required value="<?php echo $nome; ?>">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-2" for="foto">Foto </label>
												<div class="col-sm-10"> 
													<input type="file" name="img" class="form-control" capture >
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-2" for="data de nascimento">Data de Nascimento <span style="color:red">*</span></label>
												<div class="col-sm-10">
													<input type="date"  name="datanasc" value="<?php echo $datanasc; ?>" class="form-control" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-2" for="número de certidão">Número de Certidão <span style="color:red">*</span></label>
												<div class="col-sm-10"> 
													<input type="text" value="<?php echo $ncertidao; ?>" onkeyup="somenteNumeros(this);" name="ncertidao" size="13" maxlength="13" placeholder="Número certidão (OBRIGATÓRIO)" required class="form-control">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-2" for="nis">NIS <span style="color:red">*</span></label>
												<div class="col-sm-10">
													<input type="text" onkeyup="somenteNumeros(this);"  value="<?php echo $nis; ?>" name="nis" size="12" maxlength="12" placeholder="NIS (OBRIGATÓRIO)" required class="form-control">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-2" for="escola">Escola <span style="color:red">*</span></label>
												<div class="col-sm-10"> 
													<input type="text" name="escola" value="<?php echo $escola; ?>" placeholder="Escola" required class="form-control">
												</div>
											</div>	  
											<div class="form-group">
												<label class="control-label col-sm-2" for="naturalidade">Naturalidade <span style="color:red">*</span></label>
												<div class="col-sm-10">
													<input type="text" name="naturalidade" value="<?php echo $naturalidade; ?>" placeholder="Naturalidade" required class="form-control">
												</div>
											</div> 
											<div class="form-group">
												<label class="control-label col-sm-2" for="pasta">Pasta <span style="color:red">*</span></label>
												<div class="col-sm-10">
													<input type="text" name="pasta" value="<?php echo $pasta; ?>" placeholder="Naturalidade" required class="form-control">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-2" for="observação">Observação</label>
												<div class="col-sm-10">
													<textarea class="form-control" name="obs" placeholder="Observação..." style="resize:vertical;"><?php echo $obs; ?></textarea>
												</div>
											</div>
											<span style="color:red">*</span> Obrigatório
										</div>
										<h1>2. DADOS RESPONSÁVEL <button type="button" class="btn btn-default" title="Infos" data-toggle="collapse" data-target="#dres">+</button></h1>
										<hr>
										<div id="dres" class="collapse">
											<div class="form-group">
												<label class="control-label col-sm-2" >Nome </label>
												<div class="col-sm-10">
													<input type="text"   name="nome_tipo" value="<?php echo $nome_tipo;?>" placeholder="Inserir nome completo (OBRIGATÓRIO)" class="form-control">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-2" for="pwd">RG </label>
												<div class="col-sm-10"> 
													<input type="text" onkeyup="somenteNumeros(this);" value="<?php echo $rg;?>" name="rg" size="10" maxlength="10" placeholder="Número RG" class="form-control" >
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-2" >CPF <span style="color:red">*</span></label>
												<div class="col-sm-10">
													<input type="text" onkeyup="somenteNumeros(this);" value="<?php echo $cpf;?>" name="cpf" size="11" maxlength="11" placeholder="Número CPF (OBRIGATÓRIO)" required class="form-control" >
													<input type="checkbox" name="existe" value="1" style="width: 15px; height: 15px;">Responsável já cadastrado
													<a href="javascript:void(0)" onclick="window.open('consulta.php', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=770, HEIGHT=400');" style="float: right;"><u style="color: black;">Consultar CPF</u></a>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-2" for="pwd">Dependentes </label>
												<div class="col-sm-10"> 
													<input type="text"   name="dependentes" value="<?php echo $dependentes;?>" placeholder="Dependentes" class="form-control" >
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-2" >Grau <span style="color:red">*</span></label>
												<div class="col-sm-10">
													<select class="form-control"  name="tipo">
														<option selected><?php echo $tipo; ?></option>
														<?php if($tipo!='Pai'){ echo '<option value="Pai">Pai</option>'; }?>
														<?php if($tipo!='Mãe'){ echo '<option value="Mãe">Mãe</option>'; }?>
														<?php if($tipo!='Responsável'){ echo '<option value="Responsável">Responsável</option>'; }?>
													</select>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="pwd">Data de Nascimento </label>
											<div class="col-sm-10"> 
												<input type="date" name="data_nasc_resp" value="<?php echo $data_nasc;?>" class="form-control">
											</div>
										</div>	  
										<div class="form-group">
											<label class="control-label col-sm-2" >Telefone <span style="color:red">*</span></label>
											<div class="col-sm-10">
												<input type="text" onkeyup="somenteNumeros(this);" value="<?php echo $telefone;?>" name="telefone" size="11" maxlength="11" placeholder="xx xxxx xxxx (OBRIGATÓRIO)" class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="pwd">Escolaridade </label>
											<div class="col-sm-10"> 
												<input type="text" name="escolaridade" value="<?php echo $escolaridade;?>" placeholder="Insira o grau de escolaridade" class="form-control">
											</div>
										</div>	  
										<div class="form-group">
											<label class="control-label col-sm-2" >Profissão </label>
											<div class="col-sm-10">
												<input type="text" name="profissao" value="<?php echo $profissao;?>" placeholder="Insira a profissão" class="form-control">
											</div>
										</div>
										<span style="color:red">*</span> Obrigatório
									</div>
									<h1>3. DADOS CARTÓRIO <button type="button" class="btn btn-default" title="Infos" data-toggle="collapse" data-target="#cart">+</button></h1>
									<hr>
									<div id="cart" class="collapse">
										<div class="form-group">
											<label class="control-label col-sm-2" >Nome Cartório <span style="color:red">*</span></label>
											<div class="col-sm-10">
												<input type="text"   name="cartorio" value="<?php echo $cartorio; ?>" placeholder="Nome do Cartório"  required class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="pwd">Folha <span style="color:red">*</span></label>
											<div class="col-sm-10"> 
												<input type="text"   name="livro" placeholder="Livro" value="<?php echo $folha; ?>" required class="form-control" >
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" >Livro <span style="color:red">*</span></label>
											<div class="col-sm-10">
												<input type="text" name="folha" placeholder="Folha" value="<?php echo $livro; ?>" required class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="pwd">Data <span style="color:red">*</span></label>
											<div class="col-sm-10"> 
												<input type="date" name="datareg" value="<?php echo $datareg; ?>" required class="form-control">
											</div>
										</div>
										<span style="color:red">*</span> Obrigatório
									</div>
									<h1>4. ENDEREÇO <button type="button" class="btn btn-default" title="Infos" data-toggle="collapse" data-target="#end">+</button></h1>
									<hr>

									<div id="end" class="collapse">
										<div class="form-group">
											<label class="control-label col-sm-2" >Rua <span style="color:red">*</span></label>
											<div class="col-sm-10">
												<input type="text"   name="rua" value="<?php echo $rua; ?>" placeholder="Inserir nome rua" required class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="pwd">Número <span style="color:red">*</span></label>
											<div class="col-sm-10"> 
												<input type="text"   name="numero" value="<?php echo $numero; ?>" size="6" maxlength="6" placeholder="xxx" required class="form-control" >
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" >Bairro <span style="color:red">*</span></label>
											<div class="col-sm-10">
												<input type="text"   name="bairro" value="<?php echo $bairro; ?>" placeholder="Inserir nome bairro" required class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="pwd">Complemento </label>
											<div class="col-sm-10"> 
												<input type="text"   name="complemento" value="<?php echo $complemento; ?>" placeholder="Inserir complemento" class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="pwd">Cidade <span style="color:red">*</span></label>
											<div class="col-sm-10"> 
												<input type="text"   name="cidade" value="<?php echo $cidade; ?>" placeholder="Inserir nome cidade" required class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="pwd">CEP <span style="color:red">*</span></label>
											<div class="col-sm-10"> 
												<input type="text" onkeyup="somenteNumeros(this);" value="<?php echo $cep; ?>" name="cep" size="9" maxlength="9" placeholder="Inserir CEP" required class="form-control">
											</div>
										</div> 
										<span style="color:red">*</span> Obrigatório	  
									</div>
									<center><button type="submit" class="btn" name="atualizar">Enviar</button>
									</form>
								</div>
								<br>
							</div>
						</div>

						<script>
							function somenteNumeros(num) {
								var er = /[^0-9.]/;
								er.lastIndex = 0;
								var campo = num;
								if (er.test(campo.value)) {
									campo.value = "";
								}
							}
						</script>