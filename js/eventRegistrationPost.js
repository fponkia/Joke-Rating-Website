let obj1 = document.getElementsByName("title")[0];
obj1.addEventListener("blur", validateTitle);

let obj2 = document.getElementsByName("textarea")[0];
obj2.addEventListener("blur", validateTextarea);

// gets triggered when the submit button is clicked on post_form
let obj = document.getElementById("post_form");
obj.addEventListener("submit", validatePosting);

// gets triggered when the key is released on title input field of post_form
document.getElementsByName("title")[0].addEventListener("keyup",characterCounter);