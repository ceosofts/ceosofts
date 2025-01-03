//! START 4SIDE GLASS 

function glass4maxbencal() {
    let glassthk = parseFloat(document.getElementById("glassthk").value);
    let shortside = parseFloat(document.getElementById("shortside").value);
    let longside = parseFloat(document.getElementById("longside").value);
    let windload = parseFloat(document.getElementById("windload").value);

    if (isNaN(glassthk) || isNaN(shortside) || isNaN(longside) || isNaN(windload)) {
        console.error("Invalid input values");
        return;
    }

    let M = (windload * shortside ** 2) / 8;
    let S = (shortside * (glassthk / 1000) ** 2) / 6;
    let bending = ((M / S) / 1000000);

    let result = bending;
    let sendresult = result.toFixed(3);
    document.getElementById("glass4maxben").value = sendresult;
}

function val() {
    let d = document.getElementById("glasstype").value;
}

$('#glasstype').change(function () {
    let result = $(this).val();
    document.getElementById("glasstypevalue").value = result;
});

function checkglass4bendingcal() {
    let glasstype = parseFloat(document.getElementById("glasstype").value);
    let glass4maxben = parseFloat(document.getElementById("glass4maxben").value);

    if (isNaN(glasstype) || isNaN(glass4maxben)) {
        console.error("Invalid input values");
        return;
    }

    if (glasstype >= glass4maxben) {
        document.getElementById("checkbending").value = "Max.Bend. < allow stress";
        document.getElementById("checkbending2").value = "Hence be allowable";
    } else {
        document.getElementById("checkbending").value = "Max.Bend. > allow stress";
        document.getElementById("checkbending2").value = "Hence cannot be allowable";
    }
}

function glass4maxdefcal() {
    let glassthk = parseFloat(document.getElementById("glassthk").value);
    let shortside = parseFloat(document.getElementById("shortside").value);
    let longside = parseFloat(document.getElementById("longside").value);
    let windload = parseFloat(document.getElementById("windload").value);

    if (isNaN(glassthk) || isNaN(shortside) || isNaN(longside) || isNaN(windload)) {
        console.error("Invalid input values");
        return;
    }

    let d = document.getElementById("glasstype");
    if (!d) {
        console.error("Element with id 'glasstype' not found");
        return;
    }

    let selectedOption = d.options[d.selectedIndex];
    let GTFValue = selectedOption.getAttribute("GTFdata");

    if (!GTFValue) {
        console.error("Invalid GTFdata value");
        return;
    }

    let I = (longside * (glassthk / 1000) ** 3) / 12;
    let E = 71 * 10 ** 9;

    let Deflection = ((5 * windload * shortside ** 4) / (384 * E * I)) * 100;

    let result = Deflection / GTFValue;
    let sendresult = result.toFixed(3);
    document.getElementById("glass4maxdef").value = sendresult;
}

function glass4allowdefcal() {
    let shortside = parseFloat(document.getElementById("shortside").value);

    if (isNaN(shortside)) {
        console.error("Invalid input value");
        return;
    }

    let result = (shortside / 60) * 1000;
    let sendresult = result.toFixed(3);
    document.getElementById("glass4allowdef").value = sendresult;
}

function glass4defcheck() {
    let glass4maxdef = parseFloat(document.getElementById("glass4maxdef").value);
    let glass4allowdef = parseFloat(document.getElementById("glass4allowdef").value);

    if (isNaN(glass4maxdef) || isNaN(glass4allowdef)) {
        console.error("Invalid input values");
        return;
    }

    if (glass4maxdef >= 2) {
        document.getElementById("defcheck").value = "Max.def. > 2";
        document.getElementById("defcheck2").value = "Hence cannot be allowable";
    } else if (glass4maxdef >= glass4allowdef) {
        document.getElementById("defcheck").value = "Max.def. > allow def.";
        document.getElementById("defcheck2").value = "Hence cannot be allowable";
    } else {
        document.getElementById("defcheck").value = "Max.def. < allow def.";
        document.getElementById("defcheck2").value = "Hence be allowable";
    }
}

//! END 4SIDE GLASS
/////////////////////////////////////////////////////////////////
//! START 2SIDE GLASS

function glass2bendingmaxcal() {
    let glassthk = parseFloat(document.getElementById("glassthk").value);
    let windload = parseFloat(document.getElementById("windload").value);
    let longside = parseFloat(document.getElementById("longside").value);

    if (isNaN(glassthk) || isNaN(windload) || isNaN(longside)) {
        console.error("Invalid input values");
        return;
    }

    let M = (windload * longside ** 2 / 8) * 1000;
    let S = (glassthk / 1000) ** 2 / 6;
    let BendingStress = M / S / 10 ** 9;

    let result = BendingStress;
    let sendresult = result.toFixed(3);

    document.getElementById("glass2bendingmax").value = sendresult;

    console.log(result);
}

function checkglass2bendincal() {
    let glasstype = parseFloat(document.getElementById("glasstype").value);
    let glass2bendingmax = parseFloat(document.getElementById("glass2bendingmax").value);

    if (isNaN(glasstype) || isNaN(glass2bendingmax)) {
        console.error("Invalid input values");
        return;
    }

    if (glass2bendingmax < glasstype) {
        document.getElementById("checkbending").value = "Max.Bend. < allow stress";
        document.getElementById("checkbending2").value = "Hence be allowable";
    } else {
        document.getElementById("checkbending").value = "Max.Bend. > allow stress";
        document.getElementById("checkbending2").value = "Hence cannot be allowable";
    }
}

function glass2maxdefcal() {
    let windload = parseFloat(document.getElementById("windload").value);
    let longside = parseFloat(document.getElementById("longside").value);
    let glassthk = parseFloat(document.getElementById("glassthk").value);

    if (isNaN(windload) || isNaN(longside) || isNaN(glassthk)) {
        console.error("Invalid input values");
        return;
    }

    let d = document.getElementById("glasstype");
    if (!d) {
        console.error("Element with id 'glasstype' not found");
        return;
    }

    let selectedOption = d.options[d.selectedIndex];
    let GTFValue = selectedOption.getAttribute("GTFdata");

    if (!GTFValue) {
        console.error("Invalid GTFdata value");
        return;
    }

    let I = (glassthk / 1000) ** 3 / 12;
    let E = 71 * 10 ** 9;

    let MaxDef = ((5 * windload * (longside ** 4)) / (384 * E * I)) / GTFValue;

    let result = (MaxDef * 1000);
    let sendresult = result.toFixed(3);

    document.getElementById("glass2maxdef").value = sendresult;
}

function glass2allowdefcal() {
    let longside = parseFloat(document.getElementById("longside").value);

    if (isNaN(longside)) {
        console.error("Invalid input value");
        return;
    }

    let result = (longside / 60) * 1000;
    let sendresult = result.toFixed(3);
    document.getElementById("glass2allowdef").value = sendresult;
}

function glass2defcheck() {
    let glass2maxdef = parseFloat(document.getElementById("glass2maxdef").value);
    let glass2allowdef = parseFloat(document.getElementById("glass2allowdef").value);

    if (isNaN(glass2maxdef) || isNaN(glass2allowdef)) {
        console.error("Invalid input values");
        return;
    }

    if (glass2maxdef >= 20) {
        document.getElementById("defcheck").value = "Max.def. > 20";
        document.getElementById("defcheck2").value = "Hence cannot be allowable";
    } else if (glass2maxdef >= glass2allowdef) {
        document.getElementById("defcheck").value = "Max.def. > allow def.";
        document.getElementById("defcheck2").value = "Hence cannot be allowable";
    } else {
        document.getElementById("defcheck").value = "Max.def. < allow def.";
        document.getElementById("defcheck2").value = "Hence be allowable";
    }
}

//! END 2 SIDE GLASS
/////////////////////////////////////////////////////////////////
//! START 1 SIDE GLASS

function glass1maxbencal() {
    let glassthk = parseFloat(document.getElementById("glassthk").value);
    let shortside = parseFloat(document.getElementById("shortside").value);
    let longside = parseFloat(document.getElementById("longside").value);
    let windload = parseFloat(document.getElementById("windload").value);

    if (isNaN(glassthk) || isNaN(shortside) || isNaN(longside) || isNaN(windload)) {
        console.error("Invalid input values");
        return;
    }

    let M = (windload * longside ** 2) / 2;
    let bending = ((6 * M * shortside) / (((glassthk / 1000) ** 2))) / 10 ** 6;

    let result = bending;
    let sendresult = result.toFixed(3);
    document.getElementById("glass1maxben").value = sendresult;
}

function val() {
    let d = document.getElementById("glasstype").value;
}

$('#glasstype').change(function () {
    let result = $(this).val();
    document.getElementById("glasstypevalue").value = result;
});

function checkglass1bendingcal() {
    let glasstype = parseFloat(document.getElementById("glasstype").value);
    let glass1maxben = parseFloat(document.getElementById("glass1maxben").value);

    if (isNaN(glasstype) || isNaN(glass1maxben)) {
        console.error("Invalid input values");
        return;
    }

    if (glasstype >= glass1maxben) {
        document.getElementById("checkbending").value = "Max.Bend. < allow stress";
        document.getElementById("checkbending2").value = "Hence be allowable";
    } else {
        document.getElementById("checkbending").value = "Max.Bend. > allow stress";
        document.getElementById("checkbending2").value = "Hence cannot be allowable";
    }
}

function glass1maxdefcal() {
    let glassthk = parseFloat(document.getElementById("glassthk").value);
    let shortside = parseFloat(document.getElementById("shortside").value);
    let longside = parseFloat(document.getElementById("longside").value);
    let windload = parseFloat(document.getElementById("windload").value);
    let F = windload * shortside;

    if (isNaN(glassthk) || isNaN(shortside) || isNaN(longside) || isNaN(windload)) {
        console.error("Invalid input values");
        return;
    }

    let d = document.getElementById("glasstype");
    if (!d) {
        console.error("Element with id 'glasstype' not found");
        return;
    }

    let selectedOption = d.options[d.selectedIndex];
    let GTFValue = selectedOption.getAttribute("GTFdata");

    if (!GTFValue) {
        console.error("Invalid GTFdata value");
        return;
    }

    let I = (shortside * (glassthk / 1000) ** 3) / 12;
    let E = 71 * 10 ** 9;

    let Deflection = ((F * longside ** 3) / (6 * E * I * GTFValue)) * 1000;

    let result = Deflection;
    let sendresult = result.toFixed(3);
    document.getElementById("glass1maxdef").value = sendresult;
}

function glass1allowdefcal() {
    let shortside = parseFloat(document.getElementById("shortside").value);

    if (isNaN(shortside)) {
        console.error("Invalid input value");
        return;
    }

    let result = (shortside / 60) * 1000;
    let sendresult = result.toFixed(3);
    document.getElementById("glass1allowdef").value = sendresult;
}

function glass1defcheck() {
    let glass1maxdef = parseFloat(document.getElementById("glass1maxdef").value);
    let glass1allowdef = parseFloat(document.getElementById("glass1allowdef").value);

    if (isNaN(glass1maxdef) || isNaN(glass1allowdef)) {
        console.error("Invalid input values");
        return;
    }

    if (glass1maxdef >= 2) {
        document.getElementById("defcheck").value = "Max.def. > 2";
        document.getElementById("defcheck2").value = "Hence cannot be allowable";
    } else if (glass1maxdef >= glass1allowdef) {
        document.getElementById("defcheck").value = "Max.def. > allow def.";
        document.getElementById("defcheck2").value = "Hence cannot be allowable";
    } else {
        document.getElementById("defcheck").value = "Max.def. < allow def.";
        document.getElementById("defcheck2").value = "Hence be allowable";
    }
}

//! END 1 SIDE GLASS
/////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////
//! START SIGGLE MULLION

function alummomenmaxcal() {
    let alumwidth = parseFloat(document.getElementById("alumwidth").value);
    let alumheight = parseFloat(document.getElementById("alumheight").value);
    let windload = parseFloat(document.getElementById("windload").value);

    if (isNaN(alumwidth) || isNaN(alumheight) || isNaN(windload)) {
        console.error("Invalid input values");
        return;
    }

    let result = ((windload * alumwidth * (alumheight ** 2)) / 8) / 1000000;
    let sendresult = result.toFixed(3);
    document.getElementById("alummomentmax").value = sendresult;
}

function alumbendingstress() {
    let alummomentmax = parseFloat(document.getElementById("alummomentmax").value);
    let alumcentroid = parseFloat(document.getElementById("alumcentroid").value);
    let alumix = parseFloat(document.getElementById("alumix").value);

    if (isNaN(alummomentmax) || isNaN(alumcentroid) || isNaN(alumix)) {
        console.error("Invalid input values");
        return;
    }

    let result = ((alummomentmax * 100 * alumcentroid) / (alumix)) * 1000;
    let sendresult = result.toFixed(3);
    document.getElementById("alummaxbend").value = sendresult;
}

function checkalumcheckbend() {
    let alummaxbend = parseFloat(document.getElementById("alummaxbend").value);

    if (isNaN(alummaxbend)) {
        console.error("Invalid input value");
        return;
    }

    if (650 >= alummaxbend) {
        document.getElementById("alumcheckbend").value = "Max.Bend. < allow bend.";
        document.getElementById("alumcheckbend2").value = "Hence be allowable";
    } else {
        document.getElementById("alumcheckbend").value = "Max.Bend. > allow bend.";
        document.getElementById("alumcheckbend2").value = "Hence cannot be allowable";
    }
}

function alummaxdefcal() {
    let windload = parseFloat(document.getElementById("windload").value);
    let alumwidth = parseFloat(document.getElementById("alumwidth").value);
    let alumheight = parseFloat(document.getElementById("alumheight").value);
    let alumix = parseFloat(document.getElementById("alumix").value);

    if (isNaN(windload) || isNaN(alumwidth) || isNaN(alumheight) || isNaN(alumix)) {
        console.error("Invalid input values");
        return;
    }

    let result = ((5 * (windload)) * alumwidth * (alumheight ** 4)) / (384 * 700000 * alumix);
    let sendresult = result.toFixed(3);
    document.getElementById("alummaxdef").value = sendresult;
}

function alumallowdefcal() {
    let alumheight = parseFloat(document.getElementById("alumheight").value);

    if (isNaN(alumheight)) {
        console.error("Invalid input value");
        return;
    }

    let result = alumheight / 175;
    let sendresult = result.toFixed(3);
    document.getElementById("alumallowdef").value = sendresult;
}

function checkalumdefcheck() {
    let alummaxdef = parseFloat(document.getElementById("alummaxdef").value);
    let alumallowdef = parseFloat(document.getElementById("alumallowdef").value);

    if (isNaN(alummaxdef) || isNaN(alumallowdef)) {
        console.error("Invalid input values");
        return;
    }

    if (alummaxdef >= 2) {
        document.getElementById("alumdefcheck").value = "Max.def. > 2";
        document.getElementById("alumdefcheck2").value = "Hence cannot be allowable";
    } else if (alummaxdef >= alumallowdef) {
        document.getElementById("alumdefcheck").value = "Max.def. > allow bend.";
        document.getElementById("alumdefcheck2").value = "Hence cannot be allowable";
    } else {
        document.getElementById("alumdefcheck").value = "Max.def. < allow def.";
        document.getElementById("alumdefcheck2").value = "Hence be allowable";
    }
}
//! END SIGGLE MULLION
/////////////////////////////////////////////////////////////////

//! START COMBINE MULLION

function combinebendingstress() {
    let alummomentmax = parseFloat(document.getElementById("alummomentmax").value);
    let alumcentroid = parseFloat(document.getElementById("alumcentroid").value);
    let alumix = parseFloat(document.getElementById("alumix").value);
    let combineix = parseFloat(document.getElementById("combineix").value);
    let combinemullion = parseFloat(alumix) + parseFloat(combineix);

    if (isNaN(alummomentmax) || isNaN(alumcentroid) || isNaN(alumix) || isNaN(combineix)) {
        console.error("Invalid input values");
        return;
    }

    let result = ((alummomentmax * 100 * alumcentroid) / combinemullion) * 1000;
    let sendresult = result.toFixed(3);
    document.getElementById("combinemaxbend").value = sendresult;
}

function checkcombinecheckbend() {
    let combinemaxbend = parseFloat(document.getElementById("combinemaxbend").value);

    if (isNaN(combinemaxbend)) {
        console.error("Invalid input value");
        return;
    }

    if (650 >= combinemaxbend) {
        document.getElementById("combinecheckbend").value = "Max.Bend. < allow bend.";
        document.getElementById("combinecheckbend2").value = "Hence be allowable";
    } else {
        document.getElementById("combinecheckbend").value = "Max.Bend. > allow bend.";
        document.getElementById("combinecheckbend2").value = "Hence cannot be allowable";
    }
}

function combinemaxdefcal() {
    let windload = parseFloat(document.getElementById("windload").value);
    let alumwidth = parseFloat(document.getElementById("alumwidth").value);
    let alumheight = parseFloat(document.getElementById("alumheight").value);
    let alumix = parseFloat(document.getElementById("alumix").value);
    let combineix = parseFloat(document.getElementById("combineix").value);
    let combinemullion = parseFloat(alumix) + parseFloat(combineix);

    if (isNaN(windload) || isNaN(alumwidth) || isNaN(alumheight) || isNaN(alumix) || isNaN(combineix)) {
        console.error("Invalid input values");
        return;
    }

    let result = ((5 * (windload)) * alumwidth * (alumheight ** 4)) / (384 * 700000 * combinemullion);
    let sendresult = result.toFixed(3);
    document.getElementById("combinemaxdef").value = sendresult;
}

function checkcombinedefcheck() {
    let combinemaxdef = parseFloat(document.getElementById("combinemaxdef").value);
    let alumallowdef = parseFloat(document.getElementById("alumallowdef").value);

    if (isNaN(combinemaxdef) || isNaN(alumallowdef)) {
        console.error("Invalid input values");
        return;
    }

    if (combinemaxdef >= 2) {
        document.getElementById("combinedefcheck").value = "Max.def. > 2";
        document.getElementById("combinedefcheck2").value = "Hence cannot be allowable";
    } else if (combinemaxdef >= alumallowdef) {
        document.getElementById("combinedefcheck").value = "Max.def. > allow bend.";
        document.getElementById("combinedefcheck2").value = "Hence cannot be allowable";
    } else {
        document.getElementById("combinedefcheck").value = "Max.def. < allow def.";
        document.getElementById("combinedefcheck2").value = "Hence be allowable";
    }
}
//! END COMBINE MULLION
/////////////////////////////////////////////////////////////////
//! START TRANSOM

function transommomenmaxcal() {
    let tannsomwidth = parseFloat(document.getElementById("tannsomwidth").value);
    let transomheight1 = parseFloat(document.getElementById("transomheight1").value);
    let transomheight2 = parseFloat(document.getElementById("transomheight2").value);
    let windload = parseFloat(document.getElementById("windload").value);

    if (isNaN(tannsomwidth) || isNaN(transomheight1) || isNaN(transomheight2) || isNaN(windload)) {
        console.error("Invalid input values");
        return;
    }

    let height = parseFloat(transomheight1) + parseFloat(transomheight2);
    let result = ((windload * height * (tannsomwidth ** 2)) / 8) / 1000000;
    let sendresult = result.toFixed(3);
    document.getElementById("transommomentmax").value = sendresult;
}

function transombendingstress() {
    let transommomentmax = parseFloat(document.getElementById("transommomentmax").value);
    let transomcentroidx = parseFloat(document.getElementById("transomcentroidx").value);
    let transomiy = parseFloat(document.getElementById("transomiy").value);
    let stiffeneriy = parseFloat(document.getElementById("stiffeneriy").value);
    let combineiy = parseFloat(transomiy) + parseFloat(stiffeneriy);

    if (isNaN(transommomentmax) || isNaN(transomcentroidx) || isNaN(transomiy) || isNaN(stiffeneriy)) {
        console.error("Invalid input values");
        return;
    }

    let result = ((transommomentmax * 100 * transomcentroidx) / (combineiy)) * 1000;
    let sendresult = result.toFixed(3);
    document.getElementById("transommaxbend").value = sendresult;
}

function checktransombend() {
    let combinemaxbend = parseFloat(document.getElementById("transommaxbend").value);

    if (isNaN(combinemaxbend)) {
        console.error("Invalid input value");
        return;
    }

    if (650 >= combinemaxbend) {
        document.getElementById("transomcheckbend").value = "Max.Bend. < allow bend.";
        document.getElementById("transomcheckbend2").value = "Hence be allowable";
    } else {
        document.getElementById("transomcheckbend").value = "Max.Bend. > allow bend.";
        document.getElementById("transomcheckbend2").value = "Hence cannot be allowable";
    }
}

function transommaxdefcal() {
    let windload = parseFloat(document.getElementById("windload").value);
    let tannsomwidth = parseFloat(document.getElementById("tannsomwidth").value);
    let transomheight1 = parseFloat(document.getElementById("transomheight1").value);
    let transomheight2 = parseFloat(document.getElementById("transomheight2").value);
    let transomiy = parseFloat(document.getElementById("transomiy").value);
    let stiffeneriy = parseFloat(document.getElementById("stiffeneriy").value);
    let combineiy = parseFloat(transomiy) + parseFloat(stiffeneriy);

    if (isNaN(windload) || isNaN(tannsomwidth) || isNaN(transomheight1) || isNaN(transomheight2) || isNaN(transomiy) || isNaN(stiffeneriy)) {
        console.error("Invalid input values");
        return;
    }

    let height = parseFloat(transomheight1) + parseFloat(transomheight2);
    let result = ((5 * (windload)) * height * (tannsomwidth ** 4)) / (384 * 700000 * combineiy);
    let sendresult = result.toFixed(3);
    document.getElementById("transommaxdef").value = sendresult;
}

function transomallowdefcal() {
    let tannsomwidth = parseFloat(document.getElementById("tannsomwidth").value);

    if (isNaN(tannsomwidth)) {
        console.error("Invalid input value");
        return;
    }

    let result = tannsomwidth / 175;
    let sendresult = result.toFixed(3);
    document.getElementById("transomallowdef").value = sendresult;
}

function checktransomdef() {
    let transommaxdef = parseFloat(document.getElementById("transommaxdef").value);
    let transomallowdef = parseFloat(document.getElementById("transomallowdef").value);

    if (isNaN(transommaxdef) || isNaN(transomallowdef)) {
        console.error("Invalid input values");
        return;
    }

    if (transommaxdef >= 2) {
        document.getElementById("transomdefcheck").value = "Max.def. > 2";
        document.getElementById("transomdefcheck2").value = "Hence cannot be allowable";
    } else if (transommaxdef >= transomallowdef) {
        document.getElementById("transomdefcheck").value = "Max.def. > allow bend.";
        document.getElementById("transomdefcheck2").value = "Hence cannot be allowable";
    } else {
        document.getElementById("transomdefcheck").value = "Max.def. < allow def.";
        document.getElementById("transomdefcheck2").value = "Hence be allowable";
    }
}

//! END TRANSOM
/////////////////////////////////////////////////////////////////
//! START TRANSOM DEAD LOAD

function glassweightcal() {
    let tannsomwidth = parseFloat(document.getElementById("tannsomwidth").value);
    let transomheight1 = parseFloat(document.getElementById("transomheight1").value);
    let glassthk = parseFloat(document.getElementById("glassthk").value);

    if (isNaN(tannsomwidth) || isNaN(transomheight1) || isNaN(glassthk)) {
        console.error("Invalid input values");
        return;
    }

    let result = (parseFloat(tannsomwidth) * parseFloat(transomheight1) * parseFloat(glassthk) * 25.6) / 10000;
    let sendresult = result.toFixed(3);
    document.getElementById("glassweight").value = sendresult;
}

function maxshearcal() {
    let glassweight = parseFloat(document.getElementById("glassweight").value);

    if (isNaN(glassweight)) {
        console.error("Invalid input value");
        return;
    }

    let result = (parseFloat(glassweight) / 2) / 100;
    let sendresult = result.toFixed(3);
    document.getElementById("maxshear").value = sendresult;
}

function deadloadtransommaxdefcal() {
    let maxshear = parseFloat(document.getElementById("maxshear").value);
    let tannsomwidth = parseFloat(document.getElementById("tannsomwidth").value);
    let transomix = parseFloat(document.getElementById("transomix").value);
    let stiffenerix = parseFloat(document.getElementById("stiffenerix").value);
    let combineix = parseFloat(transomix) + parseFloat(stiffenerix);

    if (isNaN(maxshear) || isNaN(tannsomwidth) || isNaN(transomix) || isNaN(stiffenerix)) {
        console.error("Invalid input values");
        return;
    }

    let a = tannsomwidth / 4;
    let set1 = maxshear * a;
    let set2 = 24 * 700000 * combineix;
    let set3 = 3 * (tannsomwidth ** 2);
    let set4 = 4 * (a ** 2);

    let result = ((set1 / set2) * (set3 - set4)) * 10000000;
    let sendresult = result.toFixed(3);
    document.getElementById("deadloadtransommaxdef").value = sendresult;
}

function daedloadallowdefcal() {
    let tannsomwidth = parseFloat(document.getElementById("tannsomwidth").value);

    if (isNaN(tannsomwidth)) {
        console.error("Invalid input value");
        return;
    }

    let result = tannsomwidth / 300;
    let sendresult = result.toFixed(3);
    document.getElementById("deadloadallowdef").value = sendresult;
}

function checkdeadloaddef() {
    let deadloadtransommaxdef = parseFloat(document.getElementById("deadloadtransommaxdef").value);
    let deadloadallowdef = parseFloat(document.getElementById("deadloadallowdef").value);

    if (isNaN(deadloadtransommaxdef) || isNaN(deadloadallowdef)) {
        console.error("Invalid input values");
        return;
    }

    if (deadloadtransommaxdef >= 2) {
        document.getElementById("deadloaddefcheck").value = "Max.def. > 0.3";
        document.getElementById("deadloaddefcheck2").value = "Hence cannot be allowable";
    } else if (deadloadtransommaxdef >= deadloadallowdef) {
        document.getElementById("deadloaddefcheck").value = "Max.def. > allow bend.";
        document.getElementById("deadloaddefcheck2").value = "Hence cannot be allowable";
    } else {
        document.getElementById("deadloaddefcheck").value = "Max.def. < allow def.";
        document.getElementById("deadloaddefcheck2").value = "Hence be allowable";
    }
}

//! END TRANSOM DEAD LOAD
/////////////////////////////////////////////////////////////////
//! START silicone

function siliconebilecal() {
    let siliconeshortside = parseFloat(document.getElementById("siliconeshortside").value);
    let windload = parseFloat(document.getElementById("windload").value);

    if (isNaN(siliconeshortside) || isNaN(windload)) {
        console.error("Invalid input values");
        return;
    }

    let result = siliconeshortside * windload / 27500;

    if (result <= 6) {
        result = 6;
    }

    let sendresult = result.toFixed(1);
    document.getElementById("siliconewidth").value = sendresult;
}

//! END silicone
/////////////////////////////////////////////////////////////////
//! START Anchor Bolt

function Anchorloadcal() {
    let glassWg = parseFloat(document.getElementById("glassWg").value);
    let alumWg = parseFloat(document.getElementById("alumWg").value);
    let otherWg = parseFloat(document.getElementById("otherWg").value);
    let windloaddesign = parseFloat(document.getElementById("windloaddesign").value);
    let shortside = parseFloat(document.getElementById("shortside").value);
    let longside = parseFloat(document.getElementById("longside").value);

    if (isNaN(glassWg) || isNaN(alumWg) || isNaN(otherWg) || isNaN(windloaddesign) || isNaN(shortside) || isNaN(longside)) {
        console.error("Invalid input values");
        return;
    }

    let set1 = (glassWg + alumWg + otherWg) * 0.01;
    let set2 = ((windloaddesign / 100) * (shortside / 100) * (longside / 100));

    let sendresultset1 = set1.toFixed(3);
    document.getElementById("deadload").value = sendresultset1;

    let sendresultset2 = set2.toFixed(3);
    document.getElementById("windloadcal").value = sendresultset2;

    let set3 = (set1 * 0.1) + (set2 * 1.25);
    let sendresultset3 = set3.toFixed(3);
    document.getElementById("tenonanchor").value = sendresultset3;

    let set4 = set2 * 1.1;
    let sendresultset4 = set4.toFixed(3);
    document.getElementById("shearonanchor").value = sendresultset4;
}

function getanchorvalue() {
    let d = document.getElementById("anchorsize").value;
}

function getallowcal() {
    const selectElement = document.querySelector('#anchorsize');
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const dataTenValue = selectedOption.getAttribute('data-ten');
    const dataShearValue = selectedOption.getAttribute('data-shear');

    let dataTenValuetonumber = parseFloat(dataTenValue);
    let dataShearValuetonumber = parseFloat(dataShearValue);
    let anchorqty = parseFloat(document.getElementById("anchorqty").value);

    if (isNaN(dataTenValuetonumber) || isNaN(dataShearValuetonumber) || isNaN(anchorqty)) {
        console.error("Invalid input values");
        return;
    }

    let tenallowcal = dataTenValuetonumber * anchorqty;
    let shearallowcal = dataShearValuetonumber * anchorqty;

    let sendtenallowcal = tenallowcal.toFixed(3);
    document.getElementById("tenallowcal").value = sendtenallowcal;

    let sendshearallowcal = shearallowcal.toFixed(3);
    document.getElementById("shearallowcal").value = sendshearallowcal;
}

function checkten() {
    let tenallowcal = parseFloat(document.getElementById("tenallowcal").value);
    let tenonanchor = parseFloat(document.getElementById("tenonanchor").value);

    if (isNaN(tenallowcal) || isNaN(tenonanchor)) {
        console.error("Invalid input values");
        return;
    }

    if (tenonanchor >= tenallowcal) {
        document.getElementById("checkten").value = "Tensile strength > allowable";
        document.getElementById("checkten2").value = "Hence cannot be allowable";
    } else {
        document.getElementById("checkten").value = "Tensile strength < allowable";
        document.getElementById("checkten2").value = "Hence be allowable";
    }
}

function checkshear() {
    let shearallowcal = parseFloat(document.getElementById("shearallowcal").value);
    let tenonanchor = parseFloat(document.getElementById("tenonanchor").value);

    if (isNaN(shearallowcal) || isNaN(tenonanchor)) {
        console.error("Invalid input values");
        return;
    }

    if (tenonanchor >= shearallowcal) {
        document.getElementById("checkshear").value = "Shear strength> allowable";
        document.getElementById("checkshear2").value = "Hence cannot be allowable";
    } else {
        document.getElementById("checkshear").value = "Shear strength < allowable";
        document.getElementById("checkshear2").value = "Hence be allowable";
    }
}

//! END Anchor Bolt
/////////////////////////////////////////////////////////////////
//! START bracket

function getalumbracketvalue() {
    let d = document.getElementById("brackettype").value;
}

function getbracketallowcal() {
    const selectElement = document.querySelector('#brackettype');
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const dataTenValue = selectedOption.getAttribute('data-ten');
    const dataShearValue = selectedOption.getAttribute('data-shear');

    let dataTenValuetonumber = parseFloat(dataTenValue);
    let dataShearValuetonumber = parseFloat(dataShearValue);

    if (isNaN(dataTenValuetonumber) || isNaN(dataShearValuetonumber)) {
        console.error("Invalid input values");
        return;
    }

    let sendtenallowcal = dataTenValuetonumber.toFixed(3);
    document.getElementById("benallowcal").value = sendtenallowcal;

    let sendshearallowcal = dataShearValuetonumber.toFixed(3);
    document.getElementById("shearallowcal").value = sendshearallowcal;
}

function bracketloadcal() {
    let glassWg = parseFloat(document.getElementById("glassWg").value);
    let alumWg = parseFloat(document.getElementById("alumWg").value);
    let otherWg = parseFloat(document.getElementById("otherWg").value);
    let windloaddesign = parseFloat(document.getElementById("windloaddesign").value);
    let shortside = parseFloat(document.getElementById("shortside").value);
    let longside = parseFloat(document.getElementById("longside").value);

    if (isNaN(glassWg) || isNaN(alumWg) || isNaN(otherWg) || isNaN(windloaddesign) || isNaN(shortside) || isNaN(longside)) {
        console.error("Invalid input values");
        return;
    }

    let set1 = (glassWg + alumWg + otherWg) * 0.01;
    let set2 = ((windloaddesign / 100) * (shortside / 100) * (longside / 100));

    let sendresultset1 = set1.toFixed(3);
    document.getElementById("deadload").value = sendresultset1;

    let sendresultset2 = set2.toFixed(3);
    document.getElementById("windloadcal").value = sendresultset2;
}

function bracketLoadCal() {
    let windloadcal = parseFloat(document.getElementById("windloadcal").value);
    let deadload = parseFloat(document.getElementById("deadload").value);
    let bracketH = parseFloat(document.getElementById("bracketH").value);
    let bracketPd = parseFloat(document.getElementById("bracketPd").value);
    let bracketW = parseFloat(document.getElementById("bracketW").value);
    let bracketthk = parseFloat(document.getElementById("bracketthk").value);
    let benallowcal = parseFloat(document.getElementById("benallowcal").value);
    let shearallowcal = parseFloat(document.getElementById("shearallowcal").value);

    if (isNaN(windloadcal) || isNaN(deadload) || isNaN(bracketH) || isNaN(bracketPd) || isNaN(bracketW) || isNaN(bracketthk) || isNaN(benallowcal) || isNaN(shearallowcal)) {
        console.error("Invalid input values");
        return;
    }

    let benallowcalsafety = benallowcal * 0.6;
    let shearallowcalsafety = shearallowcal * 0.35;

    let sendbenallowcalsafety = benallowcalsafety.toFixed(3);
    document.getElementById("benallowcalsafety").value = sendbenallowcalsafety;

    let sendshearallowcalsafety = shearallowcalsafety.toFixed(3);
    document.getElementById("shearallowcalsafety").value = sendshearallowcalsafety;

    //*bending calculation
    let set1 = (windloadcal * bracketH) + (deadload * bracketPd);
    let set2 = (bracketW * bracketthk ** 2) / 4;
    let set3 = (set1 / set2) * 10;

    let sendresultset3 = set3.toFixed(3);
    document.getElementById("bendOnBracket").value = sendresultset3;

    //*shear calculation
    let set5 = 0.5 * windloadcal;
    let set6 = 0.9 * bracketthk * bracketW;
    let set7 = (set5 / set6) * 10;

    let sendresultset7 = set7.toFixed(3);
    document.getElementById("shearOnBracket").value = sendresultset7;

    //*combined calculation
    let set11 = set3 / benallowcalsafety;
    let set12 = (set7 / shearallowcalsafety) ** 2;
    let set20 = set11 + set12;

    let sendresultset20 = set20.toFixed(3);
    document.getElementById("Combinedcal").value = sendresultset20;
}

function checkbracketbend() {
    let benallowcalsafety = parseFloat(document.getElementById("benallowcalsafety").value);
    let bendOnBracket = parseFloat(document.getElementById("bendOnBracket").value);

    if (isNaN(benallowcalsafety) || isNaN(bendOnBracket)) {
        console.error("Invalid input values");
        return;
    }

    if (bendOnBracket >= benallowcalsafety) {
        document.getElementById("checkbracketbend").value = "Bending Moment > allowable";
        document.getElementById("checkbracketbend2").value = "Hence cannot be allowable";
    } else {
        document.getElementById("checkbracketbend").value = "Bending Moment < allowable";
        document.getElementById("checkbracketbend2").value = "Hence be allowable";
    }
}

function checkshearbracket() {
    let shearallowcalsafety = parseFloat(document.getElementById("shearallowcalsafety").value);
    let shearOnBracket = parseFloat(document.getElementById("shearOnBracket").value);

    if (isNaN(shearallowcalsafety) || isNaN(shearOnBracket)) {
        console.error("Invalid input values");
        return;
    }

    if (shearOnBracket >= shearallowcalsafety) {
        document.getElementById("checkshearbracket").value = "Bending Moment > allowable";
        document.getElementById("checkshearbracket2").value = "Hence cannot be allowable";
    } else {
        document.getElementById("checkshearbracket").value = "Bending Moment < allowable";
        document.getElementById("checkshearbracket2").value = "Hence be allowable";
    }
}

function CheckCombined() {
    let Combinedcal = parseFloat(document.getElementById("Combinedcal").value);

    if (isNaN(Combinedcal)) {
        console.error("Invalid input value");
        return;
    }

    if (Combinedcal >= 1) {
        document.getElementById("CheckCombined").value = "Combined Stress > 1";
        document.getElementById("CheckCombined2").value = "Hence cannot be allowable";
    } else {
        document.getElementById("CheckCombined").value = "Combined Stress < 1";
        document.getElementById("CheckCombined2").value = "Hence be allowable";
    }
}

//! END bracket
/////////////////////////////////////////////////////////////////