<?php
  session_start();
  require_once("php/conecta.php");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Redefinir Senha</title>

<style>
  * { 
  box-sizing: border-box; 
  }
@import url('https://fonts.googleapis.com/css?family=Rubik:400,500&display=swap');

body, html {
  font-family: 'Verdana', sans-serif;
  margin: 0;
  height: 100%;
}

.container {
  height: 100vh;
}

  .column {
  float: left;
  width: 50%;
  padding: 15px;
}

/* Clear floats after the columns */
.linha::after {
  content: "";
  display: table;
  clear: both;
}

.linha{
  display: flex;
  height: 100%;
}

#esquerda {
  background-color: #43005c;
  height: 100%;
  overflow: hidden;
  display: flex;
  flex-wrap: wrap;
  flex-direction: column;
  justify-content: center;
  animation-name: left;
  animation-duration: 1s;
  animation-fill-mode: both;
  animation-delay: 1s;
}

.direita {
  flex: 1;
  background-color: none;
  transition: 1s;
  background-image: url("Logo/logobranca.png");
  background-size: 40rem;
  background-repeat: no-repeat;
  background-position: center;
}

.header{
text-align: center;
}

.header > h2 {
  margin: 0;
  text-align: center;
  color: white;
}

.header > h4 {
  margin-top: 10px;
  font-weight: normal;
  font-size: 15px;
  text-align: center;
  color: white;
}

.form {
  max-width: 100%;
  display: flex;
  flex-direction: column;
}

.form > p {
  text-align: right;
}

.form > p > a {
  color: rgb(200,200,200);
  font-size: 14px;
  text-decoration: none;
}

.form > p > a:hover {
  color: #d76bff;
  font-size: 14px;
}

.form-field {
  height: 3rem;
  padding: 0 16px;
  border: 2px solid #ddd;
  border-radius: 4px;
  font-family: 'Rubik', sans-serif;
  outline: 0;
  transition: .2s;
  margin-top: 20px;
}

.form-field:focus {
  border-color: #8d0dfe;
}

.form > input {
  border-radius: 50px;
}

.form > button {
  padding: 12px 10px;
  border: 0;
  background: linear-gradient(to right, #8d0dfe 0%, #800080 100%); 
  border-radius: 50px;
  margin-top: 10px;
  color: #fff;
  letter-spacing: 1px;
  font-family: 'Rubik', sans-serif;
}

.animation {
  animation-name: move;
  animation-duration: .4s;
  animation-fill-mode: both;
  animation-delay: 2s;
}

.a1 {
  animation-delay: 2s;
}

.a2 {
  animation-delay: 2.1s;
}

.a3 {
  animation-delay: 2.2s;
}

.a4 {
  animation-delay: 2.3s;
}

.a5 {
  animation-delay: 2.4s;
}

.a6 {
  animation-delay: 2.5s;
}

@keyframes move {
  0% {
    opacity: 0;
    visibility: hidden;
    transform: translateY(-40px);
  }

  100% {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
  }
}

@keyframes left {
  0% {
    opacity: 0;
    width: 0;
  }

  100% {
    opacity: 1;
    padding: 20px 40px;
    width: 65vh;
  }
}

/*animacao fundo*/
body {
    font-family: -apple-system, BlinkMacSystemFont, sans-serif;
    overflow: auto;
    background: linear-gradient(315deg, #5a0e77 3%, #76129b 38%, #441657 68%, #500c69 98%);
    animation: gradient 15s ease infinite;
    background-size: 400% 400%;
    background-attachment: fixed;
}

@keyframes gradient {
    0% {
        background-position: 0% 0%;
    }
    50% {
        background-position: 100% 100%;
    }
    100% {
        background-position: 0% 0%;
    }
}

/*https://encycolorpedia.pt/800080*/
</style>
</head>
<body>
  <?php

  if(isset($_POST['ds_senha']) && isset($_POST['ds_senha2'])){
    if($_POST['ds_senha'] != $_POST['ds_senha2']){
      echo "<script> alert('Senhas diferentes. Por favor, tente novamente.')</script>";
    }else{
      $chave = filter_input(INPUT_GET, 'chave', FILTER_DEFAULT);
      if (!empty($chave)) {
        //var_dump($chave);
        $sql = "SELECT cd_perfil FROM perfil WHERE ds_esqueceu = :ds_esqueceu LIMIT 1";
        $result = $conn->prepare($sql);
        $result->bindParam(':ds_esqueceu', $chave, PDO::PARAM_STR);
        $result->execute();
        if (($result) AND ($result->rowCount() != 0)) {
          $row_perfil = $result->fetch(PDO::FETCH_ASSOC);
          $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
          //var_dump($data);
            if (!empty($data['PassAlter'])) {
              $ds_senha = $data['ds_senha'];
              $ds_esqueceu = 'NULL';
              $stmt = "UPDATE perfil SET ds_senha = :ds_senha, ds_esqueceu = :ds_esqueceu WHERE cd_perfil =:cd_perfil LIMIT 1";
              $result_esqueceu = $conn->prepare($stmt);
              $result_esqueceu->bindParam(':ds_senha', $ds_senha, PDO::PARAM_STR);
              $result_esqueceu->bindParam(':ds_esqueceu', $ds_esqueceu);
              $result_esqueceu->bindParam(':cd_perfil', $row_perfil['cd_perfil'], PDO::PARAM_INT);
              $bool = $result_esqueceu->execute();
              if ($bool) {
                header("Location: login.php");
              }else{
                echo "<script> alert('Senhas inseridas não são iguais.')</script>";
              }
            }
          }else{
            echo "<script> alert('Erro: Link Inválido, Solicite um Novo Link.')</script>";
            echo "<script> window.location.href = 'esqueceusenha.php'; </script>";
          }
        }else{
          echo "<script> alert('Erro: Link Inválido, Solicite um Novo Link.')</script>";
          echo "<script> window.location.href = 'esqueceusenha.php'; </script>";
        }
    }
  }

?>
<div class="linha">
  <div class="column" id="esquerda">
    <div class="header">
      <img class="animation a1" style="width:15rem;" src="Logo\logobranca.png">
    <h2 class="animation a2">Redefinir Senha</h2>
    </div>
<form method="POST" action="">
    <div class="form">
      <input type="password" name="ds_senha" class="form-field animation a3" placeholder="Insira a Nova Senha">
      <!--<input type="password" name="ds_senha2" value="<?php //echo $ds_senha2 ?>" class="form-field animation a3" placeholder="Confirme a Nova Senha">-->
      <input type="password" name="ds_senha2" class="form-field animation a3" placeholder="Confirme a Nova Senha">
      <br>
      <p class="animation a5"><a href="login.php">Entrar com sua conta</a> <a href="cadastro.php">Não tem uma conta?</a></p>
      <button class="animation a7" value="Alterar" name="PassAlter">Finalizar</button>
    </div>
</form>
  </div>
  <div class="direita"></div>
</div>
</body>
</html>