<?php
    //se nao existir a variavel page
    if ( !isset ($page) ) exit;

   

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
