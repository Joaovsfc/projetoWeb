<?php
    //se nao existir a variavel page
    if ( !isset ($page) ) exit;

    if ( $_POST ) {
        //recuperar os dados digitados
        $id = trim( $_POST["id"] ?? NULL );
        $nome = trim( $_POST["nome"] ?? NULL);

        //verificar se o nome não está em branco
        if ( empty( $nome ) ) {
            mensagemErro("Preencha o nome da categoria");
        }

        //verificar se esta categoria já não está cadastrada
        $sql = "select id from categoria 
            where nome = :nome and id <> :id 
            limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":nome", $nome);
        $consulta->bindParam(":id", $id);
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        //verificar se trouxe algum resultado
        if ( !empty ( $dados->id ) ) {
            mensagemErro("Já existe uma categoria cadastrada com este nome");
        }

        //verificar se irá inserir ou se irá atualizar
        if ( empty ( $id ) ) {
            $sql = "insert into categoria (nome) values (:nome)";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":nome", $nome);
        } else {
            $sql = "update categoria set nome = :nome where id = :id limit 1";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":nome", $nome);
            $consulta->bindParam(":id", $id);
        }

        if ( !$consulta->execute() ){
            mensagemErro("Não foi possível salvar os dados");
        }
        echo "<script>location.href='listar/categorias';</script>";
        exit;
    }

    //mostrar uma mensagem de erro
    mensagemErro("Requisição inválida");