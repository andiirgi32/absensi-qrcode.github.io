let imgFoto = document.getElementById("imgFoto");
let inputFoto = document.getElementById("inputFoto");

inputFoto.onchange = function () {
    imgFoto.src = URL.createObjectURL(inputFoto.files[0]);
}