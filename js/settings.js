
// ----------------------------------------- update user details -----------------------------------------

var fName = document.getElementById("f-name");
var lName = document.getElementById("l-name");

var fNameError = document.getElementById("f-name-error");
var lNameError = document.getElementById("l-name-error");

var locat = document.getElementById("locat");
var subLocat = document.getElementById("sub-locat");

var dbFName = fName.value;
var dbLName = lName.value;

var dbLocat = locat.value;
var dbSubLocat = subLocat.value;

var btnUpdateDetails = document.getElementById("btn-update-details");
var btnconfirmUpdateDetails = document.getElementById("btn-confirm-update");

btnconfirmUpdateDetails.disabled = true;

fName.addEventListener("input", function() {
    validation();
});

lName.addEventListener("input", function() {
    validation();
});

locat.addEventListener("change", function() {
    validation();
});
subLocat.addEventListener("change", function() {
    validation();
});

btnconfirmUpdateDetails.addEventListener("click", function() {
    
});

function validation() {
    
    if (fNamevalidation() && lNameValidation() && canUpdate) {
        btnconfirmUpdateDetails.disabled = false;
        btnUpdateDetails.setAttribute("type", "submit");
    }
    else {
        btnconfirmUpdateDetails.disabled = true;
        btnUpdateDetails.setAttribute("type", "button");
    }
}

function canUpdate() {

    if (dbFName != fName.value || dbLName != lName.value || dbLocat != locat.value || dbSubLocat != subLocat.value)
        return true;
    else
        return false;
}

function fNamevalidation() {

    let fN = fName.value;

    if (fN.length) {

        if (fN.length < 5){

            fNameError.innerText = "First Name are required 5  charactors !";
            return false;
        }
        else {

            fNameError.innerText = "";
            return true;
        }
    } else {

        fNameError.innerText = "First Name is Empty !";
        return false;
    }
        
}

function lNameValidation() {

    let lN = lName.value;

    if (lN.length) {

        if (lN.length < 5) {

            lNameError.innerText = "Last Name are required 5 charactors !";
            return false;
        }
        else {

            lNameError.innerText = "";
            return true;
        } 
    } else {

        lNameError.innerText = "Last Name is Empty !";
        return false;
    }
}


// ----------------------------------------- change user password -----------------------------------------


var cPword = document.getElementById("current-pword");
var nPword = document.getElementById("new-pword");
var cNPword = document.getElementById("confirm-new-pword");

var cPwordError = document.getElementById("current-pword-error");
var nPwordError = document.getElementById("new-pword-error");
var cNPwordError = document.getElementById("confirm-new-pword-error");

var btnChangePword = document.getElementById("btn-change-pword");
var btnConfirmChangePword = document.getElementById("btn-confirm-change-pword");

var isValidcPword = false;
var isValidnPword = false;
var isValidcNPword = false;

cPword.addEventListener("input", function() {
    isValidcPword = currentPwordValidation();
});
nPword.addEventListener("input", function() {
    isValidnPword = newPwordValidation();
    pwordValidation();
});
cNPword.addEventListener("input", function() {
    isValidcNPword = confirmNewPwordValidation();
    pwordValidation();
});

function pwordValidation() {

    if (isValidcPword && isValidnPword && isValidcNPword) {

        checkIsmatchPword();
    }
}

function currentPwordValidation() {

    var cp = cPword.value;
    
    if (!cp.length) {

        cPwordError.innerHTML = "Password Feald is Empty !";
        return false;
    } else if (cp.length < 8) {

        cPwordError.innerHTML = "Password are required 8 charactors !";
        return false;
    } else {

        cPwordError.innerHTML = "";
        return true;
    }
}

function newPwordValidation() {

    var np = nPword.value;
    
    if (!np.length) {

        nPwordError.innerHTML = "Password Feald is Empty !";
        return false;
    } else if (np.length < 8) {

        nPwordError.innerHTML = "Password are required 8 charactors !";
        return false;
    } else {

        nPwordError.innerHTML = "";
        return true;
    }
}

function confirmNewPwordValidation() {

    var cnp = cNPword.value;
    
    if (!cnp.length) {

        cNPwordError.innerHTML = "Password Feald is Empty !";
        return false;
    } else if (cnp.length < 8) {

        cNPwordError.innerHTML = "Password are required 8 charactors !";
        return false;
    } else {

        cNPwordError.innerHTML = "";
        return true;
    }
}

function checkIsmatchPword() {

    if (nPword.value == cNPword.value) {

        cNPwordError.innerHTML = "";
        btnConfirmChangePword.setAttribute("type", "submit");
        btnChangePword.disabled = false;
    } else {

        cNPwordError.innerHTML = "New password are not match !";
        btnConfirmChangePword.setAttribute("type", "button");
        btnChangePword.disabled = true;
    }
}
