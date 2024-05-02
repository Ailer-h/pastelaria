<?php

    //Checa se a sessão do usuário é valida
    include "utilities/checkSession.php";
    
    //Checa se o usuário tem permissões para entrar na pagina
    include "utilities/checkPermissions.php";

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar'])){

        include "utilities/mysql_connect.php";

        $nome = $_POST['nome'];
        $val_venda = $_POST['val_venda'];
        $img = $_FILES['image'];
        
        $search_nome = mysqli_fetch_array(mysqli_query($connection, "select nome_prod from produtos where nome_prod like '$nome' group by nome_prod"));
        
        if(empty($search_nome)){

            if($img != NULL){
                
                $pic = base64_encode(file_get_contents(addslashes($img['tmp_name'])));
                
                $id_query = mysqli_query($connection, "select id_item, valor_custo, unidade_medida from estoque;");
                
                while($output = mysqli_fetch_array($id_query)){

                    if(isset($_POST['qtd'.$output[0]])){
                        
                        $qtd = $_POST['qtd'.$output[0]];
                        
                        $query = mysqli_query($connection, "insert into produtos(nome_prod, img_prod, id_ingrediente, preco_custo, qtd_ingrediente, valor_venda) values('$nome','$pic','$output[0]','$output[1]','$qtd','$val_venda')");
                        
                    }
                    
                }
                
                mysqli_close($connection);
                
                header("Location: tabelaProdutos.php");
                
            }
            
        }else{
            echo"<script>alert('Produto já existe')</script>";
        
        }


    }
        
        function getProducts(){
        
        include "utilities/mysql_connect.php";
        $query = mysqli_query($connection, "select id_item, nome_item, unidade_medida, valor_custo from estoque;");

        while($output = mysqli_fetch_array($query)){
            echo"<label for='check$output[0]'>$output[1] (R$$output[3]/$$output[2])</label>";
            echo"<input type='checkbox' name='check$output[0]' id='check$output[0]' onchange='showInput(\"qtd$output[0]\", \"p$output[0]\")'>";
            echo"<div style='display: flex; gap: .4em;'>
                    <input type='number' name='qtd$output[0]' id='qtd$output[0]' style='opacity: 0; width: 5em;' disabled>
                    <p id='p$output[0]' style='opacity: 0;'>$output[2]</p>
                </div>";
        }

        mysqli_close($connection);

    }

    function setForm($form_id){

        if($form_id == 0){
            echo"<div class='center-absolute'>
            <div class='header'>
                <h1 id='titulo-form'>Novo Produto</h1>
                <img src='../images/icons/close.png' id='close-register' onclick='location.href = location.href'>
            </div>
            <form action='tabelaProdutos.php' method='post' enctype='multipart/form-data'>
            <div class='form-holder'>
                <div class='half-1'>
                    <div class='r-one'>
                        <div style='display: flex; flex-direction: column;'>
                            <label for='nome'>Nome:</label>
                            <input type='text' name='nome' id='nome' required>
                        </div>
                        
                        <div style='display: flex; flex-direction: column;'>
                            <label for='val_venda'>Valor de Venda:</label>
                            <input type='number' name='val_venda' id='val_venda' min='0.0001' step='any' required>
                        </div>

                    </div>

                    <div class='r-two'>

                            <div class='prod-grid'>";

                                    getProducts();
                            
                            echo"</div>

                    </div>

                    <input type='submit' name='cadastrar' value='Cadastrar'>
                </div>
                <div class='half-2'>
                    <div class='img-frame'><img class='img-thumbnail' id='img-thumbnail'></div>
                    <p id='img-filename' style='font-style: italic;'></p>
                    <div class='img-input'>
                        <label for='img' class='label'>Imagem do Produto</label>
                        <input type='file' name='image' id='img' accept='.jpg, .jpeg, .png' onchange='changePlaceholder(\"img-filename\", this.id, \"img-thumbnail\")' required>
                    </div>
                </div>

                </div>
            </form>
        </div>";
        }

    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/tabelaProdutos.css">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <title>Produtos</title>
</head>
<body>

    <div class="navbar">
        <a href="adm_dashboard.php">
            <div class="logo"></div>
        </a>

        <h1>Produtos</h1>
        <div class="menu">
            <button>Produtos</button>
            <button>Pedidos</button>

            <div class="user-area">
                <?php

                $username = $_SESSION['username'];
                echo "<p>Olá $username!</p>";

                ?>
                <a href="sessionEnded.php">
                    <div class="logout"><img src="../images/icons/logout.png">
                        <p>Logout</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="center">
        <div class="table-header">

            <form action="tabelaProdutos.php" method="post" id="searchbox">
                <input type="text" placeholder="Pesquisar..." name="search" id="searchbar">
                <input type="submit" value="🔎︎">
                <a href="tabelaProdutos.php"><img src="../images/icons/close.png" id="close-search"></a>
            </form>

            <div id="menu">
                <button onclick=""><img src="../images/icons/report.png"></button>
                <form action="tabelaProdutos.php" method="post">
                    <input type="hidden" name="new-item" value="0">
                    <button><img src="../images/icons/plus.png"></button>
                </form>
            </div>

        </div>

        <div class="table-holder">
            <table>
                <tr style="position: sticky; top: 0; background-color: #dcdcdc;">
                <th style="border-left: none;">Nome</th>
                <th>Ingredientes</th>
                <th>Preço</th>
                <th style="border-right: none;">Valor de Venda</th>

            </table>
        </div>
    </div>

    <div id="form-box">
        <?php
        
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new-item'])){
            setForm(0);
        
        }
        
        ?>
    </div>

</body>
<script src="../js/masks.js"></script> <!-- Pacote de máscaras -->
<script src="../js/imgPlaceholder_handler.js"></script> <!-- Função para a preview da imagem selecionada -->
<script src="../js/show_qtdInput.js"></script>
</html>