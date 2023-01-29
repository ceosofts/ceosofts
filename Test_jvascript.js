document.write("test javascrpt by Yai"); //แสดงตัวหนังสือ
document.write("<p>test javascrpt by Yai222555</P>"); //แสดงตัวหนังสือ

//alert('yo!') //มีกล่องข้อความขึ้นมาเตือน

console.log("hello javascript"); //แสดงค่าใน console

///////////////////////////
//ฟังก์ชั่น function

//ชื่อฟังกืชั่น
function abcd() {
	console.log("abcd");
}

function message() {
	alert("ทดลองแจ้งเตือน");
}

function displayName() {
	document.write("ชื่อ นาย ยิ่งใหญ่");
}

//เรียกใช้ฟังก์ชั่น
abcd();
message();

///////////////////////////
// ฟังก์ชั่นที่มีการรับค่าเข้ามา
// อาร์กิวเมนต์ คือ ตัวแปรหรือค่าที่ต้องการส่งมาให้กับฟังก์ชั่น //ตัวแปรส่ง
// พารามิเตอร์ คือ ตัวแปรที่ฟังก์ชั่นสร้างไว้สำหรับรับค่าที่จะส่งเข้ามาให้กับฟังก์ชั่น //ตัวแปรรับ

function plusNumber(x) {
	//x = พารามิเตอร์
	console.log("เลขที่ส่งมาตือ =", x);
}

//เรียกใช้ฟังก์ชั่น
plusNumber(5);
plusNumber(10);
//เลข 5 10 คือ อาร์กิวเมนต์

//กำหนดค่า ในตัวแปร
let number = 200;
//เรียกใช้ฟังก์ชั่น
plusNumber(number);
//number คือ อาร์กิวเมนต์

////////////////////////////////////////
function fullName(fname, lname) {
	console.log("ชื่อ =", fname, "นามสกุล =", lname);
}
fullName("yai", "boon");
fullName("namo", "naja");
fullName("Jojo");
////////////////////////////////////////
//การกำหนดค่าเริ่มต้นให้ พารามิเตอร์ ดูที่ Jojo
function fullName2(fname, lname = "555") {
	console.log("ชื่อ =", fname, "นามสกุล =", lname);
}
fullName2("yai", "boon");
fullName2("namo", "naja");
fullName2("Jojo");

////////////////////////////////////////
function summary(x, y) {
	let total = x + y;
	console.log("ผลรวม =", total);
}
summary(5, 10);

////////////////////////////////////////
function getComIp() {
	return "127.0.0.1"; //ส่งออกค่าที่ต้องการ ได้ทั้งค่าตัวเลข และ ตัวหนังสือ
}
let myIp = getComIp(); //สร้างตัวแปรมารับค่า
console.log(myIp); //เรียกตัวแปรมาแสดงค่า
console.log(getComIp); //ความแตกต่าง ของการสร้างตัวแปรมารับค่าและแสดงค่า

////////////////////////////////////////
function city() {
	let mycity = "ubon";
	return mycity; //ส่งออกค่าที่ต้องการ ได้ทั้งค่าตัวเลข และ ตัวหนังสือ
}

console.log(city()); //เรียกตัวแปรมาแสดงค่า

////////////////////////////////////////

function setSarary(salary) {
	let bonus = 5000;
	return salary + bonus;
}
let AAA = setSarary(10000);
console.log("AAA เงินเดือนรวม =", AAA);

let BBB = setSarary(20000);
console.log("BBB เงินเดือนรวม =", BBB);

let CCC = setSarary(20000);
CCC = CCC - 500;
console.log("CCC เงินเดือนรวม =", CCC);

////////////////////////////////////////
function summary22(x, y) {
	return x + y;
}

let sum = summary22(50, 100);
console.log("ผลรวม =", sum);

let sum1 = summary22(150, 100);
console.log("ผลรวม =", sum1);
////////////////////////////////////////
let aaaa = 100;
function display() {
	let aaaa = 50;
	console.log(" a inside", aaaa);
}
console.log(" a outside", aaaa);
display();
////////////////////////////////////////
let aaaaa = 100;
function display2() {
	let aaaaa = 50;
	console.log(" a inside2", aaaaa);
}
console.log(" a outside2", aaaaa);
display2();

////////////////////////////////////////
let colors1 = ["แดง", "ขาว", "ฟ้า", "เหลือง"];
let count = colors1.length; //นับจำนวนข้อมุล
let result = colors1.sort(); //เรียงลำดับจำนวนข้อมุล จากน้อยไปมาก
let result2 = colors1.reverse(); //เรียงลำดับจำนวนข้อมุล จากมากไปน้อย
console.log("นับจำนวนข้อมูล", count);

console.log("เรียงจากน้อยไปมาก", result);
console.log("ทดลองเรียกข้อมูล", colors1.sort()); //เรียงได้ถูกต้องตามคำสั่ง
console.log("ทดลองเรียกข้อมูล2", colors1.reverse()); //เรียงได้ถูกต้องตามคำสั่ง
console.log("เรียงจากมากไปน้อย", result2);

console.log("สมาชิกตัวแรก", colors1[0]); //แสดงสมาชิกตัวแรก
console.log("สมาชิกตัวสุดท้าย", colors1[colors1.length - 1]); //สมาชิกตัวสุดท้าย

colors1.push("เทา");
console.log("เพิ่มสมาชิก", colors1);
////////////////////////////////////////
//*เข้าถึงสมาชิกด้วย for loop

let colors2 = ["แดง", "ขาว", "ฟ้า", "เหลือง"]; //ใน[]ก็คือ array
let count2 = colors2.length; //นับจำนวนข้อมุล เร่มจาก 0

colors2.push("black"); //*เพิ่มข้อมูลเข้า array

console.log("ทดลองเพิ่มข้อมูล =", colors2);

// for (let i = 0; i < count2; i++) { //*cแบบที่ 1
for (let i = 0; i < colors2.length; i++) {
	//*แบบที่ 2
	//console.log(colors2[i]) //*ทดสอบเปลี่ยนการแสดง
	//console.log('ลำดับที่ =', i, 'มีค่า =', colors2[i]) //*ทดสอบเปลี่ยนการแสดง
	console.log("ลำดับที่ =", i + 1, "มีค่า =", colors2[i]); //*ทดสอบเปลี่ยนการแสดง
}
////////////////////////////////////////
//*เข้าถึงสมาชิกด้วย foreach

let colors3 = ["แดง", "ขาว", "ฟ้า", "เหลือง"]; //ใน[]ก็คือ array

colors3.forEach(mydata);

function mydata(item) {
	console.log(item);
}
////////////////////////////////////////
//*แปลง array เป็น string
let colors4 = ["แดง", "ขาว", "ฟ้า", "เหลือง"]; //ใน[]ก็คือ array
console.log(typeof colors4); //*เช้คข้อมูลคืออะไร opject
console.log(colors4.toString()); //*เปลี่ยน opject เปลี่ยนเป็น string

let colors5 = ["แดง", "ขาว", "ฟ้า", "เหลือง"]; //ใน[]ก็คือ array
console.log(typeof colors4); //*เช้คข้อมูลคืออะไร opject
console.log(colors5.join("*")); //*เปลี่ยน ตัวคั้นจาก , เป็น *
console.log(colors5.join(" ")); //*เปลี่ยน ตัวคั้นจาก , เว้นวรรค

let colors6 = ["แดง", "ขาว", "ฟ้า", "เหลือง"]; //ใน[]ก็คือ array
console.log(colors6.pop()); //*แสดงตัวสุดท้าย แล้วเอาออก
colors6.pop(); //*เอาตัวสุดท้ายออก
console.log(colors6); //*แสดงข้อมูลใน array

////////////////////////////////////////
//*เรียงลำดับใน array
let points1 = [20, -5, 100, -500, 150];
console.log(points1);
points1.sort(function (a, b) {
	return a - b;
});
console.log(points1);

let points2 = [20, -5, 100, -500, 150];
console.log(points2);
points2.sort(function (a, b) {
	//* a, b เรียก parameter

	return b - a;
});
console.log(points2);

////////////////////////////////////////
//* opject
let product = {
	name: "mount",
	price: 150,
	color: "black",
	category: "computer",
};

console.log(product.name);
console.log("ราคา =", product.price);

let product2 = {
	name: "mount",
	price: 150,
	color: "black",
	category: "computer",
	displayProduct: function () {
		return (
			"ชื่อสินค้า=" + this.name + " ราคา=" + this.price + " color=" + this.color
		);
	},
};

console.log(product2.displayProduct()); //*แสดงที่ console
document.write(product2.displayProduct()); //*แสดงที่หน้าเว้บ

let product3 = {
	name: "mount",
	price: 150,
	color: "black",
	category: "computer",
	displayProduct: function () {
		return (
			"ชื่อสินค้า=" + this.name + " ราคา=" + this.price + " color=" + this.color
		);
	},
	discount: function () {
		return this.price - 100;
	},
	getcolor: function () {
		return this.color;
	},
};

console.log(product3.displayProduct()); //*แสดงที่ console
document.write(product3.displayProduct()); //*แสดงที่หน้าเว้บ

console.log(product3.discount()); //*แสดงที่ console
document.write(product3.displayProduct()); //*แสดงที่หน้าเว้บ

console.log(product3.getcolor()); //*แสดงที่ console

////////////////////////////////////////
//* การ confirm
function deleteData() {
	let result = confirm("คุณต้องการลบข้อมูลหรือไม ?");
	console.log(result);
}
