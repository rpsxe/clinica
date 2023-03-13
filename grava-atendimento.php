<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registro de Atendimento</title>
</head>
<body>
	<?php
	require_once '_action/functions.php';
	include ("cabecalho.php");
	include ("logs/logs.php");

	$crud = new Crud();

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$d = date("N");
		if (isset($_POST['data'])) {
			if (strtotime($data = $_POST['data']) !== false) {
				$data = $_POST['data'];
			} else {
				$data = date_create()->format('Y-m-d');
			}
		}else{
			$data = date_create()->format('Y-m-d');
		}
		$estado = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
		$id_assist = filter_input(INPUT_POST, 'id_assist', FILTER_SANITIZE_NUMBER_INT);
		$id_prof = filter_input(INPUT_POST, 'id_prof', FILTER_SANITIZE_NUMBER_INT);
		$id_serv = filter_input(INPUT_POST, 'id_serv', FILTER_SANITIZE_NUMBER_INT);
		$tipo = filter_input(INPUT_POST, 'conv', FILTER_SANITIZE_STRING);
		if (isset($_POST['id_agenda'])) {
			$id_agenda = filter_input(INPUT_POST, 'id_agenda', FILTER_SANITIZE_NUMBER_INT);

		}else{
			$id_agenda = null;
		}
	//Se ele estiver sendo desligado vai mudar o seu ativo de "sim" para "não" fazendo o mesmo sumir da agenda;
		if($estado=="Desligado" OR $estado=="Alta")
		{
			$ativo="N";
			include ("header/agenda-up-desliga.php");
		}

		$data = [
			"id_assist" => $id_assist,
			"data" => $data,
			"estado" => $estado,
			"id_prof" => $id_prof,
			"id_serv" => $id_serv,
			"tipo" => $tipo,
			"obs" => $id_agenda
		];
		$crud->create("atendimentos", $data);

		if ($estado == "Falta") {
			$faltas = $crud->verificarFaltas($id_assist);
			if($faltas >= 3) {
				$registros = $crud->read("assistidos", $id_assist, "id_assist");
				$_SESSION['mensagem'] = 'O assistido <strong>' . $registros["nome"] . '</strong> teve três ou mais faltas nos últimos 5 atendimentos.';
				$_SESSION['numero_atendimentos'] = 1;
				$_SESSION['id_assist'] = $id_assist;
			}else{
				header ("Refresh: 0, relatorio"); die; exit;
			}
		}

 // redirecionar o usuário para a mesma página
		header("Location: {$_SERVER['REQUEST_URI']}", true, 303);
		exit();
	}
	?>
	<?php 
	if (isset($_SESSION['numero_atendimentos'])) {
		?>
		<div class="container table-responsive">
			<table class="table">
				<thead style="background: white;">
					<tr >
						<th>Atendimento</th>
						<th>Profissional</th>
						<th>Data</th>
						<th>Convênio</th>
						<th>Estado</th>
					</tr>
				</thead>
				<tbody>
					<br>
					<p ><?php echo $_SESSION['mensagem']; ?><br>Abaixo estão listados os últimos atendimentos do mesmo.</p>
					<?php 
					$historico = $crud->pegarHistoricoAtendimentos( $_SESSION['id_assist']);
					foreach($historico as $row) {
						switch ($row['estado']) {
							case "Presente":
							$class_td = 'class="success"';
							break;
							case "Falta":
							$class_td = 'class="danger"';
							break;
							case "Inserido":
							$class_td = 'class="active"';
							break;
							case "Falta Justificada":
							$class_td = 'class="warning"';
							break;
							case "Desligado":
							$class_td = 'class="info"';
							break;
							default:
							break;
						};
						echo '<tr '.
						$class_td
						.' >';
						echo '<td>' . $row['servico_nome'] . '</td>';
						echo '<td>' . $row['profissional_nome'] . '</td>';
						echo '<td>' . date('d/m/Y', strtotime($row['data'])) . '</td>';
						echo '<td>' . $row['tipo'] . '</td>';
						echo '<td>' . $row['estado'] . '</td>';
						echo '</tr>';

						?>

					<?php	}
					echo '	</table>
					</div>';
				}else{
					header ("Refresh: 0, relatorio");
				}
				unset($_SESSION['mensagem']);
				unset($_SESSION['numero_atendimentos']);
				unset($_SESSION['id_assist']);
				?>
			</body>
			</html>