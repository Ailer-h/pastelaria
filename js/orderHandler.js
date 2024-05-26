var stock = toJSON(document.getElementById('estoque').value);
updateStockArray();

const form = document.getElementById('infos');
const updatedProd = document.getElementById('updatedProd');

//Funções de apoio
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

function addIngredients(recipe){
    Object.keys(recipe).forEach(key =>{
        stock[key] += parseInt(recipe[key]);
    });

    console.log(stock)
}

//Atualiza o JSON de estoque e a envia em forma de string bara o php
function updateStockArray(){

    let jsonStock = JSON.stringify(stock);

    document.getElementById('estoque').value = jsonStock;

}

//FIm das funções de apoio

//Funções de controle
function start(id){

    document.getElementById('newState' + id).value = 'Em Andamento';
    updatedProd.value = id;
    form.submit();

}

function cancel(id, started){

    document.getElementById('newState' + id).value = 'Cancelado';
    
    if(!started){
        let recipe = toJSON(document.getElementById('recipe'+id).value);

        addIngredients(recipe);
        updateStockArray();
    }

    updatedProd.value = id;
    form.submit();

}

function done(id){

    document.getElementById('newState' + id).value = 'Concluído';
    updatedProd.value = id;
    form.submit();

}