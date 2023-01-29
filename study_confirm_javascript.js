//* การ confirm
function deleteData() {
	let result = confirm("คุณต้องการลบข้อมูลหรือไม ?");
	if (result) {
		console.log("ลบข้อมูลเรียบร้อย");
	} else {
		console.log("ยกเลิกการลบข้อมูล");
	}
}

let a = document.getElementsByTagName("p");
console.log(a);

let b = document.getElementById("demo");
console.log(b);

let c = document.getElementById("demo");
c.innerText = "test change text in tag p by id";

let d = document.getElementById("text"); //*สั่งให้ เมื่อกดปุ่มแล้ว ข้อความเปลี่ยนเป็นข้อความใหม่
function display() {
	d.innerText = "test change text";
}

let e = document.getElementById("text"); //*สั่งให้ เมื่อกดปุ่มแล้ว ข้อความเปลี่ยนเป็นข้อความใหม่
function display2() {
	//*ตั้งชท่อ function ขึ้นมาใหม่เพื่อเอาเรียกใช้งาน
	d.innerHTML = "<strong> test change text2 </strong>";
	//*จุดสงเกตุ ที่ d.innerHTML เพื่อให้สามารถใช้ tag <strong> ที่เป็นคำสั่งของ HTML ได้ตัวหนังสือหนา
}

let x = 10;
let y = 20;
function display3() {
	//*ตั้งชท่อ function ขึ้นมาใหม่เพื่อเอาเรียกใช้งาน
	d.innerHTML = "แสดงค่าของ x =" + x; //* + คือเป็นการเอา string มาต่อกัน
}

function display4() {
	//*ตั้งชท่อ function ขึ้นมาใหม่เพื่อเอาเรียกใช้งาน
	d.innerHTML = `แสดงค่าของตัวแปร y = ${y}`;
}

let f = document.querySelector(".myclass"); //*อ้างอิงผ่าน class
//*เหตุผลที่ใช้ผ่าน class เพราะ เราสามารถ กำหนด class ไว้ใน หลายๆ tag ได้ ทำให้สามารถ
//*เปลี่ยนแปลงหรือแก้ไข พร้อมๆกันหลายตัวได้
let g = document.querySelector("#text"); //*อ้างอิงผ่าน id เป็นการเรียกใช้อีกแบบหนึ่ง
let h = document.querySelector("p"); //*อ้างอิงผ่าน tag p จะดึงมาเฉพาะตัวแรกเท่านั้น
let i = document.querySelectorAll("p"); //*อ้างอิงผ่าน tag p จะดึงมาทั้งหมดที่เป็น tag p

const j = document.querySelector("#text"); //*อ้างอิงผ่าน id เป็นการเรียกใช้อีกแบบหนึ่ง
//* const นิยมใช้เป้นมาตรฐาน เพราะ ค่าของตัวแปร จะไม่สามารถแก้ไขได้ ใช้สำหรับการอ้างอิง ไปที่ใดที่หนึ่ง
//* let จะอามาใช้สำหรับการประมวลผล ค่าจะเปลี่ยนแปลง

console.log(f);
console.log(g);
console.log(h);
console.log(i);
console.log(j);

///////////////////////////////////////////////
//*เปลี่ยน style ของตัวหนังสือ โดยเปลี่ยนเป็นกลุ่ม ที่ต้องการเลือก
const titleEl = document.getElementById("title");
const contentEl = document.querySelector(".content");
const allEl = document.querySelectorAll("p");

titleEl.style.color = "red";
titleEl.style.backgroundColor = "yellow";

function display5() {
	titleEl.style.color = "blue";
	titleEl.style.backgroundColor = "black";
	titleEl.style.fontSize = "60px";

	contentEl.setAttribute("class", "yai"); //*เปลี่ยนชื่อ class จาก content เป้น yai
}

//////////////////////////////////////////
//*เปลี่ยน style ของตัวหนังสือ โดยเปลี่ยนเป็นกลุ่ม ที่ต้องการเลือก
const ModeDark = document.querySelector(".mode");
function display6() {
	ModeDark.setAttribute("class", "dark"); //*เปลี่ยนชื่อ class จาก ModeDark เป้น dark
}
///////////////////////////////////////////////

const textAll = document.querySelectorAll("p");

console.log(textAll); //*การเลือกทุกตัว ให้แสดง
console.log(textAll[1]); //* การเลือกตัวไหนตัวหนึ่ง

let messge = textAll[1].innerHTML;
console.log(messge);

///////////////////////////////////////////////
const menu = document.getElementById("menu"); //*ติดต่อไปที่ id=menu
const item = document.createElement("li"); //*สร้าง tag ลูก li
item.innerText = "item"; //* tag ลูกชื่อ item
menu.appendChild(item);
///////////////////////////////////////////////
const menu2 = document.getElementById("menu"); //*ติดต่อไปที่ id=menu
let count = 1; //*สร้างตัวแปร สำหรับนับ ตัวเลข
function display7() {
	const item = document.createElement("li"); //*สร้าง tag ลูก li
	item.innerText = "item" + count++; //* tag ลูกชื่อ item และ ใส่ตัวเลข ต่อท้าย
	menu.appendChild(item);
}
///////////////////////////////////////////////
const TestDelete = document.getElementById("TestDeleteTag"); //*ติดต่อไปที่ id=
const TestDeleteItem = document.getElementById("tag2"); //*ติดต่อไปที่ id= ที่ต้องการลบ
TestDeleteTag.removeChild(TestDeleteItem); //*สั่งลบ id= ที่ต้องการลบ
///////////////////////////////////////////////
const TestDelete2 = document.getElementById("TestDeleteTag"); //*ติดต่อไปที่ id=
const buttonDeleteItem4 = document.getElementById("tag4"); //*ติดต่อไปที่ id= ที่ต้องการลบ
function display8() {
	TestDeleteTag.removeChild(buttonDeleteItem4); //*สั่งลบ id= ที่ต้องการลบ
}
///////////////////////////////////////////////
const TestDelete3 = document.getElementById("TestDeleteTag"); //*ติดต่อไปที่ id=
const itemA = document.getElementById("tag1"); //*เลือกปลายทางที่ต้องการเปลี่ยน
const newitem = document.createElement("li"); //* tag ที่ต้องการเปลี่ยน
newitem.innerText = "x"; //*ข้อความที่ต้องการแทนที่
TestDeleteTag.replaceChild(newitem, itemA); //*สั่งทำการแทนที่

const itemC = document.getElementById("tag3"); //*เลือกปลายทางที่ต้องการเปลี่ยน
const newitem3 = document.createElement("li"); //* tag ที่ต้องการเปลี่ยน
newitem3.innerText = "YY"; //*ข้อความที่ต้องการแทนที่
function display9() {
	TestDeleteTag.replaceChild(newitem3, itemC); //*สั่งทำการแทนที่
}
///////////////////////////////////////////////
const box = document.getElementById("box");
let statusStyle;

function addDrakMode() {
	box.classList.add("dark");
}

function deleteDrakMode() {
	box.classList.remove("dark");
}

function changeDrakMode() {
	box.classList.toggle("dark");
	statusStyle = box.classList.contains("dark");
	console.log(statusStyle);
	if (statusStyle) {
		box.style.color = "yellow";
	} else {
		box.style.color = "red";
	}
}
///////////////////////////////////////////////
//* Event ความหาย ทำงานร่วมกับแท็ก
//* onfocus="" เมื่อมีการโฟกัส >>>select text textarea
//* onblur="" เมื่อถูกย้ายโฟกัส >>>select text textarea
//* onchange="" เมื่อมีการเปลี่ยนแปลงค่า >>>select text textarea
//* onselect="" เมื่อมีการเลือกข้อความ >>>text textarea
//* onsubmit="" เมื่อคลิกปุ๋ม submit >>>form
///////////////////////////////////////////////
function welcome() {
	alert("ยินดีต้อนรับเข้าสู่หน้าเว้บของเรา");
}

function hightlight(obj) {
	obj.style.background = "yellow";
}

function unhightlight(obj) {
	obj.style.background = "black";
}
///////////////////////////////////////////////
function getmanu() {
	const menu9 = document.getElementById("menu9");
	const displaymenu9 = document.getElementById("displaymenu9");
	console.log(menu9.value);
	displaymenu9.innerText = menu9.value;
}

function hightlighttext(obj) {
	obj.style.background = "yellow";
}
function unhightlighttext(obj) {
	obj.style.background = "red";
}
///////////////////////////////////////////////
//* เขียน การแสดง elements ใน javascript อย่างเดียวไม่ต้องไปเขียนที่ html
const menu10 = document.getElementById("Displaymenu10"); //* อ้างอิง id ที่ต้องการ
menu10.addEventListener("change", getmanu10); //*ใช้ ฟังกืชั้น เหมือน onclick แล้วให้เรียก ฟังก์ชั่น getmanu10 มาทำงาน
function getmanu10() {
	console.log(menu10.value); //*ได้ค่ามาแล้วนำไปแสดง
	displaymenu10.innerText = menu10.value; //*ได้ค่ามาแล้วนำไปแสดง ที่ displaymenu10 โดยเอาค่ามาจาก menu10
}
