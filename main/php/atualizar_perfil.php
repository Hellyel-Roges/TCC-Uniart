<?php
session_start();
require_once('conecta.php');
require_once('../bibliotecas/getid3/getid3/getid3.php');

function atualizarPost($cd, $desc, $arquivo, $nome, $celular, $email, $idade, $conn)
{
    try {
        // Verifique se o arquivo foi enviado corretamente
        if ($arquivo["error"] == UPLOAD_ERR_OK) {
            $uploadDir = "upload_foto_perfil/" . $cd . "/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755);
            }

            // Use a biblioteca getID3 para verificar se o arquivo é uma imagem
            $getID3 = new getID3;
            $fileInfo = $getID3->analyze($arquivo["tmp_name"]);
            if (isset($fileInfo['fileformat']) && in_array($fileInfo['fileformat'], ['jpg', 'jpeg', 'png', 'gif'])) {
                $arquivoCaminho = $uploadDir . $arquivo["name"];

                // Remove qualquer arquivo de imagem anterior na pasta
                $files = glob($uploadDir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
                foreach ($files as $file) {
                    unlink($file);
                }
                $nomeArquivo = basename($arquivo["name"]);
                if (move_uploaded_file($arquivo["tmp_name"], $arquivoCaminho)) {
                    // Atualize o banco de dados
                    $stmt = $conn->prepare("UPDATE perfil SET nm_perfil = :nome, nr_cell = :telefone, ds_email = :email, ds_perfil = :descricao, ds_imagem = :caminho, dt_nascimento = :nasce WHERE cd_perfil = :id");
                    $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
                    $stmt->bindParam(":telefone", $celular, PDO::PARAM_STR);
                    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
                    $stmt->bindParam(":descricao", $desc, PDO::PARAM_STR);
                    $stmt->bindParam(":caminho", $nomeArquivo);
                    $stmt->bindParam(":nasce", $idade);
                    $stmt->bindParam(":id", $cd, PDO::PARAM_INT);
                    $stmt->execute();

                    return "Perfil Atualizado com Sucesso!";
                } else {
                    return "Erro ao fazer upload do arquivo.";
                }
            } else {
                return "Apenas arquivos de imagem (jpg, jpeg, png, gif) são permitidos.";
            }
        } else {
            // Se nenhum arquivo foi enviado, atualize o banco de dados sem imagem
            $stmt = $conn->prepare("UPDATE perfil SET nm_perfil = :nome, nr_cell = :telefone, ds_email = :email, ds_perfil = :descricao, dt_nascimento = :nasce WHERE cd_perfil = :id");
            $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
            $stmt->bindParam(":telefone", $celular, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":descricao", $desc, PDO::PARAM_STR);
            $stmt->bindParam(":nasce", $idade);
            $stmt->bindParam(":id", $cd, PDO::PARAM_INT);
            $stmt->execute();
            return "Perfil Atualizado com Sucesso!";
        }
    } catch (PDOException $e) {
        return "Erro no banco de dados: " . $e->getMessage();
    } catch (Exception $e) {
        return "Erro: " . $e->getMessage();
    }
}

// Uso da função
// Uso da função
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cd = $_POST["id"];
    $desc = $_POST["descricao"];
    $arquivo = $_FILES["arquivo"];

    $nome = $_POST["nome"];
    $email = $_POST["email"];

    // Consulta para verificar se o nome já existe no banco de dados
    $verificaNome = $conn->prepare("SELECT cd_perfil FROM perfil WHERE nm_perfil = :nome AND cd_perfil != :id");
    $verificaNome->bindParam(":nome", $nome, PDO::PARAM_STR);
    $verificaNome->bindParam(":id", $cd, PDO::PARAM_INT);
    $verificaNome->execute();

    // Consulta para verificar se o email já existe no banco de dados
    $verificaEmail = $conn->prepare("SELECT cd_perfil FROM perfil WHERE ds_email = :email AND cd_perfil != :id");
    $verificaEmail->bindParam(":email", $email, PDO::PARAM_STR);
    $verificaEmail->bindParam(":id", $cd, PDO::PARAM_INT);
    $verificaEmail->execute();

    if ($verificaNome->rowCount() > 0) {
        echo "Nome de usuário já existente!";
    } elseif ($verificaEmail->rowCount() > 0) {
        echo "Email já existente!";
    } else {
        $idade = $_POST["idade"];
        if (empty($idade)) {
            $idade = null;
        }
        $celular = $_POST['telefone'];
        $celular = preg_replace("/[^0-9]/", "", $celular); // Remova todos os caracteres não numéricos
        
        if (strlen($celular) === 0) {
            $celular = null;
            $resultado = atualizarPost($cd, $desc, $arquivo, $nome, $celular, $email, $idade, $conn);
            if ($resultado === "Perfil Atualizado com Sucesso!") {
                $_SESSION['id'] = $cd;
                $_SESSION['nome'] = $nome;
                $_SESSION['email'] = $email;
                $_SESSION['descricao'] = $desc;
                $_SESSION['telefone'] = $celular;
                $_SESSION['foto'] = $arquivo;
                $_SESSION['idade'] = $idade;
            }
            echo $resultado;
        } elseif (strlen($celular) !== 11) {
            echo "Número de telefone deve conter 11 dígitos.";
        } else {
            $resultado = atualizarPost($cd, $desc, $arquivo, $nome, $celular, $email, $idade, $conn);
            if ($resultado === "Perfil Atualizado com Sucesso!") {
                $_SESSION['id'] = $cd;
                $_SESSION['nome'] = $nome;
                $_SESSION['email'] = $email;
                $_SESSION['descricao'] = $desc;
                $_SESSION['telefone'] = $celular;
                $_SESSION['foto'] = $arquivo;
                $_SESSION['idade'] = $idade;
            }
            echo $resultado;
        }
    }
} else {
    echo "Requisição inválida.";
}
