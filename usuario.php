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
		table,th,td,span,div,nav,a{border:0px solid black;}
		.logo{height:70px}
		.jumbotron{height:110px;padding:0px;margin:0px}
		table{magin:0px;padding:0px}
		.menubtn{width:150px;border-radius:10px}	
		.btn-l{width:170px}
		.submenu{background-color:faf7ff;padding:0px;border:0.5px solid silver;margin:0px;border-radius:50px;text-align:center}
		.badge{border-radius:10px}
	</style>
</head>
<!--*************************************************Menu*******************************************************-->
<body>
	<div class="jumbotron">
		<table width="100%">
			<tr>
				<!--Logo-->
				<td width="20%" align="center">
					<img src="http://www.stickpng.com/assets/images/5847faf6cef1014c0b5e48cd.png" class="logo"><img>
				</td>
				<!--Menu Centro-->
				<td width="45%">
					<div style="margin-top:50px">
						 <a href="index.php" class="menubtn btn btn-light">Home</a>
						 <a href="usuario.php" class="menubtn btn btn-light">Area do Cliente</a>
						 <button href="" class="menubtn btn btn-light">Informações</button>
						 <a href="Exeple.html" class="menubtn btn btn-light">Fale Conosco</a>
					</div>
				</td>
				<!--Menu Direito-->	
				<td width="30%" align="center">
					<?php if(isset($_SESSION['user_nome'])){ //Para não aparecer erros php quando não logado?>
						<div class="list-group-item-silver" style="margin-top:4px;border:0px solid green;height:100px;border-radius:20px;padding:10px;font-family:arial;color:black">
							<h6>
								nome: <strong><?php echo $_SESSION['user_nome']; ?></strong><br>
								cidade: <?php echo $_SESSION['user_cidade']; ?><br>
								email: <?php echo $_SESSION['user_email']; ?><br>
							</h6>
					<?php } ?>
					<a href="#" class="badge badge-success"style="margin-top:0px;color:white;width:40%">Trocar</a>
					<a href="index.php" class="badge badge-warning" style="margin-top:0px;color:white;width:40%">
						Logoff
					</a>
					</div>
				</td>
			</tr>
		</table>
	</div>
<!--*************************************************Sub Menu*******************************************************-->
	<table width="100%" height="100%">
		<tr>
			<td width="20%" style="height:100%;background-color:#e6e6e6">
			<div style="height:100%;background-color:#e6e6e6">
				<div class="navbar navbar-light" style="padding:0px;border:0px;margin:0px">				  
					<a href="arquivos.php" target="contentiframe" class="d-inline p-1 btn-block btn submenu" style="magin:0px">
						Arquivos
					</a>
					<a href="login.php" target="contentiframe" class="d-inline p-1 btn-block btn submenu" style="margin:1px;">
						Arquivos Compartilhados
					</a>
					<a href="Cadastro.php" target="contentiframe" class="d-inline p-1 btn-block btn submenu" style="margin:0px;">
						Filtragem
					</a>
					<a href="#" class="d-inline p-1 btn-block btn submenu" style="margin:1px;">
						Conta Pessoal
					</a>
					<a href="#" class="d-inline p-1 btn-block btn submenu" style="margin:1px;">
						Encontrar Usuarios
					</a>
				</div>
			</div>
			</td>
<!--*************************************************Conteudo Pagina*******************************************************-->
			<td>
				<div style="width:100%;height:100%;">
					<iframe name="contentiframe" style="height:100%;width:95%;border:0.02px solid silver" src="<?php echo $_SERVER['PHP_SEF'];?>">
						
					</iframe>
				</div>
			</td>
		</tr>
	</table>
<!--*************************************************Rodapé*******************************************************-->
	<?php 
		if(!isset($_SESSION['user_nome'])){ ?>
			<div style="position:fixed; bottom:0px"> <!--colocar em um if de detecção de sessão-->
				<div class="alert alert-warning alert-dismissible fade show"><strong>Não foi detectado Login ao sistema</strong></div>
			</div>
	<?php }
		else { ?>
			<div style="position:fixed; bottom:0px; width:20%">
				<div class="alert alert-success alert-dismissible fade show">
					<strong>Conectado ao Sistema</strong>
				</div>
			</div>
	<?php } ?>
</body>
</html>