
document.querySelector("#main-advert-caro-img").addEventListener("click", () => {

});

var imageResizeButton = document.getElementsByClassName("img-resize-button");

for (let i = 0; i < imageResizeButton.length; i++) {
    imageResizeButton[i].addEventListener("click", function() {
        
    });
}


var advertDescriptionBox = document.getElementById("advert-description");
var btnToggleAdvertDescription = document.getElementById("btn-toggle-advert-description");
var btnToggleAdvertDescriptionIcon = document.getElementById("btn-toggle-advert-description-icon");

var isToggle = false;

btnToggleAdvertDescription.addEventListener("click", function() {
    if (isToggle) {

        isToggle = false;
        advertDescriptionBox.classList.add("description-height");
        btnToggleAdvertDescription.innerText = "Show more";
        btnToggleAdvertDescriptionIcon.classList.add("fa-angle-down");
        btnToggleAdvertDescriptionIcon.classList.remove("fa-angle-up");
    }
    else {

        isToggle = true;
        advertDescriptionBox.classList.remove("description-height");
        btnToggleAdvertDescription.innerText = "Show less";
        btnToggleAdvertDescriptionIcon.classList.add("fa-angle-up");
        btnToggleAdvertDescriptionIcon.classList.remove("fa-angle-down");
    }

});

var advertPhoneNumber = document.getElementById("advert-phone-number");
var number = document.getElementById("number");
var expandNumberNotyfy = document.getElementById("expand-number-notyfy");
var expandToggleNumberAria = document.getElementById("expand-number-aria");

advertPhoneNumber.addEventListener("click", ()=> {
    expandToggleNumberAria.classList.remove("d-none");
    expandNumberNotyfy.innerText = "";
    number.innerText = "Call Seller";
});