<?php

    //Verifica se o usuário está logado para impedir a entrada sem loging

    session_start();

    if(!isset($_SESSION['username'])){

        header("Location: sessionEnded.php");

    }

?>