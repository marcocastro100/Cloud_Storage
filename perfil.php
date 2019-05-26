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
	<link rel="stylesheet" href="css/bootstrap.min.css"><!--Modelo CSS-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src='script.js'></script>
    <link rel='stylesheet' href="css.css">
    <!------------------------------------Style CSS-------------------------------------------->
    <style>
		.border{border:10px solid black; margin:0px;padding:10px;border-radius:20px;background-color:white}
        .form-control{border:1px solid silver;border-radius:10px;width:320px;height:30px;margin:0px;padding:2px;margin-left:20px;margin-bottom:5px}
        .feed{position:fixed; bottom:0px; width:40%; margin-left:30%; border-radius:10px; text-align:center; border:1px solid silver;background-color:e6e6e6; color:black}
		</style>
</head>
<?php
    $conexao = mysqli_connect("localhost","root","790084","repositorio") or die("Erro ao conectar ao BD!");

    $select_usuario = "select * from usuario where id_usuario=".$_SESSION['id_usuario'].";";
    $select_usuario = mysqli_query($conexao,$select_usuario);
    while($query=mysqli_fetch_assoc($select_usuario)){
        $id = $query['id_usuario'];
        $nome = $query['nome_usuario'];
        $cidade =$query['cidade_usuario'];
        $email =$query['email_usuario'];
        $senha = $query['senha_usuario'];
    }
    $select_arquivos = "select * from arquivos where id_usuario=".$_SESSION['id_usuario'].";";
    $select_arquivos = mysqli_query($conexao,$select_arquivos);
    $cont_arquivos = 0;
    $cont_memoria = 0;
    while($query2=mysqli_fetch_assoc($select_arquivos)){
        $cont_arquivos +=1;
        $cont_memoria += $query2['tamanho_arquivo'];
    }
    //Alteração de dados
    if(isset($_POST['alteracao'])){
        if($_POST['oldsenha'] == $senha ){  //confere se a senha atual é igual à senha do usuario na sessão
            //caso algum campo não tenha sido preenchido, o valor original é mantido
            if(strlen($_POST['newnome']) == 0){$_POST['newnome'] = $nome;}
            if(strlen($_POST['newcidade']) == 0){$_POST['newcidade'] = $cidade;}
            if(strlen($_POST['newemail']) == 0){$_POST['newemail'] = $email;}
            if(strlen($_POST['newsenha']) == 0){$POST['newsenha'] = $senha;}
            //query
            $update_usuario = "call update_usuario(
                ".$_SESSION['id_usuario'].",
                '".$_POST['newnome']."',
                '".$_POST['newcidade']."',
                '".$_POST['newemail']."',
                '".$_POST['newsenha']."'
            );";

            if(mysqli_query($conexao,$update_usuario)){
                $_SESSION['feed'] = "Edicao feita!";
                $_SESSION['senha_usuario']  = $_POST['newsenha'];   //muda a senha de sessão do usuario para a nova senha digitada
            }
            else{
                $_SESSION['feed'] =  "Erro na query!";
            }
        }
        else{
            $_SESSION['feed'] =  "Senha Atual incorreta!";
        }
    }

    if(isset($_POST['excluir_perfil'])){
        if($_POST['confirmpassword'] == $_SESSION['senha_usuario']){    //verificação de senha de confirmação de exclusão

            //Apagar arquivos do servidor antes de apagar no bd com unlink
            $select="select * from arquivos where id_usuario =".$_SESSION['id_usuario'].";";
            $select = mysqli_query($conexao,$select);
            while($query=mysqli_fetch_assoc($select)){unlink($query['link_arquivo']);}

            //apaga todos os dados do usuario no servido na ordem de compartilhamento(rem e dest),arquivos e usuario
            $transact = "call transaction_delete_usuario(".$_SESSION['id_usuario'].");";
            if(mysqli_query($conexao,$transact)){
                $_SESSION['feed'] = 'Usuario deletado!';
                session_unset();
                session_destroy();
            }
            else{
                $_SESSION['feed'] = 'Erro ao deletar o usuario do BD'; 
            }
        }
        else{$_SESSION['feed'] = "Senha invalida!";}
    }
?>
<body class='body' style='background-size:1% 100%'>
    <div class='conatainer' style='height:100%'>
        <div class='row' style='width:800px;height:450px;margin-left:11%;margin-top:1%;;text-align:center'>
            <div class='col-sm border' style='margin-right:5px'>
                <div class='' style='border-radius:1000px;width:130px;height:130px;margin-left:32%;margin-top:30px'>
                    <img src="logo.png" class='logo'>
                </div>
                <form action='perfil.php' method='post' target='_self'>
                    <button type='submit' name='alterar_perfil' class='badge-success badge btn btn-arquivos'onclick='anima_click(this)'>Alterar Perfil</button>
                    <button type='submit' name='apagar_perfil' class='badge-danger badge btn btn-arquivos'onclick='anima_click(this)'>Excluir Perfil</button>
                    <?php
                        if(isset($_POST['apagar_perfil'])){
                    ?>
                        <input type='password' name='confirmpassword' class='form-control' placeholder='Password' style='margin-top:10px'>
                        <button type='submit' name='excluir_perfil' class='badge-primary badge btn btn-arquivos' onclick='anima_click(this)'>Confirmar</button>
                    <?php
                        }
                    ?>
                </form>
            </div>
            <div class='col-sm border' style='text-align:left;border:2px solid black'>
                <?php
                    if(!isset($_POST['alterar_perfil'])){   
                ?>
                        Usuario ID:
                        <div class='form-control' style='background-color:eaefef'>
                            <?php echo $id;?>
                        </div>
                        Nome:
                        <div class='form-control' style='background-color:eaefef'>
                            <?php echo $nome;?>
                        </div>
                        Cidade:
                        <div class='form-control' style='background-color:eaefef'>
                            <?php echo $cidade;?>
                        </div >
                        Email:
                        <div class='form-control' style='background-color:eaefef'>
                            <?php echo $email;?>
                        </div>
                        Arquivos Armazenados:
                        <div class='form-control' style='background-color:eaefef'>
                            <?php echo $cont_arquivos;?>
                        </div>
                        Memória em Nuvem usada:
                        <div class='form-control' style='background-color:eaefef'>
                            <?php echo round($cont_memoria/1000);?> Kb
                        </div>
                <?php 
                    }
                    //Botão alterar perfil acionado, aparece campos de edição
                    else{ ?>
                        <form action='perfil.php' method='post' target='_self'>
                            Usuario ID:
                            <div class='form-control' style='background-color:eaefef'>
                                <?php echo $id;?>
                            </div>
                            Novo Nome:
                            <input type='text' placeholder='<?php echo $nome;?>' name='newnome' class='form-control'>
                            Nova Cidade:
                            <input type='text' placeholder='<?php echo $cidade;?>' name='newcidade'class='form-control'>
                            Novo Email:
                            <input type='text' placeholder='<?php echo $email;?>' name='newemail'class='form-control'>
                            Nova Senha:
                            <input type='password' name='newsenha' class='form-control'>
                            Senha Atual
                            <input type='password' name='oldsenha' class='form-control'>
                            <button type='submit' name='alteracao' value='<?php echo $id;?>' class='btn btn-success' style='margin-top:3px;margin-left:5px;width:100px' onclick='anima_click(this)'>Aplicar</button>
                            <a href='perfil.php' class='btn btn-secondary'style='margin-top:3px;margin-left:5px;width:100px' onclick='anima_click(this)'>Cancelar</a>
                        </form>
                <?php 
                    }
                ?>
            </div>
        </div>
    </div>
    <input type='text' name='feed' class=' badge-basic from-control feed' placeholder="<?php if(isset($_SESSION['feed'])){echo $_SESSION['feed'];} ?>" target="contentiframe">   
</body>