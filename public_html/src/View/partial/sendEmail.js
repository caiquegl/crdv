console.log("iniciou")
function sendEmail () {
  let data = {
    nome: $("#nomeEmail")[0].value,
    email: $("#emailEmail")[0].value,
    tel: $("#telefoneEmail")[0].value,
    numeroPedido: $("#numeroPedidoEmail")[0].value,
    msg: $("#menssagemEmail")[0].value,
  }
  console.log(data)
}
