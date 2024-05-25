<?php

    //Checa se a sessão do usuário é valida
    include "utilities/checkSession.php";

    //Função que recebe a classe referente a tag de status
    include "utilities/getStatusClass.php";

    function getProducts($id){

        include "utilities/mysql_connect.php";

        $str_prods = "";

        $prods = mysqli_query($connection, "select pr.nome_prod, pp.qtd_prod from produtos_pedido pp, produtos pr where pp.id_prod = pr.id_prod and pp.id_pedido = $id;");

        while($output = mysqli_fetch_array($prods)){
            $str_prods = $str_prods."$output[0] x$output[1], ";
        }

        mysqli_close($connection);

        echo substr($str_prods, 0, -2).".";

    }

    function table(){

        include "utilities/mysql_connect.php";

        $query = mysqli_query($connection, "select id_pedido, estado from pedidos WHERE estado not in ('Cancelado', 'Finalizado') and dataHora_pedido >= CURRENT_DATE;");

        while($output = mysqli_fetch_array($query)){

            $status_class = getStatusClass($output[1]);

            echo"<tr class='normal-row'>";
            
            echo"<td style='max-width: 5em; padding-left: .5em; padding-right: .5em;'>";
            getProducts($output[0]);
            echo"</td>";

            echo"<td id='timer$output[0]'>00:00:00</td>";
            echo"<td><div style='display: flex; justify-content: center; gap: 1em;'><div class='$status_class'>$output[1]</div></div></td>";
            echo"<td><div id='actions$output[0]' style='display: flex; justify-content: center; gap: 1em;'>";
            echo"<button><img src='../images/icons/play.png'></button>";
            echo"</div></td>";

            echo"</tr>";

        }

    }

    //<button><img src='../images/icons/done.png'></button>
    //<button><img src='../images/icons/close.png'></button>

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cozinha.css">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <title>Pedidos</title>
</head>
<body>
    
    <div class="navbar">
        <?php
            
            if($_SESSION['user_flag'] != 'f' && $_SESSION['user_flag'] != 'c'){
                echo"<a href='adm_dashboard.php'>
                        <div class='logo'></div>
                    </a>";
            
            }else{
                echo"<a href='user_dashboard.php'>
                        <div class='logo'></div>
                    </a>";
            }
        
        ?>

        <h1>Pedidos Abertos</h1>
        
        <div class="menu">

            <?php
        
                if($_SESSION['user_flag'] != 'f' && $_SESSION['user_flag'] != 'c'){
                    echo"<a href='tabelaProdutos.php'><button>Produtos</button></a>
                        <a href='cozinha.php'><button>Cozinha</button></a>
                        <button>Pedidos</button>";
            
                }else{
                    echo"<a href='pdv.php'><button>PDV</button></a>
                        <a href=''><button>Pedidos</button></a>";

                }
        
            ?>

            <div class="user-area">
                <?php

                    $username = $_SESSION['username'];
                    echo"<p>Olá $username!</p>";

                ?>
                <a href="sessionEnded.php"><div class="logout"><img src="../images/icons/logout.png"><p>Logout</p></div></a>
            </div>
        </div>
    </div>

    <div class="table-holder">
        <table>
            <tr style="position: sticky; top: 0; background-color: #dcdcdc;">
                <th style='border-left: none;'>Produtos do Pedido</th>
                <th>Tempo do Pedido</th>
                <th>Estado do Pedido</th>
                <th style='border-right: none;'>Ações</th>
            </tr>

            <?php
                table();
            ?>

        </table>
    </div>

</body>
</html>