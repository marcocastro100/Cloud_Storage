<?php session_start(); ?>
<html>
<head>
<!------------------------------------Configuration Bootstrap--------------------------->
	<meta charset="utf-8"> <!--Acentuação-->
	<meta name="viewport" content="width=device-width, initial-scale=1"><!--Responsividade(tamanho tela celular)-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"><!--Modelo CSS-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<!------------------------------------Style CSS-------------------------------------------->
	<style>
		table,th,td,span,div{border:0px solid black;}
		.logo{height:70px}
	</style>
</head>
<!--**********************************************Verificão de Formulario****************************************-->
<?php
	if(isset($_GET["inputemail"])){	//Condição de primeira visita à pagina para rodar o php
		$conex = mysqli_connect("localhost","root","790084","pagin") or die("fail connect"); #Tenta conectar à base de dados e ao banco 'pagin'
		
		$select = "select * from users";	//consulta sql da tabela users(usuarios do sistema) pegando o email e password para comparação com os inseridos pelo usuario no sistema
		$select = mysqli_query($conex,$select);	//estabelece a query com o banco de dados

		if (mysqli_num_rows($select) > 0) {	//conta o numero de linhas retornadas da consulta, se for maior que 0 linhas, um loop é feito mostrando o resultado
		// output data of each row
			while($row = mysqli_fetch_assoc($select)) {	//enquanto houver linhas da consulta ainda não exibidas, a var row assume o conteudo dessas linhas de forma associativa, combinando os resultados em vetores com posições(com nomes dos atributos) da tabela
				//echo "Email: ".$row["email"]."<br>-Password: ".$row["password"]."<br><br>";	//Mostra o output dos dados dp bd
				if ($_GET["inputemail"]==$row["email"] && $_GET["inputpassword"] == $row["password"]) //faz a comparação dos dados em formulario(identificados pelos names=input...) obtidos atravez da supervariavel $_GET com os dados retornados do bd, caso um dê match, é exibido a mensagem
				{
					//Guarda os dados do usuario autenticado em variaveis de sessão
					$_SESSION['user_nome'] = $row["nome"];
					$_SESSION['user_cidade'] = $row['cidade'];
					$_SESSION['user_email'] = $row['email'];
					//Redireciona à pagina de usuario
					echo("<script language='javascript' type='text/javascript'> alert('Logado com Sucesso!'); window.location.href = 'usuario.php'</script>");
				}
			}
			echo("<script language='javascript' type='text/javascript'> alert('login e/ou senha incorretos'); window.location.href = 'login.php'</script>");
		}
		else {
			echo "0 results";
		}
	}
	?>
<!--******************************************************Conteudo Pagina***************************************-->
<body class="text-center">
	<div class="jumbotron">
	<table width="100%">
		<tr height="500px" style="padding-left:500px" align="center">
			<td>
				<div width="200px" style="width:300px">
					<form action="login.php" target="_self" method="get">
						<img src="http://www.stickpng.com/assets/images/5847faf6cef1014c0b5e48cd.png" class="logo"></img><br>
						<h2>Acesso ao Sistema<br><br>
						<input type="email" name="inputemail" id="inputemail" class="form-control" placeholder="Endereço de Email"></input>
						<input type="password" name="inputpassword" id="inputpassword" class="form-control" placeholder="Senha"></input><br>
						<button type="submit" class="btn btn-primary btn-block btn-lg">Acessar</button>
					</form>
				</div>
			</td>
		</tr>
	</table>
	</div>
</body>
</html>