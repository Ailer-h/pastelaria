let elements = document.getElementsByTagName("tr");

// changeVisibiltyState();

function getNewVisibilityState(input){
    if(input.style.display == 'table-row'){
        return 'none';
    }

    return 'table-row';
}

function changeVisibiltyState(){
    Array.from(elements).forEach(e => {
        if(e.id.includes('canceled')){
            e.style.display = getNewVisibilityState(e);
        }
    })
}