<!-- <script type="text/javascript" src="http://jqueryjs.googlecode.com/files/jquery-1.3.2.js"></script> -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<?php

    include "mysql_connect.php";

    $user = $_POST['user'];
    $password = $_POST['senha'];

    $query = mysqli_query($connection, "select email_user, senha_user, tipo_user from usuarios where email_user like'".$user."';");
    $values = mysqli_fetch_array($query);
    

    if(empty($values)){

        echo"Empty";

        header("Location: login.php?n=100");

    }else if($values[1] != $password){

        echo"Wrong password";

        header("Location: login.php?n=200");

    }else{

        echo "Logged <br>";
        echo "Flag = ".$values[2];

    }

    // echo $user;
    // echo $password;

?>