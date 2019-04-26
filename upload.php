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
    <style></style>
</head>
<?php
    if(isset($_FILES["uploadfile"])){
        $conexao = mysqli_connect("localhost","root","790084","repositorio") or die("fail connect"); #Tenta conectar à base de dados e ao banco 'pagin'

        $nome_arquivo =  $_FILES['uploadfile']['name'];
        $tamanho_arquivo = $_FILES['uploadfile']['size'];

        $diretorio_arquivos = "upload/"; //onde o arquivo será armazenado no servidor(pasta upload)
        $caminho_arquivo = $diretorio_arquivos.basename($_FILES["uploadfile"]["name"]);   //o arquivo com o caminho completo

        $tipo_arquivo = pathinfo($caminho_arquivo,PATHINFO_EXTENSION); //pega o tipo do arquivo
        $uploadok = 1;
        $icone = "icones/"; //icone que aparece no repositorio

        $nome_arquivo = preg_replace('/[^.[:alnum:]_-]/', '',$_FILES["uploadfile"]["name"]);
        $caminho_arquivo = $diretorio_arquivos.basename( preg_replace('/[^.[:alnum:]_]/', '',$_FILES["uploadfile"]["name"]));
        
        //Selecionar inteiro correspondente ao tipo (estrutura interna do bd, tipo de arquivo = int)
        switch($tipo_arquivo){
            case "pdf": $tipo_arquivo=1;$icone = $icone.'pdf.png';break;
            case "doc": $tipo_arquivo=2;$icone = $icone.'doc.png';break;
            case "txt": $tipo_arquivo=3;$icone = $icone.'txt.png';break;
            case "jpg": $tipo_arquivo=4;$icone = $icone.'jpg.png';break;
            case "png": $tipo_arquivo=5;$icone = $icone.'png.png';break;
            case "mp4": $tipo_arquivo=6;$icone = $icone.'mp4.png';break;
            case "docx":$tipo_arquivo=7;$icone = $icone.'doc.png';break;
            case "gif": $tipo_arquivo=8;$icone = $icone.'gif.png';break;
            case "php": $tipo_arquivo=9;$icone = $icone.'php.png';break;
            case "html":$tipo_arquivo=10;$icone = $icone.'html.png';break;
            default: $tipo_arquivo=0;$icone=$icone.'default.png';break;
        }
        // Check if file already exists
        if (file_exists($caminho_arquivo)) {
            echo "Arquivo Existente";
            $uploadok = 0;
        }
        else{
            //Adicionar os dados do arquivo ao banco de dados (SEM ACENTOS NO NOME!! incompativel com mysql string?)
            $inserquery = "insert into arquivos (id_usuario,nome_arquivo,extensao_arquivo,tamanho_arquivo,link_arquivo,link_icone)
            values (
                '$_SESSION[id_usuario]',
                '$nome_arquivo',
                '$tipo_arquivo',
                '$tamanho_arquivo',
                '$caminho_arquivo',
                '$icone'
            )";
            if(mysqli_query($conexao,$inserquery)){
                $uploadok = 1;    //sucesso
            }
            else{
                $uploadok = 0;
                echo"Falha ao enviar para o servidor!"; 
            }
            //Tenta mover o arquivo para o servidor
            if($uploadok == 1){
                if(move_uploaded_file($_FILES['uploadfile']['tmp_name'],$caminho_arquivo)){
                    echo"Enviado com Sucesso!";
                }
                else{
                    echo"Falha ao mover arquivo para o servidor!";
                }
            }
        }
    }
?>
<body>
    <table align="center">
        <tr>
            <td style="padding-top:100px">
                <form action="<?php echo $_SERVER['PHP_SELF'];  ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="tamanho_max" value="30000000">
                    <input type="file" class="form-control-file" name="uploadfile"><br>
                    <button type="submit" class="btn btn-primary" name="submit">Enviar Arquivo</button>
                </form>
            </td>
        </tr>
    </table>
    
</body>
</html>