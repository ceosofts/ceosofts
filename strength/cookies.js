// Create cookie
// function setCookie(cname, cvalue, exdays) {
//     const d = new Date();
//     d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
//     let expires = "expires=" + d.toUTCString();
//     document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
// }

// // Delete cookie
// function deleteCookie(cname) {
//     const d = new Date();
//     d.setTime(d.getTime() + (24 * 60 * 60 * 1000));
//     let expires = "expires=" + d.toUTCString();
//     document.cookie = cname + "=;" + expires + ";path=/";
// }

// // Read cookie
// function getCookie(cname) {
//     let name = cname + "=";
//     let decodedCookie = decodeURIComponent(document.cookie);
//     let ca = decodedCookie.split(';');
//     for (let i = 0; i < ca.length; i++) {
//         let c = ca[i];
//         while (c.charAt(0) == ' ') {
//             c = c.substring(1);
//         }
//         if (c.indexOf(name) == 0) {
//             return c.substring(name.length, c.length);
//         }
//     }
//     return "";
// }

// Set cookie consent
// function acceptCookieConsent() {
//     deleteCookie('user_cookie_consent');
//     setCookie('user_cookie_consent', 1, 7);
//     document.getElementById("cookieNotice").style.display = "none";
// }

// let cookie_consent = getCookie("user_cookie_consent");
// if (cookie_consent != "") {
//     document.getElementById("cookieNotice").style.display = "none";
// } else {
//     document.getElementById("cookieNotice").style.display = "block";
// }

function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function checkCookie() {
    let user = getCookie("username");
    if (user != "") {
        alert("Welcome again : ยินดีต้อนรับอีกครั้ง " + user);
    } else {
        // user = prompt(" Please enter your name : ผู้เข้าชมใหม่กรุณาระบุชื่อ", "");
        user = prompt(" Cookies Policy เราใช้คุกกี้เพื่อเพิ่มประสบการณ์และความพึงพอใจในการใช้งานเว็บไซต์ของคุณ หากคุณยินยอม กรุณาระบุชื่อแล้วกด OK หรือ Cancel แล้วใช้งานเว็บไซต์ของเราต่อ", "");
        if (user != "" && user != null) {
            setCookie("username", user, 30);
        }
    }
}