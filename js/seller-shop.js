
var mobileContactBox = document.querySelector("#shop-mobile-contact-box");

var hideNumber = document.querySelector("#hide-number");
var numberButton = document.querySelector("#number-button");

mobileContactBox.addEventListener("click", () => {

    hideNumber.classList.add("d-none");
    numberButton.classList.remove("d-none")
});

var btnShowMoreLess = document.querySelector("#btn-shop-more-less");
var aboutShopText = document.querySelector("#about-shop-text");
var btnShowMoreLessIcon = document.querySelector("#btn-shop-more-less-icon");

var isInShowMore = false;

btnShowMoreLess.addEventListener("click", () => {

    if (isInShowMore) {

        isInShowMore = false;
        aboutShopText.style.height = "108px";
        btnShowMoreLessIcon.classList.remove("fa-chevron-up");
        btnShowMoreLessIcon.classList.add("fa-chevron-down");
    } else {

        isInShowMore = true;
        aboutShopText.style.height = "100%";
        btnShowMoreLessIcon.classList.remove("fa-chevron-down");
        btnShowMoreLessIcon.classList.add("fa-chevron-up");
    }
});
