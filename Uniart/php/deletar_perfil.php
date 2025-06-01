<?php
require_once('conecta.php'); // Inclua o arquivo de conexão com o banco de dados

function excluirPublicacao($deletar, $conn) {
    try {
        // Consulta para obter o ID do post associado ao ID do arquivo
        $stmt = $conn->prepare("DELETE FROM perfil WHERE cd_perfil = :id");
        $stmt->bindParam(':id', $deletar, PDO::PARAM_INT);
        $stmt->execute();
        if($stmt->rowCount() != 0) {
            return 'Perfil deletado com sucesso!';
        }else{
            return 'Algo de errado não está certo!';
        }

    } catch (PDOException $e) {
        return 'Algo deu errado: ' . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deletar'])) {
    $deletar = $_POST['deletar'];
    $mensagem = excluirPublicacao($deletar, $conn);
    echo $mensagem;
    echo "<meta http-equiv='refresh' content='1'>";
} else {
    echo "ID de arquivo não especificado.";
}

?>
