
function validate(event)
{
    let fail = validateUserName(document.forms["signup_form"]["username"]);
    let fail1 = validateEmailAddress(document.forms["signup_form"]["email"]);
    let fail2 = validatePassword(document.forms["signup_form"]["pass"]);
    let fail3 = validateConfirmPassword(document.forms["signup_form"]["confirmpass"]);
    let fail4 = validateBirth(document.forms["signup_form"]["birth"]);
    let fail5 = validateAvatar(document.forms["signup_form"]["avatar"]);
    let fail6 = validateFname(document.forms["signup_form"]["fname"]);
    let fail7 = validateLname(document.forms["signup_form"]["lname"]);

    if(fail && fail1 && fail2 && fail3 && fail4 && fail5 && fail6 && fail7)
    { 
        return true;
    }
    else {
        event.preventDefault();
        return false;
    }
}

function validateLogin(event){
    let fail = validateEmailAddress(document.forms["login_form"]["email"]);
    let fail1 = validatePassword(document.forms["login_form"]["pass"]);

    if(fail && fail1){
        return true;
    }
    else{
        event.preventDefault();
        return false;
    }
}

function validatePosting(event){
    let fail = validateTitle(document.forms["post_form"]["title"]);
    let fail1 = validateTextarea(document.forms["post_form"]["textarea"]);

    if(fail && fail1){
        return true;
    }
    else{
        event.preventDefault();
        return false;
    }
}

function validateTitle(field){
    field = field.target.value;
    let isValid = true;
    let message = "";
    if(field == ""){
        isValid = false;
        message = "Needs to have some title and it should be less than or equal to 50 characters."
        document.getElementsByName("title_error")[0].textContent = message;
    }
    else if (field.length > 50){
        isValid = false;
        message = "Title should be less than or equal to 50 characters.";
    }

    if(!isValid){
        document.getElementsByName("title")[0].style.borderWidth = "2px";
        document.getElementsByName("title")[0].style.borderColor = "Red";
        document.getElementsByName("title_error")[0].textContent = message;
    }
    else{
        document.getElementsByName("title")[0].style.borderWidth = "0.4px";
        document.getElementsByName("title")[0].style.borderColor = "Black";
        document.getElementsByName("title_error")[0].textContent = "";
    }

    return isValid;
}

function validateTextarea(field){
    field = field.target.value;
    let isValid = true;
    let message = "";

    if(field == ""){
        isValid = false;
        message = "Textarea for the Joke is empty. Needs to have some text in the Joke textarea."
        document.getElementsByName("textarea_error")[0].textContent = message;
    }

    if(!isValid){
        document.getElementsByName("textarea")[0].style.borderWidth = "2px";
        document.getElementsByName("textarea")[0].style.borderColor = "Red";
        document.getElementsByName("textarea_error")[0].textContent = message;
    }
    else{
        document.getElementsByName("textarea")[0].style.borderWidth = "0.4px";
        document.getElementsByName("textarea")[0].style.borderColor = "Black";
        document.getElementsByName("textarea_error")[0].textContent = "";
    }

    return isValid;
}

function validateFname(field){
    field = field.target.value;
    let isValid = true;
    let message = "";
    if(field == ""){
        isValid = false;
        message = "No First Name was entered";
    }
    else if(/[\w]+/.test(field)){
        isValid = true;
        message = "";
    }
    else{
        isValid = false;
        message = "Only word charcters are allowed";
    }

    if(!isValid)
    {
        document.getElementsByName("fname")[0].style.borderWidth = "2px";
        document.getElementsByName("fname")[0].style.borderColor = "Red";
        document.querySelector('[name = "fname_error"]').textContent = message;
    }
    else{
        document.getElementsByName("fname")[0].style.borderWidth = "0.4px";
        document.getElementsByName("fname")[0].style.borderColor = "Black";
        document.querySelector('[name = "fname_error"]').textContent = "";
    }

    return isValid;

}

function validateLname(field){
    field = field.target.value;
    let isValid = true;
    let message = "";

    if(field == ""){
        isValid = false;
        message = "No Last Name was entered";
    }
    else if(/[\w]+/.test(field)){
        isValid = true;
        message = "";
    }
    else{
        isValid = false;
        message = "Only word charcters are allowed";
    }

    if(!isValid)
    {
        document.getElementsByName("lname")[0].style.borderWidth = "2px";
        document.getElementsByName("lname")[0].style.borderColor = "Red";
        document.querySelector('[name = "lname_error"]').textContent = message;
    }
    else{
        document.getElementsByName("lname")[0].style.borderWidth = "0.4px";
        document.getElementsByName("lname")[0].style.borderColor = "Black";
        document.querySelector('[name = "lname_error"]').textContent = "";
    }

    return isValid;

}

function validateUserName(field){
    field = field.target.value;
    let isValid = true;
    let message = "";
    if(field == ""){
        isValid = false;
        message = "No username was entered\n";
    }
    else if (/[^\w]/.test(field)){
        isValid = false;
        message = "Only a-z, A-Z, 0-9, - and _ allowed in Usernames\n";
    }

    if(!isValid)
    {
        document.getElementsByName("username")[0].style.borderWidth = "2px";
        document.getElementsByName("username")[0].style.borderColor = "Red";
        document.querySelector('[name = "username_error"]').textContent = message;
    }
    else{
        document.getElementsByName("username")[0].style.borderWidth = "0.4px";
        document.getElementsByName("username")[0].style.borderColor = "Black";
        document.querySelector('[name = "username_error"]').textContent = "";
    }

    return isValid;
}

function validateEmailAddress(field){
    field = field.target.value;
    let isValid = true;
    let message = "";
    if(field == ""){
        isValid = false;
        message = "No Email Address entered\n";
    }
    else if(/^[\w.-]+@[\w-]+\.[\w]{2,}$/.test(field)){
        isValid = true;
    }
    else{
        isValid = false;
        message = "Email is not entered in proper format (abc@example.com)\n";
    }

    if(!isValid)
    {
        document.getElementsByName("email")[0].style.borderWidth = "2px";
        document.getElementsByName("email")[0].style.borderColor = "Red";
        document.querySelector('[name = "email_error"]').textContent = message;
    }
    else{
        document.getElementsByName("email")[0].style.borderWidth = "0.4px";
        document.getElementsByName("email")[0].style.borderColor = "Black";
        document.querySelector('[name = "email_error"]').textContent = "";
    }

    return isValid;
}

function validatePassword(field){
    field = field.target.value;
    let isValid = true;
    let message = "";
    if(field == ""){
        isValid = false;
        message = "No Password was entered\n";
    }
    else if(field.length < 8){
        isValid = false;
        message = "Password needs to be alteast 8 characters\n";
    }
    else if(/^[\w]+[^A-Za-z0-9 ]$/.test(field)){
        //should have atleast 1 non-letter character and also have a length of 8 characters with no spaces.
        isValid = true;
    }
    else if(/[ ]+/.test(field)){
        isValid = false;
        message = "No spaces allowed\n";
    }
    else{
        isValid = false;
        message = "Needs to have alteast one non-letter character\n";
    }

    if(!isValid)
    {
        document.getElementsByName("pass")[0].style.borderWidth = "2px";
        document.getElementsByName("pass")[0].style.borderColor = "Red";
        document.querySelector('[name = "pass_error"]').textContent = message;
    }
    else{
        document.getElementsByName("pass")[0].style.borderWidth = "0.4px";
        document.getElementsByName("pass")[0].style.borderColor = "Black";
        document.querySelector('[name = "pass_error"]').textContent = "";
    }

    return isValid;
}

function validateConfirmPassword(field){
    field = field.target.value;
    let isValid = true;
    let message = "";

    if(field == ""){
        isValid = false;
        message = "No Password was entered";
    }

    /*if(validatePassword(document.forms["signup_form"]["pass"].value) != ""){
        isValid = false;
        message = "Password entered does not matches with the requirements\n";
    }*/

    else if (document.forms["signup_form"]["pass"].value != field){
        isValid = false;
        message = "Password does not match\n";
    }

    if(!isValid)
    {
        document.getElementsByName("confirmpass")[0].style.borderWidth = "2px";
        document.getElementsByName("confirmpass")[0].style.borderColor = "Red";
        document.querySelector('[name = "confirmpass_error"]').textContent = message;
    }
    else{
        document.getElementsByName("confirmpass")[0].style.borderWidth = "0.4px";
        document.getElementsByName("confirmpass")[0].style.borderColor = "Black";
        document.querySelector('[name = "confirmpass_error"]').textContent = "";
    }

    return isValid;
}

function validateBirth(field){
    field = field.target.value;
    let isValid = true;
    let message = "";
    if(field == ""){
        isValid = false;
        message =  "No Date was entered\n";
    }
    else if (/[0-1][0-9]\/[0-3][0-9]\/[0-2][0-9][0-9][0-9]/.test(field)){
        //mm/dd/yyyy
        isValid = true;
    }
    else if(/[0-2][0-9][0-9][0-9]\-[0-1][0-9]\-[0-3][0-9]/.test(field)){
        //yyyy-mm-dd
        isValid = true;
    }
    else{
        isValid = false;
        message = "Date is not entered in Proper Format. It should be mm/dd/yyyy\n";
    }

    if(!isValid)
    {
        document.getElementsByName("birth")[0].style.borderWidth = "2px";
        document.getElementsByName("birth")[0].style.borderColor = "Red";
        document.querySelector('[name = "birth_error"]').textContent = message;
    }
    else{
        document.getElementsByName("birth")[0].style.borderWidth = "0.4px";
        document.getElementsByName("birth")[0].style.borderColor = "Black";
        document.querySelector('[name = "birth_error"]').textContent = "";
    }

    return isValid;
}

function validateAvatar(field){
    field = field.target.value;
    let isValid1 = true;
    let message = "";
    if(field == ""){
        isValid1 = false;
        message =  "Needs to upload the image\n";
    }
    else{
        let validExtension = ["jpg", "jpeg", "png", "gif"];
        let actualExtension = document.getElementsByName("avatar")[0].value.split(".").pop().toLowerCase();
        let isValid = false;

        for(let i = 0 ; i < validExtension.length ; i++){
            if(actualExtension == [validExtension[i]]){
                isValid = true;
                break;
            }
        }

        if(!isValid){
            isValid1 = false;
            message =  "Needs to have one of this image extensions jpg, jpeg, png, gif\n";
        }
    }
    

    if(!isValid1)
    {
        document.getElementsByName("avatar")[0].style.borderWidth = "2px";
        document.getElementsByName("avatar")[0].style.borderColor = "Red";
        document.querySelector('[name = "avatar_error"]').textContent = message;
    }
    else{
        document.getElementsByName("avatar")[0].style.borderWidth = "0.4px";
        document.getElementsByName("avatar")[0].style.borderColor = "Black";
        document.querySelector('[name = "avatar_error"]').textContent = "";
    }

    return isValid1;
}

function characterCounter(){
    let maxCount = 50;
    let count = document.getElementsByName("title")[0].value.length;

    if(count > maxCount){
        document.getElementsByName("title")[0].style.borderWidth = "2px";
        document.getElementsByName("title")[0].style.borderColor = "Red";
        document.getElementsByName("character_count")[0].textContent = "Character count is exceeded by " + (count - maxCount) + " characters.";
        document.getElementsByName("character_count")[0].style.color = "Red";
    }
    else{
        document.getElementsByName("title")[0].style.borderWidth = "0.4px";
        document.getElementsByName("title")[0].style.borderColor = "Black";
        document.getElementsByName("character_count")[0].textContent = "Current character count is " + count + ", remaining count is " + (maxCount - count) + ".";
        document.getElementsByName("character_count")[0].style.color = "Aliceblue";
        document.getElementsByName("title_error")[0].textContent = "";
    }
}

function decreaseNumber(){
    let currentNumber = document.getElementsByName("ratingjoke")[0].value;
    document.getElementsByName("ratingjoke")[0].value = Number(currentNumber) - 1;
    if(currentNumber == 1){
        document.getElementsByName("decrease")[0].disabled = true;
    }
    if(currentNumber == 5){
        document.getElementsByName("increase")[0].disabled = false;
    }
}

function increaseNumber(){
    let currentNumber = document.getElementsByName("ratingjoke")[0].value;
    document.getElementsByName("ratingjoke")[0].value = Number(currentNumber) + 1;
    if(currentNumber == 0){
        document.getElementsByName("decrease")[0].disabled = false;
    }
    if(currentNumber == 4){
        document.getElementsByName("increase")[0].disabled = true;
    }
}

function check(){
    let currentNumber = document.getElementsByName("ratingjoke")[0].value;
    currentNumber = Number(currentNumber);
    if(currentNumber <= 0){
        document.getElementsByName("ratingjoke")[0].value = 0;
        document.getElementsByName("decrease")[0].disabled = true;
        document.getElementsByName("increase")[0].disabled = false;
    }
    else if(currentNumber >= 5){
        document.getElementsByName("ratingjoke")[0].value = 5;
        document.getElementsByName("increase")[0].disabled = true;
        document.getElementsByName("decrease")[0].disabled = false;
    }
    else{
        document.getElementsByName("ratingjoke")[0].value = currentNumber;
        document.getElementsByName("increase")[0].disabled = false;
        document.getElementsByName("decrease")[0].disabled = false;
    }
}

function submitbackend(event){

    let rating = document.getElementsByName("ratingjoke")[0].value;
    //console.log(rating);

    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){

            let JSONArray = JSON.parse(this.responseText);
                let rating = JSONArray[0];
                let averageRating = JSONArray[1];

                let element = document.getElementById("avgRating");

                element.textContent = "";

                element.textContent = "Current Rating of this joke is: " + averageRating;
                document.getElementsByName("ratingjoke")[0].value = rating;
        }
    }

    xhr.open("GET", "jokeratingbackend.php?rating=" + rating, true);
    xhr.send();

    event.preventDefault();
}

let time = setInterval(updateAvg, 20000);
let newjoke = setInterval(updateJoke, 90000);

function updateAvg(){

    let joke_id = document.getElementById("last_joke_id").getAttribute("value");
    let joke_date = document.getElementById("last_joke_dateTime").getAttribute("value");
    let avgRatearray = null;

    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            avgRatearray = JSON.parse(this.responseText);
            let arraylength = avgRatearray.length;

            for(let i = 0 ; i < arraylength ; i++){
                let element = document.getElementById(joke_id);
                element.innerHTML = "";

                let strong = document.createElement("strong");
                strong.textContent = "Average Rating: " + avgRatearray[i];

                element.appendChild(strong);

                joke_id--;
            }
        }
    }

    xhr.open("GET", "avgRatebackend.php?joke_id="+joke_id+"&date="+joke_date, true);
    xhr.send();
}

function updateJoke(){

    let joke_id = document.getElementById("last_joke_id").getAttribute("value");
    let joke_date = document.getElementById("last_joke_dateTime").getAttribute("value");
    let homeDiv = document.getElementsByClassName("home")[0];

    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            let jsonArray = JSON.parse(this.responseText);
            let arraylength = jsonArray.length;

            if(arraylength > 0){
                 let last_joke_id_update = jsonArray[0].joke_id;
                if(last_joke_id_update > 20){
                    last_joke_id_update = last_joke_id_update - 20;
                    for(let i = arraylength-1 ; i >= 0 ; i--){

                        let div = document.createElement("div");
                        let section = document.createElement("section");
                        let aside = document.createElement("aside");
                        let img = document.createElement("img");
                        let firstP = document.createElement("p");
                        let h3 = document.createElement("h3");
                        let a = document.createElement("a");
                        let secondP = document.createElement("p");
                        let firstLabel = document.createElement("label");
                        let secondLabel = document.createElement("label");
                        let strong = document.createElement("strong");
                        let secondStrong = document.createElement("strong");
                        let br = document.createElement("br");

                        img.className = "listimg";
                        img.setAttribute("src", jsonArray[i].avatar);
                        firstP.textContent = jsonArray[i].username;
                        a.setAttribute("href", "jokedetailpage.php?joke_id="+jsonArray[i].joke_id);
                        a.textContent = jsonArray[i].title;
                        secondP.textContent = jsonArray[i].text;
                        strong.textContent = "Average Rating: " + jsonArray[i].Average_Rating;
                        firstLabel.id = jsonArray[i].joke_id;
                        secondStrong.textContent = "Date and Time of upload: " + jsonArray[i].dateTime;
                        secondLabel.id = jsonArray[i].dateTime;

                        section.appendChild(img);
                        section.appendChild(firstP);

                        h3.appendChild(a);
                        firstLabel.appendChild(strong);
                        secondLabel.appendChild(secondStrong);

                        aside.appendChild(h3);
                        aside.appendChild(secondP);
                        aside.appendChild(firstLabel);
                        aside.appendChild(br);
                        aside.appendChild(secondLabel);

                        div.appendChild(section);
                        div.appendChild(aside);

                        homeDiv.insertBefore(div, document.getElementsByClassName("home")[0].firstElementChild);

                        let lastDiv = document.getElementsByClassName("home")[0].lastElementChild;
                        lastDiv.innerHTML = "";

                        homeDiv.removeChild(homeDiv.lastElementChild);
                    }
                }
                else{
                    for(let i = arraylength-1 ; i >= 0 ; i--){

                        let div = document.createElement("div");
                        let section = document.createElement("section");
                        let aside = document.createElement("aside");
                        let img = document.createElement("img");
                        let firstP = document.createElement("p");
                        let h3 = document.createElement("h3");
                        let a = document.createElement("a");
                        let secondP = document.createElement("p");
                        let firstLabel = document.createElement("label");
                        let secondLabel = document.createElement("label");
                        let strong = document.createElement("strong");
                        let secondStrong = document.createElement("strong");
                        let br = document.createElement("br");

                        img.className = "listimg";
                        img.setAttribute("src", jsonArray[i].avatar);
                        firstP.textContent = jsonArray[i].username;
                        a.setAttribute("href", "jokedetailpage.php?joke_id="+jsonArray[i].joke_id);
                        a.textContent = jsonArray[i].title;
                        secondP.textContent = jsonArray[i].text;
                        strong.textContent = "Average Rating: " + jsonArray[i].Average_Rating;
                        firstLabel.id = jsonArray[i].joke_id;
                        secondStrong.textContent = "Date and Time of upload: " + jsonArray[i].dateTime;
                        secondLabel.id = jsonArray[i].dateTime;

                        section.appendChild(img);
                        section.appendChild(firstP);

                        h3.appendChild(a);
                        firstLabel.appendChild(strong);
                        secondLabel.appendChild(secondStrong);

                        aside.appendChild(h3);
                        aside.appendChild(secondP);
                        aside.appendChild(firstLabel);
                        aside.appendChild(br);
                        aside.appendChild(secondLabel);

                        div.appendChild(section);
                        div.appendChild(aside);

                        homeDiv.insertBefore(div, document.getElementsByClassName("home")[0].firstElementChild);
                    }
                }
                document.getElementById("last_joke_id").setAttribute("value", jsonArray[0].joke_id);
                document.getElementById("last_joke_dateTime").setAttribute("value", jsonArray[0].joke_dateTime);
            }
        }
    }
    xhr.open("GET", "newJokeList.php?joke_id="+joke_id+"&joke_date="+joke_date, true);
    xhr.send();
}