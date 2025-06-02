<?php
session_start();
require_once('conecta.php');
require_once('tempo.php');

// Defina o valor de $id corretamente, por exemplo:
$id = $_POST['id'];

$stmt = $conn->prepare("SELECT
    comentario.cd_comentario,
    comentario.ds_comentario,
    comentario.dt_comentario,
    comentario.id_post,
    comentario.id_perfil,
    perfil.cd_perfil,
    perfil.nm_perfil,
    perfil.ds_imagem,-- Nome do perfil
    post.ds_post -- Descrição da postagem
FROM comentario
LEFT JOIN perfil ON comentario.id_perfil = perfil.cd_perfil
LEFT JOIN post ON comentario.id_post = post.cd_post
WHERE comentario.id_post = :post_id");

$stmt->bindParam(':post_id', $id, PDO::PARAM_INT); // Associe o valor da variável $id à consulta

$stmt->execute();

$comentariosHTML = '';

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // Aqui você pode exibir os comentários, o nome do usuário e a postagem relacionada
    $id = $row['cd_comentario'];
    $comentario = $row['ds_comentario'];
    $nomeUsuario = $row['nm_perfil'];
    $postagem = $row['ds_post'];
    $perfil = $row['ds_imagem'];
    $cd_perfil = $row['cd_perfil'];
    $id_perfil = $row['id_perfil'];
    $tempo = "Há " . tempo_corrido($row['dt_comentario']) . "<br>";


    if ($_SESSION['acesso'] == 2) {
        $comentariosHTML .= "

        <div class='card-footer'>
            <button type='button' class='btn btn-light' data-toggle='modal' >
                <img src='" . ($perfil === NULL ? 'php/upload_foto_perfil/usuario.png' : "php/upload_foto_perfil/$cd_perfil/$perfil") . "'>
            </button>
            <div class='author'>
                <p id='usercoment'><a style='color:black;' href='https://uniart.site/Uniart/perfil2.php?vizu_perfil=$cd_perfil'>$nomeUsuario</a> <small>$tempo</small>

                <div class='exibir_coment'>
                <a style='width:100%; height:100%;'  href='php/deletar_comentario.php?id=$id'>
            <button type='button' class='btn btn-danger' id='apagarcoment'>
                        <svg style='color: white;' xmlns='http://www.w3.org/2000/svg' width='32' height='32' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                            <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z' />
                            <path d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z' />
                        </svg>
                        </button>
                        </a>
                        </div>
                </p>
                <p>$comentario</p>
            </div>
        </div>
        ";
    } elseif ( $_SESSION['id'] == $id_perfil) {
    $comentariosHTML .= "

    <div class='card-footer'>
    <button type='button' class='btn btn-light' data-toggle='modal' >
        <img src='" . ($perfil === NULL ? 'php/upload_foto_perfil/usuario.png' : "php/upload_foto_perfil/$cd_perfil/$perfil") . "'>
    </button>
    <div class='author'>
        <p id='usercoment'><a style='color:black;' href='https://uniart.site/Uniart/perfil2.php?vizu_perfil=$cd_perfil'>$nomeUsuario</a> <small>$tempo</small>

        <div class='exibir_coment'>
        <a style='width:100%; height:100%;'  href='php/deletar_comentario.php?id=$id'>
    <button type='button' class='btn btn-danger' id='apagarcoment'>
                <svg style='color: white;' xmlns='http://www.w3.org/2000/svg' width='32' height='32' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                    <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z' />
                    <path d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z' />
                </svg>
                </button>
                </a>
                </div>
        </p>
        <p>$comentario</p>
    </div>
</div>
    ";
    }else{
        $comentariosHTML .= "
        <div class='card-footer'>
            <button type='button' class='btn btn-light' data-toggle='modal' >
                <img src='" . ($perfil === NULL ? 'php/upload_foto_perfil/usuario.png' : "php/upload_foto_perfil/$cd_perfil/$perfil") . "'>
            </button>
            <div class='author'>
                <p id='usercoment'><a style='color:black;' href='https://uniart.site/Uniart/perfil2.php?vizu_perfil=$cd_perfil'>$nomeUsuario</a> <small>$tempo</small>
                </p>
                <p>$comentario</p>
            </div>
        </div>
        ";
    }
}

echo $comentariosHTML;
?>
