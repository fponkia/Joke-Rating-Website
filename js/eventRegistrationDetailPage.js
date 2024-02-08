//document.getElementsByName("decrease")[0].disabled = true; //getting the decrease button disabled as initial value is 0.

// all the events gets triggered when one of the mentioned event gets registered on the mentioned document objects.
document.getElementsByName("decrease")[0].addEventListener("click", decreaseNumber);
document.getElementsByName("increase")[0].addEventListener("click", increaseNumber);
document.getElementsByName("ratingjoke")[0].addEventListener("loaded", check);

document.getElementById("rateform").addEventListener("submit", submitbackend);