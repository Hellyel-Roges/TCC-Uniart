<?php
require_once('conecta.php');
function atualizarPost($cd, $descricao, $conn)
{
    try {
            // O usuário não enviou um novo arquivo, apenas atualize a descrição no banco de dados
            $stmt = $conn->prepare("UPDATE post SET ds_post = :descricao WHERE cd_post = :id");
            $stmt->bindParam(":descricao", $descricao);
            $stmt->bindParam(":id", $cd);
            $stmt->execute();
            return "Post atualizado com sucesso!";
    } catch (PDOException $e) {
        return "Passou do limite atingido: "."<br>". $e->getMessage();
    }
}
// Uso da função
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cd = $_POST["edit"];
    $descricao = $_POST["desc"];

    $resultado = atualizarPost($cd, $descricao, $conn);
    echo $resultado;
    echo "<meta http-equiv='refresh' content='1'>";
} else {
    echo "Requisição inválida.";
}