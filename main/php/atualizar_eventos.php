<?php
require_once('conecta.php');
function atualizarPost($cd, $descricao, $titulo, $dia, $hora, $local, $conn)
{
    try {
            // O usuário não enviou um novo arquivo, apenas atualize a descrição no banco de dados
            $stmt = $conn->prepare("UPDATE eventos SET ds_titulo = :titulo, ds_eventos = :descricao, hr_eventos = :hora, dt_eventos = :datas, st_local = :locais   WHERE cd_eventos = :id");
            $stmt->bindParam(":titulo", $titulo, PDO::PARAM_STR);
            $stmt->bindParam(":descricao", $descricao, PDO::PARAM_STR);
            $stmt->bindParam(":hora", $hora, PDO::PARAM_STR);
            $stmt->bindParam(":datas", $dia, PDO::PARAM_STR);
            $stmt->bindParam(":locais", $local, PDO::PARAM_STR);
            $stmt->bindParam(":id", $cd, PDO::PARAM_INT);
            $stmt->execute();
            return "Mídia atualizada com sucesso!";
    } catch (PDOException $e) {
        return "Passou do limite atingido: "."<br>". $e->getMessage();
    }
}
// Uso da função
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cd = $_POST["id"];
    $descricao = $_POST["desc"];
    $titulo = $_POST["titulo"];
    $dia = $_POST["dia"];
    $hora = $_POST["hora"];
    $local = $_POST["local"];
    
    $resultado = atualizarPost($cd, $descricao, $titulo, $dia, $hora, $local, $conn);
    echo $resultado;
    echo "<meta http-equiv='refresh' content='1'>";
} else {
    echo "Requisição inválida.";
}