const fita = document.querySelector(".fita");
let posicao = 0;

function mover() {
    posicao = posicao + 0.5;

    if (posicao >= 56.57) {
        posicao = 0;
    }

    fita.style.backgroundPosition = posicao + "px 0";
    requestAnimationFrame(mover);
}

mover();