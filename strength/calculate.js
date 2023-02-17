
//! START 4SIDE GLASS

function glass4maxbencal() {
    let glassthk = parseFloat(document.getElementById("glassthk").value);
    let shortside = parseFloat(document.getElementById("shortside").value);
    let longside = parseFloat(document.getElementById("longside").value);
    let windload = parseFloat(document.getElementById("windload").value);
    let set1 = ((windload / 10000) * (shortside ** 2)) / 8;
    let set2 = 1 + 2 * (shortside / longside) ** 3;
    let set3 = 6 / glassthk ** 2;

    result = ((set1 / set2) * set3);

    let sendresult = result.toFixed(3);

    document.getElementById("glass4maxben").value = sendresult;
}

function val() {
    let d = document.getElementById("glasstype").value;
    // console.log(d);
}
$('#glasstype').change(function () {
    // console.log($(this).val());
    let result = $(this).val();
    document.getElementById("glasstypevalue").value = result;

    // console.log(result)
    // console.log(typeof result);
})


function checkglass4bendingcal() {
    let glasstype = parseFloat(document.getElementById("glasstype").value);
    let glass4maxben = parseFloat(document.getElementById("glass4maxben").value);

    if (glasstype >= glass4maxben) {
        // console.log("Hence");
        document.getElementById("checkbending").value = "Max.Bend. < allow stress";
        document.getElementById("checkbending2").value = "Max.Bend. allow";
    } else {
        document.getElementById("checkbending").value = "Max.Bend. > allow stress";
        document.getElementById("checkbending2").value = "Max.Bend. cannot allow";
    }
}

function glass4maxdefcal() {
    let glassthk = parseFloat(document.getElementById("glassthk").value);
    let shortside = parseFloat(document.getElementById("shortside").value);
    let longside = parseFloat(document.getElementById("longside").value);
    let windload = parseFloat(document.getElementById("windload").value);

    let set1 = (0.16 / (1 + 2.4 * (shortside / longside) ** 3));
    let set2 = (1 - 0.22 ** 2);
    let set3 = (windload / 10000) * (shortside ** 4);
    let set4 = (710000 * glassthk ** 3)
    let set5 = set3 / set4;

    result = set1 * set2 * set5;

    let sendresult = result.toFixed(3);

    document.getElementById("glass4maxdef").value = sendresult;
}

function glass4allowdefcal() {
    let shortside = parseFloat(document.getElementById("shortside").value);

    result = shortside / 60;

    let sendresult = result.toFixed(3);

    document.getElementById("glass4allowdef").value = sendresult;
}

function glass4defcheck() {
    let glass4maxdef = parseFloat(document.getElementById("glass4maxdef").value);
    let glass4allowdef = parseFloat(document.getElementById("glass4allowdef").value);

    // result = maxdef < allowdef;
    // document.getElementById("allowdef").value = result;

    if (glass4maxdef >= 2) {
        // console.log("Hence");
        document.getElementById("defcheck").value = "Max.def. > 2";
        document.getElementById("defcheck2").value = "Hence Glass not allow";

    } else if (glass4maxdef >= glass4allowdef) {
        document.getElementById("defcheck").value = "Max.def. > allow def.";
        document.getElementById("defcheck2").value = "Hence Glass not allow";

    } else {
        document.getElementById("defcheck").value = "Max.def. < allow def.";
        document.getElementById("defcheck2").value = "Hence Glass allow";
    }

}


//! END 4SIDE GLASS
/////////////////////////////////////////////////////////////////
//! START 2SIDE GLASS

function glass2momentinercal() {

    let shortside = parseFloat(document.getElementById("shortside").value);
    let glassthk = parseFloat(document.getElementById("glassthk").value);


    result = (shortside * glassthk ** 3) / 12;

    let sendresult = result.toFixed(3);

    document.getElementById("momentiner").value = sendresult;

    // document.getElementById("momentiner").value = result;

}

function glass2momentmaxcal() {

    let windload = parseFloat(document.getElementById("windload").value);
    let longside = parseFloat(document.getElementById("longside").value);


    result = (windload * ((longside / 100) ** 2)) / 8;

    let sendresult = result.toFixed(3);

    document.getElementById("glass2momentmax").value = sendresult;

    // document.getElementById("momentmax").value = result;

}

function glass2bendingmaxcal() {
    let momentmax = parseFloat(document.getElementById("glass2momentmax").value);
    let glassthk = parseFloat(document.getElementById("glassthk").value);
    let shortside = parseFloat(document.getElementById("shortside").value);


    let result = (6 * momentmax * 100) / (shortside) / (glassthk ** 2);

    let sendresult = result.toFixed(3);

    document.getElementById("glass2bendingmax").value = sendresult;

    // console.log(glassthk)
    // console.log(typeof glassthk);

    // document.getElementById("bendingmaxglass2side").value = result;
}

function checkglass2bendincal() {
    let glasstype = parseFloat(document.getElementById("glasstype").value);
    let glass2bendingmax = parseFloat(document.getElementById("glass2bendingmax").value);

    if (glasstype >= glass2bendingmax) {

        // console.log(glasstype)
        // console.log(typeof glasstype);

        // console.log(glass2bendingmax)
        // console.log(typeof glass2bendingmax);

        // console.log("Hence");
        document.getElementById("checkbending").value = "Max.Bend. < allow stress";
        document.getElementById("checkbending2").value = "Max.Bend. allow";

    } else {
        document.getElementById("checkbending").value = "Max.Bend. > allow stress";
        document.getElementById("checkbending2").value = "Max.Bend. cannot allow";
    }
}



function glass2maxdefcal() {
    let windload = parseFloat(document.getElementById("windload").value);
    let longside = parseFloat(document.getElementById("longside").value);
    let momentiner = parseFloat(document.getElementById("momentiner").value);

    let result = ((5 * (windload / 100)) * (longside ** 4)) / (384 * 710000 * momentiner);

    let sendresult = result.toFixed(3);

    // console.log(sendresult)
    // console.log(typeof sendresult);

    document.getElementById("glass2maxdef").value = sendresult;

    // document.getElementById("maxdef").value = result;

}

function glass2allowdefcal() {
    let longside = parseFloat(document.getElementById("longside").value);

    result = longside / 60;

    let sendresult = result.toFixed(3);

    document.getElementById("glass2allowdef").value = sendresult;
}

function glass2defcheck() {
    let glass2maxdef = parseFloat(document.getElementById("glass2maxdef").value);
    let glass2allowdef = parseFloat(document.getElementById("glass2allowdef").value);

    // result = maxdef < allowdef;
    // document.getElementById("allowdef").value = result;

    if (glass2maxdef >= 2) {
        // console.log("Hence");
        document.getElementById("defcheck").value = "Max.def. > 2";
        document.getElementById("defcheck2").value = "Hence Glass not allow";

    } else if (glass2maxdef >= glass2allowdef) {
        document.getElementById("defcheck").value = "Max.def. > allow def.";
        document.getElementById("defcheck2").value = "Hence Glass not allow";

    } else {
        document.getElementById("defcheck").value = "Max.def. < allow def.";
        document.getElementById("defcheck2").value = "Hence Glass allow";
    }
    // console.log(glass2maxdef)
    // console.log(typeof glass2maxdef);
    // console.log(glass2allowdef)
    // console.log(typeof glass2allowdef);
}


//! END 2 SIDE GLASS
/////////////////////////////////////////////////////////////////
//! START SIGGLE MULLION

function alummomenmaxcal() {

    let alumwidth = parseFloat(document.getElementById("alumwidth").value);
    let alumheight = parseFloat(document.getElementById("alumheight").value);
    let windload = parseFloat(document.getElementById("windload").value);


    result = ((windload * alumwidth * (alumheight ** 2)) / 8) / 1000000;

    let sendresult = result.toFixed(3);

    document.getElementById("alummomentmax").value = sendresult;

    // document.getElementById("momentmax").value = result;

}

function alumbendingstress() {

    let alummomentmax = parseFloat(document.getElementById("alummomentmax").value);
    let alumcentroid = parseFloat(document.getElementById("alumcentroid").value);
    let alumix = parseFloat(document.getElementById("alumix").value);


    result = ((alummomentmax * 100 * alumcentroid) / (alumix)) * 1000;

    let sendresult = result.toFixed(3);

    document.getElementById("alummaxbend").value = sendresult;

    // document.getElementById("momentmax").value = result;

}

function checkalumcheckbend() {

    let alummaxbend = parseFloat(document.getElementById("alummaxbend").value);

    if (650 >= alummaxbend) {
        // console.log("Hence");
        document.getElementById("alumcheckbend").value = "Max.Bend. < allow bend.";
        document.getElementById("alumcheckbend2").value = "Hence Mullion allow";

    } else {
        document.getElementById("alumcheckbend").value = "Max.Bend. > allow bend.";
        document.getElementById("alumcheckbend2").value = "Mullion cannot allow";
    }
}

function alummaxdefcal() {
    let windload = parseFloat(document.getElementById("windload").value);
    let alumwidth = parseFloat(document.getElementById("alumwidth").value);
    let alumheight = parseFloat(document.getElementById("alumheight").value);
    let alumix = parseFloat(document.getElementById("alumix").value);

    let result = ((5 * (windload)) * alumwidth * (alumheight ** 4)) / (384 * 700000 * alumix);

    let sendresult = result.toFixed(3);

    document.getElementById("alummaxdef").value = sendresult;

    // document.getElementById("maxdef").value = result;

}

function alumallowdefcal() {
    let alumheight = parseFloat(document.getElementById("alumheight").value);

    result = alumheight / 175;

    let sendresult = result.toFixed(3);

    document.getElementById("alumallowdef").value = sendresult;
}

function checkalumdefcheck() {

    let alummaxdef = parseFloat(document.getElementById("alummaxdef").value);
    let alumallowdef = parseFloat(document.getElementById("alumallowdef").value);

    if (alumallowdef >= alummaxdef) {
        // console.log("Hence");
        document.getElementById("alumdefcheck").value = "Max.def. < allow def.";
        document.getElementById("alumdefcheck2").value = "Hence Mullion allow";

    } else {
        document.getElementById("alumdefcheck").value = "Max.def. > allow bend.";
        document.getElementById("alumdefcheck2").value = "Mullion cannot allow";
    }
}
//! END SIGGLE MULLION
/////////////////////////////////////////////////////////////////


// $("input.txtCalinput").each((i, ele) => {
//     let clone = $(ele).clone(false)
//     clone.attr("type", "text")
//     let ele1 = $(ele)
//     clone.val(Number(ele1.val()).toLocaleString("en-IN"))
//     $(ele).after(clone)
//     $(ele).hide()
//     clone.mouseenter(() => {

//         ele1.show()
//         clone.hide()
//     })
//     setInterval(() => {
//         let newv = Number(ele1.val()).toLocaleString("en-IN")
//         if (clone.val() != newv) {
//             clone.val(newv)
//         }
//     }, 10)

//     $(ele).mouseleave(() => {
//         $(clone).show()
//         $(ele1).hide()
//     })
// })

// function fun(num) {
//     return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g), ',';
// }

// $(document).ready(function () {
//     $('input.txtCalnum').on("keyup click", function (event) {
//         // skip for arrow keys
//         if (event.which >= 37 && event.which <= 40) {
//             event.preventDefault();
//         }
//         let $this = $(this);
//         let num = $this.val();
//         let decs = num.split(".");
//         num = decs[0];
//         num = num.replace(/,/gi, "").split("").reverse().join("");

//         let num2 = RemoveRogueChar(num.replace(/(.{3})/g, "$1,").split("").reverse().join(""));
//         if (decs.length > 1) {
//             num2 += '.' + decs[1];
//         }
//         $this.val(num2);
//     });
// });

// function RemoveRogueChar(convertString) {
//     if (convertString.substring(0, 1) == ",") {
//         return convertString.substring(1, convertString.length)
//     }

//     return convertString;
// }

/////////////////////////////////////////////////////////////////
//! START COMBINE MULLION

function combinebendingstress() {

    let alummomentmax = parseFloat(document.getElementById("alummomentmax").value);
    let alumcentroid = parseFloat(document.getElementById("alumcentroid").value);
    let alumix = parseFloat(document.getElementById("alumix").value);
    let combineix = parseFloat(document.getElementById("combineix").value);
    let combinemullion = parseFloat(alumix) + parseFloat(combineix);

    result = ((alummomentmax * 100 * alumcentroid) / combinemullion) * 1000;

    let sendresult = result.toFixed(3);

    document.getElementById("combinemaxbend").value = sendresult;

    // document.getElementById("momentmax").value = result;

    // console.log(alumix)
    // console.log(combineix)
    // console.log(combinemullion)
    // console.log(typeof alumix);
    // console.log(typeof combineix);
    // console.log(typeof combinemullion);
}

function checkcombinecheckbend() {

    let combinemaxbend = parseFloat(document.getElementById("combinemaxbend").value);

    if (650 >= combinemaxbend) {
        // console.log("Hence");
        document.getElementById("combinecheckbend").value = "Max.Bend. < allow bend.";
        document.getElementById("combinecheckbend2").value = "Combine Mullion allow";

    } else {
        document.getElementById("combinecheckbend").value = "Max.Bend. > allow bend.";
        document.getElementById("combinecheckbend2").value = "Combine Mullion cannot allow";
    }
}

function combinemaxdefcal() {
    let windload = parseFloat(document.getElementById("windload").value);
    let alumwidth = parseFloat(document.getElementById("alumwidth").value);
    let alumheight = parseFloat(document.getElementById("alumheight").value);
    let alumix = parseFloat(document.getElementById("alumix").value);
    let combineix = parseFloat(document.getElementById("combineix").value);
    let combinemullion = parseFloat(alumix) + parseFloat(combineix);

    let result = ((5 * (windload)) * alumwidth * (alumheight ** 4)) / (384 * 700000 * combinemullion);

    let sendresult = result.toFixed(3);

    document.getElementById("combinemaxdef").value = sendresult;

    // document.getElementById("maxdef").value = result;

    // console.log(alumix)
    // console.log(combineix)
    // console.log(combinemullion)
    // console.log(sendresult)
    // console.log(typeof alumix);
    // console.log(typeof combineix);
    // console.log(typeof combinemullion);
    // console.log(typeof sendresult);

}

function checkcombinedefcheck() {

    let combinemaxdef = parseFloat(document.getElementById("combinemaxdef").value);
    let alumallowdef = parseFloat(document.getElementById("alumallowdef").value);

    if (alumallowdef >= combinemaxdef) {
        // console.log("Hence");
        document.getElementById("combinedefcheck").value = "Max.def. < allow def.";
        document.getElementById("combinedefcheck2").value = "Combine Mullion allow";

    } else {
        document.getElementById("combinedefcheck").value = "Max.def. > allow bend.";
        document.getElementById("combinedefcheck2").value = "Combine Mullion cannot allow";
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

    let height = parseFloat(transomheight1) + parseFloat(transomheight2);

    result = ((windload * height * (tannsomwidth ** 2)) / 8) / 1000000;

    let sendresult = result.toFixed(3);

    document.getElementById("transommomentmax").value = sendresult;

}

function transombendingstress() {

    let transommomentmax = parseFloat(document.getElementById("transommomentmax").value);
    let transomcentroidx = parseFloat(document.getElementById("transomcentroidx").value);
    let transomiy = parseFloat(document.getElementById("transomiy").value);
    let stiffeneriy = parseFloat(document.getElementById("stiffeneriy").value);

    let combineiy = parseFloat(transomiy) + parseFloat(stiffeneriy);

    // console.log(transomiy);
    // console.log(typeof transomiy);
    // console.log(stiffeneriy);
    // console.log(typeof stiffeneriy);
    // console.log(combineix);
    // console.log(typeof combineix);

    result = ((transommomentmax * 100 * transomcentroidx) / (combineiy)) * 1000;

    let sendresult = result.toFixed(3);

    document.getElementById("transommaxbend").value = sendresult;

}

function checktransombend() {

    let combinemaxbend = parseFloat(document.getElementById("transommaxbend").value);

    if (650 >= combinemaxbend) {
        // console.log("Hence");
        document.getElementById("transomcheckbend").value = "Max.Bend. < allow bend.";
        document.getElementById("transomcheckbend2").value = "transom allow";

    } else {
        document.getElementById("transomcheckbend").value = "Max.Bend. > allow bend.";
        document.getElementById("transomcheckbend2").value = "transom cannot allow";
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

    let height = parseFloat(transomheight1) + parseFloat(transomheight2);


    let result = ((5 * (windload)) * height * (tannsomwidth ** 4)) / (384 * 700000 * combineiy);

    let sendresult = result.toFixed(3);

    document.getElementById("transommaxdef").value = sendresult;

}

function transomallowdefcal() {
    let tannsomwidth = parseFloat(document.getElementById("tannsomwidth").value);

    result = tannsomwidth / 175;

    let sendresult = result.toFixed(3);

    document.getElementById("transomallowdef").value = sendresult;
}

function checktransomdef() {

    let transommaxdef = parseFloat(document.getElementById("transommaxdef").value);
    let transomallowdef = parseFloat(document.getElementById("transomallowdef").value);

    if (transomallowdef >= transommaxdef) {
        // console.log("Hence");
        document.getElementById("transomdefcheck").value = "Max.def. < allow def.";
        document.getElementById("transomdefcheck2").value = "transom allow";

    } else {
        document.getElementById("transomdefcheck").value = "Max.def. > allow bend.";
        document.getElementById("transomdefcheck2").value = "transom cannot allow";
    }
}

//! END TRANSOM
/////////////////////////////////////////////////////////////////
//! START TRANSOM DEAD LOAD

function glassweightcal() {
    let tannsomwidth = parseFloat(document.getElementById("tannsomwidth").value);
    let transomheight1 = parseFloat(document.getElementById("transomheight1").value);
    let glassthk = parseFloat(document.getElementById("glassthk").value);

    let result = (parseFloat(tannsomwidth) * parseFloat(transomheight1) * parseFloat(glassthk) * 25.6) / 10000;

    let sendresult = result.toFixed(3);

    document.getElementById("glassweight").value = sendresult;

    // console.log(result);
    // console.log(typeof result);
}

function maxshearcal() {
    let glassweight = parseFloat(document.getElementById("glassweight").value);

    let result = (parseFloat(glassweight) / 2) / 100;

    let sendresult = result.toFixed(3);

    document.getElementById("maxshear").value = sendresult;

    // console.log(result);
    // console.log(typeof result);
}

function deadloadtransommaxdefcal() {
    let maxshear = parseFloat(document.getElementById("maxshear").value);
    let tannsomwidth = parseFloat(document.getElementById("tannsomwidth").value);
    let transomix = parseFloat(document.getElementById("transomix").value);
    let stiffenerix = parseFloat(document.getElementById("stiffenerix").value);

    let combineix = parseFloat(transomix) + parseFloat(stiffenerix);

    let a = tannsomwidth / 4;

    // let set1 = (maxshear * a) / 8;
    // let set2 = 24 * 700000 * combineix;
    // let set3 = 3 * (tannsomwidth ** 2);
    // let set4 = 4 * ((tannsomwidth / 8) ** 2);
    let set1 = maxshear * a;
    let set2 = 24 * 700000 * combineix;
    let set3 = 3 * (tannsomwidth ** 2);
    let set4 = 4 * (a ** 2);

    let result = ((set1 / set2) * (set3 - set4)) * 10000000;

    // let result = ((set1 / set2) * (set3 - set4)) * 10000000;

    let sendresult = result.toFixed(3);

    document.getElementById("deadloadtransommaxdef").value = sendresult;

    // console.log(result);
    // console.log(typeof result);
}

function daedloadallowdefcal() {
    let tannsomwidth = parseFloat(document.getElementById("tannsomwidth").value);

    result = tannsomwidth / 300;

    let sendresult = result.toFixed(3);

    document.getElementById("deadloadallowdef").value = sendresult;
}

function checkdeadloaddef() {

    let deadloadtransommaxdef = parseFloat(document.getElementById("deadloadtransommaxdef").value);
    let deadloadallowdef = parseFloat(document.getElementById("deadloadallowdef").value);

    if (deadloadallowdef >= deadloadtransommaxdef) {
        // console.log("Hence");
        document.getElementById("deadloaddefcheck").value = "Max.def. < allow def.";
        document.getElementById("deadloaddefcheck2").value = "transom allow";

    } else {
        document.getElementById("deadloaddefcheck").value = "Max.def. > allow bend.";
        document.getElementById("deadloaddefcheck2").value = "transom cannot allow";
    }
}

function siliconebilecal() {

    let siliconeshortside = parseFloat(document.getElementById("siliconeshortside").value);
    let windload = parseFloat(document.getElementById("windload").value);

    let result = siliconeshortside * windload / 27500;

    if (result <= 6) {
        result = 6;
    }

    let sendresult = result.toFixed(1);

    document.getElementById("siliconewidth").value = sendresult;

}