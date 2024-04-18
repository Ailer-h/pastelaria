console.log("Running...")

let forms = [
    `<div class="center-absolute">
    <div class="header">
        <h1 id="titulo-form">Novo Cliente</h1>
        <img src="../images/icons/close.png" id="close-register" onclick="setForm(-1);">
    </div>
    <form action="tabelaClientes.php" method="post">
        <div class="form-holder">
            <div class="r-one">
                <div>
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" id="nome" oninput="letters_js(this.value, this)" requied>
                </div>
                <div>
                    <label for="num">Celular:</label>
                    <input type="text" name="num" id="num" maxlength="14" onkeyup="mask_js(this.value, this, '(##)#####-####')" required>
                </div>
            </div>

            <div class="r-two">
                <div>
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" onput="email(this.value, this)" required>

                </div>
            
                <div>
                    <label for="endereco">Endereço:</label>
                    <input type="text" name="endereco" id="endereco" required>
                </div>

                <div>
                    <label for="cpf">CPF:</label>
                    <input type="text" name="cpf" id="cpf" maxlength="14" onkeyup="mask_js(this.value, this, '###.###.###-##')" required>
                </div>

                <div>
                    <label for="rg">RG:</label>
                    <input type="text" id="rg" name="rg" maxlength="12" onkeyup="mask_js(this.value, this, '##.###.###-#')" require>
                </div>
            </div>

            <input type="submit" name="cadastrar" id="cadastrar" value="Cadastrar">

        </div>
    </form>
</div>`
];

function setForm(formIx){

    let form = document.getElementById('form-box');

    if(formIx < 0 || formIx > forms.length){
        form.innerHTML = "";
        return
    }

    form.innerHTML = forms[formIx];

}