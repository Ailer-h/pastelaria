console.log("Controller is running!");

var product_order = [];
var stock = toJSON(document.getElementById('estoque').value);

const order_table = document.getElementById('pedido');
const label_total = document.getElementById('label-total');
const input_total = document.getElementById('valor-total');

//Função que recebe uma string e retorna um JSON normalizado
function toJSON(string){
    
    string = string.toString();

    let jsonOBJ = JSON.parse("[" + string.substring(1, string.length-1) + "]");
    let json = {}
    
    jsonOBJ.forEach(element => {
        let key = Object.keys(element)[0];
        json[key] = element[key];
    });

    return convertJSONValues(json);

}

//Função que normaliza um JSON (Converte os valores em string para valores numéricos)
function convertJSONValues(json){
    let normalized_json = {};

    Object.keys(json).forEach(key => {
        normalized_json[key] = parseInt(json[key]);
    });

    return normalized_json;
}

//Função que pega o pedido feito e aumenta a quantidade e inclui o pedido na fila
function getOrder(id){
    if(!product_order.includes(id)){
        product_order.push(id);
        updateArrayPedidos();
    }

    let qtd = document.getElementById('qtd'+id);

    qtd.value = parseInt(qtd.value)+1;

    let recipe = toJSON(document.getElementById('recipe'+id).value);
    removeIngredients(recipe);

    //Faz a checagem dos valores do estoque
    checkStock();
    setOrders();

}

//Atualiza a fila de pedidos e a envia em forma de string para o php
function updateArrayPedidos(){

    let jsonPedidos = JSON.stringify(product_order);

    document.getElementById('array_pedidos').value = jsonPedidos;

}

//Atualiza o JSON de estoque e a envia em forma de string bara o php
function updateStockArray(){

    let jsonStock = JSON.stringify(stock);

    document.getElementById('estoque').value = jsonStock;

}

//Função que pega o pedido feito e diminui a quantidade e remove o pedido da fila caso necessário
function removeOrder(id){

    let qtd = document.getElementById('qtd'+id);

    if((parseInt(qtd.value) - 1) >= 0){
        qtd.value = parseInt(qtd.value)-1;

        let recipe = toJSON(document.getElementById('recipe'+id).value);

        addIngredients(recipe);

        if(parseInt(qtd.value) == 0){
            product_order.splice(product_order.indexOf(id), 1);
            updateArrayPedidos();
        }

        checkStock();
        setOrders();

    }

}

//Passa os pedidos do usuários para a barra lateral do pdv
function setOrders(){

    let total_value = 0;
    let orders_str = `<tr style='position: sticky; top: 0;'>
                        <th style='border-left: none;'>Nome</th>
                        <th>Qtd</th>
                        <th>Preço</th>
                        <th style='border-right: none; width: 3em;'></th>
                    </tr>`;

    product_order.forEach(id =>{
        let qtd = document.getElementById('qtd'+id);
        let info = document.getElementById('info'+id);

        let name = info.textContent.split('-')[0];
        let price = info.textContent.split('-')[1];

        total_value += parseFloat(price.split('R$')[1].replace(',','.')) * parseInt(qtd.value);

        orders_str += `<tr class='normal-row'>
            <td>${name}</td>
            <td>${qtd.value}</td>
            <td>${price}</td>
            <td><img src="../images/icons/minus.png" onclick='removeOrder(${id})'></td>
        </tr>`;

    });

    order_table.innerHTML = orders_str;
    label_total.textContent = 'R$' + total_value.toFixed(2).replace('.',',');
    input_total.value = total_value;

    //Habilita ou desabilita o botão de confirmar
    if(product_order.length > 0 && phoneNumbers.includes(searchbar.value)){
        order_btn.disabled = false;
        order_btn.className = 'btn';
        
    }else{
        order_btn.disabled = true;
        order_btn.className = 'disabled-btn';
    }

}

//Remove os ingredientes do estoque baseado na receita de um produto
function removeIngredients(recipe){
    Object.keys(recipe).forEach(key =>{
        stock[key] -= parseInt(recipe[key]);
    });
}

//Adiciona os ingredientes de volta no estoque baseado na receita de um produto
function addIngredients(recipe){
    Object.keys(recipe).forEach(key =>{
        stock[key] += parseInt(recipe[key]);
    });
}

//Checa o estoque e desabilita os produtos que não podem ser pedidos
function checkStock(){

    let inputs = document.getElementsByTagName('input');

    Array.from(inputs).forEach(e =>{
        if(e.id.toString().includes('qtd')){
            let id = parseInt(e.id.toString().split('qtd')[1]);
            let recipe = toJSON(document.getElementById("recipe"+id).value);

            let keys = Object.keys(recipe);
            for(let i = 0; i < keys.length; i++){
                let btn = document.getElementById('btn'+id);

                if(stock[keys[i]] < recipe[keys[i]]){
                    btn.disabled = true;
                    btn.className = 'disabled-btn';
                    break;
                
                }else{
                    btn.disabled = false;
                    btn.className = 'button';

                }

            }
            
        }
    });

    //Faz o update do array de estoque no php
    updateStockArray();

}

//Printa o forms de novo cliente na tela
function newClient(){
    
    let nome = document.getElementById('nome_cli').value;
    let tel = document.getElementById('telefone_cli').value;
    let endereco = document.getElementById('endereco_cli').value;
    
    document.getElementById('form-box').style.display = 'block';

    document.getElementById('nome').value = nome;
    document.getElementById('tel').value = tel;
    document.getElementById('email').value = '';
    document.getElementById('endereco').value = endereco;
    document.getElementById('cpf').value = '';
    document.getElementById('rg').value = '';
    
    document.getElementById('descricao').value = '';
                    
}