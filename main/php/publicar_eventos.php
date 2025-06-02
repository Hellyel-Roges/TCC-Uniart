<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
// INCLUINDO A BIBLIOTECA GETID3 E A CONEXÃO COM O BANCO VIA PDO
require_once('conecta.php');
require_once('../bibliotecas/getid3/getid3/getid3.php');

// LIMITE DE TEMPO PARA ÁUDIO E VÍDEO EM SEGUNDOS VIDEO(900s = 15m), ÁUDIO(1200s = 20m)
$limite_video = 900;
$limite_audio = 1200;
$minutos_video = $limite_video / 60;
$minutos_audio = $limite_audio / 60;

// FUNÇÃO PARA IDENTIFICAR OS TIPO DE ARQUIVOS PERMITIDOS
function arquivo_permitido($tipo_arquivo){
    $tipo_imagem = array(
        "image/jpg",
        "image/jpeg",
        "image/png",
        "image/gif"
    );
    $tipo_audio = array(
        "audio/mpeg",
        "audio/mp3",
        "audio/wav",
        "audio/ogg"
    );
    $tipo_video = array(
        "video/mp4",
        "video/webm",
        "video/mkv",
        "video/ogv"
    );

    // VERIFICAR OS TIPOS DE ARQUIVOS NÃO PERMITIDOS
    if (!in_array($tipo_arquivo, $tipo_imagem) && !in_array($tipo_arquivo, $tipo_video) && !in_array($tipo_arquivo, $tipo_audio)) {
        return false; // TIPO NÃO PERMITIDO
    } else {
        return true; // TIPO PERMITIDO
    }
}

try {
    if ($_FILES["arquivo"]["error"] === UPLOAD_ERR_OK) {
        // DECLARANDO VARIAVEIS PARA DEIXAR MAIS SIMPLES
        $nome_arquivo = $_FILES["arquivo"]["name"];
        $arquivo_tmp = $_FILES["arquivo"]["tmp_name"];
        $tipo_arquivo = $_FILES["arquivo"]["type"];

        // VALIDANDO A FUNÇÃO CRIADA ANTERIORMENTE
        if (!arquivo_permitido($tipo_arquivo)) {
            echo "Tipo de arquivo não permitido.";
        } else {
            // CRIANDO UMA NEW PARA USAR A BIBLIOTECA GETID3
            $getID3 = new getID3();
            $file_info = $getID3->analyze($arquivo_tmp);
            $duration_seconds = $file_info['playtime_seconds'];

            // VERIFICAÇÃO E COMPARAÇÃO PARA TER O LIMITE DEFINIDO
            if (($tipo_arquivo == "video/mp4" || $tipo_arquivo == "video/webm" || $tipo_arquivo == "video/mkv" || $tipo_arquivo == "video/ogv") && $duration_seconds > $limite_video) {
                echo "Desculpa... só é permitido $minutos_video minutos de vídeo.";
            } elseif (($tipo_arquivo == "audio/mpeg" || $tipo_arquivo == "audio/mp3" || $tipo_arquivo == "audio/wav" || $tipo_arquivo == "audio/ogg") && $duration_seconds > $limite_audio) {
                echo "Desculpa... só é permitido $minutos_audio minutos de áudio.";
            } else {
                // INSERINDO NO BANCO DE DADOS
                $stmt = $conn->prepare("INSERT INTO eventos (ds_titulo, ds_eventos, hr_eventos, dt_eventos, tp_eventos, st_local, ds_arquivo, id_categoria) VALUES (:titulo, :descricao, :hora, :datas, NOW(), :locals, :arquivo, :categoria)");
                $stmt->bindParam(':titulo', $_POST['titulo'], PDO::PARAM_STR);
                $stmt->bindParam(':descricao', $_POST['descricao'], PDO::PARAM_STR);
                $stmt->bindParam(':hora', $_POST['hora'], PDO::PARAM_STR);
                $stmt->bindParam(':datas', $_POST['data'], PDO::PARAM_STR);
                $stmt->bindParam(':locals', $_POST['local'], PDO::PARAM_STR);
                $stmt->bindParam(':arquivo', $nome_arquivo);
                $stmt->bindParam(':categoria', $_POST['categoria'], PDO::PARAM_INT);
                $stmt->execute();

                // CONTANDO A LINHA DO ENVIO
                if ($stmt->rowCount()) {
                    // VALIDANDO O ENVIO DO ARQUIVO
                    if ((isset($nome_arquivo)) and (!empty($nome_arquivo))) {
                        // ULTIMO CD PEGO LOGO APÓS TER INSERIDO NO BANCO
                        $ultimo_cd = $conn->lastInsertId();

                        // Diretório DA PASTA UPLOAD, E DENTRO DESTA PASTA, TERA O NUMERO DO CD DO ARQUIVO
                        $diretorio = "upload_eventos/$ultimo_cd/";

                        // CRIAR O DIRETIORIO
                        mkdir($diretorio, 0755);
                    }
                }
                // ROTINA PARA O ENVIO DO UPLOAD
                if (move_uploaded_file($arquivo_tmp, $diretorio . $nome_arquivo)) {
                    // SE DER TUDO CERTO SERÁ ENVIADO A MENSAGEM E RECARREGARA A PAGINA
                    echo "Evento enviada com sucesso!";
                    echo "<meta http-equiv='refresh' content='1'>";

                    // CASO DER ERRADO AO ENVIAR O ARQUIVO
                } else {
                    echo "Erro ao enviar o arquivo.";
                }
            }
        }
        // SE O UPLOAD DER ERRADO
    } else {
        echo "Erro durante o upload do arquivo.";
    }
} catch (PDOException $e) {
    echo 'Algo deu errado: ' . $e->getMessage();
} 
}else {
    echo "Requisição inválida.";
}
?>