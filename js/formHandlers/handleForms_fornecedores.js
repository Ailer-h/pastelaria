console.log("Running...")

let forms = [
    ``,
];

function setForm(formIx){

    let form = document.getElementById('form-box');

    if(formIx < 0 || formIx > forms.length){
        form.innerHTML = "";
        return
    }

    form.innerHTML = forms[formIx];

}