<?php
    $nome = isset($_POST['nome'])?$_POST['nome']:"";
    $email = isset($_POST['email'])?$_POST['email']:"";
    $senha = isset($_POST['senha'])?$_POST['senha']:"";
    $cidade = isset($_POST['cidade'])?$_POST['cidade']:"";
    $passatempo = isset($_POST['passatempo'])?$_POST['passatempo']:"";

    include_once "dbphp.php";
    $acao= isset($_GET['acao'])?$_GET['acao']:"";
    $id = isset($_GET['id'])?$_GET['id']:0;

    if($acao =='excluir'){
        try{
            $conexao = new PDO(MYSQL_DSN,DB_USER,DB_PASSWORD);//cria conexão com banco de dados
 
            $query = 'DELETE FROM user WHERE id = :id';
    
            $stnt = $conexao->prepare($query);
    
            $stnt->bindValue(':id', $id);

            if($stnt->execute())
                header('fff.php');

                header('location: fff.php');
    
        }catch(PDOException $e){
            print("Erro ao conectar com o banco de dados...<br>".$e->getMessage());
            die();
        }

    } else if(isset($_POST['nome'])&&(isset($_POST['email']))){
        $id = isset($_POST['id'])?$_POST['id']:0;
        $nome = isset($_POST['nome'])?$_POST['nome']:"";
        $email = isset($_POST['email'])?$_POST['email']:"";
        $senha = isset($_POST['senha'])?$_POST['senha']:"";
        $cidade = isset($_POST['cidade'])?$_POST['cidade']:"";
        $pastempo = isset($_POST['passatempo'])?$_POST['passatempo']:"";

        try{
            $conexao = new PDO(MYSQL_DSN,DB_USER,DB_PASSWORD);//cria conexão com banco de dados

            // Monta a consulta
            if($id > 0)
                $query = "UPDATE user SET nome = :nome, email = :email, senha = :senha, cidade = :cidade, passatempo = :passatempo 
                WHERE id = :id";
            
            else
            $query = 'INSERT INTO user(nome,  email, senha, cidade, passatempo) VALUES (:nome, :email, :senha, :cidade, :passatempo)';

            $stmt = $conexao->prepare($query);
            if($id != 0)
            $stmt->bindValue(':id', $id);

            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':senha', $senha);
            $stmt->bindValue(':cidade', $cidade);
            $stmt->bindValue(':passatempo', $passatempo);

            $stmt->execute();
            header('location: fff.php');

            

        }catch(PDOException $e){
            print("Erro ao conectar com o banco de dados...<br>".$e->getMessage());
            die();
        }
    }



?>