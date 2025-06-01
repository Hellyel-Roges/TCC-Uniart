<?php
session_start();
require_once ('conecta.php');
$id = $_GET['id'];
try {
    $stmt = $conn->prepare('DELETE FROM comentario where cd_comentario = :cd');
    $stmt->bindParam(':cd', $id, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount() != 0){
        $_SESSION['mensagem'] = "Comentário excluído com sucesso";

} else {
    $_SESSION['mensagem'] = "Erro ao excluir comentário";

    // Trate o caso em que a inserção falhou
}
header("Location: " . $_SERVER['HTTP_REFERER']);
} catch (Exception $e) {
    echo"error". $e->getMessage();
}
?>