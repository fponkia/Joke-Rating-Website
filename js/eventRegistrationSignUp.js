let obj1 = document.getElementsByName("fname")[0];
obj1.addEventListener("blur", validateFname);

let obj2 = document.getElementsByName("lname")[0];
obj2.addEventListener("blur", validateLname);

let obj3 = documnet.getElementsByName("username")[0];
obj3.addEventListener("blur", validateUsername);

let obj = document.getElementById("signup_form");
obj.addEventListener("submit", validate);
