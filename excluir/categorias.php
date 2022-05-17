<?php
    //se nao existir a variavel page
    if ( !isset ($page) ) exit;

    //verificar se existe um produto cadastrado
    $sql = "select id from produto 
        where categoria_id = :id limit 1";
    //preparar o sql para execução com o banco
    $consultaproduto = $pdo->prepare($sql);
    //passar o parametro
    $consultaproduto->bindParam(":id", $id);
    //executar o sql
    $consultaproduto->execute();

    $produto = $consultaproduto->fetch(PDO::FETCH_OBJ);
    
    //verificar se existe um produto
    if ( !empty($produto->id) ) {
        mensagemErro('Não foi possível excluir esta categoria, pois existe um produto relacionado a ela');
    }

    //sql para excluir
    $sql = "delete from categoria where id = :id limit 1";
    $consultacategoria = $pdo->prepare($sql);
    $consultacategoria->bindParam(":id", $id);
    
    //verificar se consegue executar
    if ( $consultacategoria->execute() ){
        //encaminhar para a tela de listagem
        echo "<script>location.href='listar/categorias';</script>";
        exit;
    }

    mensagemErro('Não foi possível excluir');
