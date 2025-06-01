<?php
require_once ('conecta.php');
try {
    // Verifica se a variável de sessão $_SESSION['foto'] está definida
    // Consulta para verificar se a imagem de perfil está definida
    $verificaImagem = $conn->prepare("SELECT ds_imagem FROM perfil WHERE cd_perfil = :id");
    $verificaImagem->bindParam(":id", $_POST['id'], PDO::PARAM_INT);
    $verificaImagem->execute();
    $imagem = $verificaImagem->fetch(PDO::FETCH_ASSOC);

    if ($imagem['ds_imagem'] === null) {
        echo '<img id="fotin" src="php/upload_foto_perfil/usuario.png" alt="Profile Picture2">';
    } else {
        echo '<img id="fotin" src="php/upload_foto_perfil/' . $_POST["id"] . '/' . $imagem["ds_imagem"] . '" alt="Profile Picture2">';

    }
} catch (PDOException $e) {
    echo "Erro de banco de dados: " . $e->getMessage();
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>
