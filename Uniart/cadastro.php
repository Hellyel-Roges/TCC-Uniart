<?php
session_start();
if (!isset($_SESSION['login'])) {
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cadastro</title>
</head>

<style>
  * {
    box-sizing: border-box;
  }

  @import url('https://fonts.googleapis.com/css?family=Rubik:400,500&display=swap');

  body,
  html {
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

  .linha {
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

  .header {
    text-align: center;
  }

  .header>h2 {
    margin: 0;
    text-align: center;
    color: white;
  }

  .header>h4 {
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

  .form>p {
    text-align: right;
  }

  .form>p>a {
    color: rgb(200, 200, 200);
    font-size: 14px;
    text-decoration: none;
  }

  .form>p>a:hover {
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

  .form>input {
    border-radius: 50px;
  }

  .form>button {
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
<script src="js/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('#cadastrar').click(function() {
      var nome = $("#nome").val();
      var email = $("#email").val();
      var login = $("#login").val();
      var senha = $("#senha").val();
      $.ajax({
        url: 'php/cadastrar_usuario.php', // Substitua com o URL do seu script PHP
        type: "POST",
        data: "nome=" + nome + "&email=" + email + "&login=" + login + "&senha=" + senha,
        dataType: "html"
      }).done(function(resposta) {
        $("#resp").html(resposta);

      }).fail(function(jqXHR, textStatus) {
        console.log("Request failed: " + textStatus);

      }).always(function() {
        console.log("completou");
      });
    });
  });
</script>

<body>
  <div class="linha">
    <div class="column" id="esquerda">
      <div class="header">
        <h2 class="animation a2">Crie sua conta</h2>
      </div>
      <div id="resp"></div>
      <div class="form">

        <input type="text" id="nome" class="form-field animation a3" placeholder="Nome de Usuário" required>
        <input type="email" id="email" class="form-field animation a3" placeholder="E-mail" required>
        <input type="text" id="login" class="form-field animation a3" placeholder="Login" required>
        <input type="password" id="senha" class="form-field animation a3" placeholder="Senha" required>

        <br>
        <p class="animation a5"><a href="esqueceusenha.php">Esqueceu a senha?</a> <a href="login.php">Tem uma conta?</a></p>
        <button class="animation a7" id="cadastrar">Criar</button>
      </div>
    </div>
    <div class="direita"></div>
  </div>
</body>
</html>
<?php
}else{
  header('location: index.php');
} 
?>