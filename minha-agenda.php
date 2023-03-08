<title>Minha Agenda</title>
<?php 
include("cabecalho.php");
?> 

<div class="modal fade" id="myModal3" role="dialog">
	<div class="modal-dialog">		
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Minha agenda</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="sel1">Selecione o profissional:</label>
					<form action="minha-agenda" method="post">
						<?php include("includes/prof.php"); ?><br>
						<input class="btn" id="btn-envia" type="submit" name="envia" value="Enviar">
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn"><a href="inicio">Voltar</a></button>
			</div>
		</div>
		
	</div>
</div>



<?php
if(isset($_POST['envia'])){
	$profissionais = $_POST['profissionais'];
	include("includes/prof-infos.php");

	$link = "http://192.168.0.99:8080/clinica/pdf.php?p=".$profissionais;
	$aux = 'qr_img0.50j/php/qr_img.php?';
	$aux .= 'd='.$link.'&';
	$aux .= 'e=H&';
	$aux .= 's=10&';
	$aux .= 't=J';
	?>
	<br>
	<div class="container">
		<h1><?php echo $profNome; ?></h1>	
		<br>
		<div class="row">
			<a href="pdf.php?p=<?php echo $profissionais; ?>" target="_blank" style="color: black; padding: 5px;">
				<i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i>
			</a>
			<a data-toggle="collapse" data-target="#infos" style="color: black; padding: 5px;"><i class="fa fa-search fa-2x" aria-hidden="true"></i></a>
		</div>
		<br>
		<hr>
		<div id="infos" class="collapse">
			<?php include("teste.php"); ?>
		</div>
		<div class="row">
			<div class="col-lg-6 text-center" style="padding: 20px;">
				<div class="row">
					<div class="col-lg-6">
						<h1><?php echo $numAgenda; ?></h1>
						Horários marcados
					</div>
					<div class="col-lg-6">
						<h1><?php echo $atd; ?></h1>
						Registros no banco de dados
					</div>
					<div class="col-lg-6">
						<h1>
							<?php echo $rCont; ?>
						</h1>
						Presenças
					</div>
					<div class="col-lg-6">
						<h1><?php echo $rFalta; ?></h1>
						Faltas
					</div>	
					<div class="col-lg-6">
						<h1><?php echo $rFj; ?></h1>
						Faltas justificadas
					</div>
					<div class="col-lg-6">
						<h1>
							<?php echo $desligado; ?>
						</h1>
						Desligados
					</div>			
				</div>				
			</div>
			<div class="col-lg-6 text-center">
				<img src="<?php echo $aux; ?>" style="width: 250px">
			</div>
		</div>
	</div>
	<?php
}else{
	?>
	<script>
		$(document).ready(function() {
			$("#myModal3").modal({backdrop: "static"});
			$('#myModal3').modal('show');
		})
	</script>
	<?php	
}
?>