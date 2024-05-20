console.log("Controller is running!");

var product_order = [];
var stock = turnIntoJson(document.getElementById('estoque').value);

function turnIntoJson(string){
    
    string = string.toString();

    let jsonOBJ = JSON.parse("[" + string.substring(1, string.length-1) + "]");
    let json = {}
    
    jsonOBJ.forEach(element => {
        let key = Object.keys(element)[0];
        json[key] = element[key];
    });

    return normalize_json(json);

}

function normalize_json(json){
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
    let btn = document.getElementById('btn'+id);
    let max = qtd.max;

    if((parseInt(qtd.value) + 1) <= max){
        qtd.value = parseInt(qtd.value)+1;

        if(parseInt(qtd.value) == max){
            console.log("Disabled")
            btn.disabled = true;
            btn.className = 'disabled-btn';
        }
    }

    let recipe = turnIntoJson(document.getElementById('recipe'+id).value);
    checkRecipe(recipe);

    checkStock();

    console.log(stock);

}

function checkRecipe(recipe){

    Object.keys(recipe).forEach(key =>{
        stock[key] -= recipe[key];
    });

}

function checkStock(){
    let inputs = document.getElementsByTagName('input');

    Array.from(inputs).forEach(e =>{
        if(e.id.toString().includes('qtd')){
            let id = parseInt(e.id.toString().split('qtd')[1]);
            let recipe = turnIntoJson(document.getElementById("recipe"+id).value);

            Object.keys(recipe).forEach(key => {

                if(stock[key] < recipe[key]){
                    let btn = document.getElementById('btn'+id);
                    btn.disabled = true;
                    btn.className = 'disabled-btn';
                }
            });
            
        }
    });
}