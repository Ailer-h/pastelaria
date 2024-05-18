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

        if($img != NULL){
            
            $pic = base64_encode(file_get_contents(addslashes($img['tmp_name'])));
            
            mysqli_query($connection, "insert into produtos(nome_prod, img_prod, valor_venda) values ('$nome','$pic','$val_venda');");
            $id_prod = mysqli_fetch_array(mysqli_query($connection, "select id_prod from produtos order by id_prod desc;"))[0];

            $query = mysqli_query($connection, "select id_item, valor_custo from estoque;");
            
            while($output = mysqli_fetch_array($query)){

                if(isset($_POST['qtd'.$output[0]])){
                    
                    $qtd = $_POST['qtd'.$output[0]];
                    
                    mysqli_query($connection, "insert into ingredientes_prod(id_ingrediente, qtd_ingrediente, preco_ingrediente, id_produto) values('$output[0]', '$qtd', '$output[1]','$id_prod')");
                    
                }
                
            }
            
            mysqli_close($connection);
            
            header("Location: tabelaProdutos.php");
            
        }


    }

        function getProducts(){
        
        include "utilities/mysql_connect.php";
        $query = mysqli_query($connection, "select id_item, nome_item, unidade_medida, valor_custo from estoque;");

        while($output = mysqli_fetch_array($query)){

            echo"<label id='lb$output[0]' for='check$output[0]'>$output[1] (R$$output[3]/$output[2])</label>";
            echo"<input type='checkbox' name='check$output[0]' id='check$output[0]' onchange='showInput(\"qtd$output[0]\", \"p$output[0]\")'>";
            echo"<div style='display: flex; gap: .4em;'>
                    <input type='number' name='qtd$output[0]' id='qtd$output[0]' style='opacity: 0; width: 5em;' oninput='calculateValue(\"label_valor\")' disabled>
                    <p id='p$output[0]' style='opacity: 0;'>$output[2]</p>
                </div>";
        }

        mysqli_close($connection);

    }

    function show_delbox(){
        echo"<div class='center-absolute'>
        <div class='delete-header'>
            <img src='../images/icons/close.png' onclick='location.href = location.href'>
        </div>
        <div class='delete-form'>
            <div style='display: flex; align-items: center; flex-direction: column;'>
                <h1>Você deseja deletar as informações de</h1>
                <h1 id='info'>[nome]</h1>
            </div>
        
            <div class='btns'>
                <form action='tabelaProdutos.php' method='post'><input type='hidden' name='id_delete' id='id' value='0'><button class='del'>Deletar</button></form>
                <a href='tabelaProdutos.php'><button class='cancel'>Cancelar</button></a>
            </div>
        </div>
        </div>
        ";
    }

    function setProducts($id){
        include "utilities/mysql_connect.php";
        $query = mysqli_query($connection, "select id_item, nome_item, unidade_medida, valor_custo from estoque;");

        while($output = mysqli_fetch_array($query)){

            $check = mysqli_fetch_array(mysqli_query($connection, "select id_ingrediente, qtd_ingrediente from ingredientes_prod where id_produto = $id and id_ingrediente = $output[0];"));
            

            if(empty($check)){
                // echo"<script>console.log('empty')</script>";
                echo"<label id='lb$output[0]' for='check$output[0]'>$output[1] (R$$output[3]/$output[2])</label>";
                echo"<input type='checkbox' name='check$output[0]' id='check$output[0]' onchange='showInput(\"qtd$output[0]\", \"p$output[0]\")'>";
                echo"<div style='display: flex; gap: .4em;'>
                        <input type='number' name='qtd$output[0]' id='qtd$output[0]' style='opacity: 0; width: 5em;' oninput='calculateValue(\"label_valor\")' disabled>
                        <p id='p$output[0]' style='opacity: 0;'>$output[2]</p>
                    </div>";
            
            }else{
                // echo"<script>console.log('$check[0]')</script>";
                echo"<label id='lb$output[0]' for='check$output[0]'>$output[1] (R$$output[3]/$output[2])</label>";
                echo"<input type='checkbox' name='check$output[0]' id='check$output[0]' onchange='showInput(\"qtd$output[0]\", \"p$output[0]\")' checked>";
                echo"<div style='display: flex; gap: .4em;'>
                        <input type='number' name='qtd$output[0]' id='qtd$output[0]' style='opacity: 1; width: 5em;' value='$check[1]' oninput='calculateValue(\"label_valor\")' required>
                        <p id='p$output[0]' style='opacity: 1;'>$output[2]</p>
                    </div>";

            }
        
        }

        mysqli_close($connection);
    }

    function setForm($form_id,$img,$id){

        if($form_id == 0){
            echo"<div class='center-absolute'>
            <div class='header'>
                <h1 id='titulo-form'>Novo Produto</h1>
                <img src='../images/icons/close.png' id='close-register' onclick='location.href = location.href'>
            </div>
            <form action='tabelaProdutos.php' method='post' enctype='multipart/form-data'>
            <input type='hidden' name='id' id='id'>
            <div class='form-holder'>
                <div class='half-1'>
                    <div class='r-one'>
                        <div style='display: flex; flex-direction: column;'>
                            <label for='nome'>Nome:</label>
                            <input type='text' name='nome' id='nome' oninput='noBackslashes(this.value, this);' required>
                        </div>
                        
                        <div style='display: flex; flex-direction: column;'>
                            <label for='val_venda'>Valor de Venda:</label>
                            <input type='number' name='val_venda' id='val_venda' min='0.0001' step='any' required>
                        </div>

                        <div style='display: flex; flex-direction: column;'>
                            <p>Valor de Custo:</p>
                            <p id='label_valor'>R$0.00</p>
                        </div>

                    </div>

                    <div class='r-two'>
                        <h3>Ingredientes:</h3>
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
            <input type='hidden' name='id' id='id'>
            <div class='form-holder'>
                <div class='half-1'>
                    <div class='r-one'>
                        <div style='display: flex; flex-direction: column;'>
                            <label for='nome'>Nome:</label>
                            <input type='text' name='nome' id='nome' oninput='noBackslashes(this.value, this);' required>
                        </div>
                        
                        <div style='display: flex; flex-direction: column;'>
                            <label for='val_venda'>Valor de Venda:</label>
                            <input type='number' name='val_venda' id='val_venda' min='0.0001' step='any' required>
                        </div>

                        <div style='display: flex; flex-direction: column;'>
                            <p>Valor de Custo:</p>
                            <p id='label_valor'>R$0.00</p>
                        </div>

                    </div>

                    <div class='r-two'>
                        <h3>Ingredientes:</h3>
                            <div class='prod-grid'>";

                                setProducts($id);
                            
                            echo"</div>

                    </div>

                    <input type='submit' name='atualizar' id='atualizar' value='Atualizar'>
                </div>
                <div class='half-2'>
                    <div class='img-frame'><img class='img-thumbnail' id='img-thumbnail' src='data:image;base64,$img'></div>
                    <p id='img-filename' style='font-style: italic;'></p>
                    <div class='img-input' id='img-input'>
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
    function getIngredients($id){

        $str_ingredients = "";

        include "utilities/mysql_connect.php";

        $query = mysqli_query($connection, "select est.nome_item, est.unidade_medida, ig.id_ingrediente, ig.qtd_ingrediente from estoque est, produtos prod, ingredientes_prod ig WHERE ig.id_produto = $id and ig.id_ingrediente = est.id_item group by ig.id_ingrediente;");

        while($output = mysqli_fetch_array($query)){

            $str_ingredients = $str_ingredients."$output[3]$output[1] $output[0], ";

        }

        mysqli_close($connection);

        echo substr($str_ingredients, 0, -2).".";

    }

    function table($search){

        include "utilities/mysql_connect.php";

        $query = mysqli_query($connection, "select prod.nome_prod, sum(ig.preco_ingrediente*ig.qtd_ingrediente), prod.valor_venda, prod.id_prod from produtos prod, ingredientes_prod ig where ig.id_produto = prod.id_prod and prod.nome_prod like \"%$search%\" group by prod.id_prod;");

        while($output = mysqli_fetch_array($query)){

            $preco = sprintf("%1$.2f", $output[1]);
            $val = sprintf("%1$.2f", $output[2]);

            echo"<tr class='normal-row'>";

            echo"<td>$output[0]</td>";
            echo"<td style='width: 20em; padding-left: .5em; padding-right: .5em;'>";
            getIngredients($output[3]);
            echo"</td>";
            echo"<td>R$$preco</td>";
            echo"<td>R$$val</td>";

            echo"<td><div style='display: flex; justify-content: center; gap: 1em;'>";
            echo"<form action='tabelaProdutos.php' method='post'><input type='hidden' name='id_info' value='$output[3]'><button name='get_info' type='submit'><img src='../images/icons/info.png'></button></form>";
            echo"<form action='tabelaProdutos.php' method='post'><input type='hidden' name='id_delete-confirmar' value='$output[3]'><button name='delete' type='submit'><img src='../images/icons/delete.png'></button></form>";
            echo"<form action='tabelaProdutos.php' method='post'><input type='hidden' name='id_edit' value='$output[3]'><button name='edit' type='submit'><img src='../images/icons/edit.png'></button></form>";
            echo"</div></td></tr>";

            echo"</tr>";
        }

        mysqli_close($connection);

    }

    //Funções das ações
    function edit($id){
        
        $nome = $_POST['nome'];
        $val_venda = $_POST['val_venda'];
        
        include "utilities/mysql_connect.php";

        if($_FILES['image']['size'] > 0){
            $img = $_FILES['image'];
            $pic = base64_encode(file_get_contents(addslashes($img['tmp_name'])));
        
        }else{
            $pic = mysqli_fetch_array(mysqli_query($connection, "select img_prod from produtos where id_prod = $id;"))[0];

        }

        mysqli_query($connection, "update produtos set nome_prod = '$nome', img_prod = '$pic', valor_venda = '$val_venda' where id_prod = $id;");

        $id_query = mysqli_query($connection, "select id_item, valor_custo from estoque;");
            
        while($output = mysqli_fetch_array($id_query)){

            $prod_exists = !empty(mysqli_fetch_array(mysqli_query($connection, "select id from ingredientes_prod where id_ingrediente = $output[0] and id_produto = $id;")));
            
            echo"<script>console.log('$prod_exists')</script>";

            if(isset($_POST['qtd'.$output[0]])){
                
                $qtd = $_POST['qtd'.$output[0]];

                if($prod_exists){
            echo"<script>console.log('prod_exists')</script>";
                    mysqli_query($connection, "update ingredientes_prod set qtd_ingrediente = '$qtd' where id_produto = $id and id_ingrediente = $output[0];");
                    
                }else{
            echo"<script>console.log('prod_not_exists')</script>";

                    mysqli_query($connection, "insert into ingredientes_prod(id_ingrediente, preco_ingrediente, qtd_ingrediente, id_produto) values('$output[0]','$output[1]','$qtd', '$id');");
                    
                }

                    
            }else{

                if($prod_exists){
                    mysqli_query($connection, "delete from ingredientes_prod where id_produto = $id and id_ingrediente = $output[0];");
                    
                }

            }
        }

        mysqli_close($connection);
        header("Location: tabelaProdutos.php");

    }

    function delete_item($id){
        include "utilities/mysql_connect.php";
        mysqli_query($connection, "delete from produtos where id_prod = $id;");
        mysqli_query($connection, "delete from ingredientes_prod where id_produto = $id;");
        mysqli_close($connection);

        header("Location: tabelaProdutos.php");
    }

    //Recebe a solicitação de deleção
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_delete'])){
        delete_item($_POST['id_delete']);

    }

    //Recebe a solicitação de edição
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['atualizar'])){
        edit($_POST['id']);
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
        
        }else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_edit'])){

            $id = $_POST['id_edit'];
        
            include "utilities/mysql_connect.php";

            $values = mysqli_fetch_array(mysqli_query($connection, "select nome_prod, valor_venda, img_prod from produtos where id_prod = $id;"));

            setForm(1, $values[2],$id);

            echo"<script>

                    document.getElementById('nome').value = '$values[0]';
                    document.getElementById('val_venda').value = '$values[1]';
                    document.getElementById('id').value = '$id';

            </script>";

            mysqli_close($connection);
        
        }else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_delete-confirmar'])){
            show_delbox();

            $id = $_POST['id_delete-confirmar'];

            include "utilities/mysql_connect.php";
            $nome = mysqli_fetch_array(mysqli_query($connection, "select nome_prod from produtos where id_prod = $id;"))[0];

            echo"<script>

                    document.getElementById('info').textContent = '$nome?';
                    document.getElementById('id').value = '$id';

                </script>";

        }else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_info'])){

            $id = $_POST['id_info'];
        
            include "utilities/mysql_connect.php";

            $values = mysqli_fetch_array(mysqli_query($connection, "select id, valor_venda, img_prod from produtos WHERE id like \"$id\" group by id;"));

            setForm(1, $values[2],$values[0]);

            echo"<script>

                    document.getElementById('nome').value = '$values[0]';
                    document.getElementById('val_venda').value = '$values[1]';
                    document.getElementById('id').value = '$values[0]';

                    Array.from(document.getElementsByTagName('input')).forEach(e => {
                        e.disabled = true;
                        if(e.type.toLowerCase() == 'checkbox'){ e.style.opacity = 0;}
                    });

                    document.getElementById('img-input').style.display = 'none';
                    document.getElementById('atualizar').style.display = 'none';
                    document.getElementById('titulo-form').textContent = 'Informações';

            </script>";

        }

        ?>

    </div>

</body>
<script src="../js/masks.js"></script> <!-- Pacote de máscaras -->
<script src="../js/imgPlaceholder_handler.js"></script> <!-- Função para a preview da imagem selecionada -->
<script src="../js/qtd_handler.js"></script> <!-- Mostrar o input de quantidade -->
</html>