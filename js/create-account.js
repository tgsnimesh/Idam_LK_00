var firstName = document.getElementById("first-name");
var lastName = document.getElementById("last-name");
var create_email = document.getElementById("create-email");
var createPword = document.getElementById("create-pword");

var firstNameError = document.getElementById("first-name-error");
var lastNameError = document.getElementById("last-name-error");
var emailError = document.getElementById("create-email-error");
var pwordError = document.getElementById("pword-error");

var btnCreateAccount = document.getElementById("btn-create-account");

firstName.addEventListener("input", createAccountvalidation);
lastName.addEventListener("input", createAccountvalidation);
create_email.addEventListener("input", createAccountvalidation);
createPword.addEventListener("input", createAccountvalidation);

function createAccountvalidation() {
  var fName = firstName.value;
  var lName = lastName.value;
  var email = create_email.value;
  var pword = createPword.value;

  fName = firstNameValidation(fName);
  lName = lastNameValidation(lName);
  email = emailValidation(email);
  pword = pwordValidation(pword);

  if (fName && lName && email && pword) btnCreateAccount.disabled = false;
  else btnCreateAccount.disabled = true;
}

function firstNameValidation(fName) {
  if (fName.length) {
    if (fName.length < 5)
      firstNameError.innerText = "First Name are required 5 charectors !";
    else {
      firstNameError.innerText = "";
      return true;
    }
  } else {
    firstNameError.innerText = "First Name is Empty !";
  }
}

function lastNameValidation(lName) {
  if (lName.length) {
    if (lName.length < 3)
      lastNameError.innerText = "Last Name are required 3 charectors !";
    else {
      lastNameError.innerText = "";
      return true;
    }
  } else {
    lastNameError.innerText = "Last Name is Empty !";
  }
}

function emailValidation(email) {
  if (email.length) {
    if (email.length < 10)
      emailError.innerText = "E-Mail are required 10 charectors !";
    else {
      emailError.innerText = "";
      return true;
    }
  } else {
    emailError.innerText = "E-Mail is Empty !";
  }
}

function pwordValidation(pword) {
  if (pword.length) {
    if (pword.length < 8)
      pwordError.innerText = "Passsword are required 8 charectors !";
    else {
      pwordError.innerText = "";
      return true;
    }
  } else {
    pwordError.innerText = "Password is Empty !";
  }
}
