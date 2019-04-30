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
    <script src='script.js'></script>
    <link rel='stylesheet' href="css.css">
	<!------------------------------------Style CSS-------------------------------------------->
	<style>
		.btn{width:180px;border-radius:10px}	
		.btn-l{width:170px}
    </style>
</head>
<!--*************************************************Menu*******************************************************-->
<body class='body' style='width:99%;height:85%'>
    <div class='conteiner' style='height:17%'>
        <div class='row' style='text-align:center;'>
            <div style='width:20%;'>
                <img src="http://www.stickpng.com/assets/images/5847faf6cef1014c0b5e48cd.png" class='logo'><img>
            </div>
            <div style='width:50%;'>
                <div style="margin-top:50px">
                        <a href="index.php" class="btn btn-light" onclick='anima_click(this)'>Home</a>
                        <!--------------------------------------PHP-------------------------------->
                        <!--Decisão de o botão de acesso ao usuario deve ser desabilitado ou não com base no login-->
                                <?php if(isset($_SESSION['nome_usuario'])){ ?>
                                    <a href="usuario.php" class="btn btn-light" onclick='anima_click(this)'>Area do Cliente</a>
                                <?php }
                                else{ ?>
                                    <button href="usuario.php" class="btn btn-light" disabled>Area do Cliente</button>
                                <?php } ?>
                        <a href="" class="btn btn-light" onclick='anima_click(this)'>Informações Empresa</a>
                </div>
            </div>
            <div style='width:30%;'>
                <div style="margin-top:50px">
                    <a href="login.php" class="btn btn-primary btn-l" onclick='anima_click(this)'>Acessar o sistema</a>
                    <a href="cadastro.php" class="btn btn-primary btn-l" onclick='anima_click(this)'>Cadastro ao sistema</a>
                </div>
            </div>
        </div>
    </div>
    <!--*************************************************Conteudo Index*******************************************************-->
    <div class='conteiner' style='height:100%;margin-top:15px'>
        <div class='row body' style='margin-left:0.5%;background-size:1% 100%;height:100%'>
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style="width:1000px;height:100px;margin-top:30px;margin-left:15%">
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