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
		table,td,tr{border:1px solid silver;text-align:center}
		.border{border:1px solid silver; margin:0px;padding:10px}
		.col-sm{font-family:arial;}
		.btn-arquivos{width:120px;height:20px}
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
		$delete_query = 'delete from arquivos where id_arquivo = '.$id_excluir.';';
		if(mysqli_query($conexao,$delete_query)){
			unlink($caminho2);	//função que deleta o arquivo no servidor
			echo "Deletado!";
		}
		else{echo "Erro ao deletar!";}
	}
	//Adicionar arquivos
	if(isset($_POST['adicionar'])){	//se o botão de adição for acionado, a pagina é redirecionada para upload.php
		echo("<script language='javascript' type='text/javascript'>window.location.href = 'upload.php'</script>");
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
				<strong>Download</strong>
			</div>
			<div class='col-sm'>
				<strong>Excluir</strong>
			</div>
		</div>
		<?php
			$select_query = "select * from arquivos where id_usuario = ".$_SESSION['id_usuario'].";";
			$result = mysqli_query($conexao,$select_query);
			if(!isset($_POST['filtro'])){
				if(mysqli_num_rows($result)){
					while($row = mysqli_fetch_assoc($result)){
						if($row['tamanho_arquivo'] > 0){
							$link = $row['link_arquivo'];
							$nome = $row['nome_arquivo'];
							$id = $row['id_arquivo'];
							$icone = $row['link_icone'];
							$tamanho = round($row['tamanho_arquivo'] / 1000);	//formata para aparece em kb
							echo "
								<div class='row border'>
									<div class='col-sm'>
										<img src='$icone' style='width:30px;height:30px;magin:0px;padding:0px'>
									</div>
									<div class='col-sm'>
										$nome
									</div>
									<div class='col-sm '>
										$tamanho Kb
									</div>
									<div class='col-sm' style='margin-top:5px'>
										<a href='$link' download>
											<button class='badge-primary badge btn btn-arquivos' name='download' value='$id'>Download</button>
										</a>
									</div>
									<div class='col-sm' style='margin-top:5px'>
										<form action='arquivos.php' method='post' target='_self'>
											<button type='submit' class='badge-danger badge btn btn-arquivos' name='excluir' value='$id'>Excluir</button>
										</form>
									</div>
								</div>
							";
						}
					}
				}
				else{
					echo"Problema na query";
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
							<div class='row border'>
								<div class='col-sm'>
                                 <img src='$icone' style='width:30px;height:30px;magin:0px;padding:0px'>
								</div>
								<div class='col-sm'>
									$nome
								</div>
								<div class='col-sm '>
									$tamanho Kb
								</div>
								<div class='col-sm' style='margin-top:5px'>
									<a href='$link' download>
										<button class='badge-primary badge btn btn-arquivos' name='download' value='$id'>Download</button>
									</a>
								</div>
								<div class='col-sm' style='margin-top:5px'>
									<form action='arquivos.php' method='post' target='_self'>
										<button type='submit' class='badge-danger badge btn btn-arquivos' name='excluir' value='$id'>Excluir</button>
									</form>
								</div>
							</div>
							";
						}
					}
				}
				else{
					echo"Problema na query";
				}
			}
		?>
	</div>
	<!-----------------------Adicionar Arquivos------------------->
	</div class='conteiner' style='align:left'>
		<form action='arquivos.php' method='post' target='_self'>
			<button type='submit' name='adicionar' class='btn btn-success' style='margin:10px'>Adcionar arquivo</button>
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
					<button type='submit' name='filtro' value='' class="dropdown-item">Null</button>
				</div>
			</div>
		</form>
		
	</div>
</body>
</html>