<br><center>
	<h4>Lista de Alunos</h4>
	<form method="post" id="agenda" action="lista-alunos-processa.php">
		<?php 
		include("includes/select.php"); 
		include("includes/prof.php");
		?>
		<select class="form-control"  name="mes">
			<option value="1">Janeiro</option>
			<option value="2">Fevereiro</option>
			<option value="3">Março</option>
			<option value="4">Abril</option>
			<option value="5">Maio</option>
			<option value="6">Junho</option>
			<option value="7">Julho</option>
			<option value="8">Agosto</option>
			<option value="9">Setembro</option>
			<option value="10">Outubro</option>
			<option value="11">Novembro</option>
			<option value="12">Dezembro</option>
		</select>

		<select class="form-control"  name="conv">
			<option value="SMED">SMED</option>
			<option value="Assistencia">Assistência</option>
			<option value="Saúde">Saúde</option>
			<option value="CLuz">Caminho da Luz</option>
		</select><br>
		<input type="submit" class="btn" name="envia" value="Enviar">
	</center>

</form>