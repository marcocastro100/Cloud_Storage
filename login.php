<?php session_start(); ?>
<html>
<head>
<!------------------------------------Configuration Bootstrap--------------------------->
	<meta charset="utf-8"> <!--Acentuação-->
	<meta name="viewport" content="width=device-width, initial-scale=1"><!--Responsividade(tamanho tela celular)-->
	<link rel="stylesheet" href="css/bootstrap.min.css"><!--Modelo CSS-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src='script.js'></script>
    <link rel='stylesheet' href="css.css">
<!------------------------------------Style CSS-------------------------------------------->    
</head>
<!--**********************************************Verificão de Formulario****************************************-->
<?php
	if(isset($_POST["inputemail"])){	//Condição de primeira visita à pagina para rodar o php
		$conexao = mysqli_connect("localhost","root","790084","repositorio") or die("fail connect"); #Tenta conectar à base de dados e ao banco 'pagin'
        
        $select = "select * from usuario";	//consulta sql da tabela users(usuarios do sistema) pegando o email e password para comparação com os inseridos pelo usuario no sistema
        if($select = mysqli_query($conexao,$select)){
            if (mysqli_num_rows($select) > 0) {	//conta o numero de linhas retornadas da consulta, se for maior que 0 linhas, um loop é feito mostrando o resultado
                while($row = mysqli_fetch_assoc($select)) {	//enquanto houver linhas da consulta ainda não exibidas, a var row assume o conteudo dessas linhas de forma associativa, combinando os resultados em vetores com posições(com nomes dos atributos) da tabela
                    if ($_POST["inputemail"]==$row["email_usuario"] && $_POST["inputpassword"] == $row["senha_usuario"]) //faz a comparação dos dados em formulario(identificados pelos names=input...) obtidos atravez da supervariavel $_GET com os dados retornados do bd, caso um dê match, é exibido a mensagem
                    {
                        //Guarda os dados do usuario autenticado em variaveis de sessão
                        $_SESSION['id_usuario'] = $row['id_usuario'];
                        $_SESSION['nome_usuario'] = $row['nome_usuario'];
                        $_SESSION['cidade_usuario'] = $row['cidade_usuario'];
                        $_SESSION['email_usuario'] = $row['email_usuario'];
                        $_SESSION['senha_usuario'] = $row['senha_usuario'];
                        $_SESSION['feed'] = ""; //variavel de feedback feito em textbox no iframe da pagina de usuario
                        //Redireciona à pagina de usuario
                        echo("<script> alert('Logado com Sucesso!'); window.location.href = 'usuario.php'</script>");
                    }
                }
                echo("<script> alert('login e/ou senha incorretos'); window.location.href = 'login.php'</script>");
            }
            else {
                echo"<script>alert('Não há usuarios cadastrados ainda!'); window.location.href ='cadastro.php'</script>";
            }
        }
	}
?>
<!--******************************************************Conteudo Pagina***************************************-->
<body class="text-center body">
	<div>
	<table width="100%">
		<tr height="500px" style="padding-left:500px" align="center">
			<td>
				<div width="200px" style="width:300px">
					<form action="login.php" target="_self" method="post">
						<img src="logo.png" class="logo"><br>
						<h2>Acesso ao Sistema<br><br></h2>
						<input type="email" name="inputemail" class="form-control" placeholder="Endereço de Email">
						<input type="password" name="inputpassword" class="form-control" placeholder="Senha"><br>
						<button type="submit" class="btn btn-primary btn-block btn-lg" onclick='anima_click(this)'>Acessar</button>
                    </form>
                </div>
                <a href='index.php' class='badge badge-secondary' sytle='margin-top:5px; width:40px; height:50px' onclick='anima_click(this)'>Voltar</a>
			</td>
		</tr>
	</table>
	</div>
</body>
</html>