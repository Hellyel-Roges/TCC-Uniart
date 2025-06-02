<?php
session_start();
require_once('php/conecta.php');
require_once('php/tempo.php');
if (!isset($_SESSION['login'])) {
  $id_sessao = 0;
}else{
  $id_sessao = $_SESSION['id'];
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Resposta da Pesquisa</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!--LINKS-->
  <link rel="icon" href="Logo/logoicon.png" type="image/png">
  <link rel="stylesheet" href="css/barrapesquisa.css" />
  <link rel="stylesheet" href="css/tab.css" />
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/respperfil.css">
  <link rel="stylesheet" href="css/modalpesq.css">
  <!-- fabbutton -->
  <link rel="stylesheet" href="css/fabbutton.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">


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
      // Exlcuir publicacao
      $(".exc_perfil").on('click', function() {
        $("#codigo_perfil").text($(this).attr('id_perfil'));
      });

      $("#excluse_perfil").on('click', function() {
        codigo = $("#codigo_perfil").text();
        $.ajax({
            url: "php/deletar_perfil.php",
            type: "POST",
            data: "deletar=" + codigo,
            dataType: "html"
          })
          .done(function(resposta) {
            $("#exclua").html(resposta);
          })
          .fail(function(jqXHR, textStatus) {
            console.log("Request failed: " + textStatus);
          })
          .always(function() {
            console.log("Completou a requisição de exclusão");
          });
      });
    });
  </script>
</head>

<body>


  <!-- NAV1 -->

  <nav class="nav">


<!-- logotipo -->

<a href="index.php" class="logo">
  <img id="logo" src="Logo/logohome.png"></a>

<!-- Barra de pesquisa reduzida -->

<!-- Tabs -->
<i class="uil uil-bars navOpenBtn" id="tabsicon"></i>
<ul class="nav-links">

  <i class="uil uil-times navCloseBtn"></i>

  <li class="nav-item" role="presentation">
    <a href="resposta_da_pesquisa.php?pesquisa=<?php echo $_GET['pesquisa']; ?>" style="color: white;text-decoration: none;">Perfil
    </a>
    </a>
  </li>

  <li class="nav-item" role="presentation">
    <a href="resposta_da_imagem.php?pesquisa=<?php echo $_GET['pesquisa']; ?>" style="color: white;text-decoration: none;">Imagens
    </a>
    </a>
  </li>

  <li class="nav-item" role="presentation">
    <a href="resposta_do_video.php?pesquisa=<?php echo $_GET['pesquisa']; ?>" style="color: white;text-decoration: none;">Vídeos
    </a>
    </a>
  </li>

  <li class="nav-item" role="presentation">

    <a href="resposta_do_audio.php?pesquisa=<?php echo $_GET['pesquisa']; ?>" style="color: white;text-decoration: none;">Áudios</a>
    </a>
  </li>

  <li class="nav-item" role="presentation">

    <a href="index.php" style="color: white;text-decoration: none;">Voltar ao Início</a>
    </a>
  </li>
</ul>

<input type="search" value="<?php echo $_GET['pesquisa']; ?>" id="pesquisas" placeholder="Pesquisa no Uniart" />

<i class="uil uil-search search-icon" id="searchIcon"></i>
    <div class="search-box">
      <i class="uil uil-search search-icon" id="botao_pesquisa"></i>
      <input type="search" value="<?php echo $_GET['pesquisa']; ?>" id="pesquisa" placeholder="Pesquisa no Uniart" />
    </div>

</nav>




  <!-- PERFIS -->

  <?php
  $nome = $_GET["pesquisa"];
  $nomePesquisa = "%" . trim($nome) . "%";

  if (!empty($nome) && isset($_GET['pesquisa']) !== ' ') {

    try {
      $stmt = $conn->prepare("SELECT * FROM perfil WHERE nm_perfil LIKE :nome and (cd_perfil != $id_sessao) ORDER BY nm_perfil ASC");
      $stmt->bindParam(":nome", $nomePesquisa, PDO::PARAM_STR);
      $stmt->execute();
      $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if (count($resultados) > 0 && isset($nomePesquisa) && trim($_GET['pesquisa']) !== '') {
        foreach ($resultados as $resultado) {
          $nomes = $resultado["nm_perfil"];
          $imagem = $resultado['ds_imagem'];
          $cd = $resultado['cd_perfil'];
          if ($_SESSION["acesso"] == 2) {
  ?>
            <div style=" border-bottom: solid;border-color: lightgray;border-width: 0.1  rem; background-color:purple;">

              <div class="corpo grid" style="background-color:white;">

                <div class="foto" style="background-color:white;">
                  <?php
                  if ($imagem === null) {
                    echo '<img id="fotin" src="php/upload_foto_perfil/usuario.png" alt="Profile Picture2">';
                  } else {
                    echo '<img id="fotin" src="php/upload_foto_perfil/' . $cd . '/' . $imagem . '" alt="Profile Picture2">';
                  }
                  ?>
                </div>
                <div class="nome justify-content-md-center" style="width: 100%;">
                  <h5 class="item" id=”full-width-img” style="width: 100%;"><a href="https://uniart.site/Uniart/perfil2.php?vizu_perfil=<?php echo $cd; ?>"><?php echo $nomes; ?></a></h5>
                  <h7>
                    <?php
                    try {
                      $statment = $conn->prepare("SELECT COUNT(*) AS total_posts FROM post WHERE id_perfil = :user_id");
                      $statment->bindParam(':user_id', $cd, PDO::PARAM_INT);
                      $statment->execute();
                      $result = $statment->fetch(PDO::FETCH_ASSOC);
                      if ($result) {
                        $total_posts = $result['total_posts'];
                        if ($total_posts < 1) {
                          echo "Sem Publicações";
                        } elseif ($total_posts == 1) {
                          echo " $total_posts Publicação feita";
                        } else
                          echo " $total_posts Publicações feitas";
                      }
                    } catch (PDOException $e) {
                      echo "error" . $e->getMessage();
                    }
                    ?>
                  </h7>
                  <button class="btn btn-danger exc_perfil" data-toggle="modal" data-target="#excluirperfil" id="apagarcoment" id_perfil="<?php echo $cd; ?>">
                    <svg style="color: white;" xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                      <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                      <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                    </svg>
                  </button>

                </div>
              </div>
            </div>
          <?php
          } else {
          ?>
            <div style="border-bottom: solid;border-color: lightgray;border-width: 0.1rem;">
              <div class="corpo grid">

                <div class="foto">
                  <?php
                  if ($imagem === null) {
                    echo '<img id="fotin" src="php/upload_foto_perfil/usuario.png" alt="Profile Picture2">';
                  } else {
                    echo '<img id="fotin" src="php/upload_foto_perfil/' . $cd . '/' . $imagem . '" alt="Profile Picture2">';
                  }
                  ?>
                </div>
                <div class="nome justify-content-md-center" style="width: 100%;">
                  <h5 class="item" id=”full-width-img” style="width: 100%;"><a href="https://uniart.site/Uniart/perfil2.php?vizu_perfil=<?php echo $cd; ?>"><?php echo $nomes; ?></a></h5>
                  <h7>
                    <?php
                    try {
                      $statment = $conn->prepare("SELECT COUNT(*) AS total_posts FROM post WHERE id_perfil = :user_id");
                      $statment->bindParam(':user_id', $cd, PDO::PARAM_INT);
                      $statment->execute();
                      $result = $statment->fetch(PDO::FETCH_ASSOC);
                      if ($result) {
                        $total_posts = $result['total_posts'];
                        if ($total_posts < 1) {
                          echo "Sem Publicações";
                        } elseif ($total_posts == 1) {
                          echo " $total_posts Publicação feita";
                        } else
                          echo " $total_posts Publicações feitas";
                      }
                    } catch (PDOException $e) {
                      echo "error" . $e->getMessage();
                    }
                    ?>
                  </h7>
                </div>
              </div>
            </div>
  <?php
          }
        }
      } else {
        echo "Nenhum resultado encontrado.";
      }
    } catch (PDOException $e) {
      echo 'Error: ' . $e->getMessage();
    }
  } else {
    echo "Preencha os campos.";
  }
  ?>








  <!-- modal quando clicar no perfil -->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">
              <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
              </svg>
            </span>
          </button>
        </div>
        <?php
        if (isset($_SESSION['login'])) {
        ?>
          <div class="modal-body">
            <div class="container">
              <div class="card">
                <div class="profile-picture">
                  <?php
                  try {
                    // Verifica se a variável de sessão $_SESSION['foto'] está definida
                    // Consulta para verificar se a imagem de perfil está definida
                    $verificaImagem = $conn->prepare("SELECT ds_imagem FROM perfil WHERE cd_perfil = :id");
                    $verificaImagem->bindParam(":id", $_SESSION['id'], PDO::PARAM_INT);
                    $verificaImagem->execute();
                    $imagem = $verificaImagem->fetch(PDO::FETCH_ASSOC);

                    if ($imagem['ds_imagem'] === null) {
                      $fotoSrc = "php/upload_foto_perfil/usuario.png";
                    } else {
                      $fotoSrc = "php/upload_foto_perfil/{$_SESSION['id']}/{$imagem['ds_imagem']}";
                    }
                  } catch (PDOException $e) {
                    echo "Erro de banco de dados: " . $e->getMessage();
                  } catch (Exception $e) {
                    echo "Erro: " . $e->getMessage();
                  }
                  ?>
                  <img id="fotin" src="<?php echo $fotoSrc; ?>" alt="Profile Picture2">

                </div>
                <h2 class="name"><?php
                                  echo $_SESSION['nome'];
                                  ?></h2>
                <h3 class="username"><?php
                                      echo $_SESSION['email'];
                                      ?></h3>
                <p class="description">O grupo horizon é o melhor de todos slk tomale</p>
                <p class="tagline">

                  <?php

                  $stmt = $conn->prepare("SELECT COUNT(*) AS total_posts FROM post WHERE id_perfil = :user_id");
                  $stmt->bindParam(':user_id', $_SESSION['id'], PDO::PARAM_INT);
                  $stmt->execute();
                  $result = $stmt->fetch(PDO::FETCH_ASSOC);
                  if ($result) {
                    $total_posts = $result['total_posts'];
                    if ($total_posts < 1) {
                      echo "Sem Publicações";
                    } elseif ($total_posts == 1) {
                      echo " $total_posts Publicação feita";
                    } else
                      echo " $total_posts Publicações feitas";
                  }
                  ?>


                </p>
                <a href="perfil.php" id="visitar" class="button">Visitar Perfil</a>
                <a href="php/logout.php" id="visitar" class="button bg-danger" style="margin-top:0.5em;">Sair do Perfil</a>
              </div>
            </div>
          </div>
        <?php
        } else {
        ?>
          <div class="modal-body">
            <div class="container">
              <div class="card">
                <div class="profile-picture">
                  <img src="php/upload_foto_perfil/visitante.png" alt="Profile Picture">
                </div>
                <h2 class="name">Visitante</h2>
                <h3 class="username">XXXXX</h3>
                <p class="description">XXXXXXXXXX</p>
                <p class="tagline">XX publicações</p>
                <a href="login.php" id="visitar" class="button">Já tem uma conta?</a>
                <a href="cadastro.php" id="visitar" class="button bg-success" style="margin-top:0.5em;">Ainda não tem uma conta?</a>
              </div>
            </div>
          </div>
        <?php
        }
        ?>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>

        </div>
      </div>
    </div>
  </div>
  <!-- fim -->

  <!-- Modal Excluir do COMENTÁRIO -->
  <div class="modal fade" id="excluirperfil" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
              <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
            </svg>
          </button>
        </div>

        <div class="modal-body">
          <p>Tem certeza que deseja excluir esse Perfil?</p>
          <div id="codigo_perfil" style="display:none;"></div>
          <ul>
            <center>
              <div id="exclua"></div>
              <li><button type="button" class="btn btn-danger botaocoment" style="width:100%;height: 3em;" id="excluse_perfil">Excluir</button></li>
              <p></p>
              <li><button type="button" class="btn btn-primary botaocoment" data-dismiss="modal" style="width:100%;height: 3em;" data-toggle="modal">Voltar</button></li>
            </center>
          </ul>
        </div>
      </div>

    </div>
  </div>
  </div>
  <!-- fim -->


  <!-- Pegar funções bootstrap -->
  <script src='bootstrap/js/bootstrap.bundle.min.js'></script>
</body>

</html>