<!-- 

	Página de Login
	Aqui será realizado o login para entrar no sistema, os campos aqui preenchidos serão enviados para 
	o arquivo de validação "valida.php" e caso a 'senha' e o 'login' estejam corretos o usuário será
	redirecionado para a página home

-->
<style>
<?php 
$r = (rand(1,10)); 
?>
body{
   /*background-image: url("img/background<?php echo $r; ?>.jpg");*/
   background-image: url("img/bg.jpg");
   background-size: cover;
}	
</style>
<script>
    function myFunction() {
        var x = document.getElementById("myInput");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>

<?php //página de validação do login
include("valida.php");
?>

<html>
<head>
    <title>LOGIN</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="box">
        <form action="login" method="post" enctype="multipart/form-data">
            <center>
                <div>
                    <input type="text" name="usuario" placeholder="Número da matrícula" required>
                </div>
                <div class="input-group">
                    <input type="password" name="senha" class="form-control" placeholder="Senha" id="myInput" required>
                </div>
                <!-- <input type="checkbox" onclick="myFunction()">Ver Senha -->
                <input type="submit" value="Entrar" name="submit">
                <br>
            </form>
        </div>
    </body>
    </html>