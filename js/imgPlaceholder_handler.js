function changePlaceholder(id_placeholder, id_file, id_thumb){

    let fileInput = document.getElementById(id_file); 

    //Pega o nome do arquivo usando uma expressão regex
    let filename = fileInput.value.split(/(\\|\/)/g).pop();

    let file = fileInput.files[0];

    if(file){
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.addEventListener('load', function(){
            document.getElementById(id_thumb).src = this.result;
        })
    }

    document.getElementById(id_placeholder).textContent = filename;
}