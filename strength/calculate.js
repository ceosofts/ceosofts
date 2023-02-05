
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
        document.getElementById("checkbending2").value = "Hence Glass allowable";
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
    var set4 = (710000 * glassthk ** 3)
    var set5 = set3 / set4;

    result = set1 * set2 * set5;

    var sendresult = result.toFixed(3);

    document.getElementById("maxdef").value = sendresult;
}

/////////////////////////////////////////////////////////////////
//ใช้รว่มกัน

function allowdef() {
    var shortside = document.getElementById("shortside").value;

    result = shortside / 60;

    var sendresult = result.toFixed(3);

    document.getElementById("allowdef").value = sendresult;
}
/////////////////////////////////////////////////////////////////
//ใช้รว่มกัน
function defcheck() {
    var maxdef = document.getElementById("maxdef").value;
    var allowdef = document.getElementById("allowdef").value;

    // result = maxdef < allowdef;
    // document.getElementById("allowdef").value = result;

    if (maxdef <= allowdef) {
        // console.log("Hence");
        document.getElementById("defcheck").value = "Max.def. < allow def.";
        document.getElementById("defcheck2").value = "Hence Glass allowable";
    } else {
        document.getElementById("defcheck").value = "Max.def. > allow def.";
        document.getElementById("defcheck2").value = "Hence Glass not allow";
    }
}

/////////////////////////////////////////////////////////////////

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
        document.getElementById("checkbending2").value = "Hence Glass allowable";

    } else {
        document.getElementById("checkbending").value = "Max.Bend. > allow stress";
        document.getElementById("checkbending2").value = "Glass cannot allow";
    }
}

function maxdeflectioncal() {
    var windload = document.getElementById("windload").value;
    var longside = document.getElementById("longside").value;
    var momentiner = document.getElementById("momentiner").value;

    var result = ((5 * (windload / 100)) * (longside ** 4)) / (384 * 710000 * momentiner);

    var sendresult = result.toFixed(3);

    document.getElementById("maxdef").value = sendresult;

    // document.getElementById("maxdef").value = result;

}

