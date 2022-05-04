<?php
    if ( !isset ( $page ) ) exit;

    $nome = $valor = $descricao = $imagem1 = $imagem2 = $categoria_id = NULL;

    if ( !empty($id) ) {
        $sql = "select * from produto where id = :id limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":id", $id);
        $consulta->execute();
        $dados = $consulta->fetch(PDO::FETCH_OBJ);
        $nome = $dados->nome;
        $valor = $dados->valor;
        $descricao = $dados->descricao;
        $imagem1 = $dados->imagem1;
        $imagem2 = $dados->imagem2;
        $categoria_id = $dados->categoria_id;

        $valor = number_format($valor,2,',','.');
    }

?>
<div class="card">
    <div class="card-header">
        <h1 class="float-left">Cadastro de Produtos</h1>
        <div class="float-right">
            <a href="listar/produtos" class="btn btn-success">
                Listar Produtos
            </a>
        </div>
    </div>
    <div class="card-body">
        <form name="formProduto" method="post" action="salvar/produtos" enctype="multipart/form-data" data-parsley-validate="">
            <label for="id">ID:</label>
            <input type="text" name="id" id="id"
            readonly class="form-control"
            value="<?=$id?>">
            <label for="nome">Nome do Produto:</label>
            <input type="text" name="nome" id="nome"
            required data-parsley-required-message="Por favor preencha este campo" class="form-control" value="<?=$nome?>">
            <label for="categoria_id">Selecione a Categoria:</label>
            <select name="categoria_id" id="categoria_id" required data-parsley-required-message="Selecione uma categoria" class="form-control">
                <option value=""></option>
                <?php
                    $sql = "select id, nome from categoria order by nome";
                    $consultaCategoria = $pdo->prepare($sql);
                    $consultaCategoria->execute();
                    while ( $dadosCategoria = $consultaCategoria->fetch(PDO::FETCH_OBJ)) {
                        //separar os dados
                        $idCategoria = $dadosCategoria->id;
                        $nomeCategoria = $dadosCategoria->nome;
                        
                        echo "<option value='{$idCategoria}'>{$nomeCategoria}</option>";
                    }
                ?>
            </select>
            <label for="valor">Valor do Produto:</label>
            <input type="text" name="valor" id="valor"
            required data-parsley-required-message="Preencha o valor" class="form-control valor"
            value="<?=$valor?>">
            <label for="descricao">Descrição do Produto:</label>
            <textarea rows="5" name="descricao" id="descricao" required data-parsley-required-message="Preencha a descrição do produto" class="form-control texto"><?=$descricao?></textarea>
            <label for="imagem1">Imagem 1:</label>
            <input type="file" name="imagem1" id="imagem1" class="form-control-file">

            <?php
                if ( !empty($imagem1 ) ) {
                    ?>
                    <img src="../produtos/<?=$imagem1?>"
                    width="100px"><br>
                    <?php
                }
            ?>

            <label for="imagem2">Imagem 2:</label>
            <input type="file" name="imagem2" id="imagem2" class="form-control-file">

            <?php
                if ( !empty($imagem2 ) ) {
                    ?>
                    <img src="../produtos/<?=$imagem2?>"
                    width="100px"><br>
                    <?php
                }
            ?>

            <br>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-check"></i>
                Gravar Dados
            </button>
        </form>

        <script>
            $(document).ready(function(){
                $('.valor').maskMoney({thousands:'.', decimal:','});
                $('.texto').summernote({
                    height: 200
                });
                $('#categoria_id').val(<?=$categoria_id?>);
            })
        </script>
    </div>
</div>