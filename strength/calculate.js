
//! START 4SIDE GLASS

function glass4sidecal() {
    var glassthk = document.getElementById("glassthk").value;
    var shortside = document.getElementById("shortside").value;
    var longside = document.getElementById("longside").value;
    var windload = document.getElementById("windload").value;
    var set1 = ((windload / 10000) * (shortside ** 2)) / 8;
    var set2 = 1 + 2 * (shortside / longside) ** 3;
    var set3 = 6 / glassthk ** 2;

    result = ((set1 / set2) * set3);

    var sendresult = result.toFixed(3);

    document.getElementById("g4sidemaxben").value = sendresult;
}

function val() {
    var d = document.getElementById("glasstype").value;
    // console.log(d);
}
$('#glasstype').change(function () {
    // console.log($(this).val());
    var glasstypevalue = $(this).val();
    document.getElementById("glasstypevalue").value = glasstypevalue;
})

function checkbendingcal() {
    var glasstypevalue = document.getElementById("glasstypevalue").value;
    var g4sidemaxben = document.getElementById("g4sidemaxben").value;
    if (glasstypevalue >= g4sidemaxben) {
        // console.log("Hence");
        document.getElementById("checkbending").value = "Max.Bend. < allow stress";
        document.getElementById("checkbending2").value = "Hence Glass allow";
    } else {
        document.getElementById("checkbending").value = "Max.Bend. > allow stress";
        document.getElementById("checkbending2").value = "Glass cannot allow";
    }
}

function maxdefcal() {
    var glassthk = document.getElementById("glassthk").value;
    var shortside = document.getElementById("shortside").value;
    var longside = document.getElementById("longside").value;
    var windload = document.getElementById("windload").value;

    var set1 = (0.16 / (1 + 2.4 * (shortside / longside) ** 3));
    var set2 = (1 - 0.22 ** 2);
    var set3 = (windload / 10000) * (shortside ** 4);
    var set4 = (700000 * glassthk ** 3)
    var set5 = set3 / set4;

    result = set1 * set2 * set5;

    var sendresult = result.toFixed(3);

    document.getElementById("maxdef").value = sendresult;
}

/////////////////////////////////////////////////////////////////
//! ใช้รว่มกัน

function allowdef() {
    var longside = document.getElementById("longside").value;

    result = longside / 60;

    var sendresult = result.toFixed(3);

    document.getElementById("allowdef").value = sendresult;
}
/////////////////////////////////////////////////////////////////
//! ใช้รว่มกัน
function defcheck() {
    var maxdef = document.getElementById("maxdef").value;
    var allowdef = document.getElementById("allowdef").value;

    // result = maxdef < allowdef;
    // document.getElementById("allowdef").value = result;

    if (maxdef <= allowdef) {
        // console.log("Hence");
        document.getElementById("defcheck").value = "Max.def. < allow def.";
        document.getElementById("defcheck2").value = "Hence Glass allow";
    } else {
        document.getElementById("defcheck").value = "Max.def. > allow def.";
        document.getElementById("defcheck2").value = "Hence Glass not allow";
    }
}
//! END 4SIDE GLASS
/////////////////////////////////////////////////////////////////
//! START 2SIDE GLASS

function momentinercal() {

    var shortside = document.getElementById("shortside").value;
    var glassthk = document.getElementById("glassthk").value;


    result = (shortside * glassthk ** 3) / 12;

    var sendresult = result.toFixed(3);

    document.getElementById("momentiner").value = sendresult;

    // document.getElementById("momentiner").value = result;

}

function checkmomenmax2sidecal() {

    var windload = document.getElementById("windload").value;
    var longside = document.getElementById("longside").value;


    result = (windload * ((longside / 100) ** 2)) / 8;

    var sendresult = result.toFixed(3);

    document.getElementById("momentmax").value = sendresult;

    // document.getElementById("momentmax").value = result;

}

function bendingmaxglass2sidecal() {
    var momentmax = document.getElementById("momentmax").value;
    var glassthk = document.getElementById("glassthk").value;
    var shortside = document.getElementById("shortside").value;


    var result = (6 * momentmax * 100) / (shortside) / (glassthk ** 2);

    var sendresult = result.toFixed(3);

    document.getElementById("bendingmaxglass2side").value = sendresult;

    // document.getElementById("bendingmaxglass2side").value = result;
}

function checkbending2sidecal() {
    var glasstypevalue = document.getElementById("glasstypevalue").value;
    var bendingmaxglass2side = document.getElementById("bendingmaxglass2side").value;

    if (glasstypevalue >= bendingmaxglass2side) {
        // console.log("Hence");
        document.getElementById("checkbending").value = "Max.Bend. < allow stress";
        document.getElementById("checkbending2").value = "Hence Glass allow";

    } else {
        document.getElementById("checkbending").value = "Max.Bend. > allow stress";
        document.getElementById("checkbending2").value = "Glass cannot allow";
    }
}

function maxdeflectioncal() {
    var windload = document.getElementById("windload").value;
    var longside = document.getElementById("longside").value;
    var momentiner = document.getElementById("momentiner").value;

    var result = ((5 * (windload / 100)) * (longside ** 4)) / (384 * 700000 * momentiner);

    var sendresult = result.toFixed(3);

    document.getElementById("maxdef").value = sendresult;

    // document.getElementById("maxdef").value = result;

}

//! END 2 SIDE GLASS
/////////////////////////////////////////////////////////////////
//! START SIGGLE MULLION

function alummomenmaxcal() {

    var alumwidth = document.getElementById("alumwidth").value;
    var alumheight = document.getElementById("alumheight").value;
    var windload = document.getElementById("windload").value;


    result = ((windload * alumwidth * (alumheight ** 2)) / 8) / 1000000;

    var sendresult = result.toFixed(3);

    document.getElementById("alummomentmax").value = sendresult;

    // document.getElementById("momentmax").value = result;

}

function alumbendingstress() {

    var alummomentmax = document.getElementById("alummomentmax").value;
    var alumcentroid = document.getElementById("alumcentroid").value;
    var alumix = document.getElementById("alumix").value;


    result = ((alummomentmax * 100 * alumcentroid) / (alumix)) * 1000;

    var sendresult = result.toFixed(3);

    document.getElementById("alummaxbend").value = sendresult;

    // document.getElementById("momentmax").value = result;

}

function checkalumcheckbend() {

    var alummaxbend = document.getElementById("alummaxbend").value;

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
    var windload = document.getElementById("windload").value;
    var alumwidth = document.getElementById("alumwidth").value;
    var alumheight = document.getElementById("alumheight").value;
    var alumix = document.getElementById("alumix").value;

    var result = ((5 * (windload)) * alumwidth * (alumheight ** 4)) / (384 * 700000 * alumix);

    var sendresult = result.toFixed(3);

    document.getElementById("alummaxdef").value = sendresult;

    // document.getElementById("maxdef").value = result;

}

function alumallowdefcal() {
    var alumheight = document.getElementById("alumheight").value;

    result = alumheight / 175;

    var sendresult = result.toFixed(3);

    document.getElementById("alumallowdef").value = sendresult;
}

function checkalumdefcheck() {

    var alummaxdef = document.getElementById("alummaxdef").value;
    var alumallowdef = document.getElementById("alumallowdef").value;

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
//         var $this = $(this);
//         var num = $this.val();
//         var decs = num.split(".");
//         num = decs[0];
//         num = num.replace(/,/gi, "").split("").reverse().join("");

//         var num2 = RemoveRogueChar(num.replace(/(.{3})/g, "$1,").split("").reverse().join(""));
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

    var alummomentmax = document.getElementById("alummomentmax").value;
    var alumcentroid = document.getElementById("alumcentroid").value;
    var alumix = document.getElementById("alumix").value;
    var combineix = document.getElementById("combineix").value;
    var combinemullion = parseInt(alumix) + parseInt(combineix);

    result = ((alummomentmax * 100 * alumcentroid) / combinemullion) * 1000;

    var sendresult = result.toFixed(3);

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

    var combinemaxbend = document.getElementById("combinemaxbend").value;

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
    var windload = document.getElementById("windload").value;
    var alumwidth = document.getElementById("alumwidth").value;
    var alumheight = document.getElementById("alumheight").value;
    var alumix = document.getElementById("alumix").value;
    var combineix = document.getElementById("combineix").value;
    var combinemullion = parseInt(alumix) + parseInt(combineix);

    var result = ((5 * (windload)) * alumwidth * (alumheight ** 4)) / (384 * 700000 * combinemullion);

    var sendresult = result.toFixed(3);

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

    var combinemaxdef = document.getElementById("combinemaxdef").value;
    var alumallowdef = document.getElementById("alumallowdef").value;

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

    var tannsomwidth = document.getElementById("tannsomwidth").value;
    var transomheight1 = document.getElementById("transomheight1").value;
    var transomheight2 = document.getElementById("transomheight2").value;
    var windload = document.getElementById("windload").value;

    var height = parseInt(transomheight1) + parseInt(transomheight2);

    result = ((windload * height * (tannsomwidth ** 2)) / 8) / 1000000;

    var sendresult = result.toFixed(3);

    document.getElementById("transommomentmax").value = sendresult;

}

function transombendingstress() {

    var transommomentmax = document.getElementById("transommomentmax").value;
    var transomcentroidx = document.getElementById("transomcentroidx").value;
    var transomiy = document.getElementById("transomiy").value;
    var stiffeneriy = document.getElementById("stiffeneriy").value;

    var combineiy = parseInt(transomiy) + parseInt(stiffeneriy);

    // console.log(transomiy);
    // console.log(typeof transomiy);
    // console.log(stiffeneriy);
    // console.log(typeof stiffeneriy);
    // console.log(combineix);
    // console.log(typeof combineix);

    result = ((transommomentmax * 100 * transomcentroidx) / (combineiy)) * 1000;

    var sendresult = result.toFixed(3);

    document.getElementById("transommaxbend").value = sendresult;

}

function checktransombend() {

    var combinemaxbend = document.getElementById("transommaxbend").value;

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
    var windload = document.getElementById("windload").value;
    var tannsomwidth = document.getElementById("tannsomwidth").value;
    var transomheight1 = document.getElementById("transomheight1").value;
    var transomheight2 = document.getElementById("transomheight2").value;

    var transomiy = document.getElementById("transomiy").value;
    var stiffeneriy = document.getElementById("stiffeneriy").value;

    var combineiy = parseInt(transomiy) + parseInt(stiffeneriy);

    var height = parseInt(transomheight1) + parseInt(transomheight2);


    var result = ((5 * (windload)) * height * (tannsomwidth ** 4)) / (384 * 700000 * combineiy);

    var sendresult = result.toFixed(3);

    document.getElementById("transommaxdef").value = sendresult;

}

function transomallowdefcal() {
    var tannsomwidth = document.getElementById("tannsomwidth").value;

    result = tannsomwidth / 175;

    var sendresult = result.toFixed(3);

    document.getElementById("transomallowdef").value = sendresult;
}

function checktransomdef() {

    var transommaxdef = document.getElementById("transommaxdef").value;
    var transomallowdef = document.getElementById("transomallowdef").value;

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
    var tannsomwidth = document.getElementById("tannsomwidth").value;
    var transomheight1 = document.getElementById("transomheight1").value;
    var glassthk = document.getElementById("glassthk").value;

    var result = (parseInt(tannsomwidth) * parseInt(transomheight1) * parseInt(glassthk) * 25.6) / 10000;

    var sendresult = result.toFixed(3);

    document.getElementById("glassweight").value = sendresult;

    // console.log(result);
    // console.log(typeof result);
}

function maxshearcal() {
    var glassweight = document.getElementById("glassweight").value;

    var result = (parseInt(glassweight) / 2) / 100;

    var sendresult = result.toFixed(3);

    document.getElementById("maxshear").value = sendresult;

    // console.log(result);
    // console.log(typeof result);
}

function maxdefcal() {
    var maxshear = document.getElementById("maxshear").value;
    var tannsomwidth = document.getElementById("tannsomwidth").value;
    var transomix = document.getElementById("transomix").value;
    var stiffenerix = document.getElementById("stiffenerix").value;

    var combineix = parseInt(transomix) + parseInt(stiffenerix);

    var a = tannsomwidth / 4;

    // var set1 = (maxshear * a) / 8;
    // var set2 = 24 * 700000 * combineix;
    // var set3 = 3 * (tannsomwidth ** 2);
    // var set4 = 4 * ((tannsomwidth / 8) ** 2);
    var set1 = maxshear * a;
    var set2 = 24 * 700000 * combineix;
    var set3 = 3 * (tannsomwidth ** 2);
    var set4 = 4 * (a ** 2);

    var result = ((set1 / set2) * (set3 - set4)) * 10000000;

    // var result = ((set1 / set2) * (set3 - set4)) * 10000000;

    var sendresult = result.toFixed(3);

    document.getElementById("maxdef").value = sendresult;

    // console.log(result);
    // console.log(typeof result);
}

function daedloadallowdefcal() {
    var tannsomwidth = document.getElementById("tannsomwidth").value;

    result = tannsomwidth / 300;

    var sendresult = result.toFixed(3);

    document.getElementById("deadloadallowdef").value = sendresult;
}

function checkdeadloaddef() {

    var maxdef = document.getElementById("maxdef").value;
    var deadloadallowdef = document.getElementById("deadloadallowdef").value;

    if (deadloadallowdef >= maxdef) {
        // console.log("Hence");
        document.getElementById("deadloaddefcheck").value = "Max.def. < allow def.";
        document.getElementById("deadloaddefcheck2").value = "transom allow";

    } else {
        document.getElementById("deadloaddefcheck").value = "Max.def. > allow bend.";
        document.getElementById("deadloaddefcheck2").value = "transom cannot allow";
    }
}