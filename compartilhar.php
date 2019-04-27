<?php session_start();
$_SESSION['feed'] = "";
?>
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
		.border{border:1px solid silver; margin:0px;padding:9px}
		.col-sm{font-family:arial;}
		.btn-arquivos{width:160px;height:22px}
        .icone{width:30px;height:30px;margin:0px;padding:0px}
        .feed{position:fixed; bottom:0px; width:40%; margin-left:30%; border-radius:10px; text-align:center; border:1px solid silver;background-color:e6e6e6; color:black}
		</style>
</head>
<?php
    $conexao = mysqli_connect("localhost","root","790084","repositorio") or die("Não foi possivel connectar ao BD");

    if(isset($_POST['compartilhar'])){
        $id_arq_comp = $_POST['arq_comp'];
        $id_remetente = $_SESSION['id_usuario'];
        $id_destinatario = $_POST['compartilhar'];
        $insert_compartilhamento = "call insert_compartilhamento(".$id_arq_comp.",".$id_remetente.",".$id_destinatario.");";
        if($insert_compartilhamento = mysqli_query($conexao,$insert_compartilhamento)){
            $_SESSION['feed'] = 'Arquivo Compartilhado com Sucesso!';
        }
        else{
            $_SESSION['feed'] = 'Arquivo já está compartilhado';
        }
    }
?>
<body>
	<div class='conteiner' align='center' >
		<div class='row border'>
			<div class='col-sm'>
				<strong>Type</strong>
			</div>
			<div class='col-sm'>
				<strong>Arquivo</strong>
			</div>
			<div class='col-sm'>
				<strong>Tamanho</strong>
			</div>
			<div class='col-sm'>
				<strong>Compartilhar</strong>
			</div>
		</div>

        <?php
            $select_arquivos = 'select * from arquivos where id_usuario ='.$_SESSION['id_usuario'].';';
            $select_arquivos = mysqli_query($conexao,$select_arquivos);
            if(!(isset($_POST['filtro']))){
                while($query = mysqli_fetch_assoc($select_arquivos)){
                    $id_arquivo = $query['id_arquivo'];
                    $id_usuario = $query['id_usuario'];
                    $nome_arquivo = $query['nome_arquivo'];
                    $extensao_arquiivo = $query['extensao_arquivo'];
                    $tamanho_arquivo = round($query['tamanho_arquivo'] / 1000);
                    $link_arquivo = $query['link_arquivo'];
                    $link_icone = $query['link_icone'];
                    echo"
                        <div class='row border'>
                            <div class='col-sm'>
                                <img src='$link_icone' class='icone'>
                            </div>
                            <div class='col-sm'>
                                $nome_arquivo
                            </div>
                            <div class='col-sm'>
                                $tamanho_arquivo Kb
                            </div>
                            <div class='col-sm'>
                                <form action='compartilhar.php' method='post' target='_self'>
                                    <div class='btn-group'>
                                        <button type='button' class='btn badge badge-secondary btn-arquivos dropdown-toggle' data-toggle='dropdown'>
                                            Compartilhar
                                        </button>
                                        <div class='dropdown-menu'>
                                        ";
                                        $select_usuarios = 'select * from usuario where id_usuario <>'.$id_usuario.';';
                                        $select_usuarios = mysqli_query($conexao,$select_usuarios);
                                        while($query2 = mysqli_fetch_assoc($select_usuarios)){
                                            $id_usuario_comp = $query2['id_usuario'];
                                            $nome_usuario_comp = $query2['nome_usuario'];
                                            echo"
                                                <input type='hidden' name='arq_comp' value='$id_arquivo'>
                                                <button type='submit' name='compartilhar' value='$id_usuario_comp' class='dropdown-item'>
                                                    $nome_usuario_comp
                                                </button>
                                            ";
                                        }
                                        echo"
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    ";
                }
            }
            else{
                while($query = mysqli_fetch_assoc($select_arquivos)){
                    if($query['extensao_arquivo'] == $_POST['filtro']){
                        $id_arquivo = $query['id_arquivo'];
                        $id_usuario = $query['id_usuario'];
                        $nome_arquivo = $query['nome_arquivo'];
                        $extensao_arquiivo = $query['extensao_arquivo'];
                        $tamanho_arquivo = round($query['tamanho_arquivo'] / 1000);
                        $link_arquivo = $query['link_arquivo'];
                        $link_icone = $query['link_icone'];
                        echo"
                            <div class='row border'>
                                <div class='col-sm'>
                                    <img src='$link_icone' class='icone'>
                                </div>
                                <div class='col-sm'>
                                    $nome_arquivo
                                </div>
                                <div class='col-sm'>
                                    $tamanho_arquivo
                                </div>
                                <div class='col-sm'>
                                    <form action='compartilhar.php' method='post' target='_self'>
                                        <div class='btn-group'>
                                            <button type='button' class='btn badge badge-secondary btn-arquivos dropdown-toggle' data-toggle='dropdown'>
                                                Compartilhar
                                            </button>
                                            <div class='dropdown-menu'>
                                            ";
                                            $select_usuarios = 'select * from usuario where id_usuario <>'.$id_usuario.';';
                                            $select_usuarios = mysqli_query($conexao,$select_usuarios);
                                            while($query2 = mysqli_fetch_assoc($select_usuarios)){
                                                $id_usuario_comp = $query2['id_usuario'];
                                                $nome_usuario_comp = $query2['nome_usuario'];
                                                echo"
                                                    <button type='submit' name='compartilhar' value='$id_usuario_comp' class='dropdown-item'>
                                                        $nome_usuario_comp
                                                    </button>
                                                ";
                                            }
                                            echo"
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        ";
                    }
                             
                }
            }
        ?>
<!--------------------Filtrar--------------------->
    </div>
    </div class='conteiner' style='align:left'>
		<form action='compartilhar.php' method='post' target='_self'>
        <div class="btn-group">
				<button type="button" class="btn btn-secondary dropdown-toggle" style='margin:10px' data-toggle="dropdown">
					Filtrar Extensão
				</button>
				<div class="dropdown-menu">
					<button type='submit' name='filtro' value='1' class="dropdown-item">.Pdf</button>
					<button type='submit' name='filtro' value='2' class="dropdown-item">.Doc</button>
					<button type='submit' name='filtro' value='3' class="dropdown-item">.Txt</button>
					<button type='submit' name='filtro' value='4' class="dropdown-item">.Jpg</button>
					<button type='submit' name='filtro' value='5' class="dropdown-item">.Png</button>
					<button type='submit' name='filtro' value='6' class="dropdown-item">.Mp4</button>
					<button type='submit' name='filtro' value='7' class="dropdown-item">.Docx</button>
					<button type='submit' name='filtro' value='8' class="dropdown-item">.Gif</button>
					<button type='submit' name='filtro' value='9' class="dropdown-item">.Php</button>
					<button type='submit' name='filtro' value='10' class="dropdown-item">.Html</button>
					<button type='submit' name='filtro' value='' class="dropdown-item">Null</button>
				</div>
			</div>
		</form>
    </div>
    <input type='text' name='feed' class=' badge-basic from-control feed' placeholder="<?php if(isset($_SESSION['feed'])){echo $_SESSION['feed'];} ?>" target="contentiframe">   
</body>
</html>