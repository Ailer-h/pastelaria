<?php

    include "mysql_connect.php";

    $user = $_POST['user'];
    $password = $_POST['senha'];

    $query = mysqli_query($connection, "select email_user, senha_user, tipo_user, nome_user from usuarios where email_user like'".$user."';");
    $values = mysqli_fetch_array($query);
    

    if(empty($values)){

        echo"Empty";

        echo"<form action='login.php' method='post' id='erro'><input type='hidden' id='n' name='n' value='100'></form>";

        echo"<script>document.getElementById('erro').submit();</script>";

    }else if($values[1] != $password){

        echo"Wrong password";

        echo"<form action='login.php' method='post' id='erro'><input type='hidden' id='n' name='n' value='200'></form>";

        echo"<script>document.getElementById('erro').submit();</script>";

    }else{

        session_start();

        $_SESSION['username'] = $values[3];
        $_SESSION['user_flag'] = $values[2];
        $_SESSION['user_email'] = $values[0];

        
        echo "Logged <br>";
        echo "Flag = ".$values[2];

        if($values[2] == "a"){
            header("Location: adm_dashboard.php");
        
        }else if($values[2] == "f"){
            header("Location: user_dashboard.php");
            
        }else{
            echo"<br> ERRO! FLAG INVALIDA";

        }

    }

    // echo $user;
    // echo $password;

    mysqli_close($connection);

?>