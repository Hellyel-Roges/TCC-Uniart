<?php
require_once('conecta.php'); // Inclua o arquivo de conexão com o banco de dados
function excluirPublicacao($deletar, $conn) {
    try {
        // Consulta para obter o ID do post associado ao ID do arquivo
        $stmt = $conn->prepare("SELECT cd_eventos FROM eventos WHERE cd_eventos = :id");
        $stmt->bindParam(':id', $deletar, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($resultado) {
            $cd_eventos = $resultado['cd_eventos'];
            $caminho_pasta = "upload_eventos/$cd_eventos/";
            // Verificar se a pasta existe
            if (is_dir($caminho_pasta)) {
                // Recursivamente excluir arquivos e subpastas
                $iterator = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator($caminho_pasta, RecursiveDirectoryIterator::SKIP_DOTS),
                    RecursiveIteratorIterator::CHILD_FIRST
                );
                foreach ($iterator as $item) {
                    if ($item->isDir()) {
                        rmdir($item->getRealPath());
                    } else {
                        unlink($item->getRealPath());
                    }
                }
                // Exclua a pasta numerada associada ao ID do post
                rmdir($caminho_pasta);
                // Exclua o registro do arquivo do banco de dados
                $stmt = $conn->prepare("DELETE FROM eventos WHERE cd_eventos = :id");
                $stmt->bindParam(':id', $deletar, PDO::PARAM_INT);
                $stmt->execute();
                return "Mídia excluída com sucesso!";
            } else {
                $stmt = $conn->prepare("DELETE FROM eventos WHERE cd_eventos = :id");
                $stmt->bindParam(':id', $deletar, PDO::PARAM_INT);
                $stmt->execute();
                return "A pasta não foi encontrada no servidor.";
            }
        } else {
            return "Arquivo não encontrado no banco de dados.";
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