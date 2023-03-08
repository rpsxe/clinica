<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
	<link rel="stylesheet" href="//cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">

    <title>Lista de Convênios</title>
  </head>
  <body>
    <table id="myTable"><thead><th>Assistido</th><th>Serviço</th><th>Convênio</th></thead><tbody>

<?php 
require_once('conecta/conexao.php');
$cont = 1;
$verifica = 0;
$select = "SELECT *, assistidos.nome nome, servicos.nome serv_nome, assistidos.autista autista, servicos.id id_serv
FROM((agenda
INNER JOIN assistidos ON agenda.id_assist = assistidos.id_assist)
INNER JOIN servicos ON agenda.id_serv = servicos.id)
WHERE ativo = 'S' ORDER BY tipo, serv_nome, assistidos.nome ASC";
$result = $conexao->prepare($select);
$result->execute();
$contar = $result->rowCount();
if($contar > 0){
	while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
		$id_assist = $linha->tipo;
	if ($id_assist === $verifica) {
			$verifica = $id_assist;
		}else{
$cont = 1;
			$verifica = $id_assist;
		}
		echo '<tr><td>' . $linha->nome . '</td><td>' .$linha->serv_nome. '</td><td>' .$linha->tipo. '</td></tr>';

	}
}
echo '</tbody></table>';
?>
	<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
	<script src="//cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>


<script>
	$(document).ready( function () {
    $('#myTable').DataTable({
    	 dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
} );
</script>
  </body>
</html>