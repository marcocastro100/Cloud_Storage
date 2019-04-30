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
    <script src='script.js'></script>
    <link rel='stylesheet' href='css.css'>
    <!------------------------------------Style CSS-------------------------------------------->
    <style>
		.col-sm{font-family:arial;width:205px}
        .feed{position:fixed; bottom:0px; width:40%; margin-left:30%; border-radius:10px; text-align:center; border:1px solid silver;background-color:e6e6e6; color:black}
        .row{width:98%;border-bottom:0.9px solid silver;border-radius:7px;text-align:center;padding:7px;background-color:white}
		</style>
</head>
<?php
    $conexao = mysqli_connect("localhost","root","790084","repositorio") or die("Não foi possivel connectar ao BD");
    /*Realiza uma consulta sql fazendo uma junção das tables compartilhamento,usuario e arquivos para
    gerar uma table com os arquivos que foram compartilhados com o usuario logado na sessão, portanto
    mostrando os arquivos contidos na table compartilhamento para exibição dos arquivos corretos,
    junção em arquivos para poder linkar o link para download e carregamento de icone, além de mostrar o nome,
    junção com usuario para mostrar o nome do usuario remetente(que compartilhou o arquivo com o usuario atual do sistema)
    usado com o while(mysqli-fetcho-assoc) para poder ler todas as linhas no loop while
    */
    $selectglobal = "
    select 
        compartilhamento.id_arquivo,
        compartilhamento.id_remetente,
        compartilhamento.id_destinatario,
        arquivos.id_arquivo,
        arquivos.id_usuario,
        arquivos.nome_arquivo,
        arquivos.extensao_arquivo,
        arquivos.tamanho_arquivo,
        arquivos.link_arquivo,
        arquivos.link_icone,
        usuario.id_usuario,
        usuario.nome_usuario,
        usuario.cidade_usuario,
        usuario.email_usuario,
        usuario.senha_usuario
    from compartilhamento join arquivos on arquivos.id_arquivo = compartilhamento.id_arquivo
        join usuario on compartilhamento.id_remetente = usuario.id_usuario
    where compartilhamento.id_destinatario = ".$_SESSION['id_usuario'].";
    ";
    $selectglobal = mysqli_query($conexao,$selectglobal);
?>
<body class='body' style='background-size:1% 100%'>
	<div class='conteiner' align='center' >
		<div class='row'>
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
				<strong>Remetente</strong>
			</div>
            <div class='col-sm'>
                <strong>Download</strong>
            </div>
		</div>

        <?php
            if(!(isset($_POST['filtro']))){
                while($query0 = mysqli_fetch_assoc($selectglobal)){
                    echo"
                        <div class='row'>
                            <div class='col-sm'>
                                <img src='$query0[link_icone]' class='icone'>
                            </div>
                            <div class='col-sm'>
                                $query0[nome_arquivo]
                            </div>
                            <div class='col-sm'>
                                $query0[tamanho_arquivo] Kb
                            </div>
                            <div class='col-sm'>
                                $query0[nome_usuario]
                            </div>
                            <div class='col-sm'>
                                <div class='col-sm'>
                                    <a href='$query0[link_arquivo]' download>
                                        <button class='badge-primary badge btn btn-arquivos' name='download' onclick='anima_click(this)'>Download</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    ";
                }
            }   
            else{
                while($query0 = mysqli_fetch_assoc($selectglobal)){
                    if($query0['extensao_arquivo'] == $_POST['filtro']){
                        echo"
                            <div class='row'>
                                <div class='col-sm'>
                                    <img src='$query0[link_icone]' class='icone'>
                                </div>
                                <div class='col-sm'>
                                    $query0[nome_arquivo]
                                </div>
                                <div class='col-sm'>
                                    $query0[tamanho_arquivo] Kb
                                </div>
                                <div class='col-sm'>
                                    $query0[nome_usuario]
                                </div>
                                <div class='col-sm'>
                                    <div class='col-sm'>
                                        <a href='$query0[link_arquivo]' download>
                                            <button class='badge-primary badge btn btn-arquivos' name='download' onclick='anima_click(this)'>Download</button>
                                        </a>
                                    </div>
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
		<form action='compartilhado.php' method='post' target='_self'>
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