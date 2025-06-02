<?php
session_start();
  require_once('php/conecta.php');
  require_once('php/tempo.php');
?>
  <!DOCTYPE html>
  <html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--LINKS-->
    <link rel="icon" href="Logo/logoicon.png" type="image/png">
    <link rel="stylesheet" href="css/barrapesquisaperfil.css" />
    <link rel="stylesheet" href="css/operfil.css" />
    <link rel="stylesheet" href="css/editarperfil.css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

    <!-- fabbutton -->
    <link rel="stylesheet" href="css/fabbutton.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <link rel="style" href="https://cdn.amazingneo.com/releases/v1.2.0/amazing-neo-1.2.0.css">
        <style>
  body {
    background-image: url('Logo/fundo_hori.jpg');
    background-repeat: no-repeat;
    background-position: center;
    background-attachment: fixed;
    background-size: cover;
  }
    </style>
    <!-- SCRIPTS -->
    <script src="js/scriptpesquisa.js" defer></script>
    <script src="js/scripttabs.js" defer></script>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/jquery.mask.min.js"></script>
    <script>
      $(document).ready(function() {
          function realizarPesquisa() {
                var pesquisa = $("#pesquisa").val();
                $.ajax({
                    url: 'resposta_da_pesquisa.php',
                    type: "GET",
                    data: { pesquisa: pesquisa }, // Envie os dados como um objeto
                    dataType: "html"
                })
                .done(function(response) {
                    // Redirecione para a página desejada
                    window.location.href = 'resposta_da_pesquisa.php?pesquisa=' + encodeURIComponent(pesquisa);
                })
                .fail(function(jqXHR, textStatus) {
                    console.log("Request failed: " + textStatus);
                })
                .always(function() {
                    console.log("Completou a requisição");
                });
            }

            // Captura o clique no botão
            $("#botao_pesquisa").click(function() {
                realizarPesquisa();
            });

            // Captura a tecla "Enter" no campo de pesquisa
            $("#pesquisa").keypress(function(e) {
                if (e.which === 13) { // Verifica se a tecla pressionada é a tecla "Enter"
                    realizarPesquisa();
                }
            });

            function realizarPesquisas() {
                var pesquisa = $("#pesquisas").val();
                $.ajax({
                    url: 'resposta_da_pesquisa.php',
                    type: "GET",
                    data: { pesquisa: pesquisa }, // Envie os dados como um objeto
                    dataType: "html"
                })
                .done(function(response) {
                    // Redirecione para a página desejada
                    window.location.href = 'resposta_da_pesquisa.php?pesquisa=' + encodeURIComponent(pesquisa);
                })
                .fail(function(jqXHR, textStatus) {
                    console.log("Request failed: " + textStatus);
                })
                .always(function() {
                    console.log("Completou a requisição");
                });
            }
            // Captura a tecla "Enter" no campo de pesquisa
            $("#pesquisas").keypress(function(e) {
                if (e.which === 13) { // Verifica se a tecla pressionada é a tecla "Enter"
                    realizarPesquisas();
                }
            });
          
        $('#telefone').mask('(00) 00000-0000');

        $('#form_perfil').submit(function(form_ajax) {
          form_ajax.preventDefault();
          var formData = new FormData(this);
          $.ajax({
              url: 'php/atualizar_perfil.php',
              type: 'POST',
              data: formData,
              processData: false,
              contentType: false
            })
            .done(function(response) {
              $('#resposta').html(response);
              if (response === "Perfil Atualizado com Sucesso!") {
            setTimeout(function() {
              location.reload();
            }, 1000);
          }
            })
            .fail(function(jqXHR, textStatus) {
              console.log("Request failed: " + textStatus);
            })
            .always(function() {
              console.log("Completou a requisição");
            });
        });

      });
    </script>

    <title>Perfil</title>

  </head>

  <body>
    <!-- NAV1 -->
    <nav class="nav">
    <a href="index.php" class="logo"><img id="logo" src="Logo/logosemtexto.png"></a>
    <input type="text" id="pesquisas" placeholder="Pesquisa no Uniart"/>

  </nav>

    <!-- CARD PERFIL -->

    <div class="perfil">
      <div class="caixa" style="position: relative;top:10em;">
        <div class="conteudo">
          <div class="container">
            <div class="row">
              <div class="col-md-12 ml-auto mr-auto">
                <div class="profile">
                  <div class="avatar">
                    <?php
                    try {
                      // Verifica se a variável de sessão $_SESSION['foto'] está definida
                      // Consulta para verificar se a imagem de perfil está definida
                      $stmt = $conn->prepare("SELECT * FROM perfil WHERE cd_perfil = :id");
                      $stmt->bindParam(":id", $_GET['vizu_perfil'], PDO::PARAM_INT);
                      $stmt->execute();
                      $row = $stmt->fetch(PDO::FETCH_ASSOC);
                      $nome = $row['nm_perfil'];
                      $cd = $row['cd_perfil'];
                      $email = $row['ds_email'];
                      $descricao = $row['ds_perfil'];

                      if ($row['ds_imagem'] === null) {
                        $fotoSrc = "php/upload_foto_perfil/usuario.png";
                      } else {
                        $fotoSrc = "php/upload_foto_perfil/{$cd}/{$row['ds_imagem']}";
                      }
                    } catch (PDOException $e) {
                      echo "Erro de banco de dados: " . $e->getMessage();
                    } catch (Exception $e) {
                      echo "Erro: " . $e->getMessage();
                    }
                    ?>
                    <?php
                      if ($_SESSION['id'] == $cd){
                        echo "<script> 
                        window.location.href = 'index.php';
                      </script>";
                        
                      }else{
                        ?>
               <div style="margin:auto;">
                      <div class="fotoo">
                        <img id="fotin" src="<?php echo $fotoSrc; ?>" style="height:100%;border-radius: 100%;border-color:purple;border-style: solid;border-width: 0.3em;box-shadow: 0px 10px 10px darkgray; ">
                      </div>
        </div>

                  </div>

                  <!-- título e ícones -->
                  <div class="redes" style="position: relative;top: -4em; ">
                    <h3 class="title"><?php echo $nome; ?></h3>

                    <p style="color:gray;height:1em;font-size: 0.9em;">
                      Número:
                      <?php
                      $telefone = $row['nr_cell'];
                      if ($telefone == null) {
                        echo "Não Cadastrado";
                      } else {
                        $telefone_formatado = '(' . substr($telefone, 0, 2) . ') ' . substr($telefone, 2, 5) . '-' . substr($telefone, 7, 4);
                        echo $telefone_formatado;
                      }
                      ?>

                    </p><br>

                    <p style="color:gray;height:1em;font-size: 0.9em;">Email: <?php echo $email; ?></p><br>

                    <p style="color:gray;height:1em;font-size: 0.9em;">
                      Data de Nascimento:
                      <?php
                      $data = $row['dt_nascimento'];
                      if ($data == null) {
                        echo "Não Cadastrada";
                      } else {
                        $data_formatada = date('d/m/Y', strtotime($data));
                        echo $data_formatada;
                      }
                      ?>
                    </p><br>

                    <p style="color:gray;height:1em;font-size: 0.9em;">
                      Uniartista desde:
                      <?php
                      $entrada = $row['dt_entrada'];
                      $entrada_formato = date('d/m/Y', strtotime($entrada));
                      echo $entrada_formato;

                      ?>
                    </p>

                  </div>
                
                <!--Conteúdo -->
                <div class="desc" style="text-align: left; width: 100%; margin-bottom: 10rem;">
                  <h5>Sobre:</h5>
                  <p><?php echo $descricao; ?></p>
                </div>
                <!-- Arquivos do Perfil -->
                <center>
                  <div class="tab-content tab-space" style="margin-top: 10em;align-content: center;align-items: center;">
                  </div>
                </center>


                <!-- FOOTER -->

                <footer class="footer text-center ">
                  <p style="color: black;position: relative;top:5em;">Proj-Uniart © 2023 All Rights Reserved</p>
                </footer>
                  <?php
                    }
                  ?>   
                
                <!-- Pra funcionar o modal -->
                <script src='bootstrap/js/bootstrap.bundle.min.js'></script>
  </body>

  </html>
<?php
?>