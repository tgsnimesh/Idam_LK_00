
// land type
var agricultural = document.getElementById("agricultural");
var residential = document.getElementById("residential");
var commercial = document.getElementById("commercial");
var other = document.getElementById("other");

var landTypeError = document.getElementById("land-type-error");

// land info
var landSize = document.getElementById("land-size");
var unit = document.getElementById("unit");

var landSizeError = document.getElementById("land-size-error");

// title
var title = document.getElementById("title");

var titleError = document.getElementById("title-error");

// title
var address = document.getElementById("address");

var addressError = document.getElementById("address-error");

// discription
var discription = document.getElementById("discription");

var discriptionError = document.getElementById("discription-error");

// size
var size = document.getElementById("size");

var sizeError = document.getElementById("size-error");

// price
var price = document.getElementById("price");

var priceError = document.getElementById("price-error");

// contact
var phoneNumber = document.getElementById("mobile-number");

var phoneNumberError = document.getElementById("mobile-number-error");

// image
var img1 = document.getElementById("img-1");
var img2 = document.getElementById("img-2");
var img3 = document.getElementById("img-3");
var img4 = document.getElementById("img-4");
var img5 = document.getElementById("img-5");

var selectImage1 = document.getElementById("show-img-1");
var selectImage2 = document.getElementById("show-img-2");
var selectImage3 = document.getElementById("show-img-3");
var selectImage4 = document.getElementById("show-img-4");
var selectImage5 = document.getElementById("show-img-5");

var btnUpdatePost = document.getElementById("btn-update-ad");

var imgError = document.getElementById("img-error");

var landTypeVali = true;
var landInfoVali = true;
var addressVali = true;
var titleVali = true;
var discriptionVali = true;
var priceVali = true;
var phoneNumberVali = true;
var sizeVali = true;
var imgVali = true;

var imgDelete2 = document.getElementById("img-delete-2");
var imgDelete3 = document.getElementById("img-delete-3");
var imgDelete4 = document.getElementById("img-delete-4");
var imgDelete5 = document.getElementById("img-delete-5");

// check all form validation
function chekAllValidation() {
    
    if (landTypeVali && landInfoVali && addressVali && titleVali && discriptionVali && priceVali && phoneNumberVali && imgVali) {
        btnUpdatePost.disabled = false;
    } else if (sizeVali && landInfoVali && addressVali && titleVali && discriptionVali && priceVali && phoneNumberVali && imgVali) {
        btnUpdatePost.disabled = false;
    }else {
        btnUpdatePost.disabled = true;
    }
}

function imageValidation(imgFile) {

    let selectImageFile = imgFile.files;
    
    if (selectImageFile.length == 1) {

        selectImageFile = selectImageFile[0];

        if (selectImageFile.type != "image/jpeg" && selectImageFile.type != "image/jpg") {

            imgError.innerText = "Invalid image type ! - Please select JPEG image.";
            imgVali = false;
            imgFile.classList.add("border-danger");
            return false;
        } else if (parseInt(selectImageFile.size) > parseInt(3000000)) {
    
            imgError.innerText = "Image size is Invalid ! maximum image size is 3MB.";
            imgVali = false;
            imgFile.classList.add("border-danger");
            return false;
        } else {

            imgError.innerText = "";
            imgVali = true;
            imgFile.classList.remove("border-danger");
            return true;
        }
    } else {

        return false;
    }
}


// ----------------------- user select image show -----------------------




// ----------------------- land type validation -----------------------


if (agricultural) {
    agricultural.addEventListener("input", function () {
        landTypeValidation();
        chekAllValidation();
    });
    residential.addEventListener("input", function () {
        landTypeValidation();
        chekAllValidation();
    });
    commercial.addEventListener("input", function () {
        landTypeValidation();
        chekAllValidation();
    });
    other.addEventListener("input", function () {
        landTypeValidation();
        chekAllValidation();
    });
}

function landTypeValidation() {

    if (agricultural.checked || residential.checked || commercial.checked || other.checked) {

        landTypeError.innerText = "";
        landTypeVali = true;
    } else {

        landTypeError.innerText = "You must chose this option !";
        landTypeVali = false;
    }
}


// ----------------------- land info validation -----------------------


landSize.addEventListener("input", function() {
    landInfoValidation();
    chekAllValidation();
});

function landInfoValidation() {

    if (landSize.value.length) {

        landSizeError.innerText = "";
        landSize.classList.remove("border-danger");
        landInfoVali = true;
    } else {

        landSizeError.innerText = "You must fill out this field !";
        landSize.classList.add("border-danger");
        landInfoVali = false;
    }
}


// ----------------------- size validation -----------------------

if (size) {
    size.addEventListener("input", function () {
        sizeValidation();
        chekAllValidation();
    });
}

function sizeValidation() {

    if (size.value.length) {

        sizeError.innerText = "";
        size.classList.remove("border-danger");
        sizeVali = true;
    } else {

        sizeError.innerText = "You must fill out this field !";
        size.classList.add("border-danger");
        sizeVali = false;
    }
}


// ----------------------- address validation -----------------------


address.addEventListener("input", function() {
    addressValidation();
    chekAllValidation();
});

function addressValidation() {

    if (!address.value.length) {

        addressError.innerText = "";
        address.classList.remove("border-danger");
        addressVali = true;
    } else if (address.value.length > 4) {

        addressError.innerText = "";
        address.classList.remove("border-danger");
        addressVali = true;
    } else {

        addressError.innerText = "The information entered is too short.";
        address.classList.add("border-danger");
        addressVali = false;
    }
}


// ----------------------- title validation -----------------------


title.addEventListener("input", function() {
    titleValidation();
    chekAllValidation();
});

function titleValidation() {

    if (!title.value.length) {

        titleError.innerText = "You must fill out this field !";
        title.classList.add("border-danger");
        titleVali = false;
    } else if (title.value.length <= 5) {

        titleError.innerText = "The information entered is too short.";
        title.classList.add("border-danger");
        titleVali = false;
    } else {

        titleError.innerText = "";
        title.classList.remove("border-danger");
        titleVali = true;
    }
}


// ----------------------- discription validation -----------------------

var discriptinoCounter = document.getElementById("discriptino-counter");

discription.addEventListener("input", function() {
    if (!inputTextCounter(discription, 5000, discriptinoCounter))
        discriptionValidation();
    else {

        discriptionError.innerText = "The information entered is too long.";
        discription.classList.add("border-danger");
        discriptionVali = false;
    }
    chekAllValidation();
});

function discriptionValidation() {

    if (!discription.value.length) {

        discriptionError.innerText = "You must fill out this field !";
        discription.classList.add("border-danger");
        discriptionVali = false;
    } else if (discription.value.length <= 10) {

        discriptionError.innerText = "The information entered is too short.";
        discription.classList.add("border-danger");
        discriptionVali = false;
    } else {

        discriptionError.innerText = "";
        discription.classList.remove("border-danger");
        discriptionVali = true;
    }
}


// ----------------------- price validation -----------------------


price.addEventListener("input", function() {
    priceValidation();
    chekAllValidation();
});

function priceValidation() {

    if (price.value.length) {

        priceError.innerText = "";
        price.classList.remove("border-danger");
        priceVali = true;
    } else {

        priceError.innerText = "You must fill out this field !";
        price.classList.add("border-danger");
        priceVali = false;
    }
}


// ----------------------- phone number validation -----------------------


phoneNumber.addEventListener("input", function() {
    phoneNumberValidation();
    chekAllValidation();
});

function phoneNumberValidation() {

    if (!phoneNumber.value.length) {

        phoneNumberError.innerText = "You must fill out this field !";
        phoneNumber.classList.add("border-danger");
        phoneNumberVali = false;
    } else if (phoneNumber.value.length != 10) {

        phoneNumberError.innerText = "The phone number is invalid ! required 10 charactors.";
        phoneNumber.classList.add("border-danger");
        phoneNumberVali = false;
    } else {

        phoneNumberError.innerText = "";
        phoneNumber.classList.remove("border-danger");
        phoneNumberVali = true;
    }
}

function inputTextCounter(inputFeldName, maxLength, element) {

    element.innerText = inputFeldName.value.length + "/" + maxLength;

    if (inputFeldName.value.length > maxLength) {
        element.classList.add("text-danger");
        return true;
    } else {
        element.classList.remove("text-danger");
        return false;
    }
}

var isUpdateImg1 = false;
var isUpdateImg2 = false;
var isUpdateImg3 = false;
var isUpdateImg4 = false;
var isUpdateImg5 = false;

img1.addEventListener("change", () => {
    imgVali = imageValidation(img1);
    chekAllValidation();
    isUpdateImg1 = true;
});
img2.addEventListener("change", () => {
    imgVali = imageValidation(img2);
    chekAllValidation();
    isUpdateImg2 = true;
});
img3.addEventListener("change", () => {
    imgVali = imageValidation(img3);
    chekAllValidation();
    isUpdateImg3 = true;
});
img4.addEventListener("change", () => {
    imgVali = imageValidation(img4);
    chekAllValidation();
    isUpdateImg4 = true;
});
img5.addEventListener("change", () => {
    imgVali = imageValidation(img5);
    chekAllValidation();
    isUpdateImg5 = true;
});

var showImg2 = document.getElementById("show-img-2");
var showImg3 = document.getElementById("show-img-3");
var showImg4 = document.getElementById("show-img-4");
var showImg5 = document.getElementById("show-img-5");

imgDelete2.addEventListener("input", () => {
    if (imgDelete2.checked) {
        img2.disabled = true;
        showImg2.classList.add("p-1");
        showImg2.classList.add("bg-danger");
    }else {
        img2.disabled = false;
        showImg2.classList.remove("p-1");
    }
});
imgDelete3.addEventListener("input", () => {
    if (imgDelete3.checked) {
        img3.disabled = true;
        showImg3.classList.add("p-1");
        showImg3.classList.add("bg-danger");
    }else {
        img3.disabled = false;
        showImg3.classList.remove("bg-danger");
        showImg3.classList.remove("p-1");
    }
});
imgDelete4.addEventListener("input", () => {
    if (imgDelete4.checked) {
        img4.disabled = true;
        showImg4.classList.add("p-1");
        showImg4.classList.add("bg-danger");
    }else {
        img4.disabled = false;
        showImg4.classList.remove("bg-danger");
        showImg4.classList.remove("p-1");
    }
});
imgDelete5.addEventListener("input", () => {
    if (imgDelete5.checked) {
        img5.disabled = true;
        showImg5.classList.add("p-1");
        showImg5.classList.add("bg-danger");
    }else {
        img5.disabled = false;
        showImg5.classList.remove("bg-danger");
        showImg5.classList.remove("p-1");
    }
});

