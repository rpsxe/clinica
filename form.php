<title>Cadastrar</title>
<?php include("cabecalho.php"); ?>
<div class="container-fluid text-center">    
	<div class="row content">
		<div class="col-sm-2 sidenav">
		</div>
		<div class="col-sm-8 text-left" style="background: white;"> <br>
			<h1>1. DADOS PESSOAIS <button type="button" class="btn btn-default" title="Clique aqui" data-toggle="collapse" data-target="#dpes">+</button></h1>
			<hr>
			<form class="form-horizontal" method="post" action="insert.php" enctype="multipart/form-data">
				<div id="dpes" class="collapse">
					<div class="form-group">
						<label class="control-label col-sm-2" for="nome">Nome <span style="color:red">*</span></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="nome" id="email" required placeholder="Insira o nome completo">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="foto">Foto <span style="color:red">*</span></label>
						<div class="col-sm-10"> 
							<input type="file" name="img" class="form-control" capture>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="data de nascimento">Data de Nascimento <span style="color:red">*</span></label>
						<div class="col-sm-10">
							<input type="date"  name="datanasc" class="form-control" required>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="número de certidão">Número da Certidão <span style="color:red">*</span></label>
						<div class="col-sm-10"> 
							<input type="text" onkeyup="somenteNumeros(this);" name="ncertidao" size="13" maxlength="13" placeholder="Insira a certidão de nascimento (APENAS NÚMEROS)" required class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="nis">NIS <span style="color:red">*</span></label>
						<div class="col-sm-10">
							<input type="text" onkeyup="somenteNumeros(this);" name="nis" size="12" maxlength="12" placeholder="Insira o NIS (APENAS NÚMEROS)" required class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="escola">Escola <span style="color:red">*</span></label>
						<div class="col-sm-10"> 
							<input type="text" name="escola" placeholder="Insira a escola" required class="form-control">
						</div>
					</div>	  
					<div class="form-group">
						<label class="control-label col-sm-2" for="naturalidade">Naturalidade <span style="color:red">*</span></label>
						<div class="col-sm-10">
							<input type="text" name="naturalidade" placeholder="Insira a naturalidade" required class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="naturalidade">Pasta <span style="color:red">*</span></label>
						<div class="col-sm-10">
							<input type="text" name="pasta" placeholder="Insira o número da pasta" required class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="observação">Observação</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="obs" placeholder="Observação..." style="resize:vertical;"></textarea>
						</div>
					</div>
					<span style="color:red">*</span> Obrigatório
				</div>

				<h1>2. DADOS RESPONSÁVEL <button type="button" class="btn btn-default" title="Clique aqui" data-toggle="collapse" data-target="#dres">+</button></h1>
				<hr>
				<div id="dres" class="collapse">
					<div class="form-group">
						<label class="control-label col-sm-2">Nome <span style="color:red">**</span></label>
						<div class="col-sm-10">
							<input type="text"   name="nome_tipo" placeholder="Insira o nome completo" class="form-control resp" id="nome_resp">				
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="pwd">RG <span style="color:red">**</span></label>
						<div class="col-sm-10"> 
							<input type="text" onkeyup="somenteNumeros(this); "name="rg" size="10" maxlength="10" placeholder="Insira número do RG (APENAS NÚMEROS)" class="form-control resp" id="rg_resp">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="email">CPF <span style="color:red">*</span></label>
						<div class="col-sm-10">
							<input type="text" onkeyup="somenteNumeros(this);"  name="cpf" size="11" maxlength="11" placeholder="Insira número do CPF (APENAS NÚMEROS)" required class="form-control" id="cpf">
							<div class="row">			
								<input type="hidden" name="existe" id="existe"> 								
								<div class="resultado"></div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="pwd">Dependentes </label>
						<div class="col-sm-10"> 
							<input type="text"   name="dependentes" placeholder="Dependentes" class="form-control resp" >
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="email">Grau <span style="color:red">*</span></label>
						<div class="col-sm-10">
							<select class="form-control"  name="tipo">
								<option value="Responsável">Responsável</option>
								<option value="Pai">Pai</option>
								<option value="Mãe">Mãe</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="pwd">Data de Nascimento </label>
						<div class="col-sm-10"> 
							<input type="date" name="data_nasc" class="form-control  resp">
						</div>
					</div>	  
					<div class="form-group">
						<label class="control-label col-sm-2" for="email">Telefone <span style="color:red">**</span></label>
						<div class="col-sm-10">
							<input type="text" onkeyup="somenteNumeros(this);" name="telefone" size="11" maxlength="11" placeholder="xx xxxx xxxx (APENAS NÚMEROS)" class="form-control resp" id="tel_resp">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="pwd">Escolaridade </label>
						<div class="col-sm-10"> 
							<input type="text" name="escolaridade" placeholder="Insira o grau de escolaridade" class="form-control  resp">
						</div>
					</div>	  
					<div class="form-group">
						<label class="control-label col-sm-2" for="email">Profissão </label>
						<div class="col-sm-10">
							<input type="text" name="profissao" placeholder="Insira a profissão" class="form-control  resp">
						</div>
					</div>
					<span style="color:red">*</span> Obrigatório<br>
				</div>
				<h1>3. DADOS CARTÓRIO <button type="button" class="btn btn-default" title="Clique aqui" data-toggle="collapse" data-target="#cart">+</button></h1>
				<hr>
				<div id="cart" class="collapse">
					<div class="form-group">
						<label class="control-label col-sm-2" for="email">Nome Cartório <span style="color:red">*</span> </label>
						<div class="col-sm-10">
							<input type="text"   name="cartorio" placeholder="Nome do Cartório"  required class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="pwd">Folha <span style="color:red">*</span> </label>
						<div class="col-sm-10"> 
							<input type="text"   name="livro" placeholder="Livro de registro"  required class="form-control" >
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="email">Livro <span style="color:red">*</span> </label>
						<div class="col-sm-10">
							<input type="text" name="folha" placeholder="Folha de registro"  required class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="pwd">Data <span style="color:red">*</span> </label>
						<div class="col-sm-10"> 
							<input type="date" name="datareg"  required class="form-control">
						</div>
					</div>
					<span style="color:red">*</span> Obrigatório
				</div>
				<h1>4. ENDEREÇO <button type="button" class="btn btn-default" title="Clique aqui" data-toggle="collapse" data-target="#end">+</button></h1>
				<hr>

				<div id="end" class="collapse">
					<div class="form-group">
						<label class="control-label col-sm-2" for="email">Rua <span style="color:red">*</span> </label>
						<div class="col-sm-10">
							<input type="text"   name="rua" placeholder="Insera o nome da rua" required class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="pwd">Número <span style="color:red">*</span> </label>
						<div class="col-sm-10"> 
							<input type="text"   name="numero" size="6" maxlength="6" placeholder="xxx" required class="form-control" >
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="email">Bairro <span style="color:red">*</span> </label>
						<div class="col-sm-10">
							<input type="text"   name="bairro" placeholder="Insira o nome do bairro" required class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="pwd">Complemento </label>
						<div class="col-sm-10"> 
							<input type="text"   name="complemento" placeholder="Insera o complemento" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="pwd">Cidade <span style="color:red">*</span> </label>
						<div class="col-sm-10"> 
							<input type="text"   name="cidade" placeholder="Insera o nome da cidade" required class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="pwd">CEP <span style="color:red">*</span> </label>
						<div class="col-sm-10"> 
							<input type="text" onkeyup="somenteNumeros(this);"  name="cep" size="9" maxlength="9" placeholder="Insera o CEP (APENAS NÚMEROS)" required class="form-control">
						</div>
					</div>  
					<span style="color:red">*</span> Obrigatório
				</div>
				
				<h1>5. ASSISTENTE SOCIAL <button type="button" class="btn btn-default" title="Clique aqui" data-toggle="collapse" data-target="#assoc">+</button></h1>
				<hr>

				<div id="assoc" class="collapse">

					<label class="control-label col-sm-2" for="email">Selecione <span style="color:red">*</span></label>
					<div class="col-sm-10">
						<select class="form-control"  name="assistente_social" required="">
							<option selected disabled> </option>
							<?php 
							require_once('conecta/conexao.php');
							$select = "SELECT prof_serv.*, profissionais.nome as nome_profissional, profissionais.id = id_prof
							FROM ((prof_serv
							INNER JOIN profissionais ON prof_serv.id_prof = profissionais.id) 
							INNER JOIN servicos ON prof_serv.id_serv = servicos.id) WHERE servicos.id='6' AND profissionais.ver='0'";
							$result=$conexao->prepare($select);
							$result->execute();
							$contar= $result->rowCount();
							if($contar>0){ $num=$contar;
								while ($linha = $result->FETCH(PDO::FETCH_OBJ)) { 
									?>
									<option value="<?php echo $linha->id_prof; ?>"><?php echo $linha->nome_profissional; ?></option>
									<?php
								}	// FIM IF COMPARAR
							} 
							?>
						</select>
					</div>
					<br><br>
					<label class="control-label col-sm-2" for="email">Convênio <span style="color:red">*</span></label>
					<div class="col-sm-10">
						<select name="convenio" class="form-control" required>
							<option selected disabled> </option>
							<option value="Saúde">Saúde</option>
							<option value="SMED">Educação</option>
							<option value="Centro">Centro</option>
							<option value="Candiota">Candiota</option>
							<option value="Unimed">UNIMED</option>
							<option value="Assistencia">Assistência</option>
							<option value="CLuz">Caminho da Luz</option>
							<option value="EJudicial">Encaminhamento Judicial</option>
						</select>
					</div>

				</div>

				<br><br>
				<center><button type="submit" class="btn">Enviar</button>
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
		$("#cpf").blur(function(){
			var numero1 = $("#cpf").val();
			$.post("consulta.php", {cpf:numero1}, function(retorno){
				$(".resultado").html(retorno)

			});
		})
	</script>