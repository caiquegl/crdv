var inputs = document.getElementsByName("iPersonType");
var personType;
var div = document.getElementById("pType");

// Initializing variable
personType = inputs[0].value;

// PF
inputs[0].onclick = () => {
    personType = inputs[0].value;
    div.innerHTML = `<p> 
                <label for="senha_cad">Seu CPF</label>
                <br>
                <input class="valores" id="cpf" name="senha_cad" required="required" type="text" placeholder="ex. 000.000.000-00"/>
              </p>`;
    $("#cpf").mask("000.000.000-00");
}
// PJ
inputs[1].onclick = () => {
    personType = inputs[1].value;
    div.innerHTML = `<p> 
            <label for="email_cad">Sua Inscrição Estadual</label>
            <br>
            <input class="valores" name="email_cad" required="required" type="email" placeholder="00000000"/> 
          </p>

          <p> 
            <label for="email_cad">Seu CNPJ</label>
            <br>
            <input class="valores" id="cnpj" name="email_cad" required="required" type="email" placeholder="00.000.00/0000-00"/> 
          </p>

          <p> 
            <label for="email_cad">Razão social</label>
            <br>
            <input class="valores" name="email_cad" required="required" type="email" placeholder="Exemplo LTD"/> 
          </p>
        `;
    $("#cnpj").mask("00.000.000/0000-00");
}
