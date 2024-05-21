var userInfos = toJSON(document.getElementById('phoneNumbers').value);
let phoneNumbers = [];

Object.keys(userInfos).forEach(number => {
    phoneNumbers.push(number);
});

function toJSON(string){
    
    string = string.toString();

    let jsonOBJ = JSON.parse("[" + string.substring(1, string.length-1) + "]");
    let json = {}
    
    jsonOBJ.forEach(element => {
        let key = Object.keys(element)[0];
        json[key] = element[key];
    });

    return json;

}

const results = document.getElementById('results');
const searchbar = document.getElementById('telefone_cli');

function search(){

    let result = [];
    let input = searchbar.value;

    if(input.length){
        result = phoneNumbers.filter((keyword) => {
            return keyword.toLowerCase().includes(input.toLowerCase());
        });
    }
    display(result);

    if(!result.length){
        results.innerHTML = '';

        document.getElementById('nome_cli').value = '';
        document.getElementById('endereco_cli').value = '';
    }
}

function display(result){
    const content = result.map((list) => {
        return "<li onclick=selectResult(this)>" + list + "</li>"
    });

    results.innerHTML = "<ul>"+ content.join("") +"</ul>";
}

function selectResult(list){
    searchbar.value = list.innerHTML;
    results.innerHTML = '';

    placeUserInfo(list.innerHTML);
}

function placeUserInfo(phone){
    document.getElementById('nome_cli').value = userInfos[phone][0];
    document.getElementById('endereco_cli').value = userInfos[phone][1];
}