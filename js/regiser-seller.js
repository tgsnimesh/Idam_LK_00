
var coverImageFile = document.getElementById("cover-img-file");
var logoImageFile = document.getElementById("logo-file");

var coverImage = document.getElementById("cover-image");
var logoImage = document.getElementById("logo-image");

var coverImageFileError = document.getElementById("c-image-error");
var logoImageFileError = document.getElementById("l-image-error");

var isImageVali = true;

$("#cover-img-file").change(function () {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#cover-image').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    }
});
$("#logo-file").change(function () {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#logo-image').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    }
});

coverImageFile.addEventListener("change", () => {
    isImageVali = imageValidation(coverImageFile.files, coverImageFileError);
    formValidation();
});
logoImageFile.addEventListener("change", () => {

    isImageVali = imageValidation(logoImageFile.files, logoImageFileError);
    formValidation();
});

function imageValidation(imageFile, errorElement) {

    let file = imageFile[0];

    if (file.type == "image/jpeg" || file.type == "image/png") {

        errorElement.innerText = "";
        if (file.size < 3000000) {

            errorElement.innerText = "";
            return true;
        } else {
            errorElement.innerText = "Maximum image size is 3MB";
            return false;
        }
    }else {

        errorElement.innerText = "Invalid image type ! pleace choose (jpeg, jpg) type.";
        return false;
    }
}

var shopName = document.getElementById("shop-name");
var shopNameError = document.getElementById("shop-name-error");

var shopTitle = document.getElementById("shop-title");
var shopTitleError = document.getElementById("shop-title-error");

var shopWebsite = document.getElementById("website");
var shopWebsiteError = document.getElementById("website-error");

var shopAddress = document.getElementById("shop-address");
var shopAddressError = document.getElementById("shop-address-error");

var aboutShop = document.getElementById("about-shop");
var aboutShopError = document.getElementById("about-shop-error");

var phonenumber = document.getElementById("phone-number");
var phonenumberError = document.getElementById("phone-number-error");

var email = document.getElementById("shop-email");
var emailError = document.getElementById("shop-email-error");

var btnRegiserShop = document.getElementById("btn-regiser-shop");

var isShopNamevali = false;
var isShopTitlevali = false;
var isShopAddressvali = false;
var isWebsiteVali = false;
var isAboutShopvali = false;
var isPhonenumbervali = false;
var isEmailvali = false;

function formValidation() {
    
    if (isImageVali && isShopNamevali && isShopTitlevali && isShopAddressvali && isWebsiteVali && isAboutShopvali && isPhonenumbervali && isEmailvali)
        btnRegiserShop.disabled = false;
    else
        btnRegiserShop.disabled = true;
}

shopName.addEventListener("input", () => {

    let text = shopName.value;

    if (!text) {

        setupError(shopName, shopNameError, "You must fill out this field");
        isShopNamevali = false;
    } else if (text.length < 6) {

        setupError(shopName, shopNameError, "The information entered is too short");
        isShopNamevali = false;
    } else {

        clearError(shopName, shopNameError);
        isShopNamevali = true;
    }
    formValidation();
        
});
shopTitle.addEventListener("input", () => {

    let text = shopTitle.value;

    if (!text) {

        setupError(shopTitle, shopTitleError, "You must fill out this field");
        isShopTitlevali = false;
    } else if (text.length < 6) {

        setupError(shopTitle, shopTitleError, "The information entered is too short");
        isShopTitlevali = false;
    } else {

        clearError(shopTitle, shopTitleError);
        isShopTitlevali = true;
    }
    formValidation();
});
shopWebsite.addEventListener("input", () => {

    let text = shopWebsite.value;

    if (!text) {

        setupError(shopWebsite, shopWebsiteError, "You must fill out this field");
        isWebsiteVali = false;
    } else if (!isUrl(text)) {

        setupError(shopWebsite, shopWebsiteError, "Invalid URL");
        isWebsiteVali = false;
    } else {

        clearError(shopWebsite, shopWebsiteError);
        isWebsiteVali = true;
    }
    formValidation();
        
});
function isUrl(url) {
    if(!url) return false;
    var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
        '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
        '((\\d{1,3}\\.){3}\\d{1,3}))|' + // OR ip (v4) address
        'localhost' + // OR localhost
        '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
        '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
        '(\\#[-a-z\\d_]*)?$', 'i'); // fragment locator
    return pattern.test(url);
}
shopAddress.addEventListener("input", () => {
    
    let text = shopAddress.value;

    if (!text) {

        setupError(shopAddress, shopAddressError, "You must fill out this field");
        isShopAddressvali = false;
    } else if (text.length < 10) {

        setupError(shopAddress, shopAddressError, "The information entered is too short");
        isShopAddressvali = false;
    } else {

        clearError(shopAddress, shopAddressError);
        isShopAddressvali = true;
    }
    formValidation();
});
aboutShop.addEventListener("input", () => {
    
    let text = aboutShop.value;

    if (!text) {

        setupError(aboutShop, aboutShopError, "You must fill out this field");
        isAboutShopvali = false;
    } else if (text.length < 15) {

        setupError(aboutShop, aboutShopError, "The information entered is too short");
        isAboutShopvali = false;
    } else if (text.length > 400) {

        setupError(aboutShop, aboutShopError, "The information entered is too long");
        isAboutShopvali = false;
    } else {

        clearError(aboutShop, aboutShopError);
        isAboutShopvali = true;
    }
    formValidation();
});
phonenumber.addEventListener("input", () => {
    
    let text = phonenumber.value;

    if (!text) {

        setupError(phonenumber, phonenumberError, "You must fill out this field");
        isPhonenumbervali = false;
    } else if (text.length != 10) {

        setupError(phonenumber, phonenumberError, "The information entered is Invalid");
        isPhonenumbervali = false;
    } else {

        clearError(phonenumber, phonenumberError);
        isPhonenumbervali = true;
    }
    formValidation();
});
email.addEventListener("input", () => {
    
    let text = email.value;

    if (!text) {

        setupError(email, emailError, "You must fill out this field");
        isEmailvali = false;
    } else if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(text))) {

        setupError(email, emailError, "The information entered is Invalid");
        isEmailvali = false;
    }  else {

        clearError(email, emailError);
        isEmailvali = true;
    }
    formValidation();
});

function setupError(errorInput, errorElement, errorText) {
    errorElement.innerText = errorText + " !";
    errorInput.classList.add("border-danger");
}
function clearError(errorInput, errorElement) {
    errorElement.innerText = "";
    errorInput.classList.remove("border-danger");
}
