
var loginModel = document.getElementById('login-model');
var loginModelObj;

var createAccountModel = document.getElementById('create-account-model');
var createAccountModelObj;

function hideLoginModel() {
    loginModelObj = bootstrap.Modal.getInstance(loginModel); // Returns a Bootstrap modal instance
    loginModelObj.hide();
}

function showLoginModel() {
    loginModelObj = bootstrap.Modal.getInstance(loginModel); // Returns a Bootstrap modal instance
    loginModelObj.show();
}

function hideCreateAccountModel() {
    createAccountModelObj = bootstrap.Modal.getInstance(createAccountModel); // Returns a Bootstrap modal instance
    createAccountModelObj.hide();
}

function showCreateAccountModel() {
    createAccountModelObj = bootstrap.Modal.getInstance(createAccountModel); // Returns a Bootstrap modal instance
    createAccountModelObj.show();
}

var adItem = document.getElementsByClassName("ad-item");
var userAdItemId = document.getElementsByClassName("user-ad-item-id");

var userAdCaroselItem = document.getElementsByClassName("user-ad-carosel-item");
var userAdCaroselItemId = document.getElementsByClassName("user-ad-carosel-item-id");

for(let i = 0; i < adItem.length; i++) {
    adItem[i].addEventListener("click", function() {
        window.open("../show-advert/?" + userAdItemId[i].value, "_self");
    });
}
for(let i = 0; i < userAdCaroselItem.length; i++) {
    userAdCaroselItem[i].addEventListener("click", function() {
        window.open("../show-advert/?" + userAdCaroselItemId[i].value, "_self");
    })
}

var btnPostYourAdd = document.getElementById("btn-post-your-add");
btnPostYourAdd.addEventListener("click", function() {
    window.open("../post-add/", "_self");
});