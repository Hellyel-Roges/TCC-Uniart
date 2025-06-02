<?php
session_start();
if (isset($_SESSION['login'])) {
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
      });
    </script>

    <title>Perfil</title>

  </head>

  <body>
    <!-- NAV1 -->
  <nav class="nav">
    <a href="index.php" class="logo"><img id="logo" src="Logo/logosemtexto.png"></a>
    <input type="search" id="pesquisas" placeholder="Pesquisa no Uniart"/>

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

                    <center>
                      <div class="fotoo">
                        <img id="fotin" src="<?php echo $fotoSrc; ?>" style="height:100%;border-radius: 100%;border-color:purple;border-style: solid;border-width: 0.3em;box-shadow: 0px 10px 10px darkgray; ">
                      </div>
                    </center>

                  </div>

                  <!-- título e ícones -->
                  <div class="redes" style="position: relative;top: -4em; ">
                    <h3 class="title"><?php echo $_SESSION['nome'] ?></h3>

                    <p style="color:gray;height:1em;font-size: 0.9em;">
                      Número:
                      <?php
                      $telefone = $_SESSION['telefone'];
                      if ($telefone == null) {
                        echo "Não Cadastrado";
                      } else {
                        $telefone_formatado = '(' . substr($telefone, 0, 2) . ') ' . substr($telefone, 2, 5) . '-' . substr($telefone, 7, 4);
                        echo $telefone_formatado;
                      }
                      ?>

                    </p><br>

                    <p style="color:gray;height:1em;font-size: 0.9em;">Email: <?php echo $_SESSION['email'] ?></p><br>

                    <p style="color:gray;height:1em;font-size: 0.9em;">
                      Data de Nascimento:
                      <?php
                      $data = $_SESSION['idade'];
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
                      $entrada = $_SESSION['entrada'];
                      $entrada_formato = date('d/m/Y', strtotime($entrada));
                      echo $entrada_formato;

                      ?>
                    </p>

                  </div>
                  <!-- Modal 3 -->


                  <button type="button" class="btn btn-outline-primary" role="button" data-toggle="modal" data-target="#exampleModal" style="position: relative;top:-3em;align-items: right;margin-left:0%;border-radius: 10em;background-color:#9600E1;color: white;border-color: transparent;">
                    Editar
                  </button>

                  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">

                      <div class="modal-content">

                        <div class="modal-header" style="background-color:#9600E1;">

                          <h5 class="modal-title" id="exampleModalLabel" style="color: white;">Editar Perfil</h5>

                          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="filter: brightness(5);">
                            <span aria-hidden="true" style="filter: brightness(5);">&times;</span>
                          </button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body" style="text-align: left;">
                          <p>Alterar Foto de Perfil:</p>


                          <!-- <div class="imgperfil">
<img src="logo/giovanne.jpg"  id="alterar_foto" >
</div> -->

                          <div class="media-control">

                            <form id="form_perfil" enctype="multipart/form-data">
                              <input type="number" name="id" style="display:none;" value="<?php echo $_SESSION['id']; ?>">
                              <br>

                              <div class="preperfil">
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
                                <img src="<?php echo $fotoSrc; ?>" alt="Profile Picture2" class="image-preview">
                              </div>
                              <br>
                              <!-- enviar arquivo -->
                              <div class="image-input">
                                <input type="file" id="arquivo" name="arquivo">
                                <label for="arquivo" class="image-button">Envie sua Mídia</label>
                                <span class="change-image">
                                  <p>Remover Mídia</p>
                                </span>
                              </div>

                              <!--  <input class="form-control" name="arquivo" type="file" id="media-input" style="height: 5.3em;text-align: left;margin-bottom: 2em;background-color:#9600E1;color: white;"> -->

                              <!-- EDITAR -->


                              <br>
                              <p style="text-align: left;">Editar nome de Usuário:</p>
                              <input type="text" name="nome" class="form-control" value="<?php echo $_SESSION['nome']; ?>">

                              <br>
                              <p style="text-align: left;">Editar Número de Celular:</p>
                              <input type="text" name="telefone" class="form-control" id="telefone" data-mask="(00) 00000-0000" value="<?php echo $_SESSION['telefone']; ?>">

                              <br>
                              <p style="text-align: left;">Editar Email:</p>
                              <input type="text" name="email" class="form-control" value="<?php echo $_SESSION['email']; ?>">

                              <br>
                              <p style="text-align: left;">Editar data de nascimento:</p>
                              <input type="date" name="idade" class="form-control" value="<?php echo $_SESSION['idade']; ?>">

                              <br>
                              <p style="text-align: left;">Editar Descrição:</p>
                              <textarea type="text" name="descricao" class="form-control" rows="5" cols="20" style="resize: none;"><?php echo $_SESSION['descricao']; ?></textarea>

                              <div class="modal-footer">
                                <div id="resposta"></div>
                                <button type="button" class=" btn btn-dark bg-dark" data-dismiss="modal" style="color:white;left: -1em;margin-left: 4em;">Fechar</button>
                                <button type="submit" class="btn btn-primary" id="salvarperfil" style="background-color:#9600E1;color: white;">Salvar</button>
                              </div>
                            </form>




                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>



                <!--Conteúdo -->
                <div class="desc" style="text-align: left; width: 100%; margin-bottom: 10rem;">
                  <h5>Sobre:</h5>
                  <p><?php echo $_SESSION['descricao'] ?></p>
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



                <!-- Fabbutton adicionar (+)
                <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
                <div class="floating-container">
                  <div class="floating-button" data-toggle="modal" data-target="#myModal" style="background-color: #9600E1;">+</div>
                  <div class="element-container">


                     Fabbuton2 (?) -->

                    <!--<span class="float-element bg-dark" style="position: relative;top: 8em;cursor: pointer;  border-style: solid;border-color:white;border-width: 0.1em;border-bottom:hidden;" data-toggle="modal" data-target="#myModal2">
                      <p style="align-items: center; text-align: center; justify-content: center;">?
                      </p>
                    </span>
                  </div>
                </div> -->




                <!-- MODAL 1 Adcionar arte -->

                <div class="modal fade" id="myModal">
                  <div class="modal-dialog">
                    <div class="modal-content">


                      <!-- Modal Header -->
                      <div class="modal-header" style="background-color:#9600E1;">
                        <h4 class="modal-title" style="color: white;">Adicione sua Arte !</h4>
                        <button type="button" class="close text-white" data-dismiss="modal" style="filter: brightness(5);">&times;</button>
                      </div>

                      <!-- Modal body -->
                      <div class="modal-body" style="text-align: left;">
                        <input class="form-control" type="file" id="formFileMultiple" multiple style="height: 2.8em;" /><br>

                        <p>Tipo:</p>
                        <select class="form-select form-control" aria-label="Default select example" style="border-radius:0.2em; width: 100%;">Selecione o Tipo do Arquivo

                          <option class="optionGroup" selected disabled style="border-radius:0.2em;">Selecione o arquivo...</option>
                          <option>Imagem(JPG, JPEG, PNG)</option>
                          <option>Áudio(WAV, MP3, OGG)</option>
                          <option>Vídeo(MP4)</option>
                        </select><br><br>

                        <p>Categoria do Arquivo:</p>
                        <select class="form-control" style="width: 100%;">
                          <option class="optionGroup" selected disabled style="border-radius:0.2em;">Selecione o anterior primeiro...
                          </option>
                        </select><br><br>

                        Descricão:<br>
                        <textarea class="form-control" rows="5" cols="30" style="resize: none; border-radius:0.2em;width: 100%;" placeholder="Digite a descrição do arquivo...">
          </textarea>

                      </div>

                      <!-- Modal footer -->
                      <div class="modal-footer">
                        <p style="position: relative; right:10em;" id="p"></p>
                        <button type="button" class="btn" id="enviar" style="background-color:#9600E1;color: white;width:90%;height: 3em;left: -1.8em;margin-bottom: 1em; ">Publicar
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>


              <!-- <div class="ground" style="position: relative;height: 0;top:0em;">
  </div> -->


              <!-- MODAL 2 (?) -->


              <div class="modal fade" id="myModal2">
                <div class="modal-dialog">
                  <div class="modal-content bg-dark" style="display:flex;border-radius: 2em; width: 13em; box-shadow: none; background:transparent;border-color:white;align-items: center; justify-content: center;  margin-left:30%;margin-top:10em;align-content: center;
          padding: 0;">


                    <!-- Modal Header -->

                    <button type="button" class="close text-white" data-dismiss="modal" style="filter: brightness(5); justify-content: right;align-content: center;position: relative;left:3em;top: 0.8em;width: 2em;height: 1.5em;">&times;
                    </button>

                    <!-- Modal body -->
                    <div class="modal-body">

                      <div style="color: white;text-align: center;filter: hue-rotate(50deg);">
                        <a href="ajuda.php" style="text-decoration: none;">
                          <h4>Ajuda</h4>
                        </a>

                        <a href="avisolegal.php" style="text-decoration: none;">
                          <h4>Aviso Legal</h4>
                        </a>

                        <a href="politica e privacidade.php" style="text-decoration: none;">
                          <h4>Política e Privacidade</h4>
                        </a>
                        <a href="sobrenos.php" style="text-decoration: none;color: white;">
                          <h4>Sobre Nós</h4>
                        </a>


                      </div>
                    </div>
                  </div>

                </div>
                <!-- exibir imagem perfil ao editar -->
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
                <!-- Pra funcionar o modal -->
                <script src='bootstrap/js/bootstrap.bundle.min.js'></script>
  </body>

  </html>
<?php
} else {
  header('location: index.php');
}
?>