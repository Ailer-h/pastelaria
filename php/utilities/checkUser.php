<!-- Faz a verificação do login do usuario -->
<?php

    include "mysql_connect.php";

    $user = $_POST['user'];
    $password = $_POST['senha'];

    $query = mysqli_query($connection, "select email_user, senha_user, tipo_user, nome_user from usuarios where email_user like'".$user."';");
    $values = mysqli_fetch_array($query);
    
    //Detecta informações de login errada e envia o erro adequado
    if(empty($values)){ //Se o email não existir no banco

        echo"<form action='../login.php' method='post' id='erro'><input type='hidden' id='n' name='n' value='100'></form>";

        echo"<script>document.getElementById('erro').submit();</script>";

    }else if($values[1] != $password){ //Se a senha estiver errada

        echo"<form action='../login.php' method='post' id='erro'><input type='hidden' id='n' name='n' value='200'></form>";

        echo"<script>document.getElementById('erro').submit();</script>";

    }else{

        //Salva a sessão do usuário
        session_start();

        $_SESSION['username'] = $values[3];
        $_SESSION['user_flag'] = $values[2];
        $_SESSION['user_email'] = $values[0];

        //Envia o usuario para a pagina correta com base na sua função
        if($values[2] == "a" || $values[2] == "d"){
            header("Location: ../adm_dashboard.php");
        
        }else if($values[2] == "f"){
            header("Location: ../user_dashboard.php");
            
        }else{ //Precaução de erro na flag
            echo"<br> ERRO! FLAG INVALIDA";

        }

    }

    mysqli_close($connection);

?>