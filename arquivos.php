<?php session_start();
$_SESSION['feed'] = "";
if(!(isset($_SESSION['id_usuario']))){
    echo "<script>
        alert('Faça Login antes!');
        window.top.location.href='login.php';
    </script>";
}
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
    <link rel='stylesheet' href="css.css">
    <!------------------------------------Style CSS-------------------------------------------->
    <style>
        .row{margin-left:10px;width:98%;border-bottom:0.9px solid silver;border-radius:5px;text-align:center;padding:5px;background-color:white}
        .col-sm{font-family:arial;width:250px}
    </style>
</head>
<?php
	$conexao = mysqli_connect("localhost","root","790084","repositorio") or die("fail connect"); #Tenta conectar à base de dados e ao banco 'pagin'
	//Deletar arquivo do sistema
	if(isset($_POST['excluir'])){
		//Descobrir onde está o arquivo para deletar do servidor
		$select_caminho_query = 'select link_arquivo from arquivos where id_arquivo ='.$_POST["excluir"].';';
		$caminho = mysqli_query($conexao,$select_caminho_query);
			while($row = mysqli_fetch_assoc($caminho)){$caminho2 = $row['link_arquivo'];}//transforma a query em texto
		//query para deletar o arquivo do banco de dados
		$id_excluir = $_POST['excluir'];
		$delete_query = "call delete_arquivos(".$id_excluir.");";
		if(mysqli_query($conexao,$delete_query)){
			unlink($caminho2);	//função que deleta o arquivo no servidor
			$_SESSION['feed'] = "Deletado!";
		}
		else{$_SESSION['feed'] = "Erro ao deletar,arquivo pode estar sendo compartilhado!";}
	}
	//Adicionar arquivos
	if(isset($_POST['adicionar'])){	//se o botão de adição for acionado, a pagina é redirecionada para upload.php
		echo("<script language='javascript' type='text/javascript'>window.location.href = 'upload.php'</script>");
	}
?>
<body class='intro body' style='background-size:1% 100%'>
	<div class='conteiner'>
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
				<strong>Download</strong>
			</div>
			<div class='col-sm'>
				<strong>Excluir</strong>
			</div>
		</div>
		<?php
			$select_query = "select * from arquivos where id_usuario = ".$_SESSION['id_usuario'].";";
            $result = mysqli_query($conexao,$select_query);
            //Gerar tabela de arquivos
			if(!isset($_POST['filtro'])){
				if(mysqli_num_rows($result)){
					while($row = mysqli_fetch_assoc($result)){
						if($row['tamanho_arquivo'] >= 0){
							$link = $row['link_arquivo'];
							$nome = $row['nome_arquivo'];
							$id = $row['id_arquivo'];
							$icone = $row['link_icone'];
							$tamanho = round($row['tamanho_arquivo'] / 1000);	//formata para aparece em kb
							echo "
								<div class='row'>
									<div class='col-sm'>
										<img src='$icone' class='icone'>
									</div>
									<div class='col-sm'>
										$nome
									</div>
									<div class='col-sm '>
										$tamanho Kb
									</div>
									<div class='col-sm'>
										<a href='$link' download>
											<button class='badge-primary badge btn btn-arquivos' name='download' onclick='anima_click(this)'>Download</button>
										</a>
									</div>
									<div class='col-sm'>
										<form action='arquivos.php' method='post' target='_self'>
											<button type='submit' class='badge-danger badge btn btn-arquivos' name='excluir' value='$id' onclick='anima_click(this)'>Excluir</button>
										</form>
									</div>
								</div>
							";
						}
					}
				}
				else{
					$_SESSION['feed'] = "Você não possui arquivos ainda";
				}
			}
			else{
				if(mysqli_num_rows($result)){
					while($row = mysqli_fetch_assoc($result)){
						if($row['tamanho_arquivo'] > 0 && $row['extensao_arquivo'] == $_POST['filtro']){	//alem de compara se o arquivo está no servidor(tamanho = 0), compara tambem se o arquivo tem o codigo do filtro selecionado
							$link = $row['link_arquivo'];
							$nome = $row['nome_arquivo'];
							$id = $row['id_arquivo'];
							$icone = $row['link_icone'];
							$tamanho = round($row['tamanho_arquivo'] / 1000);	//formata para aparece em kb
							echo "
							<div class='row'>
								<div class='col-sm'>
                                 <img src='$icone' class='icone'>
								</div>
								<div class='col-sm'>
									$nome
								</div>
								<div class='col-sm '>
									$tamanho Kb
								</div>
								<div class='col-sm'>
									<a href='$link' download>
										<button class='badge-primary badge btn btn-arquivos' name='download' onclick='anima_click(this)'>Download</button>
									</a>
								</div>
								<div class='col-sm'>
									<form action='arquivos.php' method='post' target='_self'>
										<button type='submit' class='badge-danger badge btn btn-arquivos' name='excluir' onclick='anima_click(this)'>Excluir</button>
									</form>
								</div>
							</div>
							";
						}
					}
				}
				else{
					$_SESSION['feed'] = "Problema na query";
				}
			}
		?>
	</div>
	<!-----------------------Adicionar Arquivos------------------->
	</div class='conteiner' style='align:left'>
		<form action='arquivos.php' method='post' target='_self'>
			<button type='submit' name='adicionar' class='btn btn-success' style='margin:10px' onclick='anima_click(this)'>Adcionar arquivo</button>
	<!----------------------Filtrar Arquivos----------------------->			
			<div class="btn-group">
				<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
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
					<button type='submit' name='filtro' value='0' class="dropdown-item">Null</button>
				</div>
			</div>
		</form>
    </div>
    <input type='text' name='feed' class=' badge-basic from-control feed' placeholder="<?php if(isset($_SESSION['feed'])){echo $_SESSION['feed'];} ?>" target="contentiframe">   
</body>
</html>