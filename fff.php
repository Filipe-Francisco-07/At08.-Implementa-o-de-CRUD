<?php
    include 'acao.php';
    include_once 'dbphp.php';

    $acao = isset($_GET['acao'])?$_GET['acao']:"";
    $id = isset($_GET['id'])?$_GET['id']:"";

    if ($acao == 'editar'){
        //busca dados do usuario
        echo("edit main");
        try{
            $conexao = new PDO(MYSQL_DSN,DB_USER,DB_PASSWORD);//cria conexão com banco de dados
            $query = 'SELECT * FROM user WHERE id = :id';
           
            // Monta consulta
            $stmt = $conexao->prepare($query);

            //Vincula váriaveis com a consulta
            $stmt->bindValue(':id',$id);
            $stmt->execute();
            $usuario = $stmt->fetch();

    }catch(PDOException $e){
        print("Erro ao conectar com o banco de dados...<br>".$e->getMessage());
        die();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <title>Cadastro</title>
    <script>
        function excluir(url){
            if(confirm("Confirmar Exclusão?"))
                window.location.href=url;
        }
    </script>

</head>
<body>
    <h1>Cadastrar User</h1>
    <form action="acao.php" method="post">
        <label for="id">Id:</label>
        <input type="text" id="id" name="id" value=<?php if (isset($usuario)) echo $usuario['id']; else echo 0; ?> >
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome"value=<?php if(isset($usuario))echo $usuario['nome'] ?>>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value=<?php if (isset($usuario)) echo $usuario['email'] ?>>   
        <label for="nome">Senha:</label>
        <input type="password" id="senha" name="senha" value=<?php if (isset($usuario)) echo $usuario['senha'] ?>>
        <label for="cidade">Cidade:</label>
        <input type="text" id="cidade" name="cidade" value=<?php if (isset($usuario))echo $usuario['cidade'] ?>>   
        <label for="passatempo">Passatempo:</label>
        <input type="text" id="passatempo" name="passatempo" value=<?php if (isset($usuario))echo $usuario['passatempo'] ?>>
        <button type='submit' name='acao' value='salvar'>Enviar</button>
    </form>

    <section>
            <form action="" method="post" id="pesquisa" >
                <input type="text" name="busca" id="busca">
                <button type="submit" name="buscar" id="buscar">Buscar</button>

            </form>
    </section>
    <section>
        <h2>Lista de já cadastrados:</h2>

        <table>
            <?php    
            include_once "dbphp.php";

            try{
                    $conexao = new PDO(MYSQL_DSN,DB_USER,DB_PASSWORD);//cria conexão com banco de dados

                    $busca = isset($_POST['busca'])?$_POST['busca']:"";
                    $query = 'SELECT * FROM user';
                    if($busca != ""){
                        $busca =  $busca.'%';
                        $query .= ' WHERE nome LIKE :busca' ;
                    }

                    $stnt = $conexao->prepare($query);
                    if ($busca != "") 
                        $stnt->bindValue(':busca',$busca);

                    $stnt->execute();

                    $usuarios = $stnt->fetchAll();
                    echo'<table class="table">';
                    echo '<tr><th>id</th><th>Nome</th><th>Email</th><th>Senha</th><th>Cidade</th><th>Passatempo</th></tr>';
                    foreach($usuarios as $usuario){
                        $editar = '<a href=fff.php?acao=editar&id='.$usuario['id'].'>Alt</a>';
                        $excluir = "<a href='#' onclick=excluir('acao.php?acao=excluir&id={$usuario['id']}')>Excluir</a>";
                        echo'<tr><td>'.$usuario['id'].'</td><td>'.$usuario['nome'].'</td><td>'.$usuario['email'].'</td><td>'.$usuario['senha'].'</td><td>'.$usuario['cidade'].'</td><td>'.$usuario['passatempo'].'</td><td>'.$editar.'</td><td>'.$excluir.'</td>';
                    }
                    echo'</table>';
                    }catch(PDOException $e){
                    print("Erro ao conectar com o banco de dados...<br>".$e->getMessage());
                    die();
                 }
                ?>
  </table>
    </section>
</body>
</html>
