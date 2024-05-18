try{
    calculateValue('label_valor');
}catch(error){}

function showInput(input_id, p_id){

    let input = document.getElementById(input_id);
    let p = document.getElementById(p_id);

    if(input.style.opacity == 0){
        input.style.opacity = 1;
        input.required = true;
        input.disabled = false;
        p.style.opacity = 1;
        return;
    }

    input.style.opacity = 0;
    input.required = false;
    input.disabled = true;
    p.style.opacity = 0;

}

function calculateValue(label_id){

    let total_value = 0;

    let inputs = document.getElementsByTagName('input');

    Array.from(inputs).forEach(e => {
        if(e.type.toLowerCase() == "number" && e.id.toLocaleLowerCase() != "val_venda" && e.value != ""){

            let id = parseInt(e.id.toString().split('qtd')[1]);
            let price = document.getElementById('lb' + id).textContent.split("(R$")[1].split("/")[0];
            
            total_value += (parseFloat(price) * parseFloat(e.value));
        }
    });

    document.getElementById(label_id).textContent = "R$" + total_value.toFixed(2).replace(".",",");

}