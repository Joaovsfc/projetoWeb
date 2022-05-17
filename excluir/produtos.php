<?php
    //se nao existir a variavel page
    if ( !isset ($page) ) exit;

    //selecionar as imagens
    $sql = "select imagem1, imagem2 from produto
        where id = :id limit 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(':id', $id);
    $consulta->execute();

    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    $imagem1 = "../produtos/{$dados->imagem1}";
    $imagem2 = "../produtos/{$dados->imagem2}";

    //sql para excluir
    $sql = "delete from produto where id = :id limit 1";
    $consultaproduto = $pdo->prepare($sql);
    $consultaproduto->bindParam(":id", $id);
    
    //verificar se consegue executar
    if ( $consultaproduto->execute() ){
        //excluir os arquivos
        if ( file_exists ( $imagem1 ) ) {
            unlink($imagem1);
        }
        if ( file_exists ( $imagem2 ) ) {
            unlink($imagem2);
        }

        //encaminhar para a tela de listagem
        echo "<script>location.href='listar/produtos';</script>";
        exit;
    }

    mensagemErro('Não foi possível excluir');
