const params = new URLSearchParams(window.location.search);
const erro = params.get("erro");
const mensagem = document.getElementById("mensagem-erro");

if (erro === "1") {
    mensagem.textContent = "Email ou senha incorretos.";
    mensagem.style.display = "block";
}

if (erro === "2") {
    mensagem.textContent = "Preencha todos os campos.";
    mensagem.style.display = "block";
}