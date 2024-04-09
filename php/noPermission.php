<?php

    session_start();

    if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['n'])){

        if($_SESSION['user_flag'] == "a" || $_SESSION['user_flag'] == "d"){
            header("Location: adm_dashboard.php");

        }else if($_SESSION['user_flag'] == "f"){
            header("Location: user_dashboard.php");

        }
        
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/waringPages.css">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <title>Sem Permissão</title>
</head>
<body>
    
    <div class="center">
        <img src="../images/icons/logoff.png">
        <h1>Você não tem permissão para acessar essa página!</h1>
        <a href="noPermission.php?n=100"><button>Voltar</button></a>
    </div>

</body>
</html>