console.log("Masks are working")

function noSlashes_js(value, input){

    value = value.toString();
    var mask = value.replace(/[\/\\ \t\r\n]/g, '');
    
    document.getElementById(input.id).value = mask;

}

function noBackslashes(value, input){

    value = value.toString();
    var mask = value.replace(/\\/g, '');
    
    document.getElementById(input.id).value = mask;

}

//Mascaras gerais (Usar '#" para o patern)
function mask_js(value, input, pattern){

    //Limita a entrada para apenas numeros
    let i = 0;
    value = value.toString();
    value = value.replace(/\D/g, '');

    //Subtitui os "#" pelos caracteres do valor
    let result = pattern.replace(/#/g, () => value[i++] || '');

    //Caso apague a linha, limpa o valor
    if (result == pattern.replace(/#/g, "")){

        result = "";

    }

    //Retorna o valor pro elemento
    document.getElementById(input.id).value = result

}

//Somente Numeros
function nums_js(valor, input){

    valor = valor.toString();
    var mask = valor.replace(/\D/g,"");

    document.getElementById(input.id).value = mask;

}

//Mascara para somente letras
function letters_js(valor, input){

    valor = valor.toString();
    valor = valor.replace(/[\\/0-9]/g,"");

    document.getElementById(input.id).value = valor;

}