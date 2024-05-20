console.log("Controller is running!");

product_order = [];

function getOrders(id){
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
    
    console.log(qtd.value)
    console.log(max)
}