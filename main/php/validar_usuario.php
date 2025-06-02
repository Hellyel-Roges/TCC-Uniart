<?php
$login = $_POST['login'];
$senha = $_POST['senha'];
if (empty($login) && empty($senha) && !isset($login, $senha)){
    header("location: ../index.php");
}else{
session_start();
require_once("conecta.php");

try {
    $stmt = $conn->prepare("SELECT * FROM perfil where ds_login = :logar and ds_senha = :senha ");
    $stmt->bindParam(':logar', $login, PDO::PARAM_STR);
    $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() != 0) {
        $dado = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['id'] = $dado['cd_perfil'];
        $_SESSION['acesso'] = $dado['id_nivel'];

        $_SESSION['nome'] = $dado['nm_perfil'];
        $_SESSION['email'] = $dado['ds_email'];
        $_SESSION['descricao'] = $dado['ds_perfil'];
        $_SESSION['telefone'] = $dado['nr_cell'];
        $_SESSION['foto'] = $dado['ds_imagem'];
        $_SESSION['idade'] = $dado['dt_nascimento'];
        $_SESSION['entrada'] = $dado['dt_entrada'];
        $_SESSION['login'] = $login;
        echo "<meta http-equiv='refresh' content='1'>";
    } else {
        echo "<script> 
                    alert('Login ou senha Incorreto.');
                  </script>";
    }
} catch (PDOException $e) {
    echo 'Algo deu errado: ' . $e->getMessage();
}
}
?>
