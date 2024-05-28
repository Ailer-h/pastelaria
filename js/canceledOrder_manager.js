let elements = document.getElementsByTagName("tr");

function getNewVisibilityState(input){
    if(input.style.display == 'table-row'){
        return 'none';
    }

    return 'table-row';
}

function changeVisibiltyState(){
    Array.from(elements).forEach(e => {
        if(e.id.includes('cancelado')){
            e.style.display = getNewVisibilityState(e);
        }
    })
}