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
		.icone{height:70px}
		table{magin:0px;padding:0px}
		.menubtn{width:150px;border-radius:10px}	
		.btn-l{width:170px}
		.btn{width:200px}
		.jumbotron{height:110px;padding:0px;margin:0px}
		.btn{width:120px}	
		.btn-primary-s{width:150px}
		.btn-l{width:170px}
	</style>
</head>
<!--*************************************************Menu*******************************************************-->
<body style="background-color:e6e6e6">
	<div class="jumbotron">
		<table width="100%">
			 <div class='row'>
				 <div width="20%" align="center">
					<img src="http://www.stickpng.com/assets/images/5847faf6cef1014c0b5e48cd.png" style="height: 70px	"><img>
				 </div>
				 <div width="50%">
					<div style="margin-top:50px">
						 <a href="index.php" class="btn btn-light">Home</a>
						 <!--------------------------------------PHP-------------------------------->
						 <!--Decisão de o botão de acesso ao usuario deve ser desabilitado ou não com base no login-->
								 <?php if(isset($_SESSION['nome_usuario'])){ ?>
									 <a href="usuario.php" class="btn btn-light btn-primary-s">Area do Cliente</a>
								 <?php }
								 	else{ ?>
										<button href="usuario.php" class="btn btn-light btn-primary-s" disabled>Area do Cliente</button>
									<?php } ?>

						 <button href="" class="btn btn-light btn-primary-s">Conta Pessoal</button>
						 <a href="Exeple.html" class="btn btn-light">A Empresa</a>
					</div>
				 </div>
				
				 <div width="30%">
					<div style="margin-top:50px">
						 <a href="login.php" class="btn btn-primary btn-l">Acessar o sistema</a>
						<a href="cadastro.php" class="btn btn-primary btn-l" >Cadastro ao sistema</a>
					</div>
				 </div>
			 </div>
		</table>
	</div>
<!--*************************************************Conteudo Index*******************************************************-->
	<table width="100%">
		 <div class='row' align="center">
			 <div>
				<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style="width:900px;height:100px;margin-top:30px">
				  <ol class="carousel-indicators">
					<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
					<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
				  </ol>
				  <div class="carousel-inner">
					<div class="carousel-item active">
					  <img src="https://www.cassi.com.br/modules/mod_giantcontent/assets/libraries/includes/timthumb.php?src=/images/ALIMENTACAO-SAUDAVEL_INTERNET_1950X450.jpg&w=1600&h=500&q=100" class="d-block w-100" alt="...">
					</div>
					<div class="carousel-item">
					  <img src="https://www.cassi.com.br/modules/mod_giantcontent/assets/libraries/includes/timthumb.php?src=/images/ra2018_1950x450.jpg&w=1600&h=500&q=100" class="d-block w-100" alt="...">
					</div>
				  </div>
				  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				  </a>
				  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				  </a>
				</div>
			 </div>
		 </div>
	</table>
<!--*************************************************Rodapé*******************************************************-->	
<!--------------------------------------PHP-------------------------------->
<?php 
	if(!isset($_SESSION['nome_usuario'])){ ?>
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