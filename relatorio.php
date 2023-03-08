<title>Relatórios</title>

<?php include("cabecalho.php");

$cont=0;$saude=0;$smed=0;$desliga=0;$falta=0;$fj=0;  $num=0; $ins=0; $dis=0; $alta=0; $pfaus=0;
$ano=date("Y");
$mes = NULL;
$anoBus = NULL;
$vC=0;

//ordernar
if(isset($_GET['ord'])){
	$selec = trim(strip_tags($_GET['ord']));
	$vC++;
}else{};
//pega mês	
if(isset($_GET['m'])){
	if (is_numeric($_GET['m'])){
		if (strlen($_GET['m']) > 2){header("Location: inicio"); exit;}
		$mes = $_GET['m'];
		$vC++;
	}else{
		header("Location: inicio"); exit;
	}
}else{$mes = date('m');};	
//pega ano
if(isset($_GET['a'])){
	if (is_numeric($_GET['a'])){
		if (strlen($_GET['a']) > 4){header("Location: inicio"); exit;}
		$anoBus = $_GET['a'];
		$vC++;
	}else{
		header("Location: inicio"); exit;
	}
}else{$anoBus = date('Y');};

$data = $mes.'/'.$anoBus;
?>
<div class="container text-center">      
	<div class="row content" >
		
		<div class="col-sm-12">
			<div class="jumbotron" style="background: white;">
				<h1 style="font-family: 'IBM Plex Serif', serif;">Relatório de Atividades <button type="button" class="btn btn-default" title="Infos" data-toggle="collapse" data-target="#infos">+</button></h1> 
				<hr>

				<div id="infos" class="collapse">
					<button class="btn btn-default"><a href="imprime-relatorio.php?mes=<?php echo $data; ?>">Relatório Mês</a></button> / <button class="btn btn-default"><a href="includes/lista-assist-mes.php">Assistidos Ativos</a></button> / <button class="btn btn-default"><a href="relatorio-doc?m=<?php echo $data; ?>">Relatório Geral</a></button><br>
					Para selecionar outro mês, preencha o mês no campo abaixo e clique em selecionar.<br><br>
					<form>
						<select name="m" style="height: 30px;" required>
							<option selected disabled></option>
							<option value="01">Janeiro</option>
							<option value="02">Fevereiro</option>
							<option value="03">Março</option>
							<option value="04">Abril</option>
							<option value="05">Maio</option>
							<option value="06">Junho</option>
							<option value="07">Julho</option>
							<option value="08">Agosto</option>
							<option value="09">Setembro</option>
							<option value="10">Outubro</option>
							<option value="11">Novembro</option>
							<option value="12">Dezembro</option>
						</select>
						<select name="a" style="height: 30px;" required>
							<option selected disabled> </option>
							<option value="2018">2018</option>
							<?php 
					//Aqui to deixando automático a mudança de ano, deixei o ano atual como 2018 e quando mudar o ano vai mudar aqui automático sempre gerando um novo option, isso se deve ao contador + while
							$anoAtual="2018";
							while($anoAtual < $ano){
								$anoAtual++;
								echo '<option value="'.$anoAtual.'">'.$anoAtual.'</option>';
							}
							?>
						</select>
						<button class="btn btn-default">Selecionar</button><br><br>
					</form>
					Mostrar: <form>
						<select name="ord" style="height: 30px;" required onchange="form.submit()">
							<option selected disabled> </option>
							<option value="Presente">Presentes</option>
							<option value="Falta">Faltas</option>
							<option value="Falta Justificada">Faltas Justificadas</option>
							<option value="Inserido">Inseridos</option>
							<option value="Desligado">Desligados</option>
							<option value="Alta">Altas</option>
							<option value="Profissional Ausente">Profissionais Ausentes</option>
						</select>
						<input type="hidden" name="m" value="<?php echo $mes;?>">
						<input type="hidden" name="a" value="<?php echo $anoBus;?>">
					</form><hr>
				</div>
				
				
				
				
			</div>
			<center><canvas id="myChart" style="width: 300px"></canvas></center><hr>
			<?php include("includes/relatorios-infos.php"); ?>


			<script src="js/Chart.min.js"></script>
<script>

	var ctx = document.getElementById('myChart').getContext('2d');
	var myPieChart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: ['Presenças', 'Faltas', 'Faltas Justificadas','Desligados','Inseridos','Dispensados', 'Profissional Ausente'],
			datasets: [{
				label: '',
				data: [<?php echo $cont; ?>,  <?php echo $falta; ?>, <?php echo $fj; ?>,<?php echo $desliga; ?>,<?php echo $ins; ?>,<?php echo $dis; ?>,<?php echo $pfaus; ?>],
				backgroundColor: [
				'rgba(54, 162, 235, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 206, 86, 0.2)',
				'rgba(75, 192, 192, 0.2)',
				'rgba(153, 102, 255, 0.2)',
				'rgba(255, 159, 64, 0.2)',
				'rgba(153, 102, 255, 0.2)'
				],
				borderColor: [
				'rgba(54, 162, 235, 1)',
				'rgba(255, 99, 132, 1)',
				'rgba(255, 206, 86, 1)',
				'rgba(75, 192, 192, 1)',
				'rgba(153, 102, 255, 1)',
				'rgba(255, 159, 64, 1)',
				'rgba(153, 102, 255, 1)'
				],
				borderWidth: 1
			}]
		},
		
	});
</script>

</div>
<div class="col-sm-2"></div>
</div>
</div>