<title>Relatório de Faltas</title>
<?php 
include("cabecalho.php");
?> 

<div class="container text-center">
	<h1>Relatório de Faltas</h1>
</div>
<br><br>
<div class="container">
<div class="row" >
	<div class="col-sm-3"><p>Consultar Atendimentos: </p></div>
	<div class="col-sm-4"><input type="date" name="data" id="date"></div>
	<div class="col-sm-3"><p>Intervalo de dias: </p></div>
	<div class="col-sm-2"><input type="number" min="1" max="50" name="tempo" id="tempo" value="7"></div>
</div>
</div>
<div class="container resultado"></div>
<script>

	$("#date").change(function(){
		var numero1 = $("#date").val();
		var numero3 = $("#tempo").val()
		$.post("relatorio-faltas-retorno.php", {date:numero1, tempo:numero3}, function(retorno){
			$(".resultado").html(retorno)

		});
	})	
	$("#tempo").change(function(){
		var numero1 = $("#date").val();
		if($("#tempo").val() == ""){
			$("#tempo").val("7");
		}
		var numero3 = $("#tempo").val()
		$.post("relatorio-faltas-retorno.php", {date:numero1, tempo:numero3}, function(retorno){
			$(".resultado").html(retorno)

		});
	})
	$( "#btnToggle" ).click(function() {
		$( ".resultado" ).toggle( "slow" );
	});
</script>