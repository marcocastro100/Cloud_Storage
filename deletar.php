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
		table,td,tr,div{border:0px solid silver;text-align:center}
		.border{border:1px solid silver; margin:0px;padding:10px}
	</style>
</head>
<?php
	$conexao = mysqli_connect("localhost","root","790084","repositorio") or die("fail connect"); #Tenta conectar à base de dados e ao banco 'pagin'
?>
<body>
    <div class='conteiner' align='center' >
		<div class='row border'>
			<div class='col-sm'>
				<strong>Arquivo</strong>
			</div>
			<div class='col-sm'>
				<strong>Tamanho</strong>
			</div>
			<div class='col-sm'>
				
			</div>
		</div>
			<?php
				$select_query = "select * from arquivos;";
				$result = mysqli_query($conexao,$select_query);
				if(mysqli_num_rows($result)){
					while($row = mysqli_fetch_assoc($result)){
						if($row['tamanho_arquivo'] > 0){
							$link = $row['link'];
							$nome = $row['nome_arquivo'];
							$id = $row['id_arquivo'];
							$tamanho = round($row['tamanho_arquivo'] / 1000);	//formata para aparece em kb
							echo "
								<div class='row border'>
									<div class='col-sm' width='500px'>
										$nome
									</div>
									<div class='col-sm ' width='100px'>
										$tamanho Kb
									</div>
									<div class='col-sm' width='100px'>
										<a href='$link' download>Deletar</a>
									</div>
								</div>
							";
						}
					}
				}
				else{
					echo"Problema na query";
				}
			?>
			</div>
	</div>
</body>
</html>