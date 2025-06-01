<?php
 session_start();
 require_once("php/conecta.php");

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;
  require_once ('bibliotecas/phpmailer/vendor/autoload.php');
  $mail = new PHPMailer(true);
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Esqueceu a senha</title>
  <script src="jquery-3.6.4.min.js"></script>
</head>
<style>
  * { box-sizing: border-box; }
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
  height: 46px;
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
<body>
<?php
$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (!empty($data['esqueci'])) {
  //var_dump($data);
  $sql = "SELECT cd_perfil, nm_perfil, ds_email FROM perfil WHERE ds_email = :ds_email LIMIT 1";
  $result = $conn->prepare($sql);
  $result->bindParam(':ds_email', $data['ds_email'], PDO::PARAM_STR);
  $result->execute();

  if (($result) AND ($result->rowCount() != 0)) {
    $row_perfil = $result->fetch(PDO::FETCH_ASSOC);
    $recuperar = password_hash($row_perfil['cd_perfil'], PASSWORD_DEFAULT);
    //echo "Chave $recuperar <br>";
    $stmt = "UPDATE perfil SET ds_esqueceu =:ds_esqueceu WHERE cd_perfil =:cd_perfil LIMIT 1";
    $result_esqueceu = $conn->prepare($stmt);
    $result_esqueceu->bindParam(':ds_esqueceu', $recuperar, PDO::PARAM_STR);
    $result_esqueceu->bindParam(':cd_perfil', $row_perfil['cd_perfil'], PDO::PARAM_INT);

    if ($result_esqueceu->execute()) {
      $link = "https://uniart.site/Uniart/redefinirsenha.php?chave=$recuperar";

      try{
      //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
      $mail->CharSet = 'UTF-8';                  
        $mail->isSMTP();                                            
        $mail->Host       = 'smtp.hostinger.com';                     
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = 'horizon@uniart.site';                     
        $mail->Password   = 'horizonTeam22$$$';                               
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            
        $mail->Port       = 587;

        $mail->setFrom('horizon@uniart.site', 'Recuperamento');
        $mail->addAddress($row_perfil['ds_email'], $row_perfil['nm_perfil']);

        $mail->isHTML(true);
        $mail->Subject = 'Recuperar Senha';
        
        $mail->Body    = 'Prezado(a)&nbsp;'. $row_perfil['nm_perfil'] .'. Você solicitou uma alteração de senha, por favor clique no link abaixo ou cole-o em seu navegador: <br><br><a href='. $link .'>'. $link ."</a><br><br>Se não for você quem solicitou, Não é necessário nenhuma ação. Sua senha permanecerá a mesma até a ativação do link. <br><br>";

        $mail->AltBody = 'Prezado(a) '. $row_perfil['nm_perfil'] .' \n\n Você solicitou uma alteração de senha, por favor clique no link abaixo ou cole-o em seu navegador: \n\n '. $link ."Se não for você quem solicitou, Não é necessário nenhuma ação. Sua senha permanecerá a mesma até a ativação do link. \n\n";                                   
            // Tenta enviar o e-mail
    if ($mail->send()) {
        // Exibe o alerta de sucesso se o envio for bem-sucedido
        echo "<script> alert('Verifique a caixa de e-mail para instruções de recuperação.')</script>";

        // Redireciona para a página de login
        echo "<script> window.location.href = 'login.php'; </script>";
    } else {
        // Se o envio falhar, exibe uma mensagem de erro
        echo "<script> alert('O envio de e-mail falhou. Por favor, tente novamente.')</script>";
    }
    
 
      }catch (Exception $e) {
          echo "<script> alert(' Message could not be sent. Mailer Error: {$mail->ErrorInfo}')</script>";
      }
    }else{
      echo "<script> alert('Tente Novamente, Por Favor.')</script>";
    }

  }else{
    echo "<script> alert('Erro: Usuário Não Encontrado ou Email Não Cadastrado')</script>";
  }
}
?>
<div class="linha">
  <div class="column" id="esquerda">
    <div class="header">
      <h2 class="animation a1">Esqueceu a senha?</h2>
      <h4 class="animation a2">Informe seu e-mail</h4>
    </div>
<form method="POST" action="">
    <div class="form">
      <?php
        $ds_email = "";
        if(isset($data['ds_email'])){ 
          $ds_email = $data['ds_email']; 
        } 
      ?>
      <input type="email" name="ds_email" value="<?php echo $ds_email ?>" class="form-field animation a3" placeholder="E-mail">
      <br>
      <p class="animation a5"><a href="cadastro.php">Não tem uma conta?</a> <a href="login.php">Tem uma conta?</a></p>
      <button class="animation a6" value="Recuperar" name="esqueci">Enviar</button>
    </div>
</form>
  </div>
  <div class="direita"></div>
</div>
</body>
</html>