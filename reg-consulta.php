	<?php
	require_once '_action/functions.php';
	// require_once 'cabecalho.php';
	include ("conecta/conexao.php");
	$crud = new Crud();


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
				$mensagem = 'O assistido <strong>' . $registros["nome"] . '</strong> teve três ou mais faltas nos últimos 5 atendimentos.';
				return $mensagem;
			}else{
				header ("Refresh: 0, relatorio"); die; exit;
			}
		}

	?>


			</body>
			</html>