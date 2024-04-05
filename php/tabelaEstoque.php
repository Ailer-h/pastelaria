<?php
    include "utilities/checkSession.php"
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/tabelaEstoque.css">
    <title>Estoque</title>
</head>
<body>
    
<div class="navbar">
        <div class="logo"></div>
        <div class="menu">
            <button>Test</button>
            <button>Test</button>
            <button>Test</button>
            <button>Test</button>
            
            <div class="user-area">
                
                <?php

                    $username = $_SESSION['username'];
                    echo"<p>Olá $username!</p>";
                
                ?>
                <a href="sessionEnded.php"><div class="logout"><img src="../images/icons/logout.png"> <p>Logout</p></div></a>
            </div>
        </div>
    </div>

    
    
</body>
</html>