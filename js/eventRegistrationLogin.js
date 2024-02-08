let obj1 = document.getElementsByName("email")[0];
obj1.addEventListener("blur", validateEmailAddress);

let obj2 = document.getElementsByName("pass")[0];
obj2.addEventListener("blur", validatePassword);

// gets triggered when the submit button is clicked on the login_form
let obj = document.getElementById("login_form");
obj.addEventListener("submit", validateLogin);