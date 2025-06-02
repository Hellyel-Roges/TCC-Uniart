<?php
require_once('conecta.php');

function gerarOpcoesCategoria($tipoArquivoId) {
    global $conn; // Use a conexão global definida em conecta.php

    try {
        // Consulta para obter categorias correspondentes ao tipo de arquivo selecionado
        $stmt = $conn->prepare("SELECT cd_categoria, ds_categoria FROM categoria_arquivo WHERE id_tipo = :categoriaId");
        $stmt->bindParam(':categoriaId', $tipoArquivoId, PDO::PARAM_INT);
        $stmt->execute();

        // Inicializa a variável de opções
        $options = '';

        // Gerar as opções para o segundo select
        while ($categoria = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $options .= "<option value='{$categoria['cd_categoria']}'>{$categoria['ds_categoria']}</option>";
        }

        return $options;
    } catch (PDOException $e) {
        // Em vez de usar 'echo', é melhor lançar uma exceção para que o erro possa ser tratado adequadamente pelo código que chama a função.
        throw new Exception('Erro ao obter opções de categoria: ' . $e->getMessage());
    }
}

// Uso da função
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $tipoArquivoId = $_POST['tipo'];

    try {
        $opcoesCategoria = gerarOpcoesCategoria($tipoArquivoId);
        echo $opcoesCategoria;
    } catch (Exception $ex) {
        echo 'Erro: ' . $ex->getMessage();
    }
} else {
    echo "Requisição inválida.";
}
