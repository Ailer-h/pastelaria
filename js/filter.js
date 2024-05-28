function filter(tag, buttonId){

    let showCanceled = document.getElementById('visibilityCheckbox').checked;

    Array.from(document.getElementsByTagName("tr")).forEach(tr =>{

        tr.style.display = 'none';

        console.log(tr.id.includes(tag))
        console.log(tr.id)

        if(showCanceled){
            if(tr.id.includes(tag)){
                tr.style.display = 'table-row';
            }
        }else{
            if(!tr.id.includes('cancelado') && tr.id.includes(tag)){
                tr.style.display = 'table-row';
            }
        }

    });

    document.getElementById('header').style.display = 'table-row';
    
    Array.from(document.getElementsByTagName("button")).forEach(btn => {
        if(btn.id.includes('filter')){
            btn.className = '';
        }
    })
    
    document.getElementById(buttonId).className = 'selected';
    document.getElementById('clean').style.display = 'block';

}

function cleanFilter(){

    let showCanceled = document.getElementById('visibilityCheckbox').checked;

    Array.from(document.getElementsByTagName("tr")).forEach(tr =>{

        if(showCanceled){
            tr.style.display = 'table-row';
        
        }else if(!tr.id.includes('cancelado')){
            tr.style.display = 'table-row';

        }

    });

    Array.from(document.getElementsByTagName("button")).forEach(btn => {
        if(btn.id.includes('filter')){
            btn.className = '';
        }
    })

    document.getElementById('clean').style.display = 'none';

}