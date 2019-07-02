<?php session_start(); 
    $conexao = mysqli_connect("localhost","root","790084","repositorio") or
    die("<script>alert('Não conectado à base de dados');window.location.href = 'index.php'</script>;");
?>