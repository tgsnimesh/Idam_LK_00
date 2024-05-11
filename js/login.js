
var loginEmail = document.getElementById("email");
var loginPword = document.getElementById("pword");

var loginEmailError = document.getElementById("login-email-error");
var loginPwordError = document.getElementById("login-pword-error");

var btnLogin = document.getElementById("btn-login");

email.addEventListener("input", function() {
    
    loginEmailValidation()
    loginvalidation();
});

pword.addEventListener("input", function() {
    
    loginPwordValidation()
    loginvalidation();
});

function loginvalidation() {

    if (loginEmail.value.length > 10 && loginPword.value.length >= 8)
        btnLogin.disabled = false;
    else
        btnLogin.disabled = true;
}

function loginEmailValidation() {
    
    let email = loginEmail.value;
    
    if (email.length) {

        if (email.length < 10)
            loginEmailError.innerText = "E-Mail are required 10 charactors !";
        else {

            loginEmailError.innerText = "";
            return true;
        }
    } else 
        loginEmailError.innerText = "E-Mail is Empty !";
}

function loginPwordValidation() {

    let pword = loginPword.value;

    if (pword.length) {

        if (pword.length < 8)
            loginPwordError.innerText = "Password are required 8 charactors !";
        else {

            loginPwordError.innerText = "";
            return true;
        }
    } else 
        loginPwordError.innerText = "Password is Empty !";
}
