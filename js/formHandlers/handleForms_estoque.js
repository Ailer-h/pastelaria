console.log("Running...")

let forms = [
    `<div class="center-absolute">
    <div class="header">
        <h1 id="titulo-form">Nova Matéria Prima</h1>
        <img src="../images/icons/close.png" id="close-register" onclick="setForm(-1);">
    </div>
    <form action="tabelaEstoque.php" method="post">
    <div class="form-holder">
            <div class="r-one">
                <div>
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" id="nome" requied>
                </div>
                <div>
                    <label for="data-vencimento">Data de Vencimento:</label>
                    <input type="date" name="data-vencimento" id="data-vencimento" required>
                </div>
            </div>
            
            <div class="r-two">
                <div>
                    <label for="valor-custo">Valor da unidade:</label>
                    <input type="number" name="valor-custo" id="valor-custo" min="0.0001" step="any" required>
                </div>

                <div>
                    <label for="unidade-medida">Unidade de Medida:</label>
                    <select name="unidade-medida" id="unidade-medida" required>
                        <option value="" selected hidden></option>
                        <option value="g">g</option>
                        <option value="ml">ml</option>
                    </select>
                </div>

                <div>
                    <label for="qtd">Qtd:</label>
                    <input type="number" name="qtd" id="qtd" min="0" step="1" class="qtd" required>
                </div>

                <div>
                    <label for="qtd">Qtd Padrão:</label>
                    <input type="number" name="qtd-controle" id="qtd-controle" min="0" step="1" class="qtd" required>
                </div>
            </div>

            <input type="submit" name="cadastrar" id="cadastrar" value="Cadastrar">
            
        </div>
    </form>
</div>`,
`<div class="center-absolute">
<div class="header">
    <h1 id="titulo-form">Editar Matéria Prima</h1>
    <img src="../images/icons/close.png" id="close-register" onclick="location.href = location.href">
</div>
<form action="tabelaEstoque.php" method="post">
<input type="hidden" name="id" id="id">
<div class="form-holder">
        <div class="r-one">
            <div>
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" requied>
            </div>
            <div>
                <label for="data-vencimento">Data de Vencimento:</label>
                <input type="date" name="data-vencimento" id="data-vencimento" required>
            </div>
        </div>
        
        <div class="r-two">
            <div>
                <label for="valor-custo">Valor da unidade:</label>
                <input type="number" name="valor-custo" id="valor-custo" min="0.0001" step="any" required>
            </div>

            <div>
                <label for="unidade-medida">Unidade de Medida:</label>
                <select name="unidade-medida" id="unidade-medida" required>
                    <option value="" selected hidden></option>
                    <option value="g">g</option>
                    <option value="ml">ml</option>
                </select>
            </div>

            <div>
                <label for="qtd">Qtd:</label>
                <input type="number" name="qtd" id="qtd" min="0" step="1" class="qtd" required>
            </div>

            <div>
                <label for="qtd">Qtd Padrão:</label>
                <input type="number" name="qtd-controle" id="qtd-controle" min="0" step="1" class="qtd" required>
            </div>
        </div>

        <input type="submit" name="atualizar" id="atualizar" value="Atualizar">
        
    </div>
</form>
</div>`
];

function setForm(formIx){

    let form = document.getElementById('form-box');

    if(formIx != 0 && formIx != 1){
        form.innerHTML = "";
        return
    }

    form.innerHTML = forms[formIx];

}