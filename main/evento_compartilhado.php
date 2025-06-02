<?php
session_start();
require_once('php/conecta.php');
require_once('php/tempo.php');
?>
<!DOCTYPE html>
<html>

<head>
  <link rel="icon" href="data:,">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="Logo/logoicon.png" type="image/png">
  <title>Evento Compartilhado</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <script src="js/jquery-3.6.0.min.js"></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="css/visualizarpost.css">
  <link rel="stylesheet" href="css/fabbutton.css">
  <link rel="stylesheet" href="css/postss.css">
  <link rel="stylesheet" href="css/pesquisacomp.css">
  <link rel="stylesheet" href="css/modalhome.css">
  <link rel="stylesheet" href="css/tab.css">
  <script src="js/scriptpesquisa.js" defer></script>
  <script src="js/scripttabs.js" defer></script>
          <style>
  body {
    background-image: url('Logo/fundo_hori.jpg');
    background-repeat: no-repeat;
    background-position: center;
    background-attachment: fixed;
    background-size: cover;
  }
    </style>
  <!-- Unicons CSS -->
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
  <script>
    $(document).ready(function() {
      $('#form').submit(function(form_ajax) {
        form_ajax.preventDefault();
        var formData = new FormData(this);
        var erroExibido = false;
        $.ajax({
            url: 'php/publicar_post.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false
          })
          .done(function(response) {
            $('#resposta').html(response);
          })
          .fail(function(jqXHR, textStatus) {
            console.log("Request failed: " + textStatus);
          })
          .always(function() {
            console.log("Completou a requisição");
          });
      });

      function updateCategoriaDropdown(id_tipo) {
        $.ajax({
            type: "POST",
            url: "php/consulta_categoria.php",
            data: "tipo=" + id_tipo
          })
          .done(function(data) {
            $("#categoria").html('<option value="" disabled selected>Escolha a Categoria</option>' + data);
          })
          .fail(function(jqXHR, textStatus) {
            console.log("Request failed: " + textStatus);
          })
          .always(function() {
            console.log("Completou a requisição de categoria");
          });
      }



      $("#arquivo").on('change', function() {
        function exibirErro(mensagem) {
          $('#resposta').html(mensagem);
          erroExibido = true;
        }

        function ocultarErro() {
          $('#resposta').html("");
          erroExibido = false;
        }
        var fileName = $(this).val();
        var fileType = fileName.split('.').pop().toLowerCase();

        var tipoSelect = $("#tipo");
        switch (fileType) {
          case "mp4":
          case "webm":
          case "mkv":
          case "ogv":
            tipoSelect.val("1"); // Vídeo
            ocultarErro();
            break;
          case "mp3":
          case "mpeg":
          case "wav":
          case "ogg":
            tipoSelect.val("2"); // Áudio
            ocultarErro();
            break;
          case "jpg":
          case "jpeg":
          case "png":
          case "gif":
            tipoSelect.val("3"); // Imagem
            ocultarErro();
            break;
          default:
            tipoSelect.val("");
            exibirErro("Tipo de arquivo não suportado. Selecione um arquivo de vídeo, áudio ou imagem.");
            break;
        }

        updateCategoriaDropdown(tipoSelect.val());
      });

      $("#tipo").on('change', function() {
        var id_tipo = $(this).val();
        ocultarErro();
        updateCategoriaDropdown(id_tipo);
      });

// Exlcuir publicacao
$(".exclusao").on('click', function() {
        $("#publink").val($(this).data('href'));
        $("#exx").text($(this).attr('id_exc'));
      });

      $("#excluse").on('click', function() {
        codigo = $("#exx").text();
        $.ajax({
            url: "php/deletar_eventos.php",
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
        $("#edd").text($(this).attr('id_edt'));
        $("#descricao_edit").val($(this).attr('descricao'));
        $("#titulo_edit").val($(this).attr('titulo'));
        let data = new Date($(this).attr('dia'));
        let dataFormatada = data.toISOString().substring(0, 10);
        $("#data_edit").val(dataFormatada);
        $("#hora_edit").val($(this).attr('hora').substring(0, 5));
        $("#local_edit").val($(this).attr('local'));
      });
      $('#salvar').on('click', function() {
        codigo = $("#edd").text();
        descricao = $("#descricao_edit").val();
        titulo = $("#titulo_edit").val();
        dia = $("#data_edit").val();
        hora = $("#hora_edit").val();
        local = $("#local_edit").val();
        $.ajax({
            url: 'php/atualizar_eventos.php',
            type: "POST",
            data: "id=" + codigo + "&desc=" + descricao + "&titulo=" + titulo + "&dia=" + dia + "&hora=" + hora + "&local=" +local,
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
      //Visualizar imagem da publicação
      $(".postagem").on('click', function() {
        $('#exibir').attr('src', $(this).attr('src'));
      });
            //Visualizar imagem da publicação
      $(".postagem").on('click', function() {
        $('#exibir').attr('src', $(this).attr('src'));
      });
    });
  </script>
</head>

<body>
  <!-- NAV1 -->
  <nav class="nav">
    <i class="uil uil-bars navOpenBtn"></i>
    <a href="index.php" class="logo"><img id="logo" src="Logo/logosemtexto.png"></a>

    <input type="text" id="pesquisas" placeholder="Pesquisa no Uniart" />

  </nav>
  <!-- post -->
  <p></p>
  <div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-company" role="tabpanel" aria-labelledby="pills-company-tab">
      <div class="container-fluid">
        <?php
        $stmt = $conn->prepare("SELECT DISTINCT
        eventos.cd_eventos,
        eventos.ds_titulo,
        eventos.ds_eventos,
        eventos.hr_eventos,
        eventos.dt_eventos,
        eventos.tp_eventos,
        eventos.st_local,
        eventos.ds_arquivo,
        eventos.id_categoria,
        categoria_eventos.cd_categoria,
        categoria_eventos.ds_categoria
    FROM eventos
    JOIN categoria_eventos ON eventos.id_categoria = categoria_eventos.cd_categoria
    WHERE eventos.cd_eventos = :id
    GROUP BY eventos.cd_eventos");
          $stmt->bindParam(':id', $_GET['evento_comp'], PDO::PARAM_INT);
          $stmt->execute();
          if($stmt->rowCount() != 0 ) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $id = $row["cd_eventos"];
          $titulo = $row["ds_titulo"];
          $desc = $row["ds_eventos"];
          $hora = $row["hr_eventos"];
          $data = $row["dt_eventos"];
          $tempo = $row["tp_eventos"];
          $local = $row["st_local"];
          $arquivo = $row["ds_arquivo"];
          $categoria = $row["ds_categoria"];
          $extensao = pathinfo($arquivo, PATHINFO_EXTENSION);

        ?>
          <!-- POST EVENTO -->
          <div class="publicacao">
            <div class="card">

              <div id="pontos">
                <?php
                if ($_SESSION['acesso'] == 2) {
                ?>
                  <button type="button" class="btn exclusao alterar" data-toggle="modal" data-target="#opcoes-administrador" id_edt="<?php echo $id; ?>" id_exc="<?php echo $id; ?>" descricao="<?php echo $desc; ?>" titulo="<?php echo $titulo; ?> " hora="<?php echo $hora; ?> " dia="<?php echo $data; ?> " local="<?php echo $local; ?> " categoria="<?php echo $categoria; ?> " data-href="http://localhost:8081/Uniart2/evento_compartilhado.php?evento_comp=<?php echo $id ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                      <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                    </svg>
                  </button>

                <?php
                }
                ?>
              </div>

              <div class="card-header">
                <?php
                if (in_array($extensao, ['jpg', 'jpeg', 'png', 'gif'])) {
                ?>
                  <img id_foto="<?php echo $id; ?>" visu="<?php echo $arquivo; ?>" class="postagem" data-toggle="modal" data-bs-toggle="tooltip" title="Clique para deixar em tela cheia" data-target="#visualizar" src='php/upload_eventos/<?php echo $id; ?>/<?php echo $arquivo; ?>' alt='Imagem' width='250px'><br>
              </div>
            <?php
                } elseif (in_array($extensao, ['mp4', 'webm', 'ogv', 'mkv'])) {
            ?>
              <video controls width='250px'>
                <source src='php/upload_eventos/<?php echo $id; ?>/<?php echo $arquivo; ?>' type='video/mp4'>
              </video><br>
            </div>
          <?php
                } elseif (in_array($extensao, ['mp3', 'mpeg', 'wav', 'ogg'])) {
          ?>
            <img src="Logo/audio.png" style="width:75%; height:75%; object-fit: scale-down; object-position: center;">
          </div>
          <audio controls style="width:100%;">
            <source src='php/upload_eventos/<?php echo $id; ?>/<?php echo $arquivo; ?>' type='audio/mp3'>
          </audio><br>
        <?php
                }
        ?>
        <div class="card-content">

          <!-- DETALHES DO EVENTO -->
          <span><?php echo $categoria; ?></span>
          <br>

          <!-- Titulo do Evento -->
          <h1><?php echo $titulo; ?></h1>
          <br>

          <!-- Data do Evento -->
          <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar3" viewBox="0 0 16 16">
              <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857V3.857z" />
              <path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
            </svg>
            <b>Data:</b> <?php echo date('d/m/Y', strtotime($data)); ?>
          </p>
          <br>

          <!-- Hora do Evento -->
          <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock-fill" viewBox="0 0 16 16">
              <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
            </svg>
            <b>Hora:</b> <?php echo date('H:i', strtotime($hora)); ?>
          </p>
          <br>

          <!-- Local do Evento -->
          <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
              <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
            </svg>
            <b>Local:</b> <?php echo $local; ?>
          </p>
          <br>

          <!-- Descrição do Evento -->
          <p><b><?php echo $desc; ?></b></p>
        </div>
        <div class="card-footer">
          <button type="button" class="btn btn-light" data-toggle="modal" data-target="#exampleModaleft">
            <img src="Logo/etec_itanham_logo.jpeg">
          </button>
          <div class="author">
            <p>Etec de Itanhaém</p>
            <small><?php echo "Há " . tempo_corrido($tempo) . "<br>"; ?></small>
          </div>
        </div>
      </div>

    </div>
  </div>
<?php
 }

 }else{
  echo '<center>Link errado, volte para página principal</center>';

}
?>
</div>


</div>

  <!-- partial -->

  <!-- AQUI TA SÓ OS MODAL SLK -->

  <!-- Modal -->
  <div class="modal fade view" id="visualizar" role="dialog">
    <img id="exibir" class="modal-dialog" data-toggle="modal" data-target="#visualizar">
  </div>
  <!-- fim -->

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

<!-- modal quando clicar no perfil do evento -->
<div class="modal fade" id="exampleModaleft" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
      ?>
      <div class="modal-body">
        <div class="container">
          <div class="card">
            <div class="profile-picture">

              <img src="Logo/etec_itanham_logo.jpeg" alt="Profile Picture2">

            </div>
            <h2 class="name">Etec de Itanhaém</h2>
            <h3 class="username">e158dir@cps.sp.gov.br</h3>
            <p class="description">O grupo horizon é o melhor de todos slk tomale</p>
            <p class="tagline">


            </p>

          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>

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
              Excluir Evento</button>
          </li>

          <li>
            <button type="button" class="btn opcao" data-toggle="modal" data-dismiss="modal" data-target="#editar">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
              </svg>
              Editar Evento</button>
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
              Compartilhar Evento</button>
          </li>

        </ul>
      </div>
    </div>

  </div>
</div>
<!-- FIM -->

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
        <p>Tem certeza que deseja excluir esse evento?</p>
        <div id="exclua"></div>
        <br id="exx">
        <ul>
          <li><button type="button" class="btn btn-danger" id="excluse">Excluir</button></li>
          <li><button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#opcoes">Voltar</button></li>
        </ul>
      </div>

    </div>

  </div>
</div>
</div>
<!-- fim -->

<!-- Modal Editar -->
<div class="modal fade" id="editar" role="dialog">
  <div class="modal-dialog modal-dialog-scrollable">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="background-color:#9600E1;">
        <h4 class="modal-title" style="color: white;">Editar Evento</h4>

        <button type="button" class="close" data-dismiss="modal">
          <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
          </svg>
        </button>
      </div>
      <div class="modal-body">

        <strong>
          <p>Título</p>
        </strong>
        <input type="text" id="titulo_edit" placeholder="Título do Evento">
        <br><br>
        <strong>
          <p>Data</p>
        </strong>
        <input type="date" id="data_edit">
        <br><br>
        <strong>
          <p>Horário</p>
        </strong>
        <input type="time" id="hora_edit">
        <br><br>
        <strong>
          <p>Local</p>
        </strong>
        <input type="text" id="local_edit" placeholder="Endereço do Evento">
        <br><br>

        Descricão:<br><textarea id="descricao_edit" rows="5" cols="35" style="resize: none; border-radius:0.2em;width: 100%;" placeholder="Digite a descrição do evento..."></textarea>
        <br id="edd">
        <div id="resposta_edit"></div>
        <ul>
          <li><button class="btn btn-success" id="salvar">Salvar Mudanças</button></li>
          <li><button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#opcoes">Voltar</button></li>
        </ul>
      </div>
    </div>

  </div>
</div>
</div>
<!-- fim -->

    <!-- Legenda da foto para deixar em tela cheia -->
    <script>
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
      })
    </script>
    <!-- fim -->

    <script>
      $('#arquivo').on('change', function() {
        $input = $(this);
        if ($input.val().length > 0) {
          fileReader = new FileReader();
          fileReader.onload = function(data) {
            $('.image-preview').attr('src', data.target.result);
          }
          fileReader.readAsDataURL($input.prop('files')[0]);
          $('.image-button').css('display', 'none');
          $('.image-preview').css('display', 'block');
          $('.change-image').css('display', 'block');
        }
      });

      $('.change-image').on('mouseenter', function() {
        // Quando o cursor entra na área do elemento .change-image
        $(this).css('cursor', 'pointer');
      }).on('mouseleave', function() {
        // Quando o cursor sai da área do elemento .change-image
        $(this).css('cursor', 'auto');
      });

      $('.change-image').on('click', function() {
        $control = $(this);
        $('#arquivo').val('');
        $preview = $('.image-preview');
        $preview.attr('src', '');
        $preview.css('display', 'none');
        $control.css('display', 'none');
        $('.image-button').css('display', 'block');
      });
    </script>

    <!-- fim -->
    <script src='bootstrap/js/bootstrap.bundle.min.js'></script>
</body>

</html>