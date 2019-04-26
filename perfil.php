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
		table,tr,td,div{border:0px solid silver;text-align:center;eaefef}
		.border{border:1px solid black; margin:0px;padding:10px;border-radius:10px;background-color:white}
		.col-sm{font-family:arial;}
        .logo{height:90px}
		.btn-arquivos{width:120px;height:22px;margin-top:10px}
        .icone{width:30px;height:30px;magin:0px;padding:0px}
        .form-control{border:1px solid silver;border-radius:10px;width:320px;height:30px;margin:0px;padding:2px;margin-left:20px;margin-bottom:5px}
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
    }
    $select_arquivos = "select * from arquivos where id_usuario=".$_SESSION['id_usuario'].";";
    $select_arquivos = mysqli_query($conexao,$select_arquivos);
    $cont_arquivos = 0;
    $cont_memoria = 0;
    while($query2=mysqli_fetch_assoc($select_arquivos)){
        $cont_arquivos +=1;
        $cont_memoria += $query2['tamanho_arquivo'];
    }
    //caso algum campo não tenha sido preenchido, o valor original é mantido
    if(isset($_POST['alteracao'])){
        if(strlen($_POST['newnome']) == 0){$_POST['newnome'] = $nome;}
        if(strlen($_POST['newcidade']) == 0){$_POST['newcidade'] = $cidade;}
        if(strlen($_POST['newemail']) == 0){$_POST['newemail'] = $email;}
        $update_usuario = "update usuario set 
        nome_usuario ='".$_POST['newnome']."',
        cidade_usuario ='".$_POST['newcidade']."',
        email_usuario ='".$_POST['newemail']."'
        where id_usuario =".$_SESSION['id_usuario'].";";

        if(mysqli_query($conexao,$update_usuario)){
            echo "Edicao feita!";
            echo("<script language='javascript' type='text/javascript'>window.location.href = 'perfil.php'</script>");
        }
        else{
            echo "Erro na edição!";
        }
    }

    if(isset($_POST['apagar_perfil'])){
        //Apagar arquivo do servidor antes de apagar no bd
        $select="select * from arquivos where id_usuario =".$_SESSION['id_usuario'].";";
        $select = mysqli_query($conexao,$select);
        while($query=mysqli_fetch_assoc($select)){unlink($query['link_arquivo']);}
        //apaga todos os dados do usuario no servido na ordem de compartilhamento(rem e dest),arquivos e usuario
        $delete_compartilhamento = "delete from compartilhamento where id_remetente =".$_SESSION['id_usuario'].";";
        if(mysqli_query($conexao,$delete_compartilhamento)){echo'deletado remetente<br>';}else{'nao remetente<br>';}
        $delete_comp = "delete from compartilhamento where id_destinatario =".$_SESSION['id_usuario'].";";
        if(mysqli_query($conexao,$delete_comp)){echo'deletado destinatario<br>';}else{'nao destinatario<br>';}
        $delete_arquivos = "delete from arquivos where id_usuario =".$_SESSION['id_usuario'].";";
        if(mysqli_query($conexao,$delete_arquivos)){echo'deletado arquivos<br>';}else{'nao arquivos<br>';}
        $delete_usuario = "delete from usuario where id_usuario =".$_SESSION['id_usuario'].";";
        if(mysqli_query($conexao,$delete_usuario)){echo'deletado usuario<br>';}else{'nao usuario<br>';}
        session_unset();
        session_destroy();
    }
?>
</body>
    <div class='conatainer  border' style='height:100%'>
        <div class='row border' style='width:800px;height:450px;margin-left:11%;margin-top:1%;background-color:eaefef'>
            <div class='col-sm border' style='margin-right:5px'>
                <div class='border' style='border-radius:1000px;width:130px;height:130px;margin-left:32%;margin-top:30px'>
                <img src="http://www.stickpng.com/assets/images/5847faf6cef1014c0b5e48cd.png" class="logo"><img>
                </div>
                <form action='perfil.php' method='post' target='_self'>
                    <button type='submit' name='alterar_perfil' value='1' class='badge-success badge btn btn-arquivos'>Alterar Perfil</button>
                    <button type='submit' name='apagar_perfil' value='1' class='badge-danger badge btn btn-arquivos'>Excluir Perfil</button>
                </form>
            </div>
            <div class='col-sm border' style='text-align:left'>
                <?php
                    if(!isset($_POST['alterar_perfil'])){   ?>
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
                    <?php }
                    else{ ?>
                        <form action='perfil.php' method='post' target='_self'>
                            Usuario ID:
                            <div class='form-control' style='background-color:eaefef'>
                                <?php echo $id;?>
                            </div>
                            Nome:
                            <input type='text' placeholder='<?php echo $nome;?>' name='newnome' class='form-control'>
                            Cidade:
                            <input type='text' placeholder='<?php echo $cidade;?>' name='newcidade'class='form-control'>
                            Email:
                            <input type='text' placeholder='<?php echo $email;?>' name='newemail'class='form-control'>
                            Arquivos Armazenados:
                            <div class='form-control' style='background-color:eaefef'>
                                <?php echo $cont_arquivos;?>
                            </div>
                            Memória em Nuvem usada:
                            <div class='form-control' style='background-color:eaefef'>
                                <?php echo round($cont_memoria/1000);?> Kb
                            </div>
                            
                            <button type='submit' name='alteracao' value='<?php echo $id;?>' class='btn btn-success' style='margin-top:3px;margin-left:5px;width:100px'>Aplicar</button>
                        </form>
                    <?php }
                ?>
            </div>
        </div>
    </div>
</body>