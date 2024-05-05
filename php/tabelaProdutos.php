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
                
                $id_query = mysqli_query($connection, "select id_item, valor_custo from estoque;");
                
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

    function setProducts($nome_prod){
        include "utilities/mysql_connect.php";
        $query = mysqli_query($connection, "select id_item, nome_item, unidade_medida, valor_custo from estoque;");

        while($output = mysqli_fetch_array($query)){

            $check = mysqli_fetch_array(mysqli_query($connection, "select id_ingrediente, qtd_ingrediente, nome_prod from produtos where nome_prod like \"$nome_prod\" and id_ingrediente = $output[0];"));

            if(empty($check)){

                echo"<label for='check$output[0]'>$output[1] (R$$output[3]/$$output[2])</label>";
                echo"<input type='checkbox' name='check$output[0]' id='check$output[0]' onchange='showInput(\"qtd$output[0]\", \"p$output[0]\")'>";
                echo"<div style='display: flex; gap: .4em;'>
                        <input type='number' name='qtd$output[0]' id='qtd$output[0]' style='opacity: 0; width: 5em;' disabled>
                        <p id='p$output[0]' style='opacity: 0;'>$output[2]</p>
                    </div>";
            
            }else{

                echo"<label for='check$output[0]'>$output[1] (R$$output[3]/$$output[2])</label>";
                echo"<input type='checkbox' name='check$output[0]' id='check$output[0]' onchange='showInput(\"qtd$output[0]\", \"p$output[0]\")' checked>";
                echo"<div style='display: flex; gap: .4em;'>
                        <input type='number' name='qtd$output[0]' id='qtd$output[0]' style='opacity: 1; width: 5em;' value='$check[1]' required>
                        <p id='p$output[0]' style='opacity: 1;'>$output[2]</p>
                    </div>";

            }
        
        }

        mysqli_close($connection);
    }

    function setForm($form_id,$img,$nome_prod){

        if($form_id == 0){
            echo"<div class='center-absolute'>
            <div class='header'>
                <h1 id='titulo-form'>Novo Produto</h1>
                <img src='../images/icons/close.png' id='close-register' onclick='location.href = location.href'>
            </div>
            <form action='tabelaProdutos.php' method='post' enctype='multipart/form-data'>
            <input type='hidden' name='name_id' id='name_id'>
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
        
        }else if($form_id == 1){
            echo"
            <div class='center-absolute'>
            <div class='header'>
                <h1 id='titulo-form'>Editar Produto</h1>
                <img src='../images/icons/close.png' id='close-register' onclick='location.href = location.href'>
            </div>
            <form action='tabelaProdutos.php' method='post' enctype='multipart/form-data'>
            <input type='hidden' name='nome_prod' id='nome_prod'>
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

                                setProducts($nome_prod);
                            
                            echo"</div>

                    </div>

                    <input type='submit' name='atualizar' value='Atualizar'>
                </div>
                <div class='half-2'>
                    <div class='img-frame'><img class='img-thumbnail' id='img-thumbnail' src='data:image;base64,$img'></div>
                    <p id='img-filename' style='font-style: italic;'></p>
                    <div class='img-input'>
                        <label for='img' class='label'>Imagem do Produto</label>
                        <input type='file' name='image' id='img' accept='.jpg, .jpeg, .png' onchange='changePlaceholder(\"img-filename\", this.id, \"img-thumbnail\")'>
                    </div>
                </div>

                </div>
            </form>
        </div>
            ";
        }

    }

    //Funções usadas na tabela
    function getIngredients($nome){

        $str_ingredients = "";

        include "utilities/mysql_connect.php";

        $query = mysqli_query($connection, "select prod.id_ingrediente, prod.qtd_ingrediente, prod.nome_prod, est.nome_item, est.unidade_medida from produtos prod, estoque est where prod.nome_prod like \"$nome\" AND est.id_item = prod.id_ingrediente;");

        while($output = mysqli_fetch_array($query)){

            $str_ingredients = $str_ingredients."$output[1]$output[4] $output[3], ";

        }

        mysqli_close($connection);

        echo substr($str_ingredients, 0, -2).".";

    }

    function table($search){

        include "utilities/mysql_connect.php";

        $query = mysqli_query($connection, "select nome_prod, qtd_ingrediente, sum(preco_custo*qtd_ingrediente), valor_venda from produtos where nome_prod like \"%$search%\" group by nome_prod;");

        while($output = mysqli_fetch_array($query)){

            echo"<tr class='normal-row'>";

            echo"<td>$output[0]</td>";
            echo"<td style='width: 20em;'>";
            getIngredients($output[0]);
            echo"</td>";
            echo"<td>$output[2]</td>";
            echo"<td>$output[3]</td>";

            echo"<td><div style='display: flex; justify-content: center; gap: 1em;'>";
            echo"<form action='tabelaProdutos.php' method='post'><input type='hidden' name='nome_info' value='$output[0]'><button name='get_info' type='submit'><img src='../images/icons/info.png'></button></form>";
            echo"<form action='tabelaProdutos.php' method='post'><input type='hidden' name='nome_delete-confirmar' value='$output[0]'><button name='delete' type='submit'><img src='../images/icons/delete.png'></button></form>";
            echo"<form action='tabelaProdutos.php' method='post'><input type='hidden' name='nome_edit' value='$output[0]'><button name='edit' type='submit'><img src='../images/icons/edit.png'></button></form>";
            echo"</div></td></tr>";

            echo"</tr>";
        }

        mysqli_close($connection);

    }

    //Funções das ações
    function edit($nome_prod){
        
        $nome = $_POST['nome'];
        $val_venda = $_POST['val_venda'];
        
        include "utilities/mysql_connect.php";

        $img = $_FILES['image']['size'] > 0 ? $_FILES['image'] : mysqli_fetch_array(mysqli_query($connection, "select img_prod from produtos where nome_prod like \"$nome_prod\";"))[0];

        $pic = base64_encode(file_get_contents(addslashes($img['tmp_name'])));

        $id_query = mysqli_query($connection, "select id_item, valor_custo from estoque;");
            
        while($output = mysqli_fetch_array($id_query)){

            $prod_exists = !empty(mysqli_fetch_array(mysqli_query($connection, "select * from produtos where id_ingrediente = $output[0] and nome_prod like \"$nome_prod\"")));
            
            if(isset($_POST['qtd'.$output[0]])){
                
                $qtd = $_POST['qtd'.$output[0]];

                if($prod_exists){
                    mysqli_query($connection, "update produtos set nome_prod = '$nome', img_prod = '$pic', id_ingrediente = '$output[0]', preco_custo = '$output[1]', qtd_ingrediente = '$qtd', valor_venda = '$val_venda' where nome_prod like \"$nome_prod\" and id_ingrediente = $output[0];");
                    
                }else{
                    mysqli_query($connection, "insert into produtos(nome_prod, img_prod, id_ingrediente, preco_custo, qtd_ingrediente, valor_venda) values('$nome','$pic','$output[0]','$output[1]','$qtd','$val_venda');");
                    
                }

                    
            }else{

                if($prod_exists){
                    mysqli_query($connection, "delete from produtos where nome_prod like \"$nome_prod\" and id_ingrediente = $output[0];");
                    
                }

            }
        }

        mysqli_close($connection);

    }

    //Recebe a solicitação de deleção
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_delete'])){
        // delete_item($_POST['id_delete']);

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
                <th>Valor de Venda</th>
                <th style="border-right: none;">Ações</th></tr>

                <?php

                    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])){
                        $search = $_POST['search'];
                        table($search);

                        echo "<script>
                                document.getElementById('searchbar').value='$search'
                                document.getElementById('close-search').style.display = 'block'
                            </script>";
                    
                    }else{
                        table("");

                    }

                ?>

            </table>
        </div>
    </div>

    <div id="form-box">
        <?php
        
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new-item'])){
            setForm(0,"","");
        
        }else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome_edit'])){

            $id = $_POST['nome_edit'];
            echo"<script>console.log('$id')</script>";
        
            include "utilities/mysql_connect.php";

            $values = mysqli_fetch_array(mysqli_query($connection, "select nome_prod, valor_venda, img_prod from produtos WHERE nome_prod like \"$id\" group by nome_prod;"));

            setForm(1, $values[2],$values[0]);

            echo"<script>

                    document.getElementById('nome').value = '$values[0]';
                    document.getElementById('val_venda').value = '$values[1]';
                    document.getElementById('nome_prod').value = '$values[0]';
            
            </script>";

            $info_ingredients = mysqli_query($connection, "select id_ingrediente, qtd_ingrediente, nome_prod from produtos where nome_prod like \"$id\";");

            mysqli_close($connection);
        
        }else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome_delete-confirmar'])){
            //WIP

        }else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome_info'])){
            //WIP

        }

        ?>

    </div>

</body>
<script src="../js/masks.js"></script> <!-- Pacote de máscaras -->
<script src="../js/imgPlaceholder_handler.js"></script> <!-- Função para a preview da imagem selecionada -->
<script src="../js/show_qtdInput.js"></script> <!-- Mostrar o input de quantidade -->
</html>