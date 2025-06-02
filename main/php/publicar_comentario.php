<?php
session_start();
require_once('conecta.php');
function atualizarPost($cd, $descricao, $conn, $id) 
{
    try {
            // O usuário não enviou um novo arquivo, apenas atualize a descrição no banco de dados
            $stmt = $conn->prepare("INSERT INTO comentario (ds_comentario, dt_comentario, id_post, id_perfil) VALUES (:descs, NOW(), :post, :perfil)");
            $stmt->bindParam(":descs", $descricao, PDO::PARAM_STR);
            $stmt->bindParam(":post", $cd, PDO::PARAM_INT);
            $stmt->bindParam(":perfil", $id, PDO::PARAM_INT);
            $stmt->execute();
            return "Comentado com Sucesso!";
    } catch (PDOException $e) {
        return "Passou do limite atingido: "."<br>". $e->getMessage();
    }
}
// Uso da função
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cd = $_POST["id"];
    $descricao = $_POST["desc"];
    $id = $_SESSION["id"];
    $resultado = atualizarPost($cd, $descricao, $conn, $id);
    echo $resultado;
    echo "<meta http-equiv='refresh' content='1'>";
} else {
    echo "Requisição inválida.";
}
?>