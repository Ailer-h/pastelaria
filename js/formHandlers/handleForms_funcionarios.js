console.log("Running...")

let forms = [
    `<div class="center-absolute">
    <div class="header">
        <h1 id="titulo-form">Novo Funcionário</h1>
        <img src="../images/icons/close.png" id="close-register" onclick="setForm(-1);">
    </div>
    <form action="tabelaFuncionarios.php" method="post">
        <div class="form-holder">
            <div class="r-one">
                <div>
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" id="nome" oninput="noBackslashes(this.value, this) letters_js(this.value, this)" requied>
                </div>
                <div>
                    <label for="cpf">CPF:</label>
                    <input type="text" name="cpf" id="cpf" maxlength="14" onkeyup="mask_js(this.value, this, '###.###.###-##')" required>
                </div>
            </div>

            <div class="r-two">
                <div>
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" oninput="noSlashes_js(this.value, this)" required>

                </div>
            
                <div>
                    <label for="senha">Senha:</label>
                    <input type="text" name="senha" id="senha" oninput="noSlashes_js(this.value, this)" required>
                </div>

                <div>
                    <label for="cargo">Cargo:</label>
                    <input type="text" name="cargo" id="cargo" oninput="noBackslashes(this.value, this) letters_js(this.value, this)" required>
                </div>

                <div>
                    <label for="permissoes">Permissões:</label>
                    <select name="permissoes" id="permissoes" required>
                        <option value="" selected hidden></option>
                        <option value="a">Admnistrador</option>
                        <option value="f">Funcionário</option>
                    </select>
                </div>
            </div>

            <input type="submit" name="cadastrar" id="cadastrar" value="Cadastrar">

        </div>
    </form>
</div>`,
`<div class="center-absolute">
<div class="header">
<h1 id="titulo-form">Editar Funcionário</h1>
<img src="../images/icons/close.png" id="close-register" onclick="location.href = location.href;">
</div>
<form action="tabelaFuncionarios.php" method="post">
<input type="hidden" name="id" id="id">
<div class="form-holder">
    <div class="r-one">
        <div>
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" oninput="noBackslashes(this.value, this) letters_js(this.value, this)" requied>
        </div>
        <div>
            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" id="cpf" maxlength="14" onkeyup="mask_js(this.value, this, '###.###.###-##')" required>
        </div>
    </div>
    
    <div class="r-two">
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" oninput="noSlashes_js(this.value, this)" required>
    
        </div>
    
        <div>
            <label for="senha">Senha:</label>
            <input type="text" name="senha" id="senha" oninput="noSlashes_js(this.value, this)" required>
        </div>

        <div>
            <label for="cargo">Cargo:</label>
            <input type="text" name="cargo" id="cargo" oninput="noBackslashes(this.value, this) letters_js(this.value, this)" required>
        </div>

        <div>
            <label for="permissoes">Permissões:</label>
            <select name="permissoes" id="permissoes" required>
                <option value="" selected hidden></option>
                <option value="a">Admnistrador</option>
                <option value="f">Funcionário</option>
            </select>
        </div>
    </div>

    <input type="submit" name="atualizar" id="atualizar" value="Cadastrar">

</div>
</form>
</div>`,
`<div class="center-absolute">
<div class="delete-header">
    <img src="../images/icons/close.png" onclick="location.href = location.href">
</div>
<div class="delete-form">
    <div style="display: flex; align-items: center; flex-direction: column;">
        <h1>Você deseja deletar as informações de</h1>
        <h1 id="info">[nome]</h1>
    </div>

    <div class="btns">
        <form action="tabelaFuncionarios.php" method="post"><input type="hidden" name="id_delete" id="id" value="0"><button class="del">Deletar</button></form>
        <a href="tabelaFuncionarios.php"><button class="cancel">Cancelar</button></a>
    </div>
</div>
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