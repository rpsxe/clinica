<?php 
include("conecta/conexao.php");
$dia = $_POST['dia'];
$hora = $_POST['hora'];
$id_assist = $_POST['id_assist'];

$numCont = strlen($hora);
if ($numCont > 5) {
	echo "<br><div class='alert alert-danger'>
	<strong>Horário Inválido.</strong> O horário que você digitou está incorreto, tente novamente.
	</div>";
}else{
	if ($numCont == 5) {
		if ($hora >= '12:00' AND $hora < '13:30' OR $hora < '08:00' OR $hora >= '17:30') {
			echo "<br><div class='alert alert-danger'>
			<strong>Horário Inválido.</strong> Está fora do horário de funcionamento da Clínica.
			</div>";
		}else{
			// $select = "SELECT * FROM agenda WHERE dia=:dia AND horario=:hora AND id_assist=:id_assist AND ativo='S'";
			// $result=$conexao->prepare($select);
			// $result->bindParam(':dia', $dia, PDO::PARAM_INT);
			// $result->bindParam(':hora', $hora, PDO::PARAM_INT);
			// $result->bindParam(':id_assist', $id_assist, PDO::PARAM_INT);
			// $result->execute();
			// $contar= $result->rowCount();
			// if($contar>0){		
				// echo "<br><div class='alert alert-danger'>
				// <strong>Horário Inválido.</strong> Já existe um atendimento agendado para este horário, tente novamente.
				// </div>";
			// }else{
			 	echo '<b><center><input type="submit" class="btn btn-primary" name="submit" value="Enviar"></center>';
			// }
		}
	}
}
?>