<title>Área Administrativa</title>
<?php
include("cabecalho.php"); 
$basket=0;$equo=0;$fisio=0;$fono=0;$grp6=0;$grp615=0;$grp15=0;$grpaut=0;$grpjov=0;
$grpmae=0;$hidro=0;$info=0;$merc=0;$nat=0;$ofic=0;$preofi=0;$psicomotricidade=0;$pedagoga=0;
$psico=0;$psiq=0;$sersoc=0;$to=0; $pres = 0; $falta =0;

// AQUI VAI CALCULAR O NÚMERO DE PESSOAS POR SERVIÇOS //

$select = "SELECT agenda.*, profissionais.nome as p_nome, servicos.nome as serv_nome, assistidos.nome as assist_nome
FROM (((agenda
INNER JOIN assistidos ON agenda.id_assist = assistidos.id_assist)
INNER JOIN profissionais ON agenda.id_prof = profissionais.id)
INNER JOIN servicos ON agenda.id_serv = servicos.id) WHERE ativo='S' AND tipo!='Oficinas' AND tipo!='pOficinas' ORDER BY serv_nome ASC";
$result=$conexao->prepare($select);
$result->bindParam(':dia', $dia, PDO::PARAM_INT);
$result->execute();
$contar= $result->rowCount();
if($contar>0){	
	while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
		if($linha->serv_nome == 'Basket/Volei'){$basket++;}
		if($linha->serv_nome == 'Equoterapia'){$equo++;}
		if($linha->serv_nome == 'Fisioterapia'){$fisio++;}
		if($linha->serv_nome == 'Fonoterapia'){$fono++;}
		if($linha->serv_nome == 'Grupo 0 a 6'){$grp6++;}
		if($linha->serv_nome == 'Grupo 6 a 15'){$grp615++;}
		if($linha->serv_nome == 'Grupo Acima 15'){$grp15++;}
		if($linha->serv_nome == 'Grupo Autistas'){$grpaut++;}
		if($linha->serv_nome == 'Grupo de Jovens'){$grpjov++;}
		if($linha->serv_nome == 'Grupo de Mães'){$grpmae++;}
		if($linha->serv_nome == 'Hidrocinesioterapia'){$hidro++;}
		if($linha->serv_nome == 'Informática'){$info++;}
		if($linha->serv_nome == 'Mercado de Trabalho'){$merc++;}
		if($linha->serv_nome == 'Natação'){$nat++;}
		if($linha->serv_nome == 'Oficinas'){$ofic++;}
		if($linha->serv_nome == 'Pré Oficinas'){$preofi++;}
		if($linha->serv_nome == 'Psicomotricidade'){$psicomotricidade++;}
		if($linha->serv_nome == 'Psicopedagogia'){$pedagoga++;}
		if($linha->serv_nome == 'Psicoterapia'){$psico++;}
		if($linha->serv_nome == 'Psiquiatria'){$psiq++;}
		if($linha->serv_nome == 'Serviço Social'){$sersoc++;}
		if($linha->serv_nome == 'Terapia Ocupacional'){$to++;}
	}	
}

?>

<div class="container-fluid">    
	<div class="row content"><div class="col-sm-2" ></div>
	<div class="col-sm-8" style="background: white; padding: 10px;">

		<h2><center>Número de Atendimentos (<?php echo $contar; ?>)</h2>
			<ul class="list-group">
				<li class="list-group-item"><?php echo 'Basket/Volei';?><span class="badge"><?php echo $basket; ?></span></li>
				<li class="list-group-item"><?php echo 'Equoterapia';?><span class="badge"><?php echo $equo; ?></span></li>
				<li class="list-group-item"><?php echo 'Fisioterapia';?><span class="badge"><?php echo $fisio; ?></span></li>
				<li class="list-group-item"><?php echo 'Fonoaudiologia';?><span class="badge"><?php echo $fono; ?></span></li>
				<li class="list-group-item"><?php echo 'Grupo 0 a 6';?><span class="badge"><?php echo $grp6; ?></span></li>
				<li class="list-group-item"><?php echo 'Grupo 6 a 15';?><span class="badge"><?php echo $grp615; ?></span></li>
				<li class="list-group-item"><?php echo 'Grupo acima de 15';?><span class="badge"><?php echo $grp15; ?></span></li>
				<li class="list-group-item"><?php echo 'Grupo de autistas';?><span class="badge"><?php echo $grpaut; ?></span></li>
				<li class="list-group-item"><?php echo 'Grupo de jovens';?><span class="badge"><?php echo $grpjov; ?></span></li>
				<li class="list-group-item"><?php echo 'Grupo de Mães';?><span class="badge"><?php echo $grpmae; ?></span></li>
				<li class="list-group-item"><?php echo 'Hidrocinesioterapia';?><span class="badge"><?php echo $hidro; ?></span></li>
				<li class="list-group-item"><?php echo 'Informática';?><span class="badge"><?php echo $info; ?></span></li>
				<li class="list-group-item"><?php echo 'Mercado de Trabalho';?><span class="badge"><?php echo $merc; ?></span></li>
				<li class="list-group-item"><?php echo 'Natação';?><span class="badge"><?php echo $nat; ?></span></li>
				<li class="list-group-item"><?php echo 'Psicomotricidade';?><span class="badge"><?php echo $psicomotricidade; ?></span></li>
				<li class="list-group-item"><?php echo 'Psicopedagogia';?><span class="badge"><?php echo $pedagoga; ?></span></li>
				<li class="list-group-item"><?php echo 'Psicoterapia';?><span class="badge"><?php echo $psico; ?></span></li>
				<li class="list-group-item"><?php echo 'Psiquiatria';?><span class="badge"><?php echo $psiq; ?></span></li>
				<li class="list-group-item"><?php echo 'Serviço Social';?><span class="badge"><?php echo $sersoc; ?></span></li>
				<li class="list-group-item"><?php echo 'Terapia Ocupacional';?><span class="badge"><?php echo $to; ?></span></li>

				
			</ul>
			
		</div>
	</div>
</div>
<?php include("includes/0a6.php"); ?>