function showPassword(passwordId, iconid){
    console.log('Runned')
    let icon = document.getElementById(iconid);
    let input = document.getElementById(passwordId);

    console.log(icon.src)

    if(icon.src.includes('hide.png')){
        icon.src = '../images/icons/show.png';
        input.type = 'text';
    
        return
    }

    icon.src = '../images/icons/hide.png';
    input.type = 'password';

}