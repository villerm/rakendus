let modal;
let modalImg;
let captionText;
let photoDir = '../4tund/uploadNormalPhoto/';

window.onload = function(){
    modal = document.getElementById("modalArea");
    modalImg = document.getElementById("modalImg");
    captionText = document.getElementById('modalCaption');
    let allThumbs = document.getElementById("gallery").getElementsByTagName("img");
    for (let i = 0; i < allThumbs.length; i++){
        allThumbs[i].addEventListener("click", openModal);
    }
    document.getElementById("modalClose").addEventListener("click", closeModal);
}

function openModal(e){
    modalImg.src = photoDir + e.target.dataset.fn;
    modalImg.alt = e.target.alt;
    captionText.innerHTML = e.target.alt;
    modal.style.display = "block";
}
function closeModal(){
    modal.style.display = "none";
}