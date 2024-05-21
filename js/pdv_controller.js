console.log("Controller is running!");

var product_order = [];
var stock = toJSON(document.getElementById('estoque').value);

const order_table = document.getElementById('pedido');
const label_total = document.getElementById('label-total');

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

function convertJSONValues(json){
    let normalized_json = {};

    Object.keys(json).forEach(key => {
        normalized_json[key] = parseInt(json[key]);
    });

    return normalized_json;
}

function getOrder(id){
    if(!product_order.includes(id)){
        product_order.push(id);
    }

    let qtd = document.getElementById('qtd'+id);
    let max = qtd.max;

    if((parseInt(qtd.value) + 1) <= max){
        qtd.value = parseInt(qtd.value)+1;

        let recipe = toJSON(document.getElementById('recipe'+id).value);
        removeIngredients(recipe);

        console.log(stock)

        checkStock();
        setOrders();
    }

}

function removeOrder(id){

    console.log(stock)

    let qtd = document.getElementById('qtd'+id);

    if((parseInt(qtd.value) - 1) >= 0){
        qtd.value = parseInt(qtd.value)-1;

        let recipe = toJSON(document.getElementById('recipe'+id).value);

        addIngredients(recipe);

        if(parseInt(qtd.value) == 0){
            product_order.splice(product_order.indexOf(id), 1)
        }

        checkStock();
        setOrders();

    }

}

function setOrders(){

    let total_value = 0;
    let orders_str = `<tr style='position: sticky; top: 0;'>
                        <th style='border-left: none;'>Nome:</th>
                        <th>Qtd:</th>
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

}

function removeIngredients(recipe){
    Object.keys(recipe).forEach(key =>{
        stock[key] -= recipe[key];
    });
}

function addIngredients(recipe){
    Object.keys(recipe).forEach(key =>{
        stock[key] += recipe[key];
    });
}

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

}