var stock = toJSON(document.getElementById('estoque').value);

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
}

//Atualiza o JSON de estoque e a envia em forma de string bara o php
function updateStockArray(){

    let jsonStock = JSON.stringify(stock);

    document.getElementById('estoque').value = jsonStock;

}

//FIm das funções de apoio

//Funções do Timer
function timeout(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

async function timer(startDate, id){

    while(true){
        let time = Math.abs(new Date() - new Date(startDate.replace(/-/g, '/')))
    
        time = Math.floor(time/1000);

        let h = Math.floor(time/3600);
        let m = Math.floor((time%3600)/60);
        let s = time%60;

        let formatedTimer = h.toString().padStart(2,"0") + ":" +
                            m.toString().padStart(2,"0") + ":" +
                            s.toString().padStart(2,"0");
    

        document.getElementById(id).innerHTML = formatedTimer;

        await timeout(1000);

    }

}
//Fim das funções do timer

//Funções de controle
function start(id){

    document.getElementById('actions'+id).innerHTML = `<button type='button' onclick='done(${id})'><img src='../images/icons/done.png'></button>
                                                        <button type='button' onclick='cancel(${id},true)'><img src='../images/icons/close.png'></button>`;

    document.getElementById('newState' + id).value = 'Em Andamento';
    document.getElementById('updatedProd').value = id;
    document.getElementById('infos').submit();

}

function cancel(id, started){
    console.log(id)
    document.getElementById('newState' + id).value = 'Cancelado';
    
    if(!started){
        let recipe = toJSON(document.getElementById('recipe'+id).value);

        addIngredients(recipe);
        updateStockArray();
    }

    document.getElementById('updatedProd').value = id;
    document.getElementById('infos').submit();

}

function done(id){

    document.getElementById('newState' + id).value = 'Concluído';
    document.getElementById('updatedProd').value = id;
    document.getElementById('infos').submit();

}