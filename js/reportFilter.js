function filter(tag, buttonId){
    
    Array.from(document.getElementsByTagName("button")).forEach(btn => {
        if(btn.id.includes('filter')){
            btn.className = '';
        }
    })
    
    document.getElementById(buttonId).className = 'selected';
    document.getElementById('clean').style.display = 'block';

}

function cleanFilter(){

    Array.from(document.getElementsByTagName("button")).forEach(btn => {
        if(btn.id.includes('filter')){
            btn.className = '';
        }
    })

    document.getElementById('clean').style.display = 'none';

}