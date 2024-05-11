
summeryCounter = 0;

var summeryBox = document.getElementById("summery-box");
var totalAmount = document.getElementById("total-amount");

var topAdPromotePrice = 0;
var spotlightPromotePrice = 0;
var urgentPromotePrice = 0;
var bumpupPromotePrice = 0;

// Top Ad
var isPromoteTopAd = false;

var btnAddTopAd = document.getElementById("btn-add-top-ad");
var btnRemoveTopAd = document.getElementById("btn-remove-top-ad");
var btnChangeTopAd = document.getElementById("btn-change-top-ad");
var priceTopAd = document.getElementById("price-top-ad");

var topAd3Day = document.getElementById("top-ad-3");
var topAd7Day = document.getElementById("top-ad-7");
var topAd15Day = document.getElementById("top-ad-15");

var btnPromoteTopAd = document.getElementById("btn-promote-top-ad");

var inputTopAd = document.getElementById("top-ad-value");

// top ad summery
var topAdSummery = document.getElementById("top-add-summery");
var topAdSummeryDays = document.getElementById("top-add-summery-days");
var topAdSummeryPrice = document.getElementById("top-add-summery-price");

if (btnAddTopAd) {

    btnPromoteTopAd.addEventListener("click", () => {

        let date = getPromoteDate(topAd3Day, topAd7Day, topAd15Day, inputTopAd);
        isPromoteTopAd =  setupAddRemoveButtons(isPromoteTopAd, date, btnAddTopAd, btnRemoveTopAd);
        setupChangeOptionButtons(btnChangeTopAd, priceTopAd);
        changeOptionButtonText(btnChangeTopAd, date);

        topAdPromotePrice = getUnitPrice("topad", date);
        setupSummery(topAdSummery, topAdSummeryDays, date, topAdSummeryPrice, topAdPromotePrice);
        calTotalAmout();
        console.log(date);
        console.log("input item value : " + inputTopAd.value);
    });
    btnRemoveTopAd.addEventListener("click", () => {

        isPromoteTopAd =  setupAddRemoveButtons(isPromoteTopAd, 0, btnAddTopAd, btnRemoveTopAd);
        removeChangeOptionButtons(btnChangeTopAd, priceTopAd);
        removeSummery(topAdSummery);
        topAdPromotePrice = 0;
        inputTopAd.value = 0;
        calTotalAmout();
    });
    btnChangeTopAd.addEventListener("click", (event) => {
        calTotalAmout();
        
        isPromoteTopAd = false;
        summeryCounter--;
        calTotalAmout();
    });
}

// spotlight
var isPromoteSpotlight = false;

var btnAddSpotlight = document.getElementById("btn-add-spotlight");
var btnRemoveSpotlight = document.getElementById("btn-remove-spotlight");
var btnChangeSpotlight = document.getElementById("btn-change-spotlight");
var priceSpotlight = document.getElementById("price-spotlight");

var spotlight3Day = document.getElementById("spotlight-3");
var spotlight7Day = document.getElementById("spotlight-7");
var spotlight15Day = document.getElementById("spotlight-15");

var btnPromoteSpotlight = document.getElementById("btn-promote-spotlight");

var inputSpotlight = document.getElementById("spotlight-value");

// spotlight summery
var spotlightSummery = document.getElementById("spotlight-summery");
var spotlightSummeryDays = document.getElementById("spotlight-summery-days");
var spotlightSummeryPrice = document.getElementById("spotlight-summery-price");

if (btnAddSpotlight) {

    btnPromoteSpotlight.addEventListener("click", () => {

        let date = getPromoteDate(spotlight3Day, spotlight7Day, spotlight15Day, inputSpotlight);
        isPromoteSpotlight =  setupAddRemoveButtons(isPromoteSpotlight, date, btnAddSpotlight, btnRemoveSpotlight);
        setupChangeOptionButtons(btnChangeSpotlight, priceSpotlight);
        changeOptionButtonText(btnChangeSpotlight, date);

        spotlightPromotePrice = getUnitPrice("spotlight", date);
        setupSummery(spotlightSummery, spotlightSummeryDays, date, spotlightSummeryPrice, spotlightPromotePrice);
        calTotalAmout();
        console.log(date);
        console.log("input item value : " + inputSpotlight.value);
    });
    btnRemoveSpotlight.addEventListener("click", () => {

        isPromoteSpotlight =  setupAddRemoveButtons(isPromoteSpotlight, 0, btnAddSpotlight, btnRemoveSpotlight);
        removeChangeOptionButtons(btnChangeSpotlight, priceSpotlight);
        removeSummery(spotlightSummery);
        spotlightPromotePrice = 0;
        inputSpotlight.value = 0;
        calTotalAmout();
    });
    btnChangeSpotlight.addEventListener("click", (event) => {
        
        isPromoteSpotlight = false;
        summeryCounter--;
        calTotalAmout();
    });
}

// urgent
var isPromoteUrgent = false;

var btnAddUrgent = document.getElementById("btn-add-urgent");
var btnRemoveUrgent = document.getElementById("btn-remove-urgent");
var btnChangeUrgent = document.getElementById("btn-change-urgent");
var priceUrgent = document.getElementById("price-urgent");

var urgent3Day = document.getElementById("urgent-3");
var urgent7Day = document.getElementById("urgent-7");
var urgent15Day = document.getElementById("urgent-15");

var btnPromoteUrgent = document.getElementById("btn-promote-urgent");

var inputUrgent = document.getElementById("urgent-value");

// urgent summery
var urgentSummery = document.getElementById("urgent-summery");
var urgentSummeryDays = document.getElementById("urgent-summery-days");
var urgentSummeryPrice = document.getElementById("urgent-summery-price");

btnPromoteUrgent.addEventListener("click", () => {

    let date = getPromoteDate(urgent3Day, urgent7Day, urgent15Day, inputUrgent);
    isPromoteUrgent =  setupAddRemoveButtons(isPromoteUrgent, date, btnAddUrgent, btnRemoveUrgent);
    setupChangeOptionButtons(btnChangeUrgent, priceUrgent);
    changeOptionButtonText(btnChangeUrgent, date);

    urgentPromotePrice = getUnitPrice("urgent", date);
    setupSummery(urgentSummery, urgentSummeryDays, date, urgentSummeryPrice, urgentPromotePrice);
    calTotalAmout();
    console.log(date);
    console.log("input item value : " + inputUrgent.value);
});
btnRemoveUrgent.addEventListener("click", () => {

    isPromoteUrgent =  setupAddRemoveButtons(isPromoteUrgent, 0, btnAddUrgent, btnRemoveUrgent);
    removeChangeOptionButtons(btnChangeUrgent, priceUrgent);
    removeSummery(urgentSummery);
    urgentPromotePrice = 0;
    inputUrgent.value = 0;
    calTotalAmout();
});
btnChangeUrgent.addEventListener("click", (event) => {
    
    isPromoteUrgent = false;
    summeryCounter--;
    calTotalAmout();
});

// bumpup
var isPromoteBumpup = false;

var btnAddBumpup = document.getElementById("btn-add-bumpup");
var btnRemoveBumpup = document.getElementById("btn-remove-bumpup");
var btnChangeBumpup = document.getElementById("btn-change-bumpup");
var priceBumpup = document.getElementById("price-bumpup");

var bumpup3Day = document.getElementById("bumpup-3");
var bumpup7Day = document.getElementById("bumpup-7");
var bumpup15Day = document.getElementById("bumpup-15");

var btnPromoteBumpup = document.getElementById("btn-promote-bumpup");

var inputBumpup = document.getElementById("bumpup-value");

// bumpup summery
var bumpupSummery = document.getElementById("bumpup-summery");
var bumpupSummeryDays = document.getElementById("bumpup-summery-days");
var bumpupSummeryPrice = document.getElementById("bumpup-summery-price");

btnPromoteBumpup.addEventListener("click", () => {

    let date = getPromoteDate(bumpup3Day, bumpup7Day, bumpup15Day, inputBumpup);
    isPromoteBumpup =  setupAddRemoveButtons(isPromoteBumpup, date, btnAddBumpup, btnRemoveBumpup);
    setupChangeOptionButtons(btnChangeBumpup, priceBumpup);
    changeOptionButtonText(btnChangeBumpup, date);

    bumpupPromotePrice = getUnitPrice("bumpup", date);
    setupSummery(bumpupSummery, bumpupSummeryDays, date, bumpupSummeryPrice, bumpupPromotePrice);
    calTotalAmout();
    console.log(date);
    console.log("input item value : " + inputBumpup.value);
});
btnRemoveBumpup.addEventListener("click", () => {

    isPromoteBumpup =  setupAddRemoveButtons(isPromoteBumpup, 0, btnAddBumpup, btnRemoveBumpup);
    removeChangeOptionButtons(btnChangeBumpup, priceBumpup);
    removeSummery(bumpupSummery);
    bumpupPromotePrice = 0;
    inputBumpup.value = 0;
    calTotalAmout();
});
btnChangeBumpup.addEventListener("click", (event) => {
    
    isPromoteBumpup = false;
    summeryCounter--;
    calTotalAmout();
});

function calTotalAmout() {

    let total = topAdPromotePrice + spotlightPromotePrice + urgentPromotePrice + bumpupPromotePrice;
    totalAmount.innerHTML = "Rs " + Intl.NumberFormat("en-US").format(total);
}

function getUnitPrice(unitName, option) {

    switch (unitName) {

        case "topad" :
            switch (option) {
                case 3 :
                    return 3900;
                case 7 :
                    return 5700;
                case 15 :
                    return 8100;
            }

        case "spotlight" :
            switch (option) {
                case 3 :
                    return 16500;
                case 7 :
                    return 22300;
                case 15 :
                    return 29700;
            }
        case "urgent" :
            switch (option) {
                case 3 :
                    return 1600;
                case 7 :
                    return 2300;
                case 15 :
                    return 3200;
            }
        case "bumpup" :
            switch (option) {
                case 3 :
                    return 3900;
                case 7 :
                    return 5700;
                case 15 :
                    return 8100;
            }
        
    }
}

function getPromoteDate(ad3Day, ad7Day, ad15Day, inputElement) {

    switch (true) {

        case ad3Day.checked :
            inputElement.value = 3;
            return 3;
        case ad7Day.checked :
            inputElement.value = 7;
            return 7;
        case ad15Day.checked :
            inputElement.value = 15;
            return 15;
    }
}

function setupAddRemoveButtons(isIn, inDate, btnAdd, btnRemove) {
    
    if (!isIn) {

        switch (inDate) {

            case 3 :
            case 7 :
            case 15 :
                btnAdd.classList.add("d-none");
                btnRemove.classList.remove("d-none");
                summeryCounter++;
                break;
        }
        summeryHide();
        return 1;
    } else {

        btnAdd.classList.remove("d-none");
        btnRemove.classList.add("d-none");
        summeryCounter--;
        summeryHide();
        return 0;
    }
}

function summeryHide() {
    
    if (summeryCounter != 0)
        summeryBox.classList.remove('d-none');
    else 
        summeryBox.classList.add('d-none');
}

function changeOptionButtonText(btnElement, days) {

    btnElement.innerText = days + " days";
}

function setupChangeOptionButtons(btnElement, priceElement) {

    btnElement.classList.remove("d-none");
    priceElement.classList.add("d-none");
}
function removeChangeOptionButtons(btnElement, priceElement) {

    btnElement.classList.add("d-none");
    priceElement.classList.remove("d-none");
}

function setupSummery(summery, summeryDaysElement, days, summeryPriceElemet, price) {

    summery.classList.remove("d-none");
    summeryDaysElement.innerText = days;
    summeryPriceElemet.innerText = Intl.NumberFormat("en-US").format(price);
}
function removeSummery(summeryDaysElement) {

    summeryDaysElement.classList.add("d-none");
}