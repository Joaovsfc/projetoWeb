<?php
    //validação dos dados
    if ( $_POST ) {
        //recuperar login e senha
        $login = trim( $_POST["login"] ?? NULL );
        $senha = trim ( $_POST["senha"] ?? NULL );
        
        //validar o login e a senha
        if ((empty($login)) or (empty($senha))) {
            //mostrar um erro na tela
            ?>
            <script>
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo login e o campo senha',
              }).then((result) => {
                 history.back(); 
              })
            </script>
            <?php
            exit;
        }

        //selecionar os dados do banco
        $sql = "select id, nome, login, senha 
            from usuario
            where login = :login AND ativo = 'S'
            limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":login", $login);
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        //verificar se trouxe resultado
        if ( !isset( $dados->id ) ) {
            mensagemErro("Usuário não encontrado ou inativado");
        } else if ( !password_verify($senha,$dados->senha)){
            mensagemErro("Senha incorreta");
        }

        //guardar as informações na sessao
        $_SESSION["usuario"] = array("id"=>$dados->id,
            "nome"=>$dados->nome,
            "login"=>$dados->login);
        //direcionar para uma página home
        echo "<script>location.href='paginas/home';</script>";
        exit;

    } // fim do POST

?>
<div class="login">
    <h1 class="text-center">Efetuar Login</h1>
    <form name="formLogin" method="post" data-parsley-validate="">
        <label for="login">Login:</label>
        <input type="text" name="login" id="login"
        class="form-control" required
        data-parsley-required-message="Por favor preencha este campo">
        <br>
        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha"
        class="form-control" required 
        data-parsley-required-message="Por favor preencha este campo">
        <br>
        <button type="submit" class="btn btn-success w-100">Efetuar Login</button>
    </form>
</div>