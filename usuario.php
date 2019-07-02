<?php
	include("conexao.php");    
?>
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
	<!------------------------------------Style CSS-------------------------------------------
	<style>
		div{border:0px solid black;}
		.icone{height:70px}
		.jumbotron{height:110px;padding:0px;margin:0px;background-color:e6e6e6}
		.menubtn{width:180px;border-radius:10px}	
		.submenu{background-color:faf7ff;padding:100px;border:0.5px solid silver;margin:0px;border-radius:5px;text-align:center}
		.badge{border-radius:10px}
		.d-inline{margin-bottom:-7px;}
	</style>-->
</head>
<?php
	if(isset($_POST['logoff'])){
		session_unset();
		session_destroy();
		echo("<script language='javascript' type='text/javascript'> window.location.href = 'index.php'</script>");
	}
?>
<!--*************************************************Menu*****************************style='background-size: 10% 100%;**************************-->
<body style="width:99%;height:83%" class='body'>
	<div class="conteiner">
        <div class='row' style='text-align:center'>
            <!--Logo-->
            <div style="width:20%">
                <img src="images/LionsCoding1.png" class="logo"><img>
            </div>
            <!--Menu Centro-->
            <div style="width:50%">
                <div style="margin-top:50px">
                    <a href="index.php" class="menubtn btn btn-light" onclick='anima_click(this)'>Home</a>
                    <a href="usuario.php" class="menubtn btn btn-light" onclick='anima_click(this)'>Area do Cliente</a>
                    <a href="empresa.html" class="menubtn btn btn-light" onclick='anima_click(this)'>Informações Empresa</a>
                </div>
            </div>
            <!--Menu Direito-->	
            <div style="width:30%">
            <!--------------------------------------PHP-------------------------------->
                <?php if(isset($_SESSION['nome_usuario'])){ //Para não aparecer erros php quando não logado?>
                    <div style="margin-top:4px;border:0px solid green;height:100px;border-radius:20px;padding:10px;font-family:arial;color:black">
                        <h6>
                            <strong><?php echo $_SESSION['nome_usuario']; ?></strong><br>
                            <?php echo $_SESSION['cidade_usuario']; ?><br>
                            <?php echo $_SESSION['email_usuario']; ?><br>
                        </h6>
                <?php } ?>
                <form action='usuario.php' target='_self' method='post'>
                    <a href="login.php" class="badge badge-success"style="margin-top:0px;color:white;width:40%;border:100px" onclick='anima_click(this)'>Outra Conta</a>
                    <button type='submit' class=" btn badge badge-warning" name='logoff' style="margin-top:0px;color:white;width:40%" onclick='anima_click(this)'>Sair</button>
                </form>
                </div>
            </div>
        </div>
	</div>
<!--*************************************************Sub Menu*******************************************************-->
    <div class='row' style='text-align:center;width:100%'>
        <div style="height:100%;width:20%;margin-left:13px">
            <div>
                <div class="navbar navbar-light" style="padding:0px;border:0px;margin:0px">
                    <a href="arquivos.php" target="contentiframe" class="d-inline p-1 btn-block btn submenu" onclick='anima_click(this)'>
                        Arquivos
                    </a>
                    <a href="compartilhar.php" target="contentiframe" class="d-inline p-1 btn-block btn submenu" onclick='anima_click(this)'>
                        Compartilhar
                    </a>
                    <a href="compartilhado.php" target="contentiframe" class="d-inline p-1 btn-block btn submenu" onclick='anima_click(this)'>
                        Compartilhados Comigo
                    </a>
                    <a href="perfil.php" target="contentiframe" class="d-inline p-1 btn-block btn submenu" onclick='anima_click(this)'>
                        Conta Pessoal
                    </a>
                </div>
            </div>
        </div>
<!--*************************************************Conteudo Pagina*******************************************************-->
        <div style='width:78%'>
            <div style="height:100%;">
                <iframe name="contentiframe" class='body' style="height:100%;width:100%;background-size:1% 100%;border:1px solid silver" src="<?php echo $_SERVER['PHP_SEF'];?>">
                    
                </iframe>
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
			<div style="position:fixed; bottom:0px;">
				<div class="alert alert-success alert-dismissible fade show">
					<strong>Conectado ao Sistema</strong>
				</div>
			</div>
    <?php } ?>
</body>
</html>