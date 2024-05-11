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

var btnPostAdd = document.getElementById("btn-post-add");

// image
var img1 = document.getElementById("img-1");
var img2 = document.getElementById("img-2");
var img3 = document.getElementById("img-3");
var img4 = document.getElementById("img-4");
var img5 = document.getElementById("img-5");

var imgError = document.getElementById("img-error");

var imgVali = false;
var landTypeVali = false;
var landInfoVali = false;
var addressVali = true;
var titleVali = false;
var discriptionVali = false;
var priceVali = false;
var phoneNumberVali = false;
var sizeVali = false;

// check all form validation
function chekAllValidation() {
  if (
    landTypeVali &&
    landInfoVali &&
    addressVali &&
    titleVali &&
    discriptionVali &&
    priceVali &&
    phoneNumberVali &&
    imgVali
  ) {
    btnPostAdd.disabled = false;
  } else if (
    sizeVali &&
    landInfoVali &&
    addressVali &&
    titleVali &&
    discriptionVali &&
    priceVali &&
    phoneNumberVali &&
    imgVali
  ) {
    btnPostAdd.disabled = false;
  } else {
    btnPostAdd.disabled = true;
  }
}

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
  if (
    agricultural.checked ||
    residential.checked ||
    commercial.checked ||
    other.checked
  ) {
    landTypeError.innerText = "";
    landTypeVali = true;
  } else {
    landTypeError.innerText = "You must chose this option !";
    landTypeVali = false;
  }
}

// ----------------------- land info validation -----------------------

landSize.addEventListener("input", function () {
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

address.addEventListener("input", function () {
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

title.addEventListener("input", function () {
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

discription.addEventListener("input", function () {
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

price.addEventListener("input", function () {
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

phoneNumber.addEventListener("input", function () {
  phoneNumberValidation();
  chekAllValidation();
});

function phoneNumberValidation() {
  if (!phoneNumber.value.length) {
    phoneNumberError.innerText = "You must fill out this field !";
    phoneNumber.classList.add("border-danger");
    phoneNumberVali = false;
  } else if (phoneNumber.value.length != 10) {
    phoneNumberError.innerText =
      "The phone number is invalid ! required 10 charactors.";
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

// ----------------------- image validation -----------------------

img1.addEventListener("change", function () {
  if (imageValidation(img1)) {
    img2.hidden = false;
  } else {
    img2.hidden = true;
    img3.hidden = true;
    img4.hidden = true;
    img5.hidden = true;
  }
  chekAllValidation();
});
img2.addEventListener("change", function () {
  if (imageValidation(img2)) {
    img3.hidden = false;
  } else {
    img3.hidden = true;
    img4.hidden = true;
    img5.hidden = true;
  }
  chekAllValidation();
});
img3.addEventListener("change", function () {
  if (imageValidation(img3)) {
    img4.hidden = false;
  } else {
    img4.hidden = true;
    img5.hidden = true;
  }
  chekAllValidation();
});
img4.addEventListener("change", function () {
  if (imageValidation(img4)) {
    img5.hidden = false;
  } else {
    img5.hidden = true;
  }
  chekAllValidation();
});
img5.addEventListener("change", function () {
  if (imageValidation(img5)) {
  }
  chekAllValidation();
});

$("document").ready(function () {
  $("#img-1").mouseover(function () {
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $("#select-img").attr("src", e.target.result);
      };
      reader.readAsDataURL(this.files[0]);
    }
  });
  $("#img-1").change(function () {
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $("#select-img").attr("src", e.target.result);
      };
      reader.readAsDataURL(this.files[0]);
    }
  });
  // $("#img-1").mouseout(function () {
  //     $('#select-img').attr('src', '');
  // });
});
$("document").ready(function () {
  $("#img-2").mouseover(function () {
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $("#select-img").attr("src", e.target.result);
      };
      reader.readAsDataURL(this.files[0]);
    }
  });
  $("#img-2").change(function () {
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $("#select-img").attr("src", e.target.result);
      };
      reader.readAsDataURL(this.files[0]);
    }
  });
  // $("#img-2").mouseout(function () {
  //     $('#select-img').attr('src', '');
  // });
});
$("document").ready(function () {
  $("#img-3").mouseover(function () {
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $("#select-img").attr("src", e.target.result);
      };
      reader.readAsDataURL(this.files[0]);
    }
  });
  $("#img-3").change(function () {
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $("#select-img").attr("src", e.target.result);
      };
      reader.readAsDataURL(this.files[0]);
    }
  });
  // $("#img-3").mouseout(function () {
  //     $('#select-img').attr('src', '');
  // });
});
$("document").ready(function () {
  $("#img-4").mouseover(function () {
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $("#select-img").attr("src", e.target.result);
      };
      reader.readAsDataURL(this.files[0]);
    }
  });
  $("#img-4").change(function () {
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $("#select-img").attr("src", e.target.result);
      };
      reader.readAsDataURL(this.files[0]);
    }
  });
  // $("#img-4").mouseout(function () {
  //     $('#select-img').attr('src', '');
  // });
});
$("document").ready(function () {
  $("#img-5").mouseover(function () {
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $("#select-img").attr("src", e.target.result);
      };
      reader.readAsDataURL(this.files[0]);
    }
  });
  $("#img-5").change(function () {
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $("#select-img").attr("src", e.target.result);
      };
      reader.readAsDataURL(this.files[0]);
    }
  });
  // $("#img-5").mouseout(function () {
  //     $('#select-img').attr('src', '');
  // });
});

function imageValidation(imgFile) {
  let selectImageFile = imgFile.files;

  if (selectImageFile.length == 1) {
    selectImageFile = selectImageFile[0];

    if (
      selectImageFile.type != "image/jpeg" &&
      selectImageFile.type != "image/jpg"
    ) {
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
