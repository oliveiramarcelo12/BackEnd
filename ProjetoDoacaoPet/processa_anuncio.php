<?php
require_once 'conectaBD.php';

session_start();

if (empty($_SESSION)) {
    header("Location: index.php?msgErro=Você precisa se autenticar no sistema.");
    die();
}

if (!empty($_POST)) {
    if ($_POST['enviarDados'] == 'CAD') { // CADASTRAR!!!
        try {
            $sql = "INSERT INTO anuncio (fase, tipo, porte, sexo, pelagem_cor, raca, observacao, email_usuario)
                    VALUES (:fase, :tipo, :porte, :sexo, :pelagem_cor, :raca, :observacao, :email_usuario)";
            
            $stmt = $pdo->prepare($sql);
            
            $dados = array(
                ':fase' => $_POST['fase'],
                ':tipo' => $_POST['tipo'],
                ':porte' => $_POST['porte'],
                ':sexo' => $_POST['sexo'],
                ':pelagem_cor' => $_POST['pelagemCor'],
                ':raca' => $_POST['raca'],
                ':observacao' => $_POST['observacao'],
                ':email_usuario' => $_SESSION['email']
            );

            if ($stmt->execute($dados)) {
                header("Location: index_logado.php?msgSucesso=Anúncio cadastrado com sucesso!");
                exit();
            } else {
                throw new Exception("Falha ao cadastrar anúncio.");
            }
        } catch (PDOException $e) {
            header("Location: index_logado.php?msgErro=" . urlencode($e->getMessage()));
            exit();
        }
    } elseif ($_POST['enviarDados'] == 'ALT') { // ALTERAR
        try {
            $sql = "UPDATE anuncio SET fase = :fase, tipo = :tipo, porte = :porte, pelagem_cor = :pelagem_cor, raca = :raca, sexo = :sexo, observacao = :observacao 
                    WHERE id = :id_anuncio AND email_usuario = :email";

            $dados = array(
                ':id_anuncio' => $_POST['id_anuncio'],
                ':fase' => $_POST['fase'],
                ':tipo' => $_POST['tipo'],
                ':porte' => $_POST['porte'],
                ':pelagem_cor' => $_POST['pelagemCor'],
                ':raca' => $_POST['raca'],
                ':sexo' => $_POST['sexo'],
                ':observacao' => $_POST['observacao'],
                ':email' => $_SESSION['email']
            );
            
            $stmt = $pdo->prepare($sql);
            
            if ($stmt->execute($dados)) {
                header("Location: index_logado.php?msgSucesso=Alteração realizada com sucesso!!");
                exit();
            } else {
                throw new Exception("Falha ao ALTERAR anúncio.");
            }
        } catch (PDOException $e) {
            header("Location: index_logado.php?msgErro=" . urlencode($e->getMessage()));
            exit();
        }
    } elseif ($_POST['enviarDados'] == 'DEL') { // EXCLUIR
        try {
            $sql = "DELETE FROM anuncio WHERE id = :id_anuncio AND email_usuario = :email";
            
            $stmt = $pdo->prepare($sql);
            
            $dados = array(':id_anuncio' => $_POST['id_anuncio'], ':email' => $_SESSION['email']);
            
            if ($stmt->execute($dados)) {
                header("Location: index_logado.php?msgSucesso=Anúncio excluído com sucesso!!");
                exit();
            } else {
                throw new Exception("Falha ao EXCLUIR anúncio.");
            }
        } catch (PDOException $e) {
            header("Location: index_logado.php?msgErro=" . urlencode($e->getMessage()));
            exit();
        }
    } else {
        header("Location: index_logado.php?msgErro=Operação inválida.");
        exit();
    }
} else {
    header("Location: index_logado.php?msgErro=Dados POST não recebidos.");
    exit();
}
?>
