function filter(tag){
    
    Array.from(document.getElementsByTagName("button")).forEach(btn => {
        if(btn.id.includes('filter')){
            btn.className = '';
        }
    })
    
    document.getElementById('filterTag').value = tag;
    document.getElementById('filterForm').submit();

}