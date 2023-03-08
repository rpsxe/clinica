<?php 
include("conecta/conexao.php");

$cpf = $_POST['cpf'];
$select = "SELECT * FROM `resp` WHERE cpf=:cpfNum";
try{
  $result=$conexao->prepare($select);
  $result->bindParam(':cpfNum', $cpf, PDO::PARAM_INT);
  $result->execute();
  $contar= $result->rowCount();
  if($contar>0){
    while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
      echo '<span style="color: red">Responsável já cadastrado</span>';
      echo "<script>
      $('#existe').val(1);
      $('#nome_resp').val('".$linha->nome."');
      $('#rg_resp').val('".$linha->rg."');
      $('#tel_resp').val('".$linha->telefone."');
      $('.resp').attr('readonly', true);
      </script>";
    }
  }else{
    echo '<span style="color: red">Responsável sem cadastro</span>';
    echo "<script>
    $('#existe').val(0);
    $('#nome_resp').val('').attr('disabled', false);
    $('#rg_resp').val('').attr('disabled', false);
    $('#tel_resp').val('').attr('disabled', false);
    $('.resp').attr('disabled', false);
    </script>";
  }
}catch(PDOException $e){
  echo $e;
}

?>