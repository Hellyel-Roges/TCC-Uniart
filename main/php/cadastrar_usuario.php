<?php     
$email = $_POST['email'];
$nome = $_POST['nome'];
$login = $_POST['login'];
$senha = $_POST['senha'];
    if (empty($nome) && empty($email) && empty($login) && empty($senha) && !isset($nome ,$email, $login, $senha)){
            header("location: ../index.php");
}
if (empty($nome) || empty($email) || empty($login) || empty($senha)) {
    echo "<script> 
    alert('PREENCHA TODOS OS CAMPOS'); 
  </script>";
}
else{
require_once("conecta.php");
session_start();  

$stmt_verifica = $conn->prepare("SELECT * FROM perfil WHERE ds_email = :email OR ds_login = :loga OR nm_perfil = :nome");
$stmt_verifica->bindParam(':email', $email, PDO::PARAM_STR);
$stmt_verifica->bindParam(':loga', $login, PDO::PARAM_STR);
$stmt_verifica->bindParam(':nome', $nome, PDO::PARAM_STR);
$stmt_verifica->execute();
if ($stmt_verifica->rowCount() != 0) {
    echo "<script> 
    alert('email ou login já existe.'); 
  </script>";
}else{
try {
              
                // INSERINDO NO BANCO DE DADOS
                $id = 1;
                $stmt = $conn->prepare("INSERT INTO perfil (nm_perfil, ds_email, ds_login, ds_senha, dt_entrada, id_nivel) VALUES (:nome, :email, :loginn, :senha, NOW(), :id)");
                $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':loginn', $login, PDO::PARAM_STR);
                $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();

                if ($stmt->rowCount() != 0){
                    echo "<script> 
                    alert('Cadastrado com sucesso.'); 
                    window.location.href = 'login.php';
                  </script>";
            } else {
                echo "<script> alert('Erro ao cadastrar.'); </script>";
                
            }

} catch (PDOException $e) {
    echo 'Algo deu errado: ' . $e->getMessage();
}  
}  
    
}
?>