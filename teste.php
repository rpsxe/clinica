<div class="row" >
	<div class="col-sm-3"><p>Consultar Atendimentos: </p></div>
	<div class="col-sm-3"><input type="date" name="data" id="date"></div>
	<div class="col-sm-3"><p>Intervalo de dias: </p></div>
	<div class="col-sm-2"><input type="number" min="1" max="50" name="tempo" id="tempo" value="7"></div>
	<div class="col-sm-1"> <button type='button' class='btn btn-default' id="btnToggle">+</button></div>
</div><hr>
<input type="hidden" name="prof" id="prof" value="<?php echo $profissionais;?>">
<div class="resultado"></div>
<script>

	$("#date").change(function(){
		var numero1 = $("#date").val();
		var numero2 = $("#prof").val()
		var numero3 = $("#tempo").val()
		$.post("teste1.php", {date:numero1, prof:numero2, tempo:numero3}, function(retorno){
			$(".resultado").html(retorno)

		});
	})	
	$("#tempo").change(function(){
		var numero1 = $("#date").val();
		var numero2 = $("#prof").val()
		if($("#tempo").val() == ""){
			$("#tempo").val("7");
		}
		var numero3 = $("#tempo").val()
		$.post("teste1.php", {date:numero1, prof:numero2, tempo:numero3}, function(retorno){
			$(".resultado").html(retorno)

		});
	})
	$( "#btnToggle" ).click(function() {
		$( ".resultado" ).toggle( "slow" );
	});
</script>