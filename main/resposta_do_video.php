<?php
session_start();
require_once('php/conecta.php');
require_once('php/tempo.php');
if (isset($_SESSION['mensagem'])) {
  // Exibe a mensagem
  echo "<script>alert('{$_SESSION['mensagem']}');</script>";

  // Remove a mensagem da sessão para que ela não seja exibida novamente
  unset($_SESSION['mensagem']);
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Resposta da Pesquisa</title>

<meta name="viewport" content="width=device-width, initial-scale=1">


<!--LINKS-->
    <link rel="icon" href="Logo/logoicon.png" type="image/png">
    <link rel="stylesheet" href="css/barrapesquisavideo.css" />
    <link rel="stylesheet" href="css/modalhome.css">
        <link rel="stylesheet" type="text/css" href="css/postss.css">
        <link rel="stylesheet" type="text/css" href="css/modalhome.css">
    <link rel="stylesheet" href="css/tab.css" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/resppesquisa.css">
      <link rel="stylesheet" href="css/modal.css">
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
                    window.location.href = 'resposta_do_video.php?pesquisa=' + encodeURIComponent(pesquisa);
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
                    window.location.href = 'resposta_do_video.php?pesquisa=' + encodeURIComponent(pesquisa);
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
            // informações do usuario de acordo com a postagem
            $(".perfil-post").on('click', function() {
        $("#edd").text($(this).attr('id_perfil'));
        $("#nome_perfil").text($(this).attr('nome_perfil'));
        $("#email_perfil").text($(this).attr('e-mail'));

        var id_perfil = $(this).attr('id_perfil');

          // ajax quantidade publicação
        $.ajax({
            url: 'php/contagem_publicação.php',
            type: "POST",
            data: "id=" + id_perfil,
            dataType: "html"
          })
          .done(function(response) {
            $('#quantidade').html(response);
          })
          .fail(function(jqXHR, textStatus) {
            console.log("Request failed: " + textStatus);
          })
          .always(function() {
            console.log("Completou a requisição");
          });

          // link do usuario
          $.ajax({
            url: 'php/link_post.php',
            type: "POST",
            data: "id=" + id_perfil,
            dataType: "html"
          })
          .done(function(response) {
            $('.aparecer_link').html(response);
          })
          .fail(function(jqXHR, textStatus) {
            console.log("Request failed: " + textStatus);
          })
          .always(function() {
            console.log("Completou a requisição");
          });

            // ajax foto perfil
        $.ajax({
            url: 'php/validar_foto_perfil.php',
            type: "POST",
            data: "id=" + id_perfil,
            dataType: "html"
          })
          .done(function(response) {
            $('#resp_foto').html(response);
          })
          .fail(function(jqXHR, textStatus) {
            console.log("Request failed: " + textStatus);
          })
          .always(function() {
            console.log("Completou a requisição");
          });
      });

              //Jquery comentario
              $(".botao_coment").on('click', function() {
        $("#comentacao").text($(this).attr('id_post_coment'));
         id_perfil = $(this).attr('id_post_coment');
          
        $.ajax({
            url: 'php/exibir_comentario.php',
            type: "POST",
            data: "id=" + id_perfil,
            dataType: "html"
          })
          .done(function(response) {
            $('.exibir_comentarios').html(response);
          })
          .fail(function(jqXHR, textStatus) {
            console.log("Request failed: " + textStatus);
          })
          .always(function() {
            console.log("Completou a requisição");
          });
      
      });
      $('#comenta').on('click', function() {
        codigo_post = $("#comentacao").text();
        descricao = $("#descricaocoment").val();
        $.ajax({
            url: 'php/publicar_comentario.php',
            type: "POST",
            data: "id=" + codigo_post + "&desc=" + descricao,
            dataType: "html"
          })
          .done(function(response) {
            $('#resp_coment').html(response);
          })
          .fail(function(jqXHR, textStatus) {
            console.log("Request failed: " + textStatus);
          })
          .always(function() {
            console.log("Completou a requisição");
          });
      });

      $(".exclusao").on('click', function() {
        $("#exx").text($(this).attr('id_exc'));
      });

      $("#excluse").on('click', function() {
        codigo = $("#exx").text();
        $.ajax({
            url: "php/deletar_post.php",
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

      // Editar publicacao
      $(".alterar").on('click', function() {
        $("#publink").val($(this).data('href'));
        $("#edd").text($(this).attr('id_edt'));
        $("#descricao_edit").val($(this).attr('descricao'));
      });
      $('#salvar').on('click', function() {
        codigo = $("#edd").text();
        descricao = $("#descricao_edit").val();
        $.ajax({
            url: 'php/atualizar_post.php',
            type: "POST",
            data: "edit=" + codigo + "&desc=" + descricao,
            dataType: "html"
          })
          .done(function(response) {
            $('#resposta_edit').html(response);
          })
          .fail(function(jqXHR, textStatus) {
            console.log("Request failed: " + textStatus);
          })
          .always(function() {
            console.log("Completou a requisição");
          });
      });
      //filtro video
      $('#categoria-select-video').change(function() {
        var categoriaSelecionada = $(this).val();
        $('.publicacao-video').hide(); // Oculta todas as publicações
        if (categoriaSelecionada === 'todos') {
          $('.publicacao-video').show(); // Mostra todas as publicações se "todos" for selecionado
        } else {
          $('.categoria-video-' + categoriaSelecionada).show(); // Mostra apenas as publicações com a classe correspondente à categoria
        }
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

<h2><select id="categoria-select-video">
            <option value="todos">Todas as categorias</option>

            <?php
            // Recupere todas as categorias da tabela categoria_arquivo
            $stmtCategorias = $conn->query("SELECT * FROM categoria_arquivo");

            while ($rowCategoria = $stmtCategorias->fetch(PDO::FETCH_ASSOC)) {
              $categoriaNome = $rowCategoria['ds_categoria'];
              $categoriaId = $rowCategoria['cd_categoria'];
              $tipo = $rowCategoria['id_tipo'];
              if ($tipo == 1) {
                echo "<option value='$categoriaId'>$categoriaNome</option>";
              }
            }
            ?>
          </select></h2>
<?php
  $descricao = $_GET["pesquisa"];
  $descricaoPesquisa = "%" . trim($descricao) . "%";

  if (!empty($descricao)) {

    try {
      $stmt = $conn->prepare("SELECT DISTINCT
      post.cd_post,
      post.ds_post,
      post.dt_post,
      post.ds_arquivo,
      post.id_categoria,
      post.id_perfil,
      categoria_arquivo.cd_categoria,
      categoria_arquivo.ds_categoria,
      categoria_arquivo.id_tipo,
      perfil.cd_perfil,
      perfil.nm_perfil,
      perfil.nr_cell,
      perfil.ds_email,
      perfil.ds_login,
      perfil.ds_senha,
      perfil.ds_perfil,
      perfil.ds_imagem,
      perfil.dt_nascimento,
      perfil.dt_entrada,
      perfil.id_nivel
  FROM post
  JOIN categoria_arquivo ON post.id_categoria = categoria_arquivo.cd_categoria
  LEFT JOIN perfil ON post.id_perfil = perfil.cd_perfil
  WHERE post.ds_post LIKE :descricao
  GROUP BY post.cd_post
  ORDER BY post.ds_post ASC");
      $stmt->bindParam(":descricao", $descricaoPesquisa, PDO::PARAM_STR);
      $stmt->execute();
      $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if (count($resultados) > 0 && isset($descricaoPesquisa) && trim($_GET['pesquisa']) !== '') {
        foreach ($resultados as $resultado) {
          $id = $resultado['cd_post'];
          $nome = $resultado['nm_perfil'];
          $cd_perfil = $resultado['cd_perfil'];
          $email = $resultado['ds_email'];
          $arquivo = $resultado['ds_arquivo'];
          $perfil = $resultado['ds_imagem'];
          $descricao = $resultado['ds_post'];
          $id_perfil = $resultado['id_perfil'];
          $categoria = $resultado['ds_categoria'];
          $categoria_id = $resultado['cd_categoria'];
          $extensao = pathinfo($arquivo, PATHINFO_EXTENSION);
          $classeCategoria = 'categoria-video-' . $categoria_id;
          if (in_array($extensao, ['mp4', 'webm', 'ogv', 'mkv'])) {
  ?>
<div class="publicacao-video <?php echo $classeCategoria ?>">
              <div class="card">

                <div id="pontos">

                  <?php
                  if ($_SESSION['acesso'] == 2) {
                  ?>
                    <button type="button" class="btn exclusao alterar" data-toggle="modal" data-target="#opcoes-administrador" id_edt="<?php echo $id; ?>" id_exc="<?php echo $id; ?>" descricao="<?php echo $descricao; ?>" data-href="https://uniart.site/Uniart/post_compartilhado.php?post_comp=<?php echo $id ?>">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                        <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                      </svg>
                    </button>

                  <?php
                  } elseif ($_SESSION['id'] == $id_perfil) {
                  ?>
                    <button type="button" class="btn exclusao alterar" data-toggle="modal" data-target="#opcoes-usuario" id_edt="<?php echo $id; ?>" id_exc="<?php echo $id; ?>" descricao="<?php echo $descricao; ?>" data-href="https://uniart.site/Uniart/post_compartilhado.php?post_comp=<?php echo $id ?>">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                        <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                      </svg>
                    </button>
                  <?php
                  } else {
                  ?>
                    <button type="button" class="btn exclusao alterar" data-toggle="modal" data-target="#opcoes-visitante" id_edt="<?php echo $id; ?>" id_exc="<?php echo $id; ?>" descricao="<?php echo $descricao; ?>" data-href="https://uniart.site/Uniart/post_compartilhado.php?post_comp=<?php echo $id ?>">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                        <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                      </svg>
                    </button>
                  <?php
                  }
                  ?>

                </div>
                <div class="card-header">

                <video controls width='250px'>
                    <source src='php/upload_post/<?php echo $id; ?>/<?php echo $arquivo; ?>' type='video/mp4'>
                  </video><br>
                </div>
                <div class="card-content">
                  <span><?php echo $categoria; ?></span>
                  <p></p>
                  <p><?php echo $descricao; ?></p>
                </div>
                <div class="card-footer">
                <button type="button" class="btn btn-light perfil-post" data-toggle="modal" data-target="#Perfil_post" nome_perfil="<?php echo $nome; ?>" id_perfil="<?php echo $cd_perfil; ?>" caminho="<?php echo $perfil; ?>" e-mail="<?php echo $email; ?>">
                  <?php
                  if ($perfil === NUll) {
                    $fotoSrc = "php/upload_foto_perfil/usuario.png";
                  } else {
                    $fotoSrc = "php/upload_foto_perfil/{$cd_perfil}/{$perfil}";
                  }
                  ?>
                  <img src="<?php echo $fotoSrc; ?>" alt="Foto do usuário">
                </button>
                  <div class="author">
                    <p><?php echo $nome; ?></p>
                    <small><?php echo "Há " . tempo_corrido($resultado['dt_post']) . "<br>"; ?></small>
                  </div>
                  <div class="comentarios">
                  <button type="button" class="btn btn-light botao_coment" data-toggle="modal" data-target="#comentarios" id_post_coment="<?php echo $id; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-chat" viewBox="0 0 16 16">
                      <path d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z" />
                    </svg>
                  </button>
                </div>
                </div>

              </div>
            </div>
  <?php
        }else{
        }
      }
      } else {
        echo "Nenhum resultado encontrado.";
      }
    } catch (PDOException $e) {
      echo 'Error: ' . $e->getMessage();
    }
  } else {
    echo "Preencha os dados.";
  }
  ?>


 
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
<!-- FIM -->

<!-- MODAL DOS COMENTARIOS -->
<div class="modal fade " id="comentarios">
  <div class="modal-dialog  modal-dialog-scrollable modal-xl">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <?php if (!isset($_SESSION["login"])){
          ?>
           <button class="btn" style="background-color:#808080; color:white;" >Comentar</button>
          <?php
}else{
   ?>
        <button class="btn" style="background-color:#9600E1; color:white;" data-toggle="modal" data-target="#comentar" data-dismiss="modal">Comentar</button>
<?php
      }
?>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body exibir_comentarios" >



        <!-- <div class="card-footer">
          <button type="button" class="btn btn-light" data-toggle="modal" data-target="#exampleModalCenter">
            <img src="Logo/xavier.jpg">
          </button>
          <div class="author">
            <p>Xavin <small>tempo</small></p>
            <p>Eu sou um cara aleatorio comentando lol lol lol</p>
          </div>
        </div> -->

      </div>

    </div>
  </div>
</div>
<!-- fim -->

<!-- Modal CRIAR COMENTÁRIO -->
<div class="modal fade" id="comentar" role="dialog">
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
        Comentário:<br><textarea id="descricaocoment" name="descricao" maxlength="300" rows="5" cols="35" style="resize: none; border-radius:0.2em;width: 100%;" placeholder="Escreva seu comentário"></textarea>
        <div class="caracter">
          <div class="contadorcoment">0</div>
          <div class="limitecontador">/300</div>
        </div>
        <br>
        <ul>
          <div style="display: none;" id="comentacao"></div>
          <div id="resp_coment"> </div>
          <li><button class="btn botaocoment" style="background-color:#9600E1; color:white;" id="comenta"> Comentar</button></li>
          <p></p>
          <li><button type="button" class="btn btn-primary botaocoment" data-target="#comentarios" data-dismiss="modal" data-toggle="modal">Voltar</button></li>
        </ul>
      </div>
    </div>

  </div>
</div>
<!-- fim -->

<!-- Modal Excluir do COMENTÁRIO -->
<div class="modal fade" id="excluircoment" role="dialog">
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
        <p>Tem certeza que deseja excluir esse comentário?</p>
        <ul>
          <center>
            <li><button type="button" class="btn btn-danger botaocoment" id="#">Excluir</button></li>
            <p></p>
            <li><button type="button" class="btn btn-primary botaocoment" data-dismiss="modal" data-toggle="modal">Voltar</button></li>
          </center>
        </ul>
      </div>
    </div>

  </div>
</div>
<!-- fim -->


  
  <!-- modal quando clicar nos 3 pontos -->

  <!-- ADMINISTRADOR -->
  <div class="modal fade" id="opcoes-administrador" role="dialog">
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
          <ul id="modais">

            <li>
              <button type="button" class="btn opcao" data-toggle="modal" data-dismiss="modal" data-target="#excluir">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                  <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                </svg>
                Excluir Publicação</button>
            </li>

            <li>
              <button type="button" class="btn opcao" data-toggle="modal" data-dismiss="modal" data-target="#editar">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                  <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                </svg>
                Editar Publicação</button>
            </li>

            <li>
              <button type="button" class="btn opcao" data-toggle="modal" data-dismiss="modal" data-target="#compartilhar">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-share-fill" viewBox="0 0 16 16">
                  <path d="M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5z" />
                </svg>
                Compartilhar Publicação</button>
            </li>

          </ul>
        </div>
      </div>

    </div>
  </div>
  <!-- FIMM -->

<!-- POST DO PROPRIO USUARIO -->
<div class="modal fade" id="opcoes-usuario" role="dialog">
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
        <ul id="modais">

          <li>
            <button type="button" class="btn opcao" data-toggle="modal" data-dismiss="modal" data-target="#excluir">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
              </svg>
              Excluir Publicação</button>
          </li>

          <li>
            <button type="button" class="btn opcao" data-toggle="modal" data-dismiss="modal" data-target="#editar">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
              </svg>
              Editar Publicação</button>
          </li>

          <li>
            <button type="button" class="btn opcao" data-toggle="modal" data-dismiss="modal" data-target="#compartilhar">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-share-fill" viewBox="0 0 16 16">
                <path d="M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5z" />
              </svg>
              Compartilhar Publicação</button>
          </li>

        </ul>
      </div>
    </div>

  </div>
</div>


<!-- POST DE OUTRO USUARIO OU VISITANTE -->
<div class="modal fade" id="opcoes-visitante" role="dialog">
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
        <ul id="modais">

          <li>
            <button type="button" class="btn opcao" data-toggle="modal" data-dismiss="modal" data-target="#compartilhar">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-share-fill" viewBox="0 0 16 16">
                <path d="M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5z" />
              </svg>
              Compartilhar Publicação</button>
          </li>

        </ul>
      </div>
    </div>

  </div>
</div>
<!-- fim -->

  <!-- Modal do perfil da postagem -->
<div class="modal fade" id="Perfil_post" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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

      <div class="modal-body">
        <div class="container">
          <div class="card">
            <div class="profile-picture" id="resp_foto">

            </div>
            <h2 class="name">
              <div id="nome_perfil"></div>
            </h2>
            <h3 class="username">
              <div id="email_perfil"></div>
            </h3>
            <p class="description">O grupo horizon é o melhor de todos slk tomale</p>
            <p class="tagline">

            <div id="quantidade"></div>


            </p>
            <div class="aparecer_link"></div>
          </div>
        </div>
      </div>
      <?php

      ?>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>

      </div>
    </div>
  </div>
</div>

<!-- FIm -->

  <!-- Modais dos itens dentro do modal 3 pontos -->

  <!-- Modal Excluir -->
  <div class="modal fade" id="excluir" role="dialog">
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
          <p>Tem certeza que deseja excluir essa publicação?</p>
          <div id="exclua"></div>
          <br id="exx">
          <ul>
            <li><button type="button" class="btn btn-danger" id="excluse">Excluir</button></li>
            <li><button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#opcoes-administrador">Voltar</button></li>
          </ul>
        </div>

      </div>

    </div>
  </div>
  </div>
  <!-- fim -->

  <!-- Modal Compartilhar -->
  <div class="modal fade" id="compartilhar" role="dialog">
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
          <p>Deseja compartilhar essa publicação? Copie o link!</p>
          <input type="text" id="publink" placeholder="link da publicação">
          <p></p>
          <ul>
            <li><button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#opcoes-administrador">Voltar</button></li>
          </ul>
        </div>
      </div>

    </div>
  </div>
  </div>
  <!-- fim -->

  <!-- Modal Editar -->
  <div class="modal fade" id="editar" role="dialog">
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
          Descricão:<br><textarea id="descricao_edit" rows="5" cols="35" style="resize: none; border-radius:0.2em;width: 100%;" placeholder="Digite a descrição do arquivo..."></textarea>
          <br id="edd">
          <div id="resposta_edit"></div>
          <ul>
            <li><button class="btn btn-success" id="salvar">Salvar Mudanças</button></li>
            <li><button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#opcoes-administrador">Voltar</button></li>
          </ul>
        </div>
      </div>

    </div>
  </div>
<!-- fim -->
<!-- fim dos modais dentro do modal 3 pontos -->

<!-- Pegar funções bootstrap -->
<script src='bootstrap/js/bootstrap.bundle.min.js'></script>
</body>

</html>