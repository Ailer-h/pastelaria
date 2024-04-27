function showInput(input_id, p_id){

    let input = document.getElementById(input_id);
    let p = document.getElementById(p_id);

    if(input.style.opacity == 0){
        input.style.opacity = 1;
        p.style.opacity = 1;
        return;
    }

    input.style.opacity = 0;
    p.style.opacity = 0;

}