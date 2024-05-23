<?php
    include "utilities/checkSession.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/user_dashboard.css">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <title>Dashboard</title>
</head>
<body>
    <!-- Barra de navegção -->
    <div class="navbar">
        <div class="logo"></div>
        <div class="menu">
            
            <div class="user-area">
                
                <?php

                    $username = $_SESSION['username'];
                    echo"<p>Olá $username!</p>";
                
                ?>
                <a href="sessionEnded.php"><div class="logout"><img src="../images/icons/logout.png"> <p>Logout</p></div></a>
            </div>
        </div>
    </div>

    <!-- Dashboard de páginas -->
    <div class="center">
        <div class="grid">
            <div class="item">
                <h1>PDV</h1>
                    <a href="pdv.php"><button>Fazer Pedido</button></a>
            </div>

            <div class="item">
                <h1>Cozinha</h1>
                    <a href="cozinha.php"><button>Ver pedidos abertos</button></a>
            </div>
        </div>
    </div>

</body>
</html>